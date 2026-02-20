<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceRegistration;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\Notifications\ServiceRegistrationCreated;
use App\Notifications\ServicePaymentSubmitted;

class ServiceRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        // Fetch all registrations with their related services
        $registrations = ServiceRegistration::with('service')->latest()->get();
        
        // Group by service
        $services = $registrations->groupBy('service.name');

        // Get count per service
        $serviceCounts = $services->map(function ($regs) {
            return $regs->count();
        });

        return view('service_registrations', compact('services', 'serviceCounts', 'registrations'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = \Auth::user();
        $member = $user->member;
        
        // Check if user has member profile
        if (!$member) {
            return back()->with('error', 'Please complete your member profile first.');
        }
        
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        // Get the service
        $service = Service::findOrFail($validated['service_id']);

        // Create registration linked to member
        $registration = ServiceRegistration::create([
            'service_id' => $validated['service_id'],
            'member_id' => $member->id,
            'amount_paid' => 0,
            'payment_status' => $service->isFree() ? 'paid' : 'pending',
            'paid_at' => $service->isFree() ? now() : null,
        ]);

        // Send notification to admins
        try {
            $notificationService = app(NotificationService::class);
            $notificationService->notifyAdmins(new ServiceRegistrationCreated($registration));
        } catch (\Exception $e) {
            \Log::error('Failed to send service registration notification', [
                'registration_id' => $registration->id,
                'error' => $e->getMessage()
            ]);
            // Don't fail registration if notification fails
        }

        $serviceName = $registration->service->name;

        if ($service->isFree()) {
            return back()->with('success', 'Thank you! You are registered for ' . $serviceName . '.');
        } else {
            return back()->with([
                'success' => 'Registration successful! Please complete payment to confirm your registration.',
                'show_payment_modal' => true,
                'registration_data' => [
                    'registration_id' => $registration->id,
                    'service_name' => $service->name,
                    'service_fee' => $service->formatted_fee,
                ]
            ]);
        }
    }

    /**
     * Submit payment proof
     */
    public function submitPaymentProof(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:service_registrations,id',
            'payment_method' => 'required|in:mobile_money,bank_transfer,cash',
            'transaction_reference' => 'required|string|max:255',
            'payment_notes' => 'nullable|string|max:1000',
        ]);

        $registration = ServiceRegistration::findOrFail($validated['registration_id']);

        // Update registration with payment proof
        $registration->update([
            'payment_method' => $validated['payment_method'],
            'transaction_reference' => $validated['transaction_reference'],
            'payment_notes' => $validated['payment_notes'] ?? null,
            // Status remains 'pending' until admin confirms
        ]);

        // Send notification to admins
        try {
            $notificationService = app(NotificationService::class);
            $notificationService->notifyAdmins(new ServicePaymentSubmitted($registration));
        } catch (\Exception $e) {
            \Log::error('Failed to send service payment notification', [
                'registration_id' => $registration->id,
                'error' => $e->getMessage()
            ]);
            // Don't fail payment submission if notification fails
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment proof submitted successfully. Our team will verify and send you a confirmation email.',
        ]);
    }

    /**
     * Get authenticated member's service registrations
     */
    public function myRegistrations()
    {
        $user = \Auth::user();
        
        if (!$user || !$user->member) {
            return response()->json([
                'success' => false,
                'message' => 'Member profile not found'
            ], 404);
        }

        $registrations = ServiceRegistration::where('member_id', $user->member->id)
            ->with('service')
            ->latest()
            ->get()
            ->map(function ($reg) {
                return [
                    'id' => $reg->id,
                    'service_name' => $reg->service->name,
                    'service_fee' => $reg->service->isFree() ? null : $reg->service->formatted_fee,
                    'payment_status' => $reg->payment_status,
                    'registered_date' => $reg->created_at->format('M d, Y'),
                ];
            });

        return response()->json([
            'success' => true,
            'registrations' => $registrations
        ]);
    }

    /**
     * Get authenticated member's pending payments
     */
    public function myPendingPayments()
    {
        $user = \Auth::user();
        
        if (!$user || !$user->member) {
            return response()->json([
                'success' => false,
                'message' => 'Member profile not found'
            ], 404);
        }

        $pendingPayments = ServiceRegistration::where('member_id', $user->member->id)
            ->where('payment_status', 'pending')
            ->with('service')
            ->latest()
            ->get()
            ->filter(function ($reg) {
                return !$reg->service->isFree(); // Only show paid services
            })
            ->map(function ($reg) {
                return [
                    'id' => $reg->id,
                    'service_name' => $reg->service->name,
                    'service_fee' => $reg->service->formatted_fee,
                    'registered_date' => $reg->created_at->format('M d, Y'),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'payments' => $pendingPayments
        ]);
    }

  
}
