<?php

namespace App\Notifications;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMemberRegistered extends Notification
{
    use Queueable;

    protected Member $member;

    /**
     * Create a new notification instance.
     */
    public function __construct(Member $member)
    {
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
        return [
            'type' => 'member_registered',
            'title' => 'New Member Registered',
            'message' => "{$this->member->full_name} has registered as a new member",
            'icon' => 'person',
            'color' => 'blue',
            'action_url' => route('admin.members') . '#member-' . $this->member->id,
            'entity_type' => 'member',
            'entity_id' => $this->member->id,
            'metadata' => [
                'member_name' => $this->member->full_name,
                'member_email' => $this->member->email,
                'member_phone' => $this->member->phone,
            ],
        ];
    }
}
