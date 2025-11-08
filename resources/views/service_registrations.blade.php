<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service Registrations Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-800 text-white flex flex-col">
        <div class="p-6 text-2xl font-bold border-b border-blue-900">
            St. Johns Admin
        </div>

        <nav class="mt-6 flex-1">
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center px-6 py-3 hover:bg-blue-700 transition {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-10 0h3"/>
                        </svg>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('members') }}"
                       class="flex items-center px-6 py-3 transition rounded-r-lg {{ request()->routeIs('members*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Members
                    </a>
                </li>

                <li>
                    <a href="{{ route('service.register') }}"
                       class="flex items-center px-6 py-3 transition rounded-r-lg {{ (request()->routeIs('service.register') || request()->routeIs('service.registrations')) ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
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

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">

        <header class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Service Registrations — Summary</h1>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline text-sm">
                ← Back to dashboard
            </a>
        </header>

        @php
            if (!isset($serviceCounts)) {
                $serviceCounts = \App\Models\ServiceRegistration::select('service', \DB::raw('count(*) as total'))
                    ->groupBy('service')
                    ->orderByDesc('total')
                    ->get();
            }
            $overall = $serviceCounts->sum('total') ?? 0;
        @endphp

        <!-- Summary Stats -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm text-gray-500">Services Tracked</div>
                <div class="text-3xl font-bold mt-2">{{ $serviceCounts->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm text-gray-500">Total Registrations</div>
                <div class="text-3xl font-bold mt-2">{{ $overall }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm text-gray-500">Last Update</div>
                <div class="text-3xl font-bold mt-2">{{ now()->format('Y-m-d H:i') }}</div>
            </div>
        </section>

        <!-- Table Section -->
        <section class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-medium">Registrations by Service</h2>
                <p class="text-sm text-gray-500">Overview of how many people registered for each service.</p>
            </div>

            <div class="p-6 overflow-x-auto">
                <table class="min-w-full text-left text-sm bg-white shadow rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 font-medium text-gray-600">Service</th>
                            <th class="px-4 py-3 font-medium text-gray-600">Name</th>
                            <th class="px-4 py-3 font-medium text-gray-600">Email</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($services as $serviceName => $registrations)
                            @foreach($registrations as $reg)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $serviceName }}</td>
                                    <td class="px-4 py-3">{{ $reg->full_name }}</td>
                                    <td class="px-4 py-3">{{ $reg->email }}</td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-gray-500">No registrations yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>


            </div>
        </section>

        <footer class="mt-8 text-sm text-gray-500 text-center">
            Tip: You can add filters (by date, category) in the controller and pass them here.
        </footer>
    </main>
</body>
</html>
