<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>St. Johns Parish Church Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .chart-container {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.5rem;
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
                        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 bg-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-10 0h3" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('members') }}" class="flex items-center px-6 py-3 hover:bg-blue-700 transition">
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
            <h1 class="text-xl font-bold text-gray-800">St Johns Church Admin Panel</h1>
        </header>

        <!-- Main Content -->
        <main class="p-6 overflow-y-auto">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="card p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Total Members</h2>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalMembers }}</p>
                    <p class="text-sm text-gray-500 mt-1">All registered members</p>
                </div>
                <div class="card p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">New Registrations</h2>
                    <p class="text-3xl font-bold text-green-600">{{ $newRegistrations }}</p>
                    <p class="text-sm text-gray-500 mt-1">This month</p>
                </div>
                <div class="card p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Active Members</h2>
                    <p class="text-3xl font-bold text-yellow-600">{{ $activeMembers }}</p>
                    <p class="text-sm text-gray-500 mt-1">Attended in last 3 months</p>
                </div>
            </div>

            <!-- Bar Chart -->
            <div class="chart-container">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">New Members Per Month</h2>
                <canvas id="newMembersChart" height="200"></canvas>
            </div>
        </main>
    </div>

    <!-- Chart.js Script -->
    <script>
        const ctx = document.getElementById('newMembersChart').getContext('2d');
        const newMembersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthLabels) !!},
                datasets: [{
                    label: 'New Members',
                    data: {!! json_encode($monthlyNewMembers) !!},
                    backgroundColor: 'rgba(30, 58, 138, 0.7)',
                    borderColor: 'rgba(30, 58, 138, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>