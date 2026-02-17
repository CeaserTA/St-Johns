<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceRegistration;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Show payment instructions page
     */
    public function showInstructions(ServiceRegistration $registration)
    {
        // Load the service relationship
        $registration->load('service');
        
        // Check if already paid
        if ($registration->isPaid()) {
            return redirect()->route('services')->with('success', 'This registration has already been paid.');
        }
        
        return view('payment.instructions', compact('registration'));
    }
    
    /**
     * Confirm manual payment (for admin use)
     */
    public function confirmPayment(Request $request, ServiceRegistration $registration)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string|in:mobile_money,cash,bank_transfer',
            'transaction_reference' => 'nullable|string|max:255',
            'payment_notes' => 'nullable|string',
        ]);
        
        $registration->update([
            'payment_status' => 'paid',
            'payment_method' => $validated['payment_method'],
            'transaction_reference' => $validated['transaction_reference'] ?? null,
            'payment_notes' => $validated['payment_notes'] ?? null,
            'amount_paid' => $registration->service->fee,
            'paid_at' => now(),
        ]);
        
        return redirect()->route('admin.services')->with('success', 'Payment confirmed successfully.');
    }
}
