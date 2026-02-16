<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Dashboard') - St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="/styles.css">
     @include('partials.theme-config')
</head>
<body class="bg-background-light font-display text-text-light">
    <div class="flex h-screen overflow-hidden bg-gray-100">
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 md:hidden z-30" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-blue-800 text-white flex flex-col fixed h-screen md:relative md:translate-x-0 transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0 z-40">
            <div class="p-6 text-2xl font-bold border-b border-blue-900 flex-shrink-0 flex items-center justify-between">
                <span>St. Johns Admin</span>
                <button id="closeSidebarBtn" class="md:hidden text-white hover:bg-blue-700 p-2 rounded" onclick="toggleSidebar()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="flex-1 overflow-y-auto">
                <ul>
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('dashboard') ? 'bg-blue-700' : 'hover:bg-blue-700' }}" onclick="closeMobileSidebar()">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-10 0h3" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.members') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.members*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}" onclick="closeMobileSidebar()">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Members
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.services') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.services*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}" onclick="closeMobileSidebar()">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Services
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.events') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.events*') || request()->routeIs('admin.announcements*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}" onclick="closeMobileSidebar()">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                            Updates
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.groups') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.groups*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}" onclick="closeMobileSidebar()">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m0-4a4 4 0 110-8 4 4 0 010 8z" />
                            </svg>
                            Groups
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.givings') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.givings*') || request()->routeIs('admin.giving*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}" onclick="closeMobileSidebar()">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Giving ❤️
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.qr-codes') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.qr-codes*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}" onclick="closeMobileSidebar()">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 16h4.01M12 8h4.01M8 12h.01M16 8h.01M8 16h.01M8 8h.01M12 16h.01" />
                            </svg>
                            QR Codes
                        </a>
                    </li>
                    <li class="mt-auto border-t border-blue-900 pt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center px-6 py-3 rounded-r-lg transition hover:bg-blue-700 w-full text-left">
                                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="flex items-center justify-between px-4 sm:px-6 py-4 bg-white shadow-sm">
                <!-- Hamburger Menu for Mobile -->
                <button id="hamburgerBtn" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none" onclick="toggleSidebar()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-lg sm:text-xl font-bold text-gray-800">@yield('header_title', 'St Johns Church Admin Panel')</h1>
                <div class="md:hidden w-10"></div>
            </header>

            <!-- Main Area -->
            <main class="flex-1 p-4 sm:p-6 overflow-y-auto bg-gray-50">
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
            </main>
        </div>
    </div>

    <script>
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
        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            closeMobileSidebar();
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                document.getElementById('sidebar').classList.remove('-translate-x-full');
                document.getElementById('sidebarOverlay').classList.add('hidden');
            }
        });
    </script>
</body>
</html>
