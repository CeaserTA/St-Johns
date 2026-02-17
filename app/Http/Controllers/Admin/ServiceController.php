<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceRegistration;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $services = Service::withCount('registrations')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('schedule', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->get();
        
        // fetch recent service registrations with their related service
        $serviceRegistrations = ServiceRegistration::with('service', 'member')->latest()->take(100)->get();
        
        // Calculate statistics
        $stats = [
            'total_services' => Service::count(),
            'total_registrations' => ServiceRegistration::count(),
            'registrations_this_month' => ServiceRegistration::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'active_services' => Service::whereHas('registrations')->count(),
        ];

        return view('admin.services_dashboard', compact('services', 'serviceRegistrations', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'schedule' => 'required|string|max:255',
            'fee' => 'nullable|numeric|min:0',
            'is_free' => 'nullable|boolean',
            'currency' => 'nullable|string|max:3',
        ]);

        // Set defaults
        $validated['fee'] = $validated['fee'] ?? 0;
        $validated['currency'] = $validated['currency'] ?? 'UGX';
        
        // Handle is_free: if checkbox is checked, it's free regardless of fee
        // If unchecked, determine based on fee amount
        if ($request->has('is_free')) {
            $validated['is_free'] = true;
        } else {
            $validated['is_free'] = ($validated['fee'] <= 0);
        }

        Service::create($validated);

        return redirect()->route('admin.services')->with('success', 'Service created successfully.');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'schedule' => 'required|string|max:255',
            'fee' => 'nullable|numeric|min:0',
            'is_free' => 'nullable|boolean',
            'currency' => 'nullable|string|max:3',
        ]);

        // Set defaults
        $validated['fee'] = $validated['fee'] ?? 0;
        $validated['currency'] = $validated['currency'] ?? 'UGX';
        
        // Handle is_free: if checkbox is checked, it's free regardless of fee
        // If unchecked, determine based on fee amount
        if ($request->has('is_free')) {
            $validated['is_free'] = true;
        } else {
            $validated['is_free'] = ($validated['fee'] <= 0);
        }

        $service->update($validated);

        return redirect()->route('admin.services')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services')->with('success', 'Service deleted successfully.');
    }

    /**
     * Confirm payment for a service registration
     */
    public function confirmPayment(Request $request, $registrationId)
    {
        $registration = ServiceRegistration::findOrFail($registrationId);

        // Generate receipt number if not exists
        if (!$registration->receipt_number) {
            $receiptNumber = $registration->generateReceiptNumber();
        } else {
            $receiptNumber = $registration->receipt_number;
        }

        $registration->update([
            'payment_status' => 'paid',
            'amount_paid' => $registration->service->fee,
            'paid_at' => now(),
            'receipt_number' => $receiptNumber,
        ]);

        // Send receipt email
        $emailSent = $registration->sendReceipt();

        $message = 'Payment confirmed successfully.';
        if ($emailSent) {
            $message .= ' Receipt email sent to ' . ($registration->guest_email ?? $registration->member->email);
        } else {
            $message .= ' However, receipt email could not be sent (no email address available).';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Reject payment for a service registration
     */
    public function rejectPayment(Request $request, $registrationId)
    {
        $registration = ServiceRegistration::findOrFail($registrationId);

        $reason = $request->input('reason');
        $notes = $registration->payment_notes ?? '';
        
        if ($reason) {
            $notes .= "\n\nRejection Reason (" . now()->format('Y-m-d H:i') . "): " . $reason;
        }

        $registration->update([
            'payment_status' => 'failed',
            'payment_notes' => $notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment rejected.',
        ]);
    }
}
