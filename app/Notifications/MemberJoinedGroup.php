<?php

namespace App\Notifications;

use App\Models\Member;
use App\Models\Group;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MemberJoinedGroup extends Notification
{
    use Queueable;

    protected Member $member;
    protected Group $group;

    /**
     * Create a new notification instance.
     */
    public function __construct(Member $member, Group $group)
    {
        $this->member = $member;
        $this->group = $group;
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
            'type' => 'group_joined',
            'title' => 'Member Joined Group',
            'message' => "{$this->member->full_name} joined {$this->group->name}",
            'icon' => 'group',
            'color' => 'orange',
            'action_url' => route('admin.groups') . '?group=' . $this->group->id,
            'entity_type' => 'group',
            'entity_id' => $this->group->id,
            'metadata' => [
                'group_name' => $this->group->name,
                'member_name' => $this->member->full_name,
                'member_id' => $this->member->id,
            ],
        ];
    }
}
