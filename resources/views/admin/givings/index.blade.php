@extends('layouts.dashboard_layout')

@section('title', 'Giving Management')
@section('header_title', 'Giving Management ❤️')

@section('content')
<div class="space-y-6">
    <!-- Giving Summary Cards – Compact & Clean -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5 mb-8 lg:mb-10">
        <!-- Total This Month -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 border-primary/50 dark:hover:border-primary/60 hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-2.5 bg-primary/10 dark:bg-primary/20 rounded-lg group-hover:bg-primary/20 dark:group-hover:bg-primary/30 transition-colors">
                        <svg class="h-6 w-6 text-primary dark:text-text-dark group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Total This Month</p>
                        <p class="text-2xl lg:text-3xl font-black text-primary dark:text-text-dark mt-0.5" id="total-month">Loading...</p>
                        <p class="text-xs text-gray-500 dark:text-text-muted-dark mt-0.5" id="current-month">{{ now()->format('F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 border-yellow-500/50 dark:hover:border-yellow-400/60 hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-2.5 bg-yellow-100/60 dark:bg-yellow-900/30 rounded-lg group-hover:bg-yellow-200/50 dark:group-hover:bg-yellow-800/40 transition-colors">
                        <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Pending</p>
                        <p class="text-2xl lg:text-3xl font-black text-yellow-600 dark:text-yellow-400 mt-0.5" id="pending-count">Loading...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tithes This Month -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 border-secondary/50 dark:hover:border-secondary/60 hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-2.5 bg-secondary/10 dark:bg-secondary/20 rounded-lg group-hover:bg-secondary/20 dark:group-hover:bg-secondary/30 transition-colors">
                        <svg class="h-6 w-6 text-secondary group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Tithes This Month</p>
                        <p class="text-2xl lg:text-3xl font-black text-secondary mt-0.5" id="tithes-month">Loading...</p>
                        <p class="text-xs text-gray-500 dark:text-text-muted-dark mt-0.5">{{ now()->format('F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 border-accent/50 dark:hover:border-accent/60 hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-2.5 bg-accent/10 dark:bg-accent/20 rounded-lg group-hover:bg-accent/20 dark:group-hover:bg-accent/30 transition-colors">
                        <svg class="h-6 w-6 text-accent group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Transactions</p>
                        <p class="text-2xl lg:text-3xl font-black text-accent mt-0.5" id="transaction-count">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions – Compact & Modern -->
    <div class="bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 p-5 lg:p-6 mb-8 lg:mb-10">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
            <h2 class="text-lg font-semibold text-primary dark:text-text-dark flex items-center gap-2">
                <svg class="h-5 w-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Quick Actions
            </h2>

            <p class="text-xs text-gray-500 dark:text-text-muted-dark" id="last-updated">
                <!-- Last updated time will be shown here -->
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.giving.reports') }}"
            class="group bg-primary hover:bg-secondary text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-300 shadow-sm hover:shadow flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-accent/30 text-sm">
                <svg class="h-4 w-4 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                View Reports
            </a>

            <button onclick="refreshData()" id="refresh-btn"
                    class="group bg-gray-600 dark:bg-gray-700 hover:bg-gray-800 dark:hover:bg-gray-800 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-300 shadow-sm hover:shadow flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-accent/30 text-sm">
                <svg class="h-4 w-4 group-hover:rotate-180 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Refresh Data
            </button>

            <a href="{{ route('giving.index') }}" target="_blank"
            class="group bg-accent hover:bg-secondary text-primary hover:text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-300 shadow-sm hover:shadow flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-accent/30 text-sm">
                <svg class="h-4 w-4 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                Public Giving Page
            </a>
        </div>
    </div>

    <!-- Filter Givings – Compact & Clean -->
    <div class="bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 p-5 lg:p-6 mb-8 lg:mb-10">
        <h2 class="text-lg font-semibold text-primary dark:text-text-dark mb-4 flex items-center gap-2">
            <svg class="h-5 w-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M3 8h18M3 12h18M3 16h18M3 20h18" />
            </svg>
            Filter Givings
        </h2>

        <form method="GET" action="{{ route('admin.givings') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Status -->
            <div>
                <label for="status" class="block text-xs font-medium text-gray-700 dark:text-text-muted-dark mb-1.5">Status</label>
                <select name="status" id="status"
                        class="w-full px-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-background-dark text-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20 hover:border-gray-400 dark:hover:border-gray-500">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Giving Type -->
            <div>
                <label for="giving_type" class="block text-xs font-medium text-gray-700 dark:text-text-muted-dark mb-1.5">Type</label>
                <select name="giving_type" id="giving_type"
                        class="w-full px-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-background-dark text-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20 hover:border-gray-400 dark:hover:border-gray-500">
                    <option value="">All Types</option>
                    <option value="tithe" {{ request('giving_type') == 'tithe' ? 'selected' : '' }}>Tithe</option>
                    <option value="offering" {{ request('giving_type') == 'offering' ? 'selected' : '' }}>Offering</option>
                    <option value="donation" {{ request('giving_type') == 'donation' ? 'selected' : '' }}>Donation</option>
                    <option value="special_offering" {{ request('giving_type') == 'special_offering' ? 'selected' : '' }}>Special Offering</option>
                </select>
            </div>

            <!-- Payment Method -->
            <div>
                <label for="payment_method" class="block text-xs font-medium text-gray-700 dark:text-text-muted-dark mb-1.5">Payment Method</label>
                <select name="payment_method" id="payment_method"
                        class="w-full px-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-background-dark text-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20 hover:border-gray-400 dark:hover:border-gray-500">
                    <option value="">All Methods</option>
                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="mobile_money" {{ request('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                    <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                    <option value="check" {{ request('payment_method') == 'check' ? 'selected' : '' }}>Check</option>
                </select>
            </div>

            <!-- Start Date -->
            <div>
                <label for="start_date" class="block text-xs font-medium text-gray-700 dark:text-text-muted-dark mb-1.5">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                    class="w-full px-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-background-dark text-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20 hover:border-gray-400 dark:hover:border-gray-500">
            </div>

            <!-- Filter Button -->
            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-primary hover:bg-secondary text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-primary/30 text-sm">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Recent Givings Table – Compact, Modern & Intuitive -->
    <div class="bg-white dark:bg-background-dark rounded-2xl shadow-lg border border-gray-200/70 dark:border-gray-700 overflow-hidden">
        <!-- Table Header -->
        <div class="px-5 py-3.5 border-b border-gray-200/80 dark:border-gray-700/80">
            <h2 class="text-lg font-bold text-primary dark:text-text-dark flex items-center gap-3">
                <svg class="h-6 w-6 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Recent Givings
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200/70 dark:divide-gray-700/60">
                <thead class="bg-primary/5 dark:bg-primary/10 border-b border-primary/30 dark:border-primary/40">
                    <tr>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                            Giver
                        </th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                            Type
                        </th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                            Amount
                        </th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                            Payment
                        </th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                            Status
                        </th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                            Date
                        </th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70 dark:divide-gray-700/50">
                    @forelse($givings as $giving)
                        <tr class="group hover:bg-primary/5 dark:hover:bg-primary/10 hover:shadow-md hover:-translate-y-[1px] hover:border-x hover:border-primary/30 dark:hover:border-primary/40 transition-all duration-200">
                            <td class="px-5 py-3.5 whitespace-nowrap border-r border-gray-100/50 dark:border-gray-700/40">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-9 w-9">
                                        <div class="h-9 w-9 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center ring-1 ring-accent/30">
                                            <span class="text-sm font-medium text-primary dark:text-text-dark">
                                                {{ $giving->member ? substr($giving->member->full_name, 0, 1) : 'G' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-text-dark group-hover:text-primary transition-colors">
                                            {{ $giving->giver_name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-text-muted-dark">
                                            {{ $giving->member ? 'Member' : 'Guest' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap border-r border-gray-100/50 dark:border-gray-700/40">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($giving->giving_type == 'tithe') bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-300
                                    @elseif($giving->giving_type == 'offering') bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300
                                    @elseif($giving->giving_type == 'donation') bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300
                                    @else bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $giving->giving_type)) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm font-medium border-r border-gray-100/50 dark:border-gray-700/40 group-hover:text-primary transition-colors">
                                <div>{{ number_format($giving->amount, 0) }} {{ $giving->currency }}</div>
                                @if($giving->processing_fee)
                                    <div class="text-xs text-gray-500 dark:text-text-muted-dark">Fee: {{ number_format($giving->processing_fee, 0) }} {{ $giving->currency }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm text-gray-700 dark:text-text-muted-dark border-r border-gray-100/50 dark:border-gray-700/40 group-hover:text-primary/90 transition-colors">
                                <div>{{ ucfirst(str_replace('_', ' ', $giving->payment_method)) }}</div>
                                @if($giving->payment_provider)
                                    <div class="text-xs text-gray-500 dark:text-text-muted-dark">{{ $giving->payment_provider }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap border-r border-gray-100/50 dark:border-gray-700/40">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($giving->status == 'completed') bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300
                                    @elseif($giving->status == 'pending') bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300
                                    @elseif($giving->status == 'failed') bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300
                                    @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-text-muted-dark @endif">
                                    {{ ucfirst($giving->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm text-gray-500 dark:text-text-muted-dark border-r border-gray-100/50 dark:border-gray-700/40">
                                {{ $giving->payment_date ? $giving->payment_date->format('M d, Y') : $giving->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-wrap gap-2">
                                    @if($giving->status == 'pending')
                                        <button onclick="showConfirmModal({{ $giving->id }}, '{{ $giving->giver_name }}', {{ $giving->amount }}, '{{ $giving->currency }}')" 
                                                class="px-3 py-1.5 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-green-800/50 rounded-lg transition duration-200 text-xs flex items-center gap-1 border border-green-200/50 dark:border-green-700/40 hover:border-green-300 dark:hover:border-green-600/60">
                                            ✓ Confirm
                                        </button>
                                        <button onclick="showFailModal({{ $giving->id }}, '{{ $giving->giver_name }}')" 
                                                class="px-3 py-1.5 bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-800/50 rounded-lg transition duration-200 text-xs flex items-center gap-1 border border-red-200/50 dark:border-red-700/40 hover:border-red-300 dark:hover:border-red-600/60">
                                            ✗ Fail
                                        </button>
                                    @endif
                                    @if($giving->status == 'completed' && $giving->giver_email)
                                        <button onclick="resendReceipt({{ $giving->id }}, '{{ $giving->giver_email }}')" 
                                                class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-800/50 rounded-lg transition duration-200 text-xs flex items-center gap-1 border border-blue-200/50 dark:border-blue-700/40 hover:border-blue-300 dark:hover:border-blue-600/60">
                                            📧 Resend
                                        </button>
                                    @endif
                                    <button onclick="viewDetails({{ $giving->id }})" 
                                            class="px-3 py-1.5 bg-gray-50 dark:bg-gray-800/30 text-gray-700 dark:text-text-muted-dark hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition duration-200 text-xs flex items-center gap-1 border border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500">
                                        👁 View
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-text-muted-dark text-sm">
                                No givings found yet.
                                <a href="{{ route('giving.index') }}" class="text-primary hover:underline font-medium ml-2">
                                    Share the public giving page
                                </a> to start receiving donations!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($givings->hasPages())
            <div class="px-5 py-3.5 border-t border-gray-200/80 dark:border-gray-700/80 flex justify-center">
                {{ $givings->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

</div>

<!-- Giving Details Modal -->
<div id="giving-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full modal-enter">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Giving Details</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="modal-content" class="giving-modal-content p-6">
                <div class="flex justify-center items-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <span class="ml-2 text-gray-600">Loading giving details...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Giving Modal -->
<div id="confirm-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Confirm Giving</h3>
            </div>
            <div class="p-6">
                <div id="confirm-details" class="mb-4">
                    <!-- Details will be populated here -->
                </div>
                <div class="space-y-4">
                    <div>
                        <label for="verified_amount" class="block text-sm font-medium text-gray-700 mb-1">
                            Verified Amount (optional)
                        </label>
                        <input type="number" id="verified_amount" name="verified_amount" step="0.01" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                               placeholder="Leave blank to use original amount">
                        <p class="text-xs text-gray-500 mt-1">Only enter if the verified amount differs from the original</p>
                    </div>
                    <div>
                        <label for="confirm_notes" class="block text-sm font-medium text-gray-700 mb-1">
                            Admin Notes (optional)
                        </label>
                        <textarea id="confirm_notes" name="confirm_notes" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                  placeholder="Add any verification notes..."></textarea>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button onclick="closeConfirmModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Cancel
                </button>
                <button onclick="confirmGiving()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                    Confirm Giving
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Fail Giving Modal -->
<div id="fail-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Mark Giving as Failed</h3>
            </div>
            <div class="p-6">
                <div id="fail-details" class="mb-4">
                    <!-- Details will be populated here -->
                </div>
                <div>
                    <label for="failure_reason" class="block text-sm font-medium text-gray-700 mb-1">
                        Failure Reason
                    </label>
                    <textarea id="failure_reason" name="failure_reason" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                              placeholder="Explain why this giving failed (e.g., insufficient funds, invalid transaction reference)"></textarea>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button onclick="closeFailModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Cancel
                </button>
                <button onclick="failGiving()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">
                    Mark as Failed
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Global variables for modal state
let currentGivingId = null;

// Load summary data on page load
document.addEventListener('DOMContentLoaded', function() {
    refreshData();
});

function refreshData() {
    // Show loading state on button and cards
    const refreshBtn = document.getElementById('refresh-btn');
    const originalBtnText = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '⏳ Loading...';
    refreshBtn.disabled = true;

    document.getElementById('total-month').innerHTML = '<span class="text-gray-500">Loading...</span>';
    document.getElementById('pending-count').innerHTML = '<span class="text-gray-500">Loading...</span>';
    document.getElementById('tithes-month').innerHTML = '<span class="text-gray-500">Loading...</span>';
    document.getElementById('transaction-count').innerHTML = '<span class="text-gray-500">Loading...</span>';

    fetch('{{ route("admin.givings.dashboard-summary") }}')
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Response text:', text);
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Dashboard data received:', data);
            
            if (data.success) {
                document.getElementById('total-month').textContent = 
                    new Intl.NumberFormat().format(data.summary.total_amount) + ' UGX';
                document.getElementById('pending-count').textContent = 
                    data.summary.pending_count || '0';
                document.getElementById('tithes-month').textContent = 
                    new Intl.NumberFormat().format(data.summary.total_tithes) + ' UGX';
                document.getElementById('transaction-count').textContent = 
                    data.summary.transaction_count || '0';
                
                // Update last refreshed time
                const now = new Date();
                document.getElementById('last-updated').textContent = 
                    'Last updated: ' + now.toLocaleTimeString();
                
                // Show debug info if available
                if (data.debug) {
                    console.log('Debug info:', data.debug);
                    document.getElementById('last-updated').textContent += 
                        ` (DB: ${data.debug.total_givings_in_db} total, ${data.debug.completed_givings_in_db} completed)`;
                }
                
                // Show success message briefly (only if manually refreshed)
                if (refreshBtn.disabled) {
                    showAlert('success', 'Dashboard data refreshed successfully');
                }
            } else {
                throw new Error(data.message || 'Server returned success=false');
            }
        })
        .catch(error => {
            console.error('Error loading dashboard data:', error);
            
            // Show error state with more details
            const errorMsg = error.message.includes('HTTP') ? 'Server Error' : 'Network Error';
            document.getElementById('total-month').innerHTML = `<span class="text-red-500" title="${error.message}">${errorMsg}</span>`;
            document.getElementById('pending-count').innerHTML = `<span class="text-red-500" title="${error.message}">${errorMsg}</span>`;
            document.getElementById('tithes-month').innerHTML = `<span class="text-red-500" title="${error.message}">${errorMsg}</span>`;
            document.getElementById('transaction-count').innerHTML = `<span class="text-red-500" title="${error.message}">${errorMsg}</span>`;
            
            showAlert('error', 'Failed to load dashboard data. Check console for details.');
        })
        .finally(() => {
            // Reset button state
            refreshBtn.innerHTML = originalBtnText;
            refreshBtn.disabled = false;
        });
}

function showConfirmModal(givingId, giverName, amount, currency) {
    currentGivingId = givingId;
    document.getElementById('confirm-details').innerHTML = `
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <h4 class="font-semibold text-green-800">Confirming Giving</h4>
            <p class="text-green-700"><strong>Giver:</strong> ${giverName}</p>
            <p class="text-green-700"><strong>Amount:</strong> ${new Intl.NumberFormat().format(amount)} ${currency}</p>
        </div>
    `;
    document.getElementById('verified_amount').value = '';
    document.getElementById('confirm_notes').value = '';
    document.getElementById('confirm-modal').classList.remove('hidden');
}

function closeConfirmModal() {
    document.getElementById('confirm-modal').classList.add('hidden');
    currentGivingId = null;
}

function confirmGiving() {
    if (!currentGivingId) return;

    const verifiedAmount = document.getElementById('verified_amount').value;
    const notes = document.getElementById('confirm_notes').value;

    const requestData = {
        notes: notes
    };

    if (verifiedAmount && verifiedAmount !== '') {
        requestData.verified_amount = parseFloat(verifiedAmount);
    }

    fetch(`/admin/givings/${currentGivingId}/confirm`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(requestData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            closeConfirmModal();
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('error', data.message || 'Error confirming giving');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'An error occurred while confirming the giving.');
    });
}

function showFailModal(givingId, giverName) {
    currentGivingId = givingId;
    document.getElementById('fail-details').innerHTML = `
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <h4 class="font-semibold text-red-800">Marking Giving as Failed</h4>
            <p class="text-red-700"><strong>Giver:</strong> ${giverName}</p>
            <p class="text-red-700 text-sm mt-2">This action will mark the giving as failed and cannot be undone.</p>
        </div>
    `;
    document.getElementById('failure_reason').value = '';
    document.getElementById('fail-modal').classList.remove('hidden');
}

function closeFailModal() {
    document.getElementById('fail-modal').classList.add('hidden');
    currentGivingId = null;
}

function failGiving() {
    if (!currentGivingId) return;

    const failureReason = document.getElementById('failure_reason').value.trim();
    
    if (!failureReason) {
        showAlert('error', 'Please provide a failure reason.');
        return;
    }

    fetch(`/admin/givings/${currentGivingId}/fail`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            failure_reason: failureReason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            closeFailModal();
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('error', data.message || 'Error marking giving as failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'An error occurred while updating the giving.');
    });
}

function resendReceipt(givingId, email) {
    if (confirm(`Resend receipt email to ${email}?`)) {
        fetch(`/admin/givings/${givingId}/resend-receipt`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while resending the receipt.');
        });
    }
}

function exportCsv() {
    // Get current filter values
    const params = new URLSearchParams();
    
    const status = document.getElementById('status').value;
    const givingType = document.getElementById('giving_type').value;
    const paymentMethod = document.getElementById('payment_method').value;
    const startDate = document.getElementById('start_date').value;
    
    if (status) params.append('status', status);
    if (givingType) params.append('giving_type', givingType);
    if (paymentMethod) params.append('payment_method', paymentMethod);
    if (startDate) params.append('start_date', startDate);
    
    // Add end date as today if start date is provided but end date isn't
    if (startDate && !document.querySelector('input[name="end_date"]')) {
        params.append('end_date', new Date().toISOString().split('T')[0]);
    }

    const url = `/admin/givings/export-csv?${params.toString()}`;
    
    // Create a temporary link and click it to download
    const link = document.createElement('a');
    link.href = url;
    link.download = '';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showAlert('success', 'CSV export started. Your download should begin shortly.');
}

function viewDetails(givingId) {
    // Show modal with loading state
    document.getElementById('giving-modal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden'); // Prevent body scroll
    document.getElementById('modal-content').innerHTML = `
        <div class="flex justify-center items-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <span class="ml-2 text-gray-600">Loading giving details...</span>
        </div>
    `;

    // Fetch detailed giving information
    fetch(`/admin/givings/${givingId}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            displayGivingDetails(data);
        } else {
            throw new Error(data.message || 'Failed to load giving details');
        }
    })
    .catch(error => {
        console.error('Error loading giving details:', error);
        document.getElementById('modal-content').innerHTML = `
            <div class="text-center py-8">
                <div class="text-red-600 mb-4">
                    <svg class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Error Loading Details</h3>
                <p class="text-gray-600 mb-4">${error.message}</p>
                <div class="space-x-3">
                    <button onclick="viewDetails(${givingId})" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Try Again
                    </button>
                    <button onclick="closeModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Close
                    </button>
                </div>
            </div>
        `;
    });
}

function displayGivingDetails(data) {
    const giving = data.giving;
    const history = data.history;
    const financialSummary = data.financial_summary;
    const giverInfo = data.giver_info;

    const content = `
        <div class="space-y-6">
            <!-- Header with Status -->
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Giving #${giving.id}</h2>
                    <p class="text-gray-600">${giving.receipt_number || 'No receipt number'}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${getStatusBadgeClass(giving.status)}">
                        ${giving.status.charAt(0).toUpperCase() + giving.status.slice(1)}
                    </span>
                    <p class="text-sm text-gray-500 mt-1">Created: ${formatDateTime(giving.created_at)}</p>
                </div>
            </div>

            <!-- Main Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Giver Information -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Giver Information</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Name:</span>
                            <span class="font-medium">${giverInfo.name}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-medium">${giverInfo.type}</span>
                        </div>
                        ${giverInfo.email ? `
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium">${giverInfo.email}</span>
                        </div>
                        ` : ''}
                        ${giverInfo.phone ? `
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phone:</span>
                            <span class="font-medium">${giverInfo.phone}</span>
                        </div>
                        ` : ''}
                    </div>
                </div>

                <!-- Financial Summary -->
                <div class="bg-green-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Financial Summary</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Gross Amount:</span>
                            <span class="font-bold text-green-600">${formatCurrency(financialSummary.gross_amount, financialSummary.currency)}</span>
                        </div>
                        ${financialSummary.processing_fee > 0 ? `
                        <div class="flex justify-between">
                            <span class="text-gray-600">Processing Fee:</span>
                            <span class="font-medium text-red-600">-${formatCurrency(financialSummary.processing_fee, financialSummary.currency)}</span>
                        </div>
                        <hr class="border-gray-300">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Net Amount:</span>
                            <span class="font-bold text-green-600">${formatCurrency(financialSummary.net_amount, financialSummary.currency)}</span>
                        </div>
                        ` : ''}
                    </div>
                </div>
            </div>

            <!-- Giving Details -->
            <div class="bg-white border rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Giving Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-medium">${giving.giving_type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Method:</span>
                            <span class="font-medium">${giving.payment_method.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}</span>
                        </div>
                        ${giving.payment_provider ? `
                        <div class="flex justify-between">
                            <span class="text-gray-600">Provider:</span>
                            <span class="font-medium">${giving.payment_provider}</span>
                        </div>
                        ` : ''}
                    </div>
                    <div class="space-y-2">
                        ${giving.transaction_reference ? `
                        <div class="flex justify-between">
                            <span class="text-gray-600">Transaction Ref:</span>
                            <span class="font-medium font-mono text-sm">${giving.transaction_reference}</span>
                        </div>
                        ` : ''}
                        ${giving.purpose ? `
                        <div class="flex justify-between">
                            <span class="text-gray-600">Purpose:</span>
                            <span class="font-medium">${giving.purpose}</span>
                        </div>
                        ` : ''}
                        <div class="flex justify-between">
                            <span class="text-gray-600">Receipt Sent:</span>
                            <span class="font-medium ${giving.receipt_sent ? 'text-green-600' : 'text-gray-500'}">
                                ${giving.receipt_sent ? 'Yes' : 'No'}
                            </span>
                        </div>
                    </div>
                </div>
                ${giving.notes ? `
                <div class="mt-4 pt-4 border-t">
                    <h4 class="font-medium text-gray-900 mb-2">Notes:</h4>
                    <p class="text-gray-700 text-sm whitespace-pre-line">${giving.notes}</p>
                </div>
                ` : ''}
            </div>

            <!-- Transaction History -->
            <div class="bg-white border rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Transaction History</h3>
                <div class="space-y-0">
                    ${history.map((item, index) => `
                        <div class="timeline-item flex items-start space-x-3 pb-4 ${index < history.length - 1 ? 'mb-3' : ''}">
                            <div class="flex-shrink-0 w-3 h-3 bg-blue-600 rounded-full mt-1.5 relative z-10"></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900">${item.action}</p>
                                        <p class="text-sm text-gray-600 mt-1">${item.description}</p>
                                        ${item.user ? `<p class="text-xs text-blue-600 mt-1">by ${item.user}</p>` : ''}
                                    </div>
                                    <div class="text-right flex-shrink-0 ml-4">
                                        <p class="text-sm text-gray-500">${formatDateTime(item.timestamp)}</p>
                                    </div>
                                </div>
                                ${Object.keys(item.details).length > 0 ? `
                                <div class="mt-2 p-2 bg-gray-50 rounded text-xs text-gray-600">
                                    ${Object.entries(item.details).map(([key, value]) => 
                                        `<div class="flex justify-between"><span class="font-medium">${key.replace('_', ' ')}:</span><span>${value}</span></div>`
                                    ).join('')}
                                </div>
                                ` : ''}
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-4 border-t">
                ${giving.status === 'completed' && giving.giver_email ? `
                <button onclick="resendReceipt(${giving.id}, '${giving.giver_email}')" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">
                    📧 Resend Receipt
                </button>
                ` : ''}
                <button onclick="closeModal()" 
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm">
                    Close
                </button>
            </div>
        </div>
    `;

    document.getElementById('modal-content').innerHTML = content;
}

function getStatusBadgeClass(status) {
    switch(status) {
        case 'completed':
            return 'bg-green-100 text-green-800';
        case 'pending':
            return 'bg-yellow-100 text-yellow-800';
        case 'failed':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}

function formatDateTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function formatCurrency(amount, currency) {
    return new Intl.NumberFormat().format(amount) + ' ' + currency;
}

function closeModal() {
    document.getElementById('giving-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden'); // Re-enable body scroll
}

// Close modal on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('giving-modal');
        if (!modal.classList.contains('hidden')) {
            closeModal();
        }
    }
});

// Close modal when clicking outside
document.getElementById('giving-modal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeModal();
    }
});

function showAlert(type, message) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transition-all duration-300 ${
        type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'
    }`;
    alertDiv.innerHTML = `
        <div class="flex items-center">
            <span class="flex-1">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-400 hover:text-gray-600">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.style.opacity = '0';
            alertDiv.style.transform = 'translateX(100%)';
            setTimeout(() => alertDiv.remove(), 300);
        }
    }, 5000);
}
</script>

<!-- Add CSRF token to head for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
/* Custom styles for the giving details modal */
.giving-modal-content {
    max-height: 90vh;
    overflow-y: auto;
}

.giving-modal-content::-webkit-scrollbar {
    width: 6px;
}

.giving-modal-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.giving-modal-content::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.giving-modal-content::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Animation for modal */
.modal-enter {
    animation: modalEnter 0.3s ease-out;
}

@keyframes modalEnter {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Timeline styles for transaction history */
.timeline-item {
    position: relative;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 4px;
    top: 24px;
    bottom: -12px;
    width: 2px;
    background: #e5e7eb;
}
</style>
@endsection