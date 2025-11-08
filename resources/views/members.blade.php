<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>St. Johns Parish Church - Members Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }
        .sidebar {
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
        }
        .topbar {
            background-color: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        }
        .table-container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        }
        .fab {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            box-shadow: 0 10px 15px -3px rgba(30, 58, 138, 0.3), 0 4px 6px -2px rgba(30, 58, 138, 0.15);
            transition: all 0.3s ease;
        }
        .fab:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(30, 58, 138, 0.4), 0 10px 10px -5px rgba(30, 58, 138, 0.2);
        }
        .nav-item {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        .nav-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: #fbbf24;
        }
        .nav-item:hover:not(.active) {
            background-color: rgba(255, 255, 255, 0.05);
        }
        .table-row {
            transition: background-color 0.2s ease;
        }
        .table-row:hover {
            background-color: #f8fafc;
        }
        .action-btn {
            transition: all 0.2s ease;
            border-radius: 6px;
            padding: 6px 12px;
        }
        .action-btn.view:hover {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        .action-btn.edit:hover {
            background-color: #fef3c7;
            color: #d97706;
        }
        .action-btn.delete:hover {
            background-color: #fee2e2;
            color: #dc2626;
        }
        .pagination .page-link {
            transition: all 0.2s ease;
        }
        .pagination .page-link:hover:not(.active) {
            background-color: #f1f5f9;
        }
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
    <!-- Sidebar Navigation -->
    <aside class="sidebar w-64 text-white flex flex-col">
        <div class="flex flex-col h-full">
            <div class="p-6 text-2xl font-bold border-b border-blue-700 flex items-center">
                <div class="w-8 h-8 rounded-full bg-amber-400 mr-3 flex items-center justify-center">
                    <span class="text-blue-900 font-black text-sm">SJ</span>
                </div>
                St. John's Admin
            </div>
            <nav class="mt-6 flex-1">
                <ul>
                    <li class="mb-1 mx-2">
                        <a href="{{ route('dashboard') }}" class="nav-item flex items-center px-4 py-3 rounded-r-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-10 0h3" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="mb-1 mx-2">
                        <a href="{{ route('members') }}" class="nav-item active flex items-center px-4 py-3 rounded-r-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Members
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="p-4 border-t border-blue-700">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="nav-item flex items-center px-4 py-3 rounded-lg w-full text-left">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Bar -->
        <header class="topbar flex items-center justify-between px-6 py-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">All Church Members</h1>
                <p class="text-sm text-gray-500 mt-1">Manage and view all registered church members</p>
            </div>
            <div class="flex items-center space-x-4">
                <form action="{{ route('members') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Search members..." value="{{ request('search') }}" 
                           class="search-input pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 w-64 transition-all duration-200" />
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto bg-gray-50/50">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Members Table -->
            <div class="table-container overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-800">Members List</h2>
                        <div class="text-sm text-gray-500">
                            Showing {{ $members->firstItem() ?? 0 }}-{{ $members->lastItem() ?? 0 }} of {{ $members->total() }} members
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-600 border-b border-gray-200 bg-gray-50">
                                <th class="py-4 px-6 font-medium text-sm uppercase tracking-wider">Name</th>
                                <th class="py-4 px-6 font-medium text-sm uppercase tracking-wider">Gender</th>
                                <th class="py-4 px-6 font-medium text-sm uppercase tracking-wider">Phone</th>
                                <th class="py-4 px-6 font-medium text-sm uppercase tracking-wider">Email</th>
                                <th class="py-4 px-6 font-medium text-sm uppercase tracking-wider">Address</th>
                                <th class="py-4 px-6 font-medium text-sm uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($members as $member)
                                <tr class="table-row border-b border-gray-100 last:border-0">
                                    <td class="py-4 px-6 font-medium text-gray-900">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-medium mr-3">
                                                {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                            </div>
                                            {{ $member->first_name }} {{ $member->last_name }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $member->gender == 'Male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                            {{ $member->gender }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-gray-700">
                                        {{ $member->phone ?? 
                                            '<span class="text-gray-400 italic">N/A</span>' }}
                                    </td>
                                    <td class="py-4 px-6 text-gray-700">
                                        {{ $member->email ?? 
                                            '<span class="text-gray-400 italic">N/A</span>' }}
                                    </td>
                                    <td class="py-4 px-6 text-gray-700 max-w-xs truncate">
                                        {{ $member->address ?? 
                                            '<span class="text-gray-400 italic">N/A</span>' }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('members.show', $member->id) }}" 
                                               class="action-btn view text-blue-600 font-medium text-sm">
                                                View
                                            </a>
                                            <a href="{{ route('members.edit', $member->id) }}" 
                                               class="action-btn edit text-amber-600 font-medium text-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this member?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete text-red-600 font-medium text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            <p class="text-lg font-medium">No members found</p>
                                            <p class="text-sm mt-1">Get started by adding your first church member</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                @if($members->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    <div class="pagination flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing {{ $members->firstItem() }} to {{ $members->lastItem() }} of {{ $members->total() }} results
                        </div>
                        <div class="flex space-x-1">
                            {{ $members->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Floating Action Button -->
            <a href="{{ route('members.create') }}" class="fab fixed bottom-6 right-6 w-14 h-14 flex items-center justify-center rounded-full text-white" title="Add New Member">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </main>
    </div>
</body>
</html>