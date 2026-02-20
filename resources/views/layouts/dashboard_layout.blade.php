<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Dashboard') - St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="/styles.css">
    @include('partials.theme-config')

    <!-- Dark Mode Script -->
    <script>
        // Check for saved theme preference or default to 'light'
        const theme = localStorage.getItem('theme') || 'light';
        document.documentElement.classList.add(theme);
    </script>
</head>

<body
    class="bg-background-light dark:bg-background-dark text-text-light dark:text-text-dark font-display min-h-screen transition-colors duration-300">
    <div class="flex h-screen overflow-hidden bg-gray-50 dark:bg-background-dark transition-colors duration-200">
        <x-sidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Bar -->
            <header
                 class="flex items-center justify-between px-5 py-4 bg-white dark:bg-background-dark border-b border-gray-200 dark:border-gray-700 shadow-md flex-shrink-0 transition-colors duration-300">
                <!-- Left Section: Hamburger + Search Bar – Sacred & Modern -->
                <div class="flex items-center gap-3 sm:gap-6 flex-1 min-w-0">
                    <!-- Hamburger Menu for Mobile -->
                    <button id="hamburgerBtn"
                        class="md:hidden inline-flex items-center justify-center p-2.5 rounded-xl text-primary hover:bg-accent/10 focus:outline-none focus:ring-2 focus:ring-accent/30 transition-all duration-200 flex-shrink-0">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Search Bar – Premium & Subtle -->
                    <div class="hidden sm:flex items-center flex-1 max-w-md">
                        <div class="w-full relative">
                            <input type="text" placeholder="Search members, events, givings..."
                                class="w-full pl-5 pr-12 py-3 rounded-xl border border-gray-200 focus:border-accent focus:ring-4 focus:ring-accent/20 bg-white text-primary placeholder-gray-500 text-base transition-all duration-200 shadow-sm hover:shadow" />
                            <button type="submit"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-accent hover:text-secondary transition-colors">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

<!-- Right Section: Theme Toggle + Notification + Logout – Dark Mode Fixed -->
<div class="flex items-center gap-3 sm:gap-5 flex-shrink-0">
    <!-- Theme Toggle Button -->
    <button id="themeToggle"
            class="p-2.5 rounded-xl text-text-light dark:text-text-dark hover:bg-accent/10 dark:hover:bg-accent/20 focus:outline-none focus:ring-2 focus:ring-accent/30 transition-all duration-200"
            title="Toggle Dark/Light Mode">
        <svg id="sunIcon" class="h-7 w-7 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <svg id="moonIcon" class="h-7 w-7 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    </button>

    <!-- Admin Notification Widget -->
    <div class="relative" x-data="notificationWidget()">
        <button @click="toggleDropdown()" 
                class="relative p-2.5 rounded-xl transition-all duration-200"
                :class="unreadCount > 0 ? 'text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20' : 'text-text-light dark:text-text-dark hover:bg-accent/10 dark:hover:bg-accent/20'"
                title="Notifications">
            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            
            <!-- Unread Badge -->
            <span x-show="unreadCount > 0" 
                  x-text="unreadCount > 99 ? '99+' : unreadCount"
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 scale-50"
                  x-transition:enter-end="opacity-100 scale-100"
                  x-cloak
                  class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1.5 shadow-md ring-2 ring-white dark:ring-gray-800">
            </span>
        </button>

        <!-- Notification Dropdown -->
        <div x-show="showDropdown" 
             @click.away="showDropdown = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
             x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
             class="absolute right-0 mt-2 w-96 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 z-50 overflow-hidden"
             style="display: none;">
          
          <!-- Header -->
          <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
            <button @click="markAllAsRead()" 
                    x-show="unreadCount > 0"
                    class="text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition">
              Mark All as Read
            </button>
          </div>

          <!-- Notification List -->
          <div class="max-h-96 overflow-y-auto">
            <!-- Loading State -->
            <div x-show="loading" class="flex items-center justify-center py-8">
              <svg class="animate-spin h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
            </div>

            <!-- Empty State -->
            <div x-show="!loading && notifications.length === 0" 
                 class="flex flex-col items-center justify-center py-12 px-4">
              <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">No notifications</p>
              <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">You're all caught up!</p>
            </div>

            <!-- Notification Items -->
            <template x-for="notification in notifications" :key="notification.id">
              <a :href="notification.action_url" 
                 @click="markAsRead(notification.id)"
                 class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                <div class="flex items-start gap-3">
                  <!-- Icon -->
                  <div class="flex-shrink-0 mt-0.5">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center"
                         :class="getNotificationIconClass(notification.type)">
                      <span x-html="getNotificationIcon(notification.type)"></span>
                    </div>
                  </div>

                  <!-- Content -->
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white mb-0.5" x-text="notification.title"></p>
                    <p class="text-xs text-gray-600 dark:text-gray-300 line-clamp-2" x-text="notification.message"></p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1" x-text="formatTimestamp(notification.created_at)"></p>
                  </div>

                  <!-- Unread Indicator -->
                  <div x-show="!notification.read_at" class="flex-shrink-0">
                    <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                  </div>
                </div>
              </a>
            </template>
          </div>

          <!-- Footer -->
          <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-700">
            <a href="#" 
               class="text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition flex items-center justify-center gap-1">
              View All Notifications
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </a>
          </div>
        </div>
    </div>

    <!-- Logout Button -->
    <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit"
                class="px-5 sm:px-6 py-2.5 text-sm font-bold text-white bg-secondary hover:bg-accent hover:text-primary rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2.5 focus:outline-none focus:ring-2 focus:ring-accent/30">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="hidden sm:inline">Logout</span>
        </button>
    </form>
