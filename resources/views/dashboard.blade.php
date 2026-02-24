@extends('layouts.dashboard_layout')

@section('title', 'Dashboard')

@section('content')

{{-- ─────────────────────────────────────────────────────────
     TOP HEADER
───────────────────────────────────────────────────────── --}}
<div class="bg-primary border-b border-white/10">
    <div class="max-w-screen-xl mx-auto px-6 lg:px-10 py-5 flex items-center justify-between gap-6">

        <div class="flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-accent/20 border border-accent/30 flex items-center justify-center shrink-0">
                <span class="font-display font-black text-accent text-base tracking-tight">SJ</span>
            </div>
            <div>
                <h1 class="font-display font-black text-white text-xl lg:text-2xl tracking-tight leading-tight">
                    St. John's Parish Church Entebbe
                </h1>
                <p class="text-accent/70 text-xs uppercase tracking-widest font-medium mt-0.5">
                    Admin Dashboard
                </p>
            </div>
        </div>

        <p class="hidden lg:block text-white/40 text-xs italic text-right max-w-xs leading-relaxed">
            "Let us not grow weary in doing good…"
            <span class="not-italic font-semibold text-accent/80">Galatians 6:9</span>
        </p>

    </div>
</div>

<div class="bg-cream min-h-screen">
<div class="max-w-screen-xl mx-auto px-6 lg:px-10 py-8 space-y-7">

    {{-- ─────────────────────────────────────────────────────────
         TODAY'S SNAPSHOT — 3 KPI CARDS
    ───────────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

        {{-- New Members Today --}}
        <div class="card-base card-hover group">
            <div class="h-1 w-full bg-primary rounded-t-2xl"></div>
            <div class="p-6 flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted uppercase tracking-widest">New Members Today</p>
                    <p class="font-display font-black text-5xl text-primary mt-2 leading-none">{{ $todayNewMembers ?? 0 }}</p>
                    <p class="text-xs text-muted mt-2">Registered today</p>
                </div>
                <div class="card-icon-container bg-primary/8 group-hover:bg-primary/15">
                    <svg class="card-icon text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Today's Giving --}}
        <div class="card-base card-hover group">
            <div class="h-1 w-full bg-success rounded-t-2xl"></div>
            <div class="p-6 flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted uppercase tracking-widest">Today's Giving</p>
                    <p class="font-display font-black text-3xl text-success mt-2 leading-none">{{ number_format($todayGiving ?? 0) }}</p>
                    <p class="text-xs text-muted mt-2">UGX collected</p>
                </div>
                <div class="card-icon-container bg-success/8 group-hover:bg-success/15">
                    <svg class="card-icon text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Next Event --}}
        <div class="card-base card-hover group">
            <div class="h-1 w-full bg-accent rounded-t-2xl"></div>
            <div class="p-6 flex items-start justify-between">
                <div class="min-w-0 flex-1 pr-3">
                    <p class="text-xs font-semibold text-muted uppercase tracking-widest">Next Event</p>
                    <p class="font-display font-bold text-xl text-primary mt-2 leading-snug truncate">
                        {{ $nextEventName ?? 'No upcoming event' }}
                    </p>
                    <p class="text-xs text-accent font-semibold mt-2">{{ $nextEventDate ?? '—' }}</p>
                </div>
                <div class="card-icon-container bg-accent/10 group-hover:bg-accent/20 shrink-0">
                    <svg class="card-icon text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- ─────────────────────────────────────────────────────────
         HERO METRICS PANEL
    ───────────────────────────────────────────────────────── --}}
    <div class="card-base">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 divide-y lg:divide-y-0 lg:divide-x divide-border">

            {{-- Left: Big numbers --}}
            <div class="p-6 lg:p-8">
                <p class="text-xs font-semibold text-muted uppercase tracking-widest mb-6">Congregation Overview</p>
                <div class="grid grid-cols-3 gap-0 divide-x divide-border">
                    <div class="pr-6">
                        <p class="text-xs text-muted font-medium uppercase tracking-wider mb-1">Total</p>
                        <p class="font-display font-black text-5xl lg:text-6xl text-primary leading-none">{{ $totalMembers }}</p>
                        <p class="text-xs text-muted mt-2">Registered</p>
                    </div>
                    <div class="px-6">
                        <p class="text-xs text-muted font-medium uppercase tracking-wider mb-1">This Month</p>
                        <p class="font-display font-black text-4xl lg:text-5xl text-success leading-none">{{ $newRegistrations }}</p>
                        <p class="text-xs text-muted mt-2">New souls</p>
                    </div>
                    <div class="pl-6">
                        <p class="text-xs text-muted font-medium uppercase tracking-wider mb-1">Engaged</p>
                        <p class="font-display font-black text-4xl lg:text-5xl text-secondary leading-none">{{ $membersWithInteraction }}</p>
                        <p class="text-xs text-muted mt-2">{{ $interactionPercentage }}% active</p>
                    </div>
                </div>
            </div>

            {{-- Right: Radial rings --}}
            <div class="p-6 lg:p-8 flex items-center justify-center gap-10 lg:gap-16 bg-sand/50">
                @php
                    $activeRatio   = round(($activeMembers / max(1, $totalMembers)) * 100);
                    $activeOffset  = 100 - $activeRatio;
                    $engagedOffset = 100 - $interactionPercentage;
                @endphp

                {{-- Active Ring --}}
                <div class="flex flex-col items-center gap-3">
                    <div class="relative w-28 h-28">
                        <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="#e2d9cc" stroke-width="3"/>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="#0c1b3a" stroke-width="3.5"
                                stroke-dasharray="100" stroke-dashoffset="{{ $activeOffset }}"
                                stroke-linecap="round"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <p class="font-display font-black text-2xl text-primary leading-none">{{ $activeMembers }}</p>
                            <p class="text-xs text-muted mt-0.5">{{ $activeRatio }}%</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-xs font-semibold text-primary uppercase tracking-widest">Active</p>
                        <div class="w-6 h-0.5 bg-primary rounded-full mx-auto mt-1 opacity-40"></div>
                    </div>
                </div>

                {{-- Engaged Ring --}}
                <div class="flex flex-col items-center gap-3">
                    <div class="relative w-28 h-28">
                        <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="#e2d9cc" stroke-width="3"/>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="#c0392b" stroke-width="3.5"
                                stroke-dasharray="100" stroke-dashoffset="{{ $engagedOffset }}"
                                stroke-linecap="round"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <p class="font-display font-black text-2xl text-secondary leading-none">{{ $membersWithInteraction }}</p>
                            <p class="text-xs text-muted mt-0.5">{{ $interactionPercentage }}%</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-xs font-semibold text-secondary uppercase tracking-widest">Engaged</p>
                        <div class="w-6 h-0.5 bg-secondary rounded-full mx-auto mt-1 opacity-40"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ─────────────────────────────────────────────────────────
         MINI CHART TRIO
    ───────────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- Member Distribution --}}
        <div class="card-base card-hover">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display font-bold text-base text-primary">Member Distribution</h3>
                    <span class="w-2 h-2 rounded-full bg-primary shrink-0"></span>
                </div>
                <div class="h-52">
                    @if(is_array($memberDistributionLabels ?? null) && count($memberDistributionLabels ?? []) > 0)
                        <canvas id="memberDistributionChart"></canvas>
                    @else
                        <div class="h-full flex items-center justify-center">
                            <p class="text-xs text-muted">No data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Service Distribution --}}
        <div class="card-base card-hover">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display font-bold text-base text-primary">Service Distribution</h3>
                    <span class="w-2 h-2 rounded-full bg-secondary shrink-0"></span>
                </div>
                <div class="h-52">
                    @php $sdLabels = $serviceDistributionLabels ?? []; $sdData = $serviceDistributionData ?? []; @endphp
                    @if(is_array($sdLabels) && count($sdLabels) > 0)
                        <canvas id="serviceDistributionChart"></canvas>
                    @else
                        <div class="h-full flex items-center justify-center">
                            <p class="text-xs text-muted">No data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Active Members --}}
        <div class="card-base card-hover">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display font-bold text-base text-primary">Active Members</h3>
                    <span class="w-2 h-2 rounded-full bg-success shrink-0"></span>
                </div>
                <div class="h-52">
                    @php
                        $aiLabelsFinal = null; $aiDataFinal = null;
                        if (!empty($activeInactiveData) && is_array($activeInactiveData) && count($activeInactiveData) > 0) {
                            $aiLabelsFinal = $activeInactiveLabels ?? ['Active', 'Inactive'];
                            $aiDataFinal   = $activeInactiveData;
                        } elseif (isset($activeMembers) && isset($totalMembers)) {
                            $active = (int)$activeMembers; $total = (int)$totalMembers;
                            $aiLabelsFinal = ['Active', 'Other'];
                            $aiDataFinal   = [$active, max(0, $total - $active)];
                        }
                    @endphp
                    @if(is_array($aiDataFinal) && count($aiDataFinal) > 0)
                        <canvas id="activeInactiveChart"></canvas>
                    @else
                        <div class="h-full flex items-center justify-center">
                            <p class="text-xs text-muted">No data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ─────────────────────────────────────────────────────────
         TIME FILTER + MAIN CHARTS
    ───────────────────────────────────────────────────────── --}}
    <div>

        {{-- Section header + pill filter --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-5">
            <div>
                <h2 class="font-display font-black text-xl text-primary">Trends & Analytics</h2>
                <p class="text-xs text-muted mt-0.5">Membership growth and service data</p>
            </div>
            <div class="flex items-center gap-1 bg-white border border-border rounded-xl p-1 shadow-sm">
                <button onclick="setTab(this,'month')" class="tab-btn font-display text-xs font-semibold px-5 py-2 rounded-lg transition-all duration-200 bg-primary text-white">
                    This Month
                </button>
                <button onclick="setTab(this,'year')"  class="tab-btn font-display text-xs font-semibold px-5 py-2 rounded-lg text-muted hover:text-primary transition-all duration-200">
                    This Year
                </button>
                <button onclick="setTab(this,'30d')"   class="tab-btn font-display text-xs font-semibold px-5 py-2 rounded-lg text-muted hover:text-primary transition-all duration-200">
                    Last 30 Days
                </button>
            </div>
        </div>

        {{-- Two main charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            {{-- Monthly New Members Trend --}}
            <div class="card-base card-hover">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-5">
                        <div>
                            <h3 class="font-display font-bold text-lg text-primary">New Members Trend</h3>
                            <p class="text-xs text-muted mt-0.5">Last 12 months</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-0.5 bg-primary rounded-full inline-block"></span>
                            <span class="text-xs text-muted">Members</span>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="monthlyMembersChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Service Registrations Doughnut --}}
            <div class="card-base card-hover">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-5">
                        <div>
                            <h3 class="font-display font-bold text-lg text-primary">Service Registrations</h3>
                            <p class="text-xs text-muted mt-0.5">Distribution by service type</p>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="serviceRegistrationsChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>{{-- /max-w container --}}
</div>{{-- /bg-cream wrapper --}}

{{-- ─────────────────────────────────────────────────────────
     SCRIPTS
───────────────────────────────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    /* ─── Tab switcher ──────────────────────────────── */
    function setTab(btn, period) {
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('bg-primary', 'text-white');
            b.classList.add('text-muted');
        });
        btn.classList.add('bg-primary', 'text-white');
        btn.classList.remove('text-muted');
        // Wire your actual filter logic here
    }

    /* ─── Palette: pulled directly from theme tokens ── */
    const palette = [
        '#0c1b3a', // primary
        '#c0392b', // secondary
        '#c8973a', // accent
        '#1a7a4a', // success
        '#142450', // primary-light
        '#e8b96a', // accent-light
        '#6b7080', // muted
    ];

    /* ─── Global Chart.js defaults ─────────────────── */
    Chart.defaults.font.family = "'Jost', system-ui, sans-serif";
    Chart.defaults.color       = '#6b7080'; // muted

    const tooltipCfg = {
        backgroundColor : '#0c1b3a',
        titleColor      : '#fdf8f0',
        bodyColor       : '#c8973a',
        borderColor     : '#c8973a',
        borderWidth     : 1,
        padding         : 10,
        cornerRadius    : 10,
    };

    const doughnutOpts = (pos = 'bottom') => ({
        responsive          : true,
        maintainAspectRatio : false,
        cutout              : '68%',
        plugins: {
            legend : {
                position : pos,
                labels   : { boxWidth: 10, boxHeight: 10, padding: 14, font: { size: 11, weight: '600', family: "'Jost', sans-serif" } }
            },
            tooltip: tooltipCfg,
        }
    });

    document.addEventListener('DOMContentLoaded', () => {

        /* Monthly Members – line ──────────────────── */
        const mmEl = document.getElementById('monthlyMembersChart');
        if (mmEl) {
            new Chart(mmEl.getContext('2d'), {
                type : 'line',
                data : {
                    labels   : {!! json_encode($monthLabels) !!},
                    datasets : [{
                        label                : 'New Members',
                        data                 : {!! json_encode($monthlyNewMembers) !!},
                        borderColor          : '#0c1b3a',
                        backgroundColor      : 'rgba(12,27,58,0.06)',
                        borderWidth          : 2.5,
                        fill                 : true,
                        tension              : 0.45,
                        pointBackgroundColor : '#c8973a',
                        pointBorderColor     : '#fdf8f0',
                        pointBorderWidth     : 2,
                        pointRadius          : 5,
                        pointHoverRadius     : 7,
                    }]
                },
                options: {
                    responsive          : true,
                    maintainAspectRatio : false,
                    plugins : { legend: { display: false }, tooltip: tooltipCfg },
                    scales  : {
                        y: { beginAtZero: true, grid: { color: 'rgba(226,217,204,0.7)' }, ticks: { stepSize: 1, font: { size: 11 } }, border: { dash: [4,4] } },
                        x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                    }
                }
            });
        }

        /* Service Registrations – doughnut ────────── */
        const srEl = document.getElementById('serviceRegistrationsChart');
        if (srEl) {
            const lbl = {!! json_encode($serviceRegistrationCounts->pluck('service')) !!};
            const dat = {!! json_encode($serviceRegistrationCounts->pluck('count')) !!};
            new Chart(srEl.getContext('2d'), {
                type : 'doughnut',
                data : { labels: lbl, datasets: [{ data: dat, backgroundColor: palette.slice(0, lbl.length), borderColor: '#fdf8f0', borderWidth: 3, hoverOffset: 6 }] },
                options: doughnutOpts('right')
            });
        }

        /* Member Distribution – doughnut ─────────── */
        const mdEl = document.getElementById('memberDistributionChart');
        if (mdEl) {
            const lbl = {!! json_encode($memberDistributionLabels ?? []) !!};
            const dat = {!! json_encode($memberDistributionData   ?? []) !!};
            new Chart(mdEl.getContext('2d'), {
                type : 'doughnut',
                data : { labels: lbl, datasets: [{ data: dat, backgroundColor: palette.slice(0, lbl.length), borderColor: '#fdf8f0', borderWidth: 3, hoverOffset: 6 }] },
                options: doughnutOpts()
            });
        }

        /* Service Distribution – bar ─────────────── */
        const sdEl = document.getElementById('serviceDistributionChart');
        if (sdEl) {
            const lbl = {!! json_encode($serviceDistributionLabels ?? []) !!};
            const dat = {!! json_encode($serviceDistributionData   ?? []) !!};
            new Chart(sdEl.getContext('2d'), {
                type : 'bar',
                data : { labels: lbl, datasets: [{ label: 'Count', data: dat, backgroundColor: lbl.map((_, i) => palette[i % palette.length]), borderRadius: 8, borderSkipped: false }] },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: tooltipCfg },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(226,217,204,0.7)' }, ticks: { font: { size: 11 } }, border: { dash: [4,4] } },
                        x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                    }
                }
            });
        }

        /* Active vs Other – doughnut ─────────────── */
        const aiEl = document.getElementById('activeInactiveChart');
        if (aiEl) {
            const lbl = {!! json_encode($aiLabelsFinal ?? ['Active', 'Other']) !!};
            const dat = {!! json_encode($aiDataFinal   ?? []) !!};
            const col = lbl.length === 2 ? ['#1a7a4a', '#e2d9cc'] : palette;
            new Chart(aiEl.getContext('2d'), {
                type : 'doughnut',
                data : { labels: lbl, datasets: [{ data: dat, backgroundColor: col.slice(0, lbl.length), borderColor: '#fdf8f0', borderWidth: 3, hoverOffset: 6 }] },
                options: doughnutOpts()
            });
        }

    });
</script>

@endsection