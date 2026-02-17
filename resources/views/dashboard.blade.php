@extends('layouts.dashboard_layout')

@section('title', 'Dashboard')

@section('content')
<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
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
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <div class="flex items-start sm:items-center mb-4">
            <div class="p-2 sm:p-3 bg-purple-100 rounded-lg mr-3 sm:mr-4 flex-shrink-0">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h2 class="text-base sm:text-lg font-semibold text-gray-700">Engaged Users</h2>
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-purple-600">{{ $membersWithInteraction }}</p>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">{{ $interactionPercentage }}% of members</p>
    </div>
</div>

<!-- Engagement and Registration Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <!-- Members Just Viewing Card -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <div class="flex items-start sm:items-center mb-4">
            <div class="p-2 sm:p-3 bg-indigo-100 rounded-lg mr-3 sm:mr-4 flex-shrink-0">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>
            <h2 class="text-base sm:text-lg font-semibold text-gray-700">Just Viewing</h2>
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-indigo-600">{{ $membersJustViewing }}</p>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">{{ $viewingPercentage }}% of members</p>
    </div>

    <!-- Service Registrations Card -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <div class="flex items-start sm:items-center mb-4">
            <div class="p-2 sm:p-3 bg-red-100 rounded-lg mr-3 sm:mr-4 flex-shrink-0">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-base sm:text-lg font-semibold text-gray-700">Service Registrations</h2>
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-red-600">{{ $totalServiceRegistrations }}</p>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Total registrations</p>
    </div>

    <!-- Event Registrations Card -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <div class="flex items-start sm:items-center mb-4">
            <div class="p-2 sm:p-3 bg-orange-100 rounded-lg mr-3 sm:mr-4 flex-shrink-0">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h2 class="text-base sm:text-lg font-semibold text-gray-700">Event Registrations</h2>
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-orange-600">{{ $totalEventRegistrations }}</p>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Total event sign-ups</p>
    </div>
</div>

 
<!-- Three Graph Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">Member Distribution</h3>
        <div style="position: relative; width: 100%; height: 220px; min-height: 180px;">
            @php
                $mdLabels = $memberDistributionLabels ?? [];
                $mdData = $memberDistributionData ?? [];
            @endphp
            @if(is_array($mdLabels) && count($mdLabels) > 0)
                <canvas id="memberDistributionChart" width="400" height="200"></canvas>
            @else
                <div class="flex items-center justify-center h-full text-gray-500">No member distribution data available</div>
            @endif
        </div>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">Service Distribution</h3>
        <div style="position: relative; width: 100%; height: 220px; min-height: 180px;">
            @php
                $sdLabels = $serviceDistributionLabels ?? [];
                $sdData = $serviceDistributionData ?? [];
            @endphp
            @if(is_array($sdLabels) && count($sdLabels) > 0)
                <canvas id="serviceDistributionChart" width="400" height="200"></canvas>
            @else
                <div class="flex items-center justify-center h-full text-gray-500">No service distribution data available</div>
            @endif
        </div>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">Active</h3>
        <div style="position: relative; width: 100%; height: 220px; min-height: 180px;">
            @php
                // Prepare final labels/data for the Active card. If only `activeMembers` exists,
                // compute the "other" slice as total - active so we can visualize the difference.
                $aiLabelsFinal = null;
                $aiDataFinal = null;

                if (!empty($activeInactiveData) && is_array($activeInactiveData) && count($activeInactiveData) > 0) {
                    $aiLabelsFinal = $activeInactiveLabels ?? ['Active','Inactive'];
                    $aiDataFinal = $activeInactiveData;
                } elseif (isset($activeMembers) && isset($totalMembers)) {
                    $active = (int) $activeMembers;
                    $total = (int) $totalMembers;
                    $other = max(0, $total - $active);
                    $aiLabelsFinal = ['Active', 'Other'];
                    $aiDataFinal = [$active, $other];
                }
            @endphp

            @if(is_array($aiDataFinal) && count($aiDataFinal) > 0)
                <canvas id="activeInactiveChart" width="400" height="200"></canvas>
            @else
                <div class="flex items-center justify-center h-full text-gray-500">No active members data available</div>
            @endif
        </div>
    </div>
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

        // Member Distribution Chart (doughnut)
        const memberCanvas = document.getElementById('memberDistributionChart');
        if (memberCanvas) {
            const mdLabels = {!! json_encode($memberDistributionLabels ?? []) !!};
            const mdData = {!! json_encode($memberDistributionData ?? []) !!};
            const palette = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4', '#14b8a6'];
            const memberCtx = memberCanvas.getContext('2d');
            new Chart(memberCtx, {
                type: 'doughnut',
                data: {
                    labels: mdLabels,
                    datasets: [{
                        data: mdData,
                        backgroundColor: palette.slice(0, mdLabels.length),
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }

        // Service Distribution Chart (bar)
        const serviceDistCanvas = document.getElementById('serviceDistributionChart');
        if (serviceDistCanvas) {
            const sdLabels = {!! json_encode($serviceDistributionLabels ?? []) !!};
            const sdData = {!! json_encode($serviceDistributionData ?? []) !!};
            const barColor = '#3b82f6';
            const sdCtx = serviceDistCanvas.getContext('2d');
            new Chart(sdCtx, {
                type: 'bar',
                data: {
                    labels: sdLabels,
                    datasets: [{
                        label: 'Count',
                        data: sdData,
                        backgroundColor: sdLabels.map((_,i) => ['#3b82f6','#10b981','#f59e0b','#8b5cf6'][i % 4]),
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        // Active vs Inactive Chart (doughnut) — use Blade-computed final values
        const aiCanvas = document.getElementById('activeInactiveChart');
        if (aiCanvas) {
            const aiLabels = {!! json_encode($aiLabelsFinal ?? ['Active','Other']) !!};
            const aiData = {!! json_encode($aiDataFinal ?? []) !!};
            const aiCtx = aiCanvas.getContext('2d');
            // Choose theme colors: green for active, gray for other; fall back to palette if more slices
            const aiColors = (aiLabels.length === 2)
                ? ['#10b981', '#9ca3af']
                : ['#10b981','#3b82f6','#f59e0b','#8b5cf6','#ef4444'];

            new Chart(aiCtx, {
                type: 'doughnut',
                data: {
                    labels: aiLabels,
                    datasets: [{
                        data: aiData,
                        backgroundColor: aiColors.slice(0, aiLabels.length),
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }
    });


</script>

@endsection