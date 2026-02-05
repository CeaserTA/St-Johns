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
            'amount' => 'required|numeric|min:100|max:100000000', // Max 100M for safety
            'currency' => 'required|string|size:3|in:UGX,USD,EUR',
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
            $rules['guest_name'] = 'required|string|max:255|regex:/^[a-zA-Z\s]+$/';
            $rules['guest_email'] = 'nullable|email|max:255';
            $rules['guest_phone'] = 'nullable|string|max:20|regex:/^[\+]?[0-9\-\s\(\)]+$/';
        }

        // Add conditional validation for payment methods
        if ($request->payment_method === 'mobile_money') {
            $rules['payment_provider'] = 'required|in:MTN,Airtel';
            $rules['payment_account'] = 'required|string|max:20|regex:/^[\+]?[0-9\-\s\(\)]+$/';
            $rules['transaction_reference'] = 'required|string|min:8|max:50';
        } elseif ($request->payment_method === 'bank_transfer') {
            $rules['transaction_reference'] = 'required|string|min:5|max:100';
        }

        $validator = Validator::make($request->all(), $rules, [
            'guest_name.regex' => 'Name should only contain letters and spaces.',
            'guest_phone.regex' => 'Please enter a valid phone number.',
            'payment_account.regex' => 'Please enter a valid phone number.',
            'amount.min' => 'Minimum giving amount is 100 ' . $request->currency . '.',
            'amount.max' => 'Maximum giving amount is 100,000,000 ' . $request->currency . '.',
            'transaction_reference.required' => 'Transaction reference is required for this payment method.',
            'transaction_reference.min' => 'Transaction reference is too short.',
            'payment_provider.required' => 'Please select your mobile money provider.',
        ]);

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
                // Guest giving - validate and sanitize guest data
                $givingData['guest_name'] = trim($request->guest_name);
                $givingData['guest_email'] = $request->guest_email ? trim(strtolower($request->guest_email)) : null;
                $givingData['guest_phone'] = $request->guest_phone ? preg_replace('/[^\+0-9]/', '', $request->guest_phone) : null;
            }

            // Set initial status based on payment method
            $givingData['status'] = $this->getInitialStatus($request->payment_method);
            $givingData['payment_date'] = now();
            
            // Audit trail
            $givingData['ip_address'] = $request->ip();
            $givingData['user_agent'] = substr($request->userAgent(), 0, 500); // Truncate for safety

            // Calculate processing fee if applicable
            if (in_array($request->payment_method, ['mobile_money', 'card'])) {
                $givingData['processing_fee'] = $this->calculateProcessingFee($request->amount, $request->payment_method);
            }

            // Additional validation for duplicate transactions
            if ($request->transaction_reference) {
                $existingGiving = Giving::where('transaction_reference', $request->transaction_reference)
                    ->where('payment_method', $request->payment_method)
                    ->where('status', '!=', 'failed')
                    ->first();

                if ($existingGiving) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'A giving with this transaction reference already exists. Please check your transaction details.'
                    ], 422);
                }
            }

            $giving = Giving::create($givingData);
            
            // Calculate net amount
            $giving->calculateNetAmount();

            // Auto-confirm cash payments (assuming they're verified at collection)
            if ($request->payment_method === 'cash') {
                $giving->markAsCompleted($user);
                
                // Send receipt immediately for cash payments if email available
                if ($giving->giver_email) {
                    $giving->sendReceipt();
                }
            }

            DB::commit();

            $responseMessage = 'Thank you for your generous giving! Your contribution has been recorded.';
            
            if ($giving->status === 'pending') {
                $responseMessage .= ' Your payment is being verified and you will receive a receipt once confirmed.';
            } elseif ($giving->status === 'completed' && $giving->giver_email) {
                $responseMessage .= ' A receipt has been sent to your email address.';
            }

            return response()->json([
                'success' => true,
                'message' => $responseMessage,
                'giving_id' => $giving->id,
                'receipt_number' => $giving->receipt_number,
                'status' => $giving->status,
                'next_steps' => $this->getNextStepsMessage($giving)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Error storing giving', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['_token'])
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your giving. Please try again or contact support if the problem persists.'
            ], 500);
        }
    }

    /**
     * Get next steps message based on giving status and payment method
     */
    private function getNextStepsMessage(Giving $giving): string
    {
        switch ($giving->payment_method) {
            case 'mobile_money':
                return 'Please ensure you have completed the mobile money transaction. Your giving will be confirmed once payment is verified.';
            case 'bank_transfer':
                return 'Please complete the bank transfer using the provided details. Your giving will be confirmed once payment is received.';
            case 'card':
                return 'Your card payment is being processed. You will receive confirmation once the transaction is complete.';
            case 'check':
                return 'Please bring your check to the church office during business hours for processing.';
            case 'cash':
                return 'Your cash giving has been confirmed. Thank you for your contribution!';
            default:
                return 'Thank you for your giving. You will receive updates on the status of your contribution.';
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
            'verified_amount' => 'nullable|numeric|min:0',
            'payment_verified' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Please check your input and try again.'
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Update verified amount if provided
            if ($request->has('verified_amount') && $request->verified_amount !== null) {
                $giving->update(['amount' => $request->verified_amount]);
                $giving->calculateNetAmount();
            }

            $giving->markAsCompleted(Auth::user());
            
            if ($request->notes) {
                $adminNote = "\n\nAdmin Note (" . now()->format('Y-m-d H:i') . "): " . $request->notes;
                $giving->update(['notes' => $giving->notes . $adminNote]);
            }

            // Send receipt if email available and not already sent
            $receiptSent = false;
            if ($giving->status === 'completed' && $giving->giver_email && !$giving->receipt_sent) {
                $receiptSent = $giving->sendReceipt();
            }

            DB::commit();

            $message = 'Giving confirmed successfully.';
            if ($receiptSent) {
                $message .= ' Receipt email sent to ' . $giving->giver_email . '.';
            } elseif ($giving->giver_email && $giving->receipt_sent) {
                $message .= ' Receipt was already sent previously.';
            } elseif (!$giving->giver_email) {
                $message .= ' No email address available for receipt.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'giving' => $giving->fresh(),
                'receipt_sent' => $receiptSent
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error confirming giving', [
                'giving_id' => $giving->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error confirming giving: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: Mark giving as failed
     */
    public function markFailed(Request $request, Giving $giving)
    {
        $this->authorize('update', $giving);

        $validator = Validator::make($request->all(), [
            'failure_reason' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Please check your input and try again.'
            ], 422);
        }

        try {
            $giving->markAsFailed();

            if ($request->failure_reason) {
                $failureNote = "\n\nFailure Reason (" . now()->format('Y-m-d H:i') . "): " . $request->failure_reason;
                $giving->update(['notes' => $giving->notes . $failureNote]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Giving marked as failed.',
                'giving' => $giving->fresh()
            ]);

        } catch (\Exception $e) {
            \Log::error('Error marking giving as failed', [
                'giving_id' => $giving->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating giving status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: Resend receipt email
     */
    public function resendReceipt(Request $request, Giving $giving)
    {
        $this->authorize('update', $giving);

        if ($giving->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Can only resend receipts for completed givings.'
            ], 400);
        }

        if (!$giving->giver_email) {
            return response()->json([
                'success' => false,
                'message' => 'No email address available for this giving.'
            ], 400);
        }

        try {
            $receiptSent = $giving->sendReceipt();

            if ($receiptSent) {
                // Log the resend action
                $resendNote = "\n\nReceipt Resent (" . now()->format('Y-m-d H:i') . ") by " . Auth::user()->name;
                $giving->update(['notes' => $giving->notes . $resendNote]);

                return response()->json([
                    'success' => true,
                    'message' => 'Receipt email sent successfully to ' . $giving->giver_email . '.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send receipt email. Please check the logs for details.'
                ], 500);
            }

        } catch (\Exception $e) {
            \Log::error('Error resending receipt', [
                'giving_id' => $giving->id,
                'email' => $giving->giver_email,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error sending receipt: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: Export givings to CSV
     */
    public function exportCsv(Request $request)
    {
        $this->authorize('viewReports', Giving::class);

        $validator = Validator::make($request->all(), [
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|in:pending,completed,failed,cancelled',
            'giving_type' => 'nullable|in:tithe,offering,donation,special_offering',
            'payment_method' => 'nullable|in:cash,mobile_money,bank_transfer,card,check',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Invalid export parameters.'
            ], 422);
        }

        try {
            $query = Giving::with(['member', 'confirmedBy']);

            // Apply filters
            if ($request->start_date && $request->end_date) {
                $query->byDateRange($request->start_date, $request->end_date);
            } elseif ($request->start_date) {
                $query->where('payment_date', '>=', $request->start_date);
            } elseif ($request->end_date) {
                $query->where('payment_date', '<=', $request->end_date);
            }

            if ($request->status) {
                $query->where('status', $request->status);
            }

            if ($request->giving_type) {
                $query->where('giving_type', $request->giving_type);
            }

            if ($request->payment_method) {
                $query->where('payment_method', $request->payment_method);
            }

            $givings = $query->orderBy('payment_date', 'desc')->get();

            // Generate CSV content
            $csvData = [];
            $csvData[] = [
                'Receipt Number',
                'Date',
                'Giver Name',
                'Giver Type',
                'Email',
                'Phone',
                'Giving Type',
                'Amount',
                'Currency',
                'Purpose',
                'Payment Method',
                'Payment Provider',
                'Transaction Reference',
                'Status',
                'Processing Fee',
                'Net Amount',
                'Confirmed By',
                'Confirmed At',
                'Receipt Sent',
                'Notes'
            ];

            foreach ($givings as $giving) {
                $csvData[] = [
                    $giving->receipt_number ?: 'N/A',
                    $giving->payment_date ? $giving->payment_date->format('Y-m-d H:i:s') : $giving->created_at->format('Y-m-d H:i:s'),
                    $giving->giver_name,
                    $giving->member ? 'Member' : 'Guest',
                    $giving->giver_email ?: 'N/A',
                    $giving->giver_phone ?: 'N/A',
                    ucfirst(str_replace('_', ' ', $giving->giving_type)),
                    $giving->amount,
                    $giving->currency,
                    $giving->purpose ?: 'N/A',
                    ucfirst(str_replace('_', ' ', $giving->payment_method)),
                    $giving->payment_provider ?: 'N/A',
                    $giving->transaction_reference ?: 'N/A',
                    ucfirst($giving->status),
                    $giving->processing_fee ?: 0,
                    $giving->net_amount ?: $giving->amount,
                    $giving->confirmedBy ? $giving->confirmedBy->name : 'N/A',
                    $giving->confirmed_at ? $giving->confirmed_at->format('Y-m-d H:i:s') : 'N/A',
                    $giving->receipt_sent ? 'Yes' : 'No',
                    str_replace(["\r", "\n"], ' ', $giving->notes ?: 'N/A')
                ];
            }

            // Generate filename
            $filename = 'givings_export_' . now()->format('Y-m-d_H-i-s') . '.csv';

            // Create CSV content
            $output = fopen('php://temp', 'r+');
            foreach ($csvData as $row) {
                fputcsv($output, $row);
            }
            rewind($output);
            $csvContent = stream_get_contents($output);
            fclose($output);

            return response($csvContent)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');

        } catch (\Exception $e) {
            \Log::error('Error exporting givings CSV', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error generating export: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: Get detailed giving information
     */
    public function show(Request $request, Giving $giving)
    {
        $this->authorize('view', $giving);

        // Load relationships
        $giving->load(['member', 'confirmedBy']);

        // Get transaction history (status changes, notes, etc.)
        $history = [];
        
        // Initial creation
        $history[] = [
            'timestamp' => $giving->created_at,
            'action' => 'Created',
            'description' => 'Giving record created',
            'user' => null,
            'details' => [
                'amount' => $giving->amount,
                'currency' => $giving->currency,
                'payment_method' => $giving->payment_method,
                'status' => 'pending'
            ]
        ];

        // Payment date (if different from creation)
        if ($giving->payment_date && $giving->payment_date->ne($giving->created_at)) {
            $history[] = [
                'timestamp' => $giving->payment_date,
                'action' => 'Payment Initiated',
                'description' => 'Payment was initiated/submitted',
                'user' => null,
                'details' => [
                    'payment_method' => $giving->payment_method,
                    'transaction_reference' => $giving->transaction_reference
                ]
            ];
        }

        // Confirmation
        if ($giving->confirmed_at && $giving->confirmedBy) {
            $history[] = [
                'timestamp' => $giving->confirmed_at,
                'action' => 'Confirmed',
                'description' => 'Giving was confirmed by admin',
                'user' => $giving->confirmedBy->name,
                'details' => [
                    'status' => 'completed',
                    'receipt_number' => $giving->receipt_number
                ]
            ];
        }

        // Receipt sent
        if ($giving->receipt_sent) {
            // Try to estimate when receipt was sent (use confirmed_at or updated_at)
            $receiptTime = $giving->confirmed_at ?: $giving->updated_at;
            $history[] = [
                'timestamp' => $receiptTime,
                'action' => 'Receipt Sent',
                'description' => 'Receipt email was sent to ' . $giving->giver_email,
                'user' => null,
                'details' => [
                    'email' => $giving->giver_email,
                    'receipt_number' => $giving->receipt_number
                ]
            ];
        }

        // Parse notes for admin actions (look for timestamps in notes)
        if ($giving->notes) {
            $noteLines = explode("\n", $giving->notes);
            foreach ($noteLines as $line) {
                if (preg_match('/^(Admin Note|Failure Reason|Receipt Resent) \((\d{4}-\d{2}-\d{2} \d{2}:\d{2})\):\s*(.+)/', $line, $matches)) {
                    $actionType = $matches[1];
                    $timestamp = \Carbon\Carbon::parse($matches[2]);
                    $note = $matches[3];
                    
                    $history[] = [
                        'timestamp' => $timestamp,
                        'action' => $actionType,
                        'description' => $note,
                        'user' => 'Admin',
                        'details' => []
                    ];
                }
            }
        }

        // Sort history by timestamp
        usort($history, function($a, $b) {
            return $a['timestamp']->timestamp <=> $b['timestamp']->timestamp;
        });

        // Calculate financial summary
        $financialSummary = [
            'gross_amount' => $giving->amount,
            'processing_fee' => $giving->processing_fee ?: 0,
            'net_amount' => $giving->net_amount ?: $giving->amount,
            'currency' => $giving->currency
        ];

        // If this is an AJAX request, return JSON
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'giving' => $giving,
                'history' => $history,
                'financial_summary' => $financialSummary,
                'giver_info' => [
                    'name' => $giving->giver_name,
                    'email' => $giving->giver_email,
                    'phone' => $giving->giver_phone,
                    'type' => $giving->member ? 'Member' : 'Guest'
                ]
            ]);
        }

        // Otherwise return view (for future use)
        return view('admin.givings.show', compact('giving', 'history', 'financialSummary'));
    }

    /**
     * Admin: Get dashboard summary data (current month)
     */
    public function dashboardSummary(Request $request)
    {
        try {
            // Check if user is authenticated and is admin
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated',
                    'summary' => array_fill_keys(['total_amount', 'total_tithes', 'total_offerings', 'total_donations', 'transaction_count', 'processing_fees', 'pending_count'], 0)
                ], 401);
            }

            if (auth()->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Admin role required.',
                    'summary' => array_fill_keys(['total_amount', 'total_tithes', 'total_offerings', 'total_donations', 'transaction_count', 'processing_fees', 'pending_count'], 0)
                ], 403);
            }

            // Always use current month for dashboard
            $startDate = now()->startOfMonth()->format('Y-m-d');
            $endDate = now()->endOfMonth()->format('Y-m-d');

            // Simple query first - get all completed givings
            $allCompleted = Giving::where('status', 'completed')->get();
            $allPending = Giving::where('status', 'pending')->get();

            // Filter by current month manually for now
            $currentMonthCompleted = $allCompleted->filter(function($giving) use ($startDate, $endDate) {
                $confirmedDate = $giving->confirmed_at ? $giving->confirmed_at->format('Y-m-d') : null;
                $paymentDate = $giving->payment_date ? $giving->payment_date->format('Y-m-d') : null;
                
                return ($confirmedDate && $confirmedDate >= $startDate && $confirmedDate <= $endDate) ||
                       ($paymentDate && $paymentDate >= $startDate && $paymentDate <= $endDate);
            });

            $currentMonthPending = $allPending->filter(function($giving) use ($startDate, $endDate) {
                $createdDate = $giving->created_at->format('Y-m-d');
                return $createdDate >= $startDate && $createdDate <= $endDate;
            });

            $summary = [
                'total_amount' => $currentMonthCompleted->sum('amount') ?: 0,
                'total_tithes' => $currentMonthCompleted->where('giving_type', 'tithe')->sum('amount') ?: 0,
                'total_offerings' => $currentMonthCompleted->where('giving_type', 'offering')->sum('amount') ?: 0,
                'total_donations' => $currentMonthCompleted->whereIn('giving_type', ['donation', 'special_offering'])->sum('amount') ?: 0,
                'transaction_count' => $currentMonthCompleted->count() ?: 0,
                'processing_fees' => $currentMonthCompleted->sum('processing_fee') ?: 0,
                'pending_count' => $currentMonthPending->count() ?: 0,
            ];

            return response()->json([
                'success' => true,
                'summary' => $summary,
                'period' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'description' => 'Current Month (' . now()->format('F Y') . ')'
                ],
                'debug' => [
                    'total_givings_in_db' => Giving::count(),
                    'completed_givings_in_db' => $allCompleted->count(),
                    'pending_givings_in_db' => $allPending->count(),
                    'current_month_completed' => $currentMonthCompleted->count(),
                    'current_month_pending' => $currentMonthPending->count(),
                    'user_role' => auth()->user()->role
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Dashboard summary error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load dashboard data: ' . $e->getMessage(),
                'summary' => array_fill_keys(['total_amount', 'total_tithes', 'total_offerings', 'total_donations', 'transaction_count', 'processing_fees', 'pending_count'], 0)
            ], 500);
        }
    }

    /**
     * Admin: Financial reports
     */
    public function reports(Request $request)
    {
        $this->authorize('viewReports', Giving::class);

        // If no dates provided, show all completed givings instead of just this month
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Build base query for completed givings
        $completedQuery = Giving::completed();
        $pendingQuery = Giving::pending();

        // Apply date filtering only if dates are provided
        if ($startDate && $endDate) {
            $completedQuery->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('confirmed_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                      ->orWhereBetween('payment_date', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            });
            $pendingQuery->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } elseif ($startDate) {
            $completedQuery->where(function($query) use ($startDate) {
                $query->where('confirmed_at', '>=', $startDate . ' 00:00:00')
                      ->orWhere('payment_date', '>=', $startDate . ' 00:00:00');
            });
            $pendingQuery->where('created_at', '>=', $startDate . ' 00:00:00');
        } elseif ($endDate) {
            $completedQuery->where(function($query) use ($endDate) {
                $query->where('confirmed_at', '<=', $endDate . ' 23:59:59')
                      ->orWhere('payment_date', '<=', $endDate . ' 23:59:59');
            });
            $pendingQuery->where('created_at', '<=', $endDate . ' 23:59:59');
        }
        // If no dates provided, show all data (no date filtering)

        $summary = [
            'total_amount' => (clone $completedQuery)->sum('amount') ?: 0,
            'total_tithes' => (clone $completedQuery)->where('giving_type', 'tithe')->sum('amount') ?: 0,
            'total_offerings' => (clone $completedQuery)->where('giving_type', 'offering')->sum('amount') ?: 0,
            'total_donations' => (clone $completedQuery)->whereIn('giving_type', ['donation', 'special_offering'])->sum('amount') ?: 0,
            'transaction_count' => (clone $completedQuery)->count() ?: 0,
            'processing_fees' => (clone $completedQuery)->sum('processing_fee') ?: 0,
            'pending_count' => (clone $pendingQuery)->count() ?: 0,
        ];

        $byPaymentMethod = (clone $completedQuery)
            ->select('payment_method', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->get();

        // Set display dates
        $displayStartDate = $startDate ?: 'All time';
        $displayEndDate = $endDate ?: 'All time';

        // If this is an AJAX request, return JSON
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'summary' => $summary,
                'by_payment_method' => $byPaymentMethod,
                'period' => [
                    'start_date' => $displayStartDate,
                    'end_date' => $displayEndDate
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