@extends('layouts.dashboard_layout')

@section('title', 'Dashboard')

@section('content')

    <!-- Dashboard Welcome Header – Blue Background, Slim & Clean -->
    <div class="bg-primary text-white py-4 px-6 lg:px-8 shadow-sm mb-6">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black tracking-tight mb-1">
                St. John’s Parish Church Entebbe
            </h1>
            <p class="text-base md:text-lg text-accent/90 font-medium">
                Admin Dashboard
            </p>
            <p class="text-sm mt-2 opacity-90 italic max-w-2xl mx-auto">
                “Let us not grow weary in doing good...” — Galatians 6:9
            </p>
        </div>
    </div>

    <!-- Today's Snapshot – Compact & Modern -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6 mb-8 lg:mb-8">
        <!-- New Members Today -->
        <div
            class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 border-primary hover:shadow-lg hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-5">
                <div class="flex items-center gap-4 mb-3">
                    <div
                        class="p-3 bg-accent/10 dark:bg-accent/20 rounded-lg group-hover:bg-accent/20 dark:group-hover:bg-accent/30 transition-colors">
                        <svg class="h-7 w-7 text-accent group-hover:scale-110 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">New
                            Members Today</p>
                        <p class="text-3xl lg:text-4xl font-black text-primary dark:text-text-dark mt-1">
                            {{ $todayNewMembers ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Giving -->
        <div
            class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 border-primary hover:shadow-lg hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-5">
                <div class="flex items-center gap-4 mb-3">
                    <div
                        class="p-3 bg-secondary/10 dark:bg-secondary/20 rounded-lg group-hover:bg-secondary/20 dark:group-hover:bg-secondary/30 transition-colors">
                        <svg class="h-7 w-7 text-secondary group-hover:scale-110 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">
                            Today's Giving</p>
                        <p class="text-3xl lg:text-4xl font-black text-secondary mt-1">
                            UGX {{ number_format($todayGiving ?? 0) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Event -->
        <div
            class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 border-primary hover:shadow-lg hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-5">
                <div class="flex items-center gap-4 mb-3">
                    <div
                        class="p-3 bg-accent/10 dark:bg-accent/20 rounded-lg group-hover:bg-accent/20 dark:group-hover:bg-accent/30 transition-colors">
                        <svg class="h-7 w-7 text-accent group-hover:scale-110 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Next
                            Event</p>
                        <p class="text-xl lg:text-2xl font-bold text-primary mt-1">
                            {{ $nextEventName ?? 'No upcoming event' }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-text-muted-dark mt-1">
                            {{ $nextEventDate ?? '' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Hero Metrics – Slim, Clean & Warm (No Gradients) -->
    <div class="bg-background-light dark:bg-background-dark rounded-2xl shadow-md border border-gray-200/70 dark:border-gray-700 p-4 lg:p-6 mb-8 lg:mb-10 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10">
            <!-- Left: Large Hero Numbers (Slim) -->
            <div class="space-y-4 text-center lg:text-left">
                <div>
                    <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wider opacity-90 mb-1">Total Members</p>
                    <p class="text-5xl lg:text-6xl font-black text-primary dark:text-text-dark">{{ $totalMembers }}</p>
                    <p class="text-xs text-gray-500 dark:text-text-muted-dark mt-1.5">All registered souls</p>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wider opacity-90 mb-1">New This Month</p>
                        <p class="text-4xl lg:text-5xl font-black text-secondary">{{ $newRegistrations }}</p>
                        <p class="text-xs text-gray-500 dark:text-text-muted-dark mt-1.5">Recent blessings</p>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wider opacity-90 mb-1">Engaged</p>
                        <p class="text-4xl lg:text-5xl font-black text-accent">{{ $membersWithInteraction }}</p>
                        <p class="text-xs text-gray-500 dark:text-text-muted-dark mt-1.5">{{ $interactionPercentage }}% active</p>
                    </div>
                </div>
            </div>

            <!-- Right: Slim Radial Progress -->
            <div class="flex flex-row sm:flex-row justify-center items-center gap-8 lg:gap-12">
                <!-- Active Radial – Smaller & Clean -->
                <div class="relative w-40 h-40 lg:w-48 lg:h-48">
                    <svg class="absolute inset-0 w-full h-full" viewBox="0 0 36 36">
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e5e7eb" dark:stroke="#374151" stroke-width="3"/>
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#0A2463" stroke-width="3.5"
                            stroke-dasharray="100" stroke-dashoffset="{{ 100 - (($activeMembers / max(1, $totalMembers)) * 100) }}" stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                        <p class="text-3xl lg:text-4xl font-black text-accent">{{ $activeMembers }}</p>
                        <p class="text-xs opacity-90 mt-1">Active</p>
                        <p class="text-xs opacity-80">{{ round(($activeMembers / max(1, $totalMembers)) * 100) }}%</p>
                    </div>
                </div>

                <!-- Engaged Radial – Smaller & Clean -->
                <div class="relative w-40 h-40 lg:w-48 lg:h-48">
                    <svg class="absolute inset-0 w-full h-full" viewBox="0 0 36 36">
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e5e7eb" dark:stroke="#374151" stroke-width="3"/>
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#A5282C" stroke-width="3.5"
                            stroke-dasharray="100" stroke-dashoffset="{{ 100 - $interactionPercentage }}" stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                        <p class="text-3xl lg:text-4xl font-black text-secondary">{{ $membersWithInteraction }}</p>
                        <p class="text-xs opacity-90 mt-1">Engaged</p>
                        <p class="text-xs opacity-80">{{ $interactionPercentage }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Three Graph Cards – Ultra Compact & Modern -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-6 mb-8 lg:mb-10">
        <!-- Member Distribution -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 hover:border-primary hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-4 lg:p-5">
                <h3 class="text-base lg:text-lg font-bold text-primary mb-3 flex items-center gap-2">
                    <svg class="h-5 w-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Member Distribution
                </h3>
                <div class="relative w-full h-56 lg:h-64 bg-gray-50/50 dark:bg-gray-800/30 rounded-lg overflow-hidden">
                    @php
                        $mdLabels = $memberDistributionLabels ?? [];
                        $mdData = $memberDistributionData ?? [];
                    @endphp
                    @if(is_array($mdLabels) && count($mdLabels) > 0)
                        <canvas id="memberDistributionChart"></canvas>
                    @else
                        <div class="flex items-center justify-center h-full text-gray-500 dark:text-text-muted-dark text-xs">
                            No data yet
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Service Distribution -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 hover:border-primary hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-4 lg:p-5">
                <h3 class="text-base lg:text-lg font-bold text-primary mb-3 flex items-center gap-2">
                    <svg class="h-5 w-5 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Service Distribution
                </h3>
                <div class="relative w-full h-56 lg:h-64 bg-gray-50/50 dark:bg-gray-800/30 rounded-lg overflow-hidden">
                    @php
                        $sdLabels = $serviceDistributionLabels ?? [];
                        $sdData = $serviceDistributionData ?? [];
                    @endphp
                    @if(is_array($sdLabels) && count($sdLabels) > 0)
                        <canvas id="serviceDistributionChart"></canvas>
                    @else
                        <div class="flex items-center justify-center h-full text-gray-500 dark:text-text-muted-dark text-xs">
                            No data yet
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Active Members -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 hover:border-primary hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-4 lg:p-5">
                <h3 class="text-base lg:text-lg font-bold text-primary mb-3 flex items-center gap-2">
                    <svg class="h-5 w-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Active Members
                </h3>
                <div class="relative w-full h-56 lg:h-64 bg-gray-50/50 dark:bg-gray-800/30 rounded-lg overflow-hidden">
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
                        <div class="flex items-center justify-center h-full text-gray-500 dark:text-text-muted-dark text-xs">
                            No data yet
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Time Filter – Sleek & Intuitive -->
    <div class="bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 p-4 lg:p-5 mb-6 lg:mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-base lg:text-lg font-semibold text-primary dark:text-text-dark">
            Viewing Data For:
        </p>

        <div class="flex flex-wrap gap-2.5">
            <button
                class="px-6 py-2 rounded-full font-medium text-sm transition-all duration-300
                    bg-accent text-primary hover:bg-secondary hover:text-white focus:outline-none focus:ring-2 focus:ring-accent/30 active:scale-95">
                This Month
            </button>

            <button
                class="px-6 py-2 rounded-full font-medium text-sm transition-all duration-300
                    bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-text-muted-dark
                    hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-primary">
                This Year
            </button>

            <button
                class="px-6 py-2 rounded-full font-medium text-sm transition-all duration-300
                    bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-text-muted-dark
                    hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-primary">
                Last 30 Days
            </button>
        </div>
    </div>

    <!-- Charts Section – Slim, Modern & Premium -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-6 mb-8 lg:mb-10">
        <!-- Monthly New Members Trend -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 hover:border-primary hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-4 lg:p-5">
                <h3 class="text-base lg:text-lg font-bold text-primary mb-3 flex items-center gap-2">
                    <svg class="h-5 w-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    New Members Trend (Last 12 Months)
                </h3>
                <div class="relative w-full h-60 lg:h-72 bg-gray-50/50 dark:bg-gray-800/30 rounded-lg overflow-hidden">
                    <canvas id="monthlyMembersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Service Registrations Distribution -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 hover:border-primary hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-4 lg:p-5">
                <h3 class="text-base lg:text-lg font-bold text-primary mb-3 flex items-center gap-2">
                    <svg class="h-5 w-5 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Service Registrations Distribution
                </h3>
                <div class="relative w-full h-60 lg:h-72 bg-gray-50/50 dark:bg-gray-800/30 rounded-lg overflow-hidden">
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