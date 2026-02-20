<?php

namespace App\Notifications;

use App\Models\ServiceRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ServicePaymentSubmitted extends Notification
{
    use Queueable;

    protected ServiceRegistration $registration;

    /**
     * Create a new notification instance.
     */
    public function __construct(ServiceRegistration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        $registrantName = $this->registration->registrant_name;
        $serviceName = $this->registration->service->name ?? 'Unknown Service';
        $amount = number_format($this->registration->amount_paid, 0);
        $currency = $this->registration->service->currency ?? 'UGX';
        
        return [
            'type' => 'service_payment',
            'title' => 'Service Payment Submitted',
            'message' => "{$registrantName} submitted payment proof for {$serviceName}: {$currency} {$amount}",
            'icon' => 'calendar',
            'color' => 'purple',
            'action_url' => route('admin.services') . '?highlight=' . $this->registration->id,
            'entity_type' => 'service_registration',
            'entity_id' => $this->registration->id,
            'metadata' => [
                'service_name' => $serviceName,
                'member_name' => $registrantName,
                'amount' => $this->registration->amount_paid,
                'payment_method' => $this->registration->payment_method,
                'transaction_reference' => $this->registration->transaction_reference,
            ],
        ];
    }
}
