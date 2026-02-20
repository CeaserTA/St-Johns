<?php

namespace App\Notifications;

use App\Models\Giving;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewGivingSubmitted extends Notification
{
    use Queueable;

    protected Giving $giving;

    /**
     * Create a new notification instance.
     */
    public function __construct(Giving $giving)
    {
        $this->giving = $giving;
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
        $giverName = $this->giving->giver_name;
        $amount = number_format($this->giving->amount, 0);
        $currency = $this->giving->currency;
        $type = ucfirst($this->giving->giving_type);
        
        return [
            'type' => 'giving_submitted',
            'title' => 'New Giving Submitted',
            'message' => "{$giverName} submitted {$type}: {$currency} {$amount} via {$this->giving->payment_method}",
            'icon' => 'money',
            'color' => 'green',
            'action_url' => route('admin.givings') . '?highlight=' . $this->giving->id,
            'entity_type' => 'giving',
            'entity_id' => $this->giving->id,
            'metadata' => [
                'giver_name' => $giverName,
                'amount' => $this->giving->amount,
                'currency' => $this->giving->currency,
                'giving_type' => $this->giving->giving_type,
                'payment_method' => $this->giving->payment_method,
                'transaction_reference' => $this->giving->transaction_reference,
            ],
        ];
    }
}
