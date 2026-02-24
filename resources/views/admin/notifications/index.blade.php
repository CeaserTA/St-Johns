@extends('layouts.dashboard_layout')

@section('title', 'All Notifications')
@section('header_title', 'Notifications')

@section('content')
<div class="space-y-6" x-data="notificationsManager()">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">All Notifications</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Stay updated with all your notifications</p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Bulk Delete Button -->
            <button @click="bulkDelete()" 
                    x-show="selectedNotifications.length > 0"
                    x-transition
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete (<span x-text="selectedNotifications.length"></span>)
            </button>

            @if($notifications->where('read_at', null)->count() > 0)
            <form method="POST" action="{{ route('notifications.read-all') }}" class="inline">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 bg-primary hover:bg-secondary text-white rounded-lg transition-colors text-sm font-medium">
                    Mark All as Read
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="flex border-b border-gray-200 dark:border-gray-700">
            <a href="{{ route('notifications.index', ['filter' => 'all']) }}" 
               class="flex-1 px-6 py-3 text-center text-sm font-medium transition-colors {{ $filter === 'all' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                All
            </a>
            <a href="{{ route('notifications.index', ['filter' => 'unread']) }}" 
               class="flex-1 px-6 py-3 text-center text-sm font-medium transition-colors {{ $filter === 'unread' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                Unread
                @if($notifications->where('read_at', null)->count() > 0)
                <span class="ml-2 px-2 py-0.5 bg-red-500 text-white text-xs rounded-full">
                    {{ $notifications->where('read_at', null)->count() }}
                </span>
                @endif
            </a>
            <a href="{{ route('notifications.index', ['filter' => 'read']) }}" 
               class="flex-1 px-6 py-3 text-center text-sm font-medium transition-colors {{ $filter === 'read' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                Read
            </a>
        </div>

        <!-- Bulk Selection Header -->
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3">
            <input type="checkbox" 
                   @change="toggleSelectAll($event.target.checked)"
                   :checked="selectedNotifications.length === {{ $notifications->count() }} && {{ $notifications->count() }} > 0"
                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
            <span class="text-sm text-gray-600 dark:text-gray-400">
                <span x-show="selectedNotifications.length === 0">Select notifications</span>
                <span x-show="selectedNotifications.length > 0" x-text="`${selectedNotifications.length} selected`"></span>
            </span>
        </div>

        <!-- Notifications List -->
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($notifications as $notification)
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors {{ $notification->read_at ? 'opacity-75' : '' }}"
                 :class="{ 'bg-blue-50 dark:bg-blue-900/10': selectedNotifications.includes('{{ $notification->id }}') }">
                <div class="flex items-start gap-4">
                    <!-- Checkbox -->
                    <div class="flex-shrink-0 mt-1">
                        <input type="checkbox" 
                               value="{{ $notification->id }}"
                               @change="toggleSelection('{{ $notification->id }}')"
                               :checked="selectedNotifications.includes('{{ $notification->id }}')"
                               class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                    </div>

                    <!-- Icon -->
                    <div class="flex-shrink-0 mt-1">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $notification->read_at ? 'bg-gray-100 dark:bg-gray-600' : 'bg-blue-100 dark:bg-blue-900/30' }}">
                            @php
                                $type = $notification->data['type'] ?? 'unknown';
                                $iconMap = [
                                    'member_registered' => '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>',
                                    'account_created' => '<svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>',
                                    'giving_submitted' => '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                                    'service_registered' => '<svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>',
                                    'service_payment' => '<svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>',
                                    'group_joined' => '<svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>'
                                ];
                                $icon = $iconMap[$type] ?? '<svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>';
                            @endphp
                            {!! $icon !!}
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 line-clamp-2">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                <div class="flex items-center gap-4 mt-2">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    @if(!$notification->read_at)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        New
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2">
                                <button @click="deleteNotification('{{ $notification->id }}')"
                                        class="px-3 py-1.5 bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 rounded-lg text-xs font-medium transition-colors">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-16 px-4">
                <svg class="w-20 h-20 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No notifications</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    @if($filter === 'unread')
                        You're all caught up! No unread notifications.
                    @elseif($filter === 'read')
                        No read notifications yet.
                    @else
                        You don't have any notifications yet.
                    @endif
                </p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function notificationsManager() {
    return {
        selectedNotifications: [],
        
        toggleSelection(id) {
            const index = this.selectedNotifications.indexOf(id);
            if (index > -1) {
                this.selectedNotifications.splice(index, 1);
            } else {
                this.selectedNotifications.push(id);
            }
        },
        
        toggleSelectAll(checked) {
            if (checked) {
                this.selectedNotifications = @json($notifications->pluck('id'));
            } else {
                this.selectedNotifications = [];
            }
        },
        
        async deleteNotification(id) {
            if (!confirm('Are you sure you want to delete this notification?')) {
                return;
            }
            
            try {
                const response = await fetch(`/api/notifications/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });
                
                const data = await response.json();
                if (data.success) {
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error deleting notification:', error);
                alert('Failed to delete notification');
            }
        },
        
        async bulkDelete() {
            if (this.selectedNotifications.length === 0) {
                return;
            }
            
            if (!confirm(`Are you sure you want to delete ${this.selectedNotifications.length} notification(s)?`)) {
                return;
            }
            
            try {
                const response = await fetch('/api/notifications/bulk-delete', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        notification_ids: this.selectedNotifications
                    })
                });
                
                const data = await response.json();
                if (data.success) {
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error deleting notifications:', error);
                alert('Failed to delete notifications');
            }
        }
    }
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
