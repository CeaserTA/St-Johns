<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - St. John's</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="/styles.css">
    @stack('head')
</head>
<body class="bg-background-light font-display text-text-light">
    <div class="flex h-screen overflow-hidden bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-800 text-white flex flex-col">
            <div class="p-6 text-2xl font-bold border-b border-blue-900">St. Johns Admin</div>
            <nav class="mt-6 flex-1">
                <ul>
                    <li class="mb-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 rounded-r-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-700' : 'hover:bg-blue-700/30' }}">
                            <span class="material-icons">dashboard</span>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('members') }}" class="flex items-center px-6 py-3 rounded-r-lg transition-all duration-200 {{ request()->routeIs('members*') ? 'bg-blue-700' : 'hover:bg-blue-700/30' }}">
                            <span class="material-icons">people</span>
                            <span class="ml-3">Members</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('service.registrations') }}" class="flex items-center px-6 py-3 rounded-r-lg transition-all duration-200 {{ request()->routeIs('service.registrations*') ? 'bg-blue-700' : 'hover:bg-blue-700/30' }}">
                            <span class="material-icons">home_repair_service</span>
                            <span class="ml-3">Services</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full px-4 py-2 bg-blue-600 rounded">Logout</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="flex items-center justify-between px-6 py-4 bg-white shadow-sm">
                <h1 class="text-xl font-bold text-gray-800">@yield('header', config('app.name'))</h1>
                @yield('header-actions')
            </header>

        {{-- Main Area --}}
        <main class="flex-1 overflow-y-auto bg-cream">
            <div class="w-full px-4 sm:px-6 py-4 sm:py-6">
                @yield('content')
            </div>
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

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        }
    });
</script>

@stack('scripts')
</body>
</html>