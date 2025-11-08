<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Member Details - St. John’s Parish Church Entebbe</title>

    <!-- Tailwind + Fonts -->
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
                        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 hover:bg-blue-700 rounded-r-lg transition">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-10 0h3" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('members') }}" class="flex items-center px-6 py-3 bg-blue-700 rounded-r-lg">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 0 018 0z"/>
                            </svg>
                            Members
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('service.register') }}" class="flex items-center px-6 py-3 hover:bg-blue-700 rounded-r-lg transition">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 0 018 0z"/>
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
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="flex items-center justify-between px-6 py-4 bg-white shadow-sm">
                <h1 class="text-xl font-bold text-gray-800">Member Details</h1>
            </header>

            <!-- Member Details (Table Style) -->
            <main class="flex-1 p-6 overflow-y-auto bg-gray-50">
                <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-8">
                    
                    <!-- Profile Header -->
                    <div class="flex items-center space-x-4 mb-6 border-b pb-4">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 text-blue-600 text-2xl font-bold">
                            {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">{{ $member->first_name }} {{ $member->last_name }}</h2>
                            <p class="text-gray-500">Church Member</p>
                        </div>
                    </div>

                    <!-- Table Layout -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-100">
                                <tr>
                                    <th class="bg-gray-50 px-4 py-3 text-left text-sm font-medium text-gray-600 w-1/3">Full Name</th>
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $member->first_name }} {{ $member->last_name }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-gray-50 px-4 py-3 text-left text-sm font-medium text-gray-600">Gender</th>
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $member->gender }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-gray-50 px-4 py-3 text-left text-sm font-medium text-gray-600">Phone</th>
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $member->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-gray-50 px-4 py-3 text-left text-sm font-medium text-gray-600">Email</th>
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $member->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-gray-50 px-4 py-3 text-left text-sm font-medium text-gray-600">Address</th>
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $member->address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-gray-50 px-4 py-3 text-left text-sm font-medium text-gray-600">Member Since</th>
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $member->created_at->format('F j, Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-gray-50 px-4 py-3 text-left text-sm font-medium text-gray-600">Last Updated</th>
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $member->updated_at->format('F j, Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('members') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">Back to Members</a>
                        <a href="{{ route('members.edit', $member->id) }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">Edit Member</a>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
