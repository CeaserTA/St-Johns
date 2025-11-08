<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>St. Johns Parish Church - Members Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            background-color: #1e3a8a;
        }
        .topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }
        .table-container {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .fab {
            background-color: #1e3a8a;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .fab:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
    <!-- Sidebar Navigation -->
    <aside class="sidebar w-64 text-white flex flex-col">
        <div>
            <div class="p-6 text-2xl font-semibold border-b border-blue-900">
                St. Johns Admin
            </div>
            <nav class="mt-6">
                <ul>
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 hover:bg-blue-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-10 0h3" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('members') }}" class="flex items-center px-6 py-3 bg-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Members
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Top Bar -->
        <header class="topbar flex items-center justify-between px-6 py-4">
            <h1 class="text-xl font-bold text-gray-800">All Church Members</h1>
            <div class="flex items-center space-x-4">
                <form action="{{ route('members') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Search members..." value="{{ request('search') }}" class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700" />
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-6 overflow-y-auto">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Members Table -->
            <div class="table-container p-6 overflow-x-auto">
                <table class="w-full min-w-[700px] text-left border-collapse">
                    <thead>
                        <tr class="text-gray-600 border-b border-gray-200 bg-gray-50">
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Gender</th>
                            <th class="py-3 px-4">Phone</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Address</th>
                            <th class="py-3 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($members as $member)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-4 font-medium">{{ $member->first_name }} {{ $member->last_name }}</td>
                                <td class="py-3 px-4">{{ $member->gender }}</td>
                                <td class="py-3 px-4">{{ $member->phone ?? 'N/A' }}</td>
                                <td class="py-3 px-4">{{ $member->email ?? 'N/A' }}</td>
                                <td class="py-3 px-4">{{ $member->address ?? 'N/A' }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('members.show', $member->id) }}" class="text-blue-500 hover:underline px-2 py-1 rounded hover:bg-blue-50">View</a>
                                        <a href="{{ route('members.edit', $member->id) }}" class="text-yellow-500 hover:underline px-2 py-1 rounded hover:bg-yellow-50">Edit</a>
                                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline px-2 py-1 rounded hover:bg-red-50">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">No members found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $members->links() }}
                </div>
            </div>

            <!-- Floating Action Button -->
            <a href="{{ route('members.create') }}" class="fab fixed bottom-6 right-6 w-14 h-14 flex items-center justify-center rounded-full text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </main>
    </div>
</body>
</html>
