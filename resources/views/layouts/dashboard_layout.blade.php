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
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-800 text-white flex flex-col fixed h-screen">
            <div class="p-6 text-2xl font-bold border-b border-blue-900 flex-shrink-0">
                St. Johns Admin
            </div>
            <nav class="flex-1 overflow-y-auto">
                <ul>
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('dashboard') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-10 0h3" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.members') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.members*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Members
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.services') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.services*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Services
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.events') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.events*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Events
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.groups') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.groups*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m0-4a4 4 0 110-8 4 4 0 010 8z" />
                            </svg>
                            Groups
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.announcements') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.announcements*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                            Announcements
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.givings') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.givings*') || request()->routeIs('admin.giving*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Giving ❤️
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
        <!-- Main Content Area with Left Margin for Fixed Sidebar -->
        <div class="ml-64 flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="flex items-center justify-between px-6 py-4 bg-white shadow-sm">
                <h1 class="text-xl font-bold text-gray-800">@yield('header_title', 'St Johns Church Admin Panel')</h1>
            </header>

            <!-- Main Area -->
            <main class="flex-1 p-6 overflow-y-auto bg-gray-50">
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
</body>
</html>
