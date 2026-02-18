<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Dashboard') - St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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

    <!-- Notification Icon -->
    <button id="notificationBtn"
            class="relative p-2.5 rounded-xl text-text-light dark:text-text-dark hover:bg-accent/10 dark:hover:bg-accent/20 focus:outline-none focus:ring-2 focus:ring-accent/30 transition-all duration-200"
            title="Notifications">
        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span id="notificationBadge"
              class="absolute -top-1 -right-1 bg-secondary text-white text-xs font-bold min-w-[20px] h-5 px-1.5 rounded-full flex items-center justify-center shadow-sm hidden">
            0
        </span>
    </button>

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

        // Fetch notification count on page load
        function fetchNotificationCount() {
            fetch('{{ route("notifications.unread-count") }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notificationBadge');
                    if (data.count > 0) {
                        badge.textContent = data.count > 9 ? '9+' : data.count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                })
                .catch(error => console.error('Error fetching notifications:', error));
        }

        // Load notifications on page load
        document.addEventListener('DOMContentLoaded', function () {
            fetchNotificationCount();

            // Refresh notification count every 30 seconds
            setInterval(fetchNotificationCount, 30000);
        });

        // Add click handler to notification button to fetch unread notifications
        document.getElementById('notificationBtn').addEventListener('click', function () {
            fetchNotificationCount();
        });
    </script>
</body>

</html>