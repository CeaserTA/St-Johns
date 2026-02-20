<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get unread notifications count for the current user
     */
    public function getUnreadCount(): JsonResponse
    {
        $count = auth()->user()
            ->unreadNotifications()
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Get all unread notifications for the current user
     */
    public function getUnreadNotifications(): JsonResponse
    {
        $notifications = auth()->user()
            ->unreadNotifications()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->data['type'] ?? 'unknown',
                    'title' => $notification->data['title'] ?? '',
                    'message' => $notification->data['message'] ?? '',
                    'icon' => $notification->data['icon'] ?? 'notifications',
                    'color' => $notification->data['color'] ?? 'gray',
                    'action_url' => $notification->data['action_url'] ?? '#',
                    'created_at' => $notification->created_at->toIso8601String(),
                    'created_at_human' => $this->formatRelativeTime($notification->created_at),
                    'read_at' => $notification->read_at?->toIso8601String(),
                ];
            });

        return response()->json($notifications);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(string $id): JsonResponse
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->first();
        
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(): JsonResponse
    {
        auth()->user()
            ->unreadNotifications()
            ->update(['read_at' => now()]);

        $count = auth()->user()->unreadNotifications()->count();

        return response()->json([
            'success' => true,
            'unread_count' => $count
        ]);
    }

    /**
     * Format timestamp as relative time
     */
    private function formatRelativeTime($timestamp): string
    {
        $now = now();
        $diff = $timestamp->diffInSeconds($now);

        if ($diff < 60) {
            return 'Just now';
        } elseif ($diff < 3600) {
            $minutes = floor($diff / 60);
            return $minutes . 'm ago';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . 'h ago';
        } elseif ($diff < 31536000) {
            return $timestamp->format('M d');
        } else {
            return $timestamp->format('M d, Y');
        }
    }
}
