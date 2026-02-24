<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display all notifications page
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all'); // all, unread, read
        
        $query = auth()->user()->notifications()->orderBy('created_at', 'desc');
        
        if ($filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($filter === 'read') {
            $query->whereNotNull('read_at');
        }
        
        $notifications = $query->paginate(20);
        
        return view('admin.notifications.index', compact('notifications', 'filter'));
    }

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
    public function markAllAsRead(Request $request)
    {
        auth()->user()
            ->unreadNotifications()
            ->update(['read_at' => now()]);

        $count = auth()->user()->unreadNotifications()->count();

        // If it's an AJAX request, return JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'unread_count' => $count
            ]);
        }

        // Otherwise redirect back with success message
        return redirect()->back()->with('success', 'All notifications marked as read');
    }

    /**
     * Show a single notification
     */
    public function show(string $id): JsonResponse
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->first();
        
        if (!$notification) {
            return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
        }

        // Mark as read when viewed
        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return response()->json([
            'success' => true,
            'notification' => [
                'id' => $notification->id,
                'type' => $notification->data['type'] ?? 'unknown',
                'title' => $notification->data['title'] ?? '',
                'message' => $notification->data['message'] ?? '',
                'action_url' => $notification->data['action_url'] ?? null,
                'created_at' => $notification->created_at->format('M d, Y \a\t g:i A'),
                'read_at' => $notification->read_at?->format('M d, Y \a\t g:i A'),
            ]
        ]);
    }

    /**
     * Delete a single notification
     */
    public function destroy(string $id): JsonResponse
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->first();
        
        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true, 'message' => 'Notification deleted']);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }

    /**
     * Delete multiple notifications
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'required|string'
        ]);

        $deleted = auth()->user()
            ->notifications()
            ->whereIn('id', $request->notification_ids)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => "{$deleted} notification(s) deleted",
            'deleted_count' => $deleted
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
