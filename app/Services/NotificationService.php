<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send a notification to all admin users.
     *
     * @param Notification $notification
     * @return void
     */
    public function notifyAdmins(Notification $notification): void
    {
        try {
            $admins = $this->getAdminUsers();
            
            if ($admins->isEmpty()) {
                Log::warning('No admin users found to send notification');
                return;
            }
            
            \Illuminate\Support\Facades\Notification::send($admins, $notification);
        } catch (\Exception $e) {
            Log::error('Failed to send notification to admins', [
                'notification_type' => get_class($notification),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Get all users with admin role.
     *
     * @return Collection
     */
    private function getAdminUsers(): Collection
    {
        return User::where('role', 'admin')->get();
    }
}