</div>
            </header>

            <!-- Main Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-background-dark transition-colors duration-200">
                <div class="w-full px-4 sm:px-6 py-4 sm:py-6">
                    @if ($message = Session::get('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded" role="alert">
                            <span>{{ $message }}</span>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded" role="alert">
                            <span>{{ $message }}</span>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        // Theme Toggle Functionality
        const themeToggle = document.getElementById('themeToggle');
        const htmlElement = document.documentElement;

        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.classList.contains('dark') ? 'dark' : 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            htmlElement.classList.remove(currentTheme);
            htmlElement.classList.add(newTheme);
            localStorage.setItem('theme', newTheme);
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (window.innerWidth < 768) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        // Close sidebar when clicking overlay
        document.getElementById('sidebarOverlay').addEventListener('click', function () {
            closeMobileSidebar();
        });

        // Handle window resize
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) {
                document.getElementById('sidebar').classList.remove('-translate-x-full');
                document.getElementById('sidebarOverlay').classList.add('hidden');
            }
        });

        // Alpine.js Notification Widget
        function notificationWidget() {
            return {
                unreadCount: 0,
                showDropdown: false,
                notifications: [],
                loading: false,
                pollingInterval: null,
                
                init() {
                    this.fetchUnreadCount();
                    this.startPolling();
                },
                
                async fetchUnreadCount() {
                    try {
                        const response = await fetch('{{ route("notifications.unread-count") }}', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            },
                            credentials: 'same-origin'
                        });
                        
                        if (response.ok) {
                            const data = await response.json();
                            this.unreadCount = data.count || 0;
                        }
                    } catch (error) {
                        console.error('Error fetching unread count:', error);
                    }
                },
                
                async toggleDropdown() {
                    this.showDropdown = !this.showDropdown;
                    
                    if (this.showDropdown && this.notifications.length === 0) {
                        await this.loadNotifications();
                    }
                },
                
                async loadNotifications() {
                    this.loading = true;
                    
                    try {
                        const response = await fetch('{{ route("notifications.unread") }}', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            },
                            credentials: 'same-origin'
                        });
                        
                        if (response.ok) {
                            const data = await response.json();
                            this.notifications = Array.isArray(data) ? data : [];
                        }
                    } catch (error) {
                        console.error('Error loading notifications:', error);
                    } finally {
                        this.loading = false;
                    }
                },
                
                async markAsRead(notificationId) {
                    try {
                        const response = await fetch(`/api/notifications/${notificationId}/read`, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            },
                            credentials: 'same-origin'
                        });
                        
                        if (response.ok) {
                            const notification = this.notifications.find(n => n.id === notificationId);
                            if (notification && !notification.read_at) {
                                notification.read_at = new Date().toISOString();
                                this.unreadCount = Math.max(0, this.unreadCount - 1);
                            }
                        }
                    } catch (error) {
                        console.error('Error marking notification as read:', error);
                    }
                },
                
                async markAllAsRead() {
                    try {
                        const response = await fetch('/api/notifications/read-all', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            },
                            credentials: 'same-origin'
                        });
                        
                        if (response.ok) {
                            this.notifications.forEach(notification => {
                                if (!notification.read_at) {
                                    notification.read_at = new Date().toISOString();
                                }
                            });
                            this.unreadCount = 0;
                        }
                    } catch (error) {
                        console.error('Error marking all as read:', error);
                    }
                },
                
                startPolling() {
                    this.pollingInterval = setInterval(() => {
                        this.fetchUnreadCount();
                        if (this.showDropdown) {
                            this.loadNotifications();
                        }
                    }, 30000);
                },
                
                formatTimestamp(timestamp) {
                    const date = new Date(timestamp);
                    const now = new Date();
                    const diffInSeconds = Math.floor((now - date) / 1000);
                    
                    if (diffInSeconds < 60) return 'Just now';
                    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)}m ago`;
                    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h ago`;
                    if (diffInSeconds < 31536000) return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                },
                
                getNotificationIcon(type) {
                    const iconMap = {
                        'member_registered': `<svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>`,
                        'account_created': `<svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>`,
                        'giving_submitted': `<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`,
                        'service_registered': `<svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>`,
                        'service_payment': `<svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>`,
                        'group_joined': `<svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>`
                    };
                    return iconMap[type] || `<svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>`;
                },
                
                getNotificationIconClass(type) {
                    const colorMap = {
                        'member_registered': 'bg-blue-100 dark:bg-blue-900/30',
                        'account_created': 'bg-indigo-100 dark:bg-indigo-900/30',
                        'giving_submitted': 'bg-green-100 dark:bg-green-900/30',
                        'service_registered': 'bg-purple-100 dark:bg-purple-900/30',
                        'service_payment': 'bg-yellow-100 dark:bg-yellow-900/30',
                        'group_joined': 'bg-orange-100 dark:bg-orange-900/30'
                    };
                    return colorMap[type] || 'bg-gray-100 dark:bg-gray-700';
                }
            }
        }
    </script>
</body>

</html>