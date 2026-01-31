<?php

namespace App\Http\Controllers;

use App\Models\Giving;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GivingController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display the giving page
     */
    public function index()
    {
        return view('giving.index');
    }

    /**
     * Store a new giving record
     */
    public function store(Request $request)
    {
        // Check if user is a logged-in member
        $user = Auth::user();
        $member = $user?->member ?? null;
        
        $rules = [
            'giving_type' => 'required|in:tithe,offering,donation,special_offering',
            'amount' => 'required|numeric|min:100',
            'currency' => 'required|string|size:3',
            'purpose' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cash,mobile_money,bank_transfer,card,check',
            'transaction_reference' => 'nullable|string|max:255',
            'payment_provider' => 'nullable|string|max:255',
            'payment_account' => 'nullable|string|max:255',
        ];
        
        // Add guest validation rules only if user is not a member
        if (!$member) {
            // If user is logged in but has no member profile, OR is not logged in at all
            $rules['guest_name'] = 'required|string|max:255';
            $rules['guest_email'] = 'nullable|email|max:255';
            $rules['guest_phone'] = 'nullable|string|max:20';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Please check your input and try again.'
            ], 422);
        }

        try {
            DB::beginTransaction();

            $givingData = $request->only([
                'giving_type', 'amount', 'currency', 'purpose', 'notes',
                'payment_method', 'transaction_reference', 'payment_provider', 'payment_account'
            ]);

            // Determine if this is a member or guest giving
            $user = Auth::user();
            $member = $user?->member ?? null;

            if ($member) {
                // Member giving
                $givingData['member_id'] = $member->id;
            } else {
                // Guest giving
                $givingData['guest_name'] = $request->guest_name;
                $givingData['guest_email'] = $request->guest_email;
                $givingData['guest_phone'] = $request->guest_phone;
            }

            // Set initial status based on payment method
            $givingData['status'] = $this->getInitialStatus($request->payment_method);
            $givingData['payment_date'] = now();
            
            // Audit trail
            $givingData['ip_address'] = $request->ip();
            $givingData['user_agent'] = $request->userAgent();

            // Calculate processing fee if applicable
            if (in_array($request->payment_method, ['mobile_money', 'card'])) {
                $givingData['processing_fee'] = $this->calculateProcessingFee($request->amount, $request->payment_method);
            }

            $giving = Giving::create($givingData);
            
            // Calculate net amount
            $giving->calculateNetAmount();

            // Auto-confirm cash payments (assuming they're verified at collection)
            if ($request->payment_method === 'cash') {
                $giving->markAsCompleted($user);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your generous giving! Your contribution has been recorded.',
                'giving_id' => $giving->id,
                'receipt_number' => $giving->receipt_number,
                'status' => $giving->status
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your giving. Please try again.'
            ], 500);
        }
    }

    /**
     * Display member's giving history
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !$user->member) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Member account required.'
            ], 403);
        }

        $givings = $user->member->givings()
            ->with('confirmedBy')
            ->orderBy('payment_date', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'givings' => $givings,
            'summary' => [
                'total_this_year' => $user->member->getTotalGivingAttribute(),
                'tithes_this_year' => $user->member->getTithesThisYearAttribute(),
                'offerings_this_year' => $user->member->getOfferingsThisYearAttribute(),
                'donations_this_year' => $user->member->getDonationsThisYearAttribute(),
            ]
        ]);
    }

    /**
     * Admin: View all givings with filters
     */
    public function adminIndex(Request $request)
    {
        $this->authorize('viewAny', Giving::class);

        $query = Giving::with(['member', 'confirmedBy']);

        // Apply filters
        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->giving_type) {
            $query->where('giving_type', $request->giving_type);
        }

        if ($request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->start_date && $request->end_date) {
            $query->byDateRange($request->start_date, $request->end_date);
        }

        $givings = $query->orderBy('created_at', 'desc')->paginate(50);

        return view('admin.givings.index', compact('givings'));
    }

    /**
     * Admin: Confirm a giving
     */
    public function confirm(Request $request, Giving $giving)
    {
        $this->authorize('update', $giving);

        $validator = Validator::make($request->all(), [
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $giving->markAsCompleted(Auth::user());
            
            if ($request->notes) {
                $giving->update(['notes' => $giving->notes . "\n\nAdmin Note: " . $request->notes]);
            }

            // Send receipt if email available
            if ($giving->giver_email) {
                $giving->sendReceipt();
            }

            return response()->json([
                'success' => true,
                'message' => 'Giving confirmed successfully.',
                'giving' => $giving->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error confirming giving.'
            ], 500);
        }
    }

    /**
     * Admin: Mark giving as failed
     */
    public function markFailed(Request $request, Giving $giving)
    {
        $this->authorize('update', $giving);

        $giving->markAsFailed();

        return response()->json([
            'success' => true,
            'message' => 'Giving marked as failed.',
            'giving' => $giving->fresh()
        ]);
    }

    /**
     * Admin: Financial reports
     */
    public function reports(Request $request)
    {
        $this->authorize('viewReports', Giving::class);

        $startDate = $request->start_date ?? now()->startOfMonth();
        $endDate = $request->end_date ?? now()->endOfMonth();

        $summary = [
            'total_amount' => Giving::completed()->byDateRange($startDate, $endDate)->sum('amount'),
            'total_tithes' => Giving::completed()->byType('tithe')->byDateRange($startDate, $endDate)->sum('amount'),
            'total_offerings' => Giving::completed()->byType('offering')->byDateRange($startDate, $endDate)->sum('amount'),
            'total_donations' => Giving::completed()->whereIn('giving_type', ['donation', 'special_offering'])->byDateRange($startDate, $endDate)->sum('amount'),
            'transaction_count' => Giving::completed()->byDateRange($startDate, $endDate)->count(),
            'processing_fees' => Giving::completed()->byDateRange($startDate, $endDate)->sum('processing_fee'),
            'pending_count' => Giving::pending()->byDateRange($startDate, $endDate)->count(),
        ];

        $byPaymentMethod = Giving::completed()
            ->byDateRange($startDate, $endDate)
            ->select('payment_method', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->get();

        // If this is an AJAX request, return JSON
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'summary' => $summary,
                'by_payment_method' => $byPaymentMethod,
                'period' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate
                ]
            ]);
        }

        // Otherwise return the view
        return view('admin.givings.reports', compact('summary', 'byPaymentMethod', 'startDate', 'endDate'));
    }

    /**
     * Get initial status based on payment method
     */
    private function getInitialStatus(string $paymentMethod): string
    {
        return match($paymentMethod) {
            'cash' => 'completed', // Cash is immediately confirmed
            'mobile_money', 'bank_transfer', 'card', 'check' => 'pending',
            default => 'pending'
        };
    }

    /**
     * Calculate processing fee based on payment method and amount
     */
    private function calculateProcessingFee(float $amount, string $paymentMethod): float
    {
        return match($paymentMethod) {
            'mobile_money' => min($amount * 0.01, 2000), // 1% capped at 2000 UGX
            'card' => $amount * 0.025, // 2.5% for cards
            default => 0
        };
    }
}