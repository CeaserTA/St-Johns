<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard - St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="styles.css">
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
        <aside class="w-64 bg-blue-800 text-white flex flex-col">
            <div class="p-6 text-2xl font-bold border-b border-blue-900">
                St. Johns Admin
            </div>
            <nav class="mt-6">
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
                        <a href="{{ route('members') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('members*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Members
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('service.register') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ (request()->routeIs('service.register') || request()->routeIs('service.registrations')) ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Services
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center px-6 py-3 hover:bg-blue-700 rounded-r-lg transition">
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
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="flex items-center justify-between px-6 py-4 bg-white shadow-sm">
                <h1 class="text-xl font-bold text-gray-800">St Johns Church Admin Panel</h1>
            </header>

            <!-- Main Area -->
            <main class="flex-1 p-6 overflow-y-auto bg-gray-50">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Total Members</h2>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalMembers }}</p>
                        <p class="text-sm text-gray-500 mt-1">All registered members</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">New Registrations</h2>
                        <p class="text-3xl font-bold text-green-600">{{ $newRegistrations }}</p>
                        <p class="text-sm text-gray-500 mt-1">This month</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Active Members</h2>
                        <p class="text-3xl font-bold text-yellow-600">{{ $activeMembers }}</p>
                        <p class="text-sm text-gray-500 mt-1">Attended in last 3 months</p>
                    </div>
                </div>

                <!-- Recent Service Registrations -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent Service Registrations</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Name</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Email</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Phone</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Service</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Registered At</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($recentServiceRegistrations as $reg)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->full_name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->email ?? '—' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->phone_number ?? '—' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->service }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700" colspan="5">No service registrations yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    
</body>
</html>