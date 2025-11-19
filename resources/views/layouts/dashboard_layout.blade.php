<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Dashboard') - St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="/styles.css">
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#3A5C83",
                        "secondary": "#F2C94C",
                        "background-light": "#F8F9FA",
                        "background-dark": "#101922",
                        "text-light": "#333333",
                        "text-dark": "#F8F9FA",
                        "text-muted-light": "#4c739a",
                        "text-muted-dark": "#a0aec0",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                },
            },
        }
    </script>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20h.01" />
                            </svg>
                            Announcements
                        </a>
                    </li>
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
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
