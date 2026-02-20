<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewAccountCreated extends Notification
{
    use Queueable;

    protected User $user;
    protected ?Member $member;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, ?Member $member = null)
    {
        $this->user = $user;
        $this->member = $member;
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
        $memberName = $this->member ? $this->member->full_name : $this->user->name;
        
        return [
            'type' => 'account_created',
            'title' => 'New Account Created',
            'message' => "{$memberName} has created an account",
            'icon' => 'account',
            'color' => 'indigo',
            'action_url' => route('admin.members') . ($this->member ? '#member-' . $this->member->id : ''),
            'entity_type' => 'user',
            'entity_id' => $this->user->id,
            'metadata' => [
                'account_email' => $this->user->email,
                'member_name' => $memberName,
                'member_id' => $this->member?->id,
            ],
        ];
    }
}
