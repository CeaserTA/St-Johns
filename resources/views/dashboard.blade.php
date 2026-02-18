@extends('layouts.dashboard_layout')

@section('title', 'Dashboard')

@section('content')

    <!-- Dashboard Introduction Header – Refined & Subtle -->
    <div class="bg-primary text-white py-6 px-6 lg:px-8 shadow-md">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-black tracking-tight mb-2">
                St. John’s Parish Church Entebbe
            </h1>
            <p class="text-lg md:text-xl text-accent/90 font-medium">
                Admin Dashboard
            </p>
            <p class="text-base mt-3 opacity-90 max-w-2xl mx-auto leading-relaxed">
                “Let us not grow weary in doing good...” — Galatians 6:9
            </p>
        </div>
    </div>

    <!-- Today's Snapshot – Hero Highlights -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-10 lg:mb-12">
        <!-- Today's New Members -->
        <div class="bg-white rounded-2xl shadow-lg p-5 lg:p-6 border border-gray-100/50">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-accent/10 rounded-xl">
                    <svg class="h-10 w-10 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">New Members Today</p>
                    <p class="text-4xl lg:text-5xl font-black text-primary mt-1">{{ $todayNewMembers ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Today's Giving -->
        <div class="bg-white rounded-2xl shadow-lg p-5 lg:p-6 border border-gray-100/50">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-secondary/10 rounded-xl">
                    <svg class="h-10 w-10 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Today's Giving</p>
                    <p class="text-4xl lg:text-5xl font-black text-secondary mt-1">
                        UGX {{ number_format($todayGiving ?? 0) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Upcoming Event -->
        <div class="bg-white rounded-2xl shadow-lg p-5 lg:p-6 border border-gray-100/50">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-accent/10 rounded-xl">
                    <svg class="h-10 w-10 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Next Event</p>
                    <p class="text-2xl lg:text-3xl font-bold text-primary mt-1">
                        {{ $nextEventName ?? 'No upcoming event' }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $nextEventDate ?? '' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards – Modern, Sacred & Eye-Catching -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 mb-10 lg:mb-12">
        <!-- Total Members -->
        <div
            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100/50 hover:border-accent/30 hover:-translate-y-1">
            <div class="p-5 lg:p-6">
                <div class="flex items-center gap-5 mb-6">
                    <div class="p-3 bg-primary/10 rounded-lg group-hover:bg-primary/20 transition-colors">
                        <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Total Members</p>
                        <p class="text-3xl lg:text-4xl font-bold text-primary mt-1">{{ $totalMembers }}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-500">All registered members</p>
            </div>
        </div>

        <!-- New Registrations -->
        <div
            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100/50 hover:border-secondary/30 hover:-translate-y-1">
            <div class="p-5 lg:p-6">
                <div class="flex items-center gap-5 mb-6">
                    <div class="p-3 bg-secondary/10 rounded-lg group-hover:bg-secondary/20 transition-colors">
                        <svg class="h-6 w-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">New Registrations</p>
                        <p class="text-3xl lg:text-4xl font-bold text-secondary mt-1">{{ $newRegistrations }}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-500">This month</p>
            </div>
        </div>

        <!-- Active Members -->
        <div
            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100/80 hover:border-accent/30 hover:-translate-y-1">
            <div class="p-6 lg:p-8">
                <div class="flex items-center gap-5 mb-6">
                    <div class="p-4 bg-accent/10 rounded-xl group-hover:bg-accent/20 transition-colors">
                        <svg class="h-8 w-8 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Active Members</p>
                        <p class="text-4xl lg:text-5xl font-black text-accent mt-1">{{ $activeMembers }}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-500">Attended in last 3 months</p>
            </div>
        </div>

        <!-- Engaged Users -->
        <div
            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100/50 hover:border-secondary/30 hover:-translate-y-1">
            <div class="p-5 lg:p-6">
                <div class="flex items-center gap-5 mb-6">
                    <div class="p-3 bg-secondary/10 rounded-lg group-hover:bg-secondary/20 transition-colors">
                        <svg class="h-6 w-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Engaged Users</p>
                        <p class="text-3xl lg:text-4xl font-bold text-secondary mt-1">{{ $membersWithInteraction }}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-500">{{ $interactionPercentage }}% of members</p>
            </div>
        </div>
    </div>


    <!-- Three Graph Cards – Modern, Sacred & Consistent with Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 mb-10 lg:mb-12">
        <!-- Member Distribution -->
        <div
            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100/50 hover:border-accent/30 hover:-translate-y-1">
            <div class="p-5 lg:p-6">
                <h3 class="text-xl lg:text-2xl font-bold text-primary mb-6 flex items-center gap-3">
                    <span class="text-accent text-2xl">📊</span>
                    Member Distribution
                </h3>
                <div class="relative w-full h-80 lg:h-96 bg-gray-50/50 rounded-xl overflow-hidden">
                    @php
                        $mdLabels = $memberDistributionLabels ?? [];
                        $mdData = $memberDistributionData ?? [];
                    @endphp
                    @if(is_array($mdLabels) && count($mdLabels) > 0)
                        <canvas id="memberDistributionChart"></canvas>
                    @else
                        <div class="flex items-center justify-center h-full text-gray-500 text-sm">
                            No member distribution data available
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Service Distribution -->
        <div
            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100/50 hover:border-secondary/30 hover:-translate-y-1">
            <div class="p-5 lg:p-6">
                <h3 class="text-xl lg:text-2xl font-bold text-primary mb-6 flex items-center gap-3">
                    <span class="text-secondary text-2xl">📈</span>
                    Service Distribution
                </h3>
                <div class="relative w-full h-80 lg:h-96 bg-gray-50/50 rounded-xl overflow-hidden">
                    @php
                        $sdLabels = $serviceDistributionLabels ?? [];
                        $sdData = $serviceDistributionData ?? [];
                    @endphp
                    @if(is_array($sdLabels) && count($sdLabels) > 0)
                        <canvas id="serviceDistributionChart"></canvas>
                    @else
                        <div class="flex items-center justify-center h-full text-gray-500 text-sm">
                            No service distribution data available
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Active Members -->
        <div
            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100/80 hover:border-accent/30 hover:-translate-y-1">
            <div class="p-6 lg:p-8">
                <h3 class="text-xl lg:text-2xl font-bold text-primary mb-6 flex items-center gap-3">
                    <span class="text-accent text-2xl">👥</span>
                    Active Members
                </h3>
                <div class="relative w-full h-80 lg:h-96 bg-gray-50/50 rounded-xl overflow-hidden">
                    @php
                        $aiLabelsFinal = null;
                        $aiDataFinal = null;

                        if (!empty($activeInactiveData) && is_array($activeInactiveData) && count($activeInactiveData) > 0) {
                            $aiLabelsFinal = $activeInactiveLabels ?? ['Active', 'Inactive'];
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
                        <canvas id="activeInactiveChart"></canvas>
                    @else
                        <div class="flex items-center justify-center h-full text-gray-500 text-sm">
                            No active members data available
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Time Filter – Above Charts -->
    <div
        class="flex flex-col sm:flex-row items-center justify-between mb-6 lg:mb-8 bg-white rounded-2xl shadow p-4 lg:p-5 border border-gray-100/50">
        <p class="text-lg font-semibold text-primary mb-3 sm:mb-0">Viewing Data For:</p>
        <div class="flex flex-wrap gap-3">
            <button class="px-5 py-2.5 rounded-full font-medium transition-all duration-300
                            bg-accent text-primary hover:bg-secondary hover:text-white focus:ring-4 focus:ring-accent/20">
                This Month
            </button>
            <button class="px-5 py-2.5 rounded-full font-medium transition-all duration-300
                            bg-gray-100 text-gray-700 hover:bg-gray-200">
                This Year
            </button>
            <button class="px-5 py-2.5 rounded-full font-medium transition-all duration-300
                            bg-gray-100 text-gray-700 hover:bg-gray-200">
                Last 30 Days
            </button>
        </div>
    </div>

    <!-- Charts Section – Modern, Sacred & Consistent -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 mb-10 lg:mb-12">
        <!-- Monthly New Members Trend -->
        <div
            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100/50 hover:border-accent/30 hover:-translate-y-1">
            <div class="p-5 lg:p-6">
                <h3 class="text-xl lg:text-2xl font-bold text-primary mb-6 flex items-center gap-3">
                    <span class="text-accent text-2xl">📈</span>
                    New Members Trend (Last 12 Months)
                </h3>
                <div
                    class="relative w-full h-80 lg:h-96 bg-gray-50/50 rounded-xl overflow-hidden border border-gray-200/50">
                    <canvas id="monthlyMembersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Service Registrations Distribution -->
        <div
            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100/50 hover:border-secondary/30 hover:-translate-y-1">
            <div class="p-5 lg:p-6">
                <h3 class="text-xl lg:text-2xl font-bold text-primary mb-6 flex items-center gap-3">
                    <span class="text-secondary text-2xl">📊</span>
                    Service Registrations Distribution
                </h3>
                <div
                    class="relative w-full h-80 lg:h-96 bg-gray-50/50 rounded-xl overflow-hidden border border-gray-200/50">
                    <canvas id="serviceRegistrationsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                            backgroundColor: sdLabels.map((_, i) => ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'][i % 4]),
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
                const aiLabels = {!! json_encode($aiLabelsFinal ?? ['Active', 'Other']) !!};
                const aiData = {!! json_encode($aiDataFinal ?? []) !!};
                const aiCtx = aiCanvas.getContext('2d');
                // Choose theme colors: green for active, gray for other; fall back to palette if more slices
                const aiColors = (aiLabels.length === 2)
                    ? ['#10b981', '#9ca3af']
                    : ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ef4444'];

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