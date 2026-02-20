<?php

namespace App\Notifications;

use App\Models\ServiceRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ServiceRegistrationCreated extends Notification
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
        $registrationDate = $this->registration->created_at->format('M d, Y');
        
        return [
            'type' => 'service_registered',
            'title' => 'New Service Registration',
            'message' => "{$registrantName} registered for {$serviceName}",
            'icon' => 'calendar',
            'color' => 'purple',
            'action_url' => route('admin.services') . '?highlight=' . $this->registration->id,
            'entity_type' => 'service_registration',
            'entity_id' => $this->registration->id,
            'metadata' => [
                'service_name' => $serviceName,
                'member_name' => $registrantName,
                'registration_date' => $registrationDate,
                'service_id' => $this->registration->service_id,
            ],
        ];
    }
}
