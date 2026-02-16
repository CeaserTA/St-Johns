@extends('layouts.dashboard_layout')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard')

@section('content')
<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <div class="flex items-start sm:items-center mb-4">
            <div class="p-2 sm:p-3 bg-blue-100 rounded-lg mr-3 sm:mr-4 flex-shrink-0">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h2 class="text-base sm:text-lg font-semibold text-gray-700">Total Members</h2>
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $totalMembers }}</p>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">All registered members</p>
    </div>
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <div class="flex items-start sm:items-center mb-4">
            <div class="p-2 sm:p-3 bg-green-100 rounded-lg mr-3 sm:mr-4 flex-shrink-0">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="text-base sm:text-lg font-semibold text-gray-700">New Registrations</h2>
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ $newRegistrations }}</p>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">This month</p>
    </div>
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <div class="flex items-start sm:items-center mb-4">
            <div class="p-2 sm:p-3 bg-yellow-100 rounded-lg mr-3 sm:mr-4 flex-shrink-0">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h2 class="text-base sm:text-lg font-semibold text-gray-700">Active Members</h2>
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-yellow-600">{{ $activeMembers }}</p>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Attended in last 3 months</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <a href="{{ route('admin.members') }}" class="bg-white p-4 sm:p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex flex-col sm:flex-row items-start sm:items-center">
            <div class="p-2 sm:p-3 bg-blue-100 rounded-lg mb-3 sm:mb-0 sm:mr-4 flex-shrink-0">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Manage Members</h3>
                <p class="text-xs sm:text-sm text-gray-500">View and manage church members</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.events') }}" class="bg-white p-4 sm:p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex flex-col sm:flex-row items-start sm:items-center">
            <div class="p-2 sm:p-3 bg-green-100 rounded-lg mb-3 sm:mb-0 sm:mr-4 flex-shrink-0">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Manage Updates</h3>
                <p class="text-xs sm:text-sm text-gray-500">Create and manage events & announcements</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.givings') }}" class="bg-white p-4 sm:p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex flex-col sm:flex-row items-start sm:items-center">
            <div class="p-2 sm:p-3 bg-purple-100 rounded-lg mb-3 sm:mb-0 sm:mr-4 flex-shrink-0">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                </svg>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Giving Management</h3>
                <p class="text-xs sm:text-sm text-gray-500">Track tithes and offerings</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.qr-codes') }}" class="bg-white p-4 sm:p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex flex-col sm:flex-row items-start sm:items-center">
            <div class="p-2 sm:p-3 bg-yellow-100 rounded-lg mb-3 sm:mb-0 sm:mr-4 flex-shrink-0">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 16h4.01M12 8h4.01M8 12h.01M16 8h.01M8 16h.01M8 8h.01M12 16h.01" />
                </svg>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">QR Codes</h3>
                <p class="text-xs sm:text-sm text-gray-500">Generate QR codes for registration</p>
            </div>
        </div>
    </a>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-8 mb-6 sm:mb-8">
    <!-- Monthly New Members Chart -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4 sm:mb-6">New Members Trend (Last 12 Months)</h3>
        <div style="position: relative; width: 100%; height: 250px; min-height: 200px;">
            <canvas id="monthlyMembersChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Service Registrations Chart -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4 sm:mb-6">Service Registrations Distribution</h3>
        <div style="position: relative; width: 100%; height: 250px; min-height: 200px;">
            <canvas id="serviceRegistrationsChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Members Chart
        const canvasElement = document.getElementById('monthlyMembersChart');
        if (canvasElement) {
            const monthlyCtx = canvasElement.getContext('2d');
            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($monthLabels) !!},
                    datasets: [{
                        label: 'New Members',
                        data: {!! json_encode($monthlyNewMembers) !!},
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
        
        // Service Registrations Chart
        const serviceCanvasElement = document.getElementById('serviceRegistrationsChart');
        if (serviceCanvasElement) {
            const serviceLabels = {!! json_encode($serviceRegistrationCounts->pluck('service')) !!};
            const serviceData = {!! json_encode($serviceRegistrationCounts->pluck('count')) !!};
            const colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4', '#14b8a6'];
            
            const serviceCtx = serviceCanvasElement.getContext('2d');
            new Chart(serviceCtx, {
                type: 'doughnut',
                data: {
                    labels: serviceLabels,
                    datasets: [{
                        data: serviceData,
                        backgroundColor: colors.slice(0, serviceLabels.length),
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 12
                                },
                                padding: 15
                            }
                        }
                    }
                }
            });
        }
    });


</script>

@endsection