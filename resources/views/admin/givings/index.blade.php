@extends('layouts.dashboard_layout')

@section('title', 'Giving Management')
@section('header_title', 'Giving Management')

@section('content')
<div class="space-y-6">

    {{-- ── Page Header ── --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-primary">Giving Management</h1>
            <p class="text-muted text-sm mt-1">Track tithes, offerings and donations across the congregation</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="refreshData()" id="refresh-btn"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-border text-muted text-sm font-semibold rounded-xl hover:border-accent/40 hover:text-primary transition-all duration-200">
                <svg id="refresh-icon" class="w-4 h-4 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Refresh
            </button>
            <a href="{{ route('admin.giving.reports') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-border text-muted text-sm font-semibold rounded-xl hover:border-accent/40 hover:text-primary transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Reports
            </a>
            <a href="{{ route('giving.index') }}" target="_blank"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-light text-white text-sm font-semibold rounded-xl shadow-card transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card-hover">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Public Giving Page
            </a>
        </div>
    </div>

    {{-- ── KPI Cards ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- Total This Month --}}
        <div class="bg-white rounded-2xl border border-border shadow-card p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover relative overflow-hidden group">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-accent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(200,151,58,0.1)">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="#c8973a" stroke-width="1.8"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-semibold text-muted">{{ now()->format('M Y') }}</span>
            </div>
            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-1">Total This Month</p>
            <p class="text-2xl font-black text-primary" id="total-month">
                <span class="text-muted font-normal text-sm">Loading…</span>
            </p>
        </div>

        {{-- Pending --}}
        <div class="bg-white rounded-2xl border border-border shadow-card p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover relative overflow-hidden group">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-accent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(200,151,58,0.12)">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="#c8973a" stroke-width="1.8"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="inline-flex items-center gap-1 text-xs font-bold px-2 py-0.5 rounded-full" style="background:rgba(200,151,58,0.12);color:#9a6f1e">Needs Review</span>
            </div>
            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-1">Pending</p>
            <p class="text-2xl font-black text-primary" id="pending-count">
                <span class="text-muted font-normal text-sm">Loading…</span>
            </p>
        </div>

        {{-- Tithes This Month --}}
        <div class="bg-white rounded-2xl border border-border shadow-card p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover relative overflow-hidden group">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-success to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(26,122,74,0.09)">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="#1a7a4a" stroke-width="1.8"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="text-xs font-semibold text-muted">{{ now()->format('M Y') }}</span>
            </div>
            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-1">Tithes This Month</p>
            <p class="text-2xl font-black text-primary" id="tithes-month">
                <span class="text-muted font-normal text-sm">Loading…</span>
            </p>
        </div>

        {{-- Transactions --}}
        <div class="bg-white rounded-2xl border border-border shadow-card p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover relative overflow-hidden group">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-primary to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(12,27,58,0.07)">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="#0c1b3a" stroke-width="1.8"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2 py-0.5 rounded-full" style="background:rgba(26,122,74,0.1);color:#1a7a4a">
                    <span class="w-1.5 h-1.5 rounded-full bg-success inline-block"></span>Live
                </span>
            </div>
            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-1">Transactions</p>
            <p class="text-2xl font-black text-primary" id="transaction-count">
                <span class="text-muted font-normal text-sm">Loading…</span>
            </p>
        </div>

    </div>

    {{-- ── Filter Bar ── --}}
    <div class="bg-white rounded-2xl border border-border shadow-card p-5">
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-4 h-4 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
            <h2 class="text-sm font-bold text-primary uppercase tracking-widest">Filter Givings</h2>
        </div>
        <form method="GET" action="{{ route('admin.givings') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

            <div>
                <label for="status" class="block text-xs font-bold text-muted uppercase tracking-widest mb-1.5">Status</label>
                <select name="status" id="status"
                        class="w-full px-3 py-2.5 border border-border rounded-xl text-sm bg-cream/40 focus:outline-none focus:ring-2 focus:border-accent transition">
                    <option value="">All Statuses</option>
                    <option value="pending"   {{ request('status') == 'pending'    ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed'  ? 'selected' : '' }}>Completed</option>
                    <option value="failed"    {{ request('status') == 'failed'     ? 'selected' : '' }}>Failed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <label for="giving_type" class="block text-xs font-bold text-muted uppercase tracking-widest mb-1.5">Type</label>
                <select name="giving_type" id="giving_type"
                        class="w-full px-3 py-2.5 border border-border rounded-xl text-sm bg-cream/40 focus:outline-none focus:ring-2 focus:border-accent transition">
                    <option value="">All Types</option>
                    <option value="tithe"            {{ request('giving_type') == 'tithe'            ? 'selected' : '' }}>Tithe</option>
                    <option value="offering"         {{ request('giving_type') == 'offering'         ? 'selected' : '' }}>Offering</option>
                    <option value="donation"         {{ request('giving_type') == 'donation'         ? 'selected' : '' }}>Donation</option>
                    <option value="special_offering" {{ request('giving_type') == 'special_offering' ? 'selected' : '' }}>Special Offering</option>
                </select>
            </div>

            <div>
                <label for="payment_method" class="block text-xs font-bold text-muted uppercase tracking-widest mb-1.5">Payment Method</label>
                <select name="payment_method" id="payment_method"
                        class="w-full px-3 py-2.5 border border-border rounded-xl text-sm bg-cream/40 focus:outline-none focus:ring-2 focus:border-accent transition">
                    <option value="">All Methods</option>
                    <option value="cash"          {{ request('payment_method') == 'cash'          ? 'selected' : '' }}>Cash</option>
                    <option value="mobile_money"  {{ request('payment_method') == 'mobile_money'  ? 'selected' : '' }}>Mobile Money</option>
                    <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="card"          {{ request('payment_method') == 'card'          ? 'selected' : '' }}>Card</option>
                    <option value="check"         {{ request('payment_method') == 'check'         ? 'selected' : '' }}>Check</option>
                </select>
            </div>

            <div>
                <label for="start_date" class="block text-xs font-bold text-muted uppercase tracking-widest mb-1.5">From Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                       class="w-full px-3 py-2.5 border border-border rounded-xl text-sm bg-cream/40 focus:outline-none focus:ring-2 focus:border-accent transition">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-light text-white text-sm font-semibold rounded-xl transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    Filter
                </button>
                <a href="{{ route('admin.givings') }}"
                   class="px-3 py-2.5 border border-border rounded-xl text-muted hover:border-accent/40 hover:text-primary transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </a>
            </div>

        </form>
    </div>

    {{-- ── Givings Table ── --}}
    <div class="bg-white rounded-2xl border border-border shadow-card overflow-hidden">
        <div class="px-6 py-4 border-b border-border flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <h2 class="text-lg font-bold text-primary">Recent Givings</h2>
            </div>
            <div class="flex items-center gap-3">
                <p class="text-xs text-muted" id="last-updated"></p>
                <button onclick="exportCsv()"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-muted border border-border rounded-lg hover:border-accent/40 hover:text-primary transition-all duration-150">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Export CSV
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr style="background:#fdf8f0">
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Giver</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Type</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Amount</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Payment</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Status</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Date</th>
                        <th class="px-6 py-3.5 text-right text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/60">
                    @forelse($givings as $giving)
                        <tr class="hover:bg-cream/40 transition-colors duration-150">

                            {{-- Giver --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-sm text-primary border-2 border-border"
                                         style="background:rgba(12,27,58,0.07)">
                                        {{ $giving->member ? strtoupper(substr($giving->member->full_name, 0, 2)) : 'GU' }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-primary">{{ $giving->giver_name }}</div>
                                        <div class="text-xs text-muted">{{ $giving->member ? 'Member' : 'Guest' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Type badge --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $typeStyles = [
                                        'tithe'            => 'background:rgba(12,27,58,0.08);color:#0c1b3a',
                                        'offering'         => 'background:rgba(26,122,74,0.1);color:#1a7a4a',
                                        'donation'         => 'background:rgba(200,151,58,0.12);color:#9a6f1e',
                                        'special_offering' => 'background:rgba(192,57,43,0.1);color:#c0392b',
                                    ];
                                    $style = $typeStyles[$giving->giving_type] ?? 'background:rgba(107,112,128,0.1);color:#6b7080';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold" style="{{ $style }}">
                                    {{ ucfirst(str_replace('_', ' ', $giving->giving_type)) }}
                                </span>
                            </td>

                            {{-- Amount --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-primary">{{ number_format($giving->amount, 0) }} {{ $giving->currency }}</div>
                                @if($giving->processing_fee)
                                    <div class="text-xs text-muted mt-0.5">Fee: {{ number_format($giving->processing_fee, 0) }} {{ $giving->currency }}</div>
                                @endif
                            </td>

                            {{-- Payment --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-primary/80">{{ ucfirst(str_replace('_', ' ', $giving->payment_method)) }}</div>
                                @if($giving->payment_provider)
                                    <div class="text-xs text-muted mt-0.5">{{ $giving->payment_provider }}</div>
                                @endif
                            </td>

                            {{-- Status badge --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($giving->status == 'completed')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold" style="background:rgba(26,122,74,0.1);color:#1a7a4a">
                                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span>Completed
                                    </span>
                                @elseif($giving->status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold" style="background:rgba(200,151,58,0.12);color:#9a6f1e">
                                        <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>Pending
                                    </span>
                                @elseif($giving->status == 'failed')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold" style="background:rgba(192,57,43,0.1);color:#c0392b">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>Failed
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-sand text-muted">
                                        <span class="w-1.5 h-1.5 rounded-full bg-muted"></span>{{ ucfirst($giving->status) }}
                                    </span>
                                @endif
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">
                                {{ $giving->payment_date ? $giving->payment_date->format('M d, Y') : $giving->created_at->format('M d, Y') }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    @if($giving->status == 'pending')
                                        <button onclick="showConfirmModal({{ $giving->id }}, '{{ $giving->giver_name }}', {{ $giving->amount }}, '{{ $giving->currency }}')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white rounded-lg transition-all duration-150"
                                                style="background:#1a7a4a"
                                                onmouseover="this.style.background='#155f39'" onmouseout="this.style.background='#1a7a4a'">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                                            Confirm
                                        </button>
                                        <button onclick="showFailModal({{ $giving->id }}, '{{ $giving->giver_name }}')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white rounded-lg bg-secondary hover:bg-red-700 transition-all duration-150">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                            Fail
                                        </button>
                                    @endif
                                    @if($giving->status == 'completed' && $giving->giver_email)
                                        <button onclick="resendReceipt({{ $giving->id }}, '{{ $giving->giver_email }}')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg border border-border text-muted hover:border-accent/40 hover:text-primary transition-all duration-150">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            Resend
                                        </button>
                                    @endif
                                    <button onclick="viewDetails({{ $giving->id }})"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg border border-border text-muted hover:border-primary/30 hover:text-primary transition-all duration-150">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center bg-sand border border-border">
                                    <svg class="w-8 h-8 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <p class="font-semibold text-primary">No givings found</p>
                                <p class="text-muted text-sm mt-1">
                                    <a href="{{ route('giving.index') }}" class="text-accent hover:underline font-semibold">Share the public giving page</a> to start receiving donations
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($givings->hasPages())
            <div class="px-6 py-4 border-t border-border flex justify-center">
                {{ $givings->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

</div>

{{-- ══════════════════════════════════════════════
     Giving Details Modal
══════════════════════════════════════════════ --}}
<div id="giving-modal" class="fixed inset-0 bg-primary/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4" style="display:none">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full flex flex-col" style="max-height:92vh;animation:modalIn 0.25s ease">
        <div class="px-8 py-5 border-b border-border flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
            <h3 class="text-xl font-black text-primary">Giving Details</h3>
            <button onclick="closeModal()" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-sand text-muted hover:text-primary transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div id="modal-content" class="p-8 overflow-y-auto flex-1"></div>
    </div>
</div>

{{-- ══════════════════════════════════════════════
     Confirm Giving Modal
══════════════════════════════════════════════ --}}
<div id="confirm-modal" class="fixed inset-0 bg-primary/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4" style="display:none">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full" style="animation:modalIn 0.25s ease">
        <div class="px-8 py-5 border-b border-border flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(26,122,74,0.1)">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="#1a7a4a" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-lg font-black text-primary">Confirm Giving</h3>
        </div>
        <div class="p-8 space-y-5">
            <div id="confirm-details"></div>
            <div>
                <label for="verified_amount" class="block text-xs font-bold text-muted uppercase tracking-widest mb-2">Verified Amount <span class="font-normal normal-case">(optional)</span></label>
                <input type="number" id="verified_amount" step="0.01" min="0" placeholder="Leave blank to use original amount"
                       class="w-full px-4 py-2.5 border border-border rounded-xl text-sm bg-cream/40 focus:outline-none focus:ring-2 focus:border-accent transition">
                <p class="text-xs text-muted mt-1.5">Only enter if the verified amount differs from the original</p>
            </div>
            <div>
                <label for="confirm_notes" class="block text-xs font-bold text-muted uppercase tracking-widest mb-2">Admin Notes <span class="font-normal normal-case">(optional)</span></label>
                <textarea id="confirm_notes" rows="3" placeholder="Add any verification notes…"
                          class="w-full px-4 py-2.5 border border-border rounded-xl text-sm bg-cream/40 focus:outline-none focus:ring-2 focus:border-accent transition resize-none"></textarea>
            </div>
        </div>
        <div class="px-8 py-5 border-t border-border flex justify-end gap-3">
            <button onclick="closeConfirmModal()" class="px-5 py-2.5 border border-border text-muted text-sm font-semibold rounded-xl hover:bg-sand transition-all">Cancel</button>
            <button onclick="confirmGiving()" class="px-6 py-2.5 text-white text-sm font-semibold rounded-xl transition-all" style="background:#1a7a4a" onmouseover="this.style.background='#155f39'" onmouseout="this.style.background='#1a7a4a'">Confirm Giving</button>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════
     Fail Giving Modal
══════════════════════════════════════════════ --}}
<div id="fail-modal" class="fixed inset-0 bg-primary/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4" style="display:none">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full" style="animation:modalIn 0.25s ease">
        <div class="px-8 py-5 border-b border-border flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(192,57,43,0.1)">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="#c0392b" stroke-width="2"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-lg font-black text-primary">Mark as Failed</h3>
        </div>
        <div class="p-8 space-y-5">
            <div id="fail-details"></div>
            <div>
                <label for="failure_reason" class="block text-xs font-bold text-muted uppercase tracking-widest mb-2">Failure Reason <span class="text-secondary">*</span></label>
                <textarea id="failure_reason" rows="3" required placeholder="e.g., insufficient funds, invalid transaction reference…"
                          class="w-full px-4 py-2.5 border border-border rounded-xl text-sm bg-cream/40 focus:outline-none focus:ring-2 transition resize-none" style="focus:border-color:#c0392b"></textarea>
            </div>
        </div>
        <div class="px-8 py-5 border-t border-border flex justify-end gap-3">
            <button onclick="closeFailModal()" class="px-5 py-2.5 border border-border text-muted text-sm font-semibold rounded-xl hover:bg-sand transition-all">Cancel</button>
            <button onclick="failGiving()" class="px-6 py-2.5 text-white text-sm font-semibold rounded-xl bg-secondary hover:bg-red-700 transition-all">Mark as Failed</button>
        </div>
    </div>
</div>

<style>
@keyframes modalIn {
    from { opacity:0; transform:scale(0.96) translateY(8px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
}
/* Timeline */
.timeline-item { position: relative; }
.timeline-item:not(:last-child)::after {
    content: ''; position: absolute;
    left: 5px; top: 20px; bottom: -16px;
    width: 2px; background: #e2d9cc;
}
/* Scrollbar */
#modal-content::-webkit-scrollbar { width: 5px; }
#modal-content::-webkit-scrollbar-thumb { background: #e2d9cc; border-radius: 9999px; }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let currentGivingId = null;

/* ── helpers ── */
function openOverlay(id) {
    const el = document.getElementById(id);
    el.style.display = 'flex';
    el.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeOverlay(id) {
    const el = document.getElementById(id);
    el.style.display = 'none';
    el.classList.add('hidden');
    document.body.style.overflow = '';
}

/* ── data ── */
document.addEventListener('DOMContentLoaded', refreshData);

function refreshData() {
    const btn  = document.getElementById('refresh-btn');
    const icon = document.getElementById('refresh-icon');
    btn.disabled = true;
    icon.style.transform = 'rotate(360deg)';

    ['total-month','pending-count','tithes-month','transaction-count'].forEach(id => {
        document.getElementById(id).innerHTML = '<span class="text-muted text-sm font-normal animate-pulse">Loading…</span>';
    });

    fetch('{{ route("admin.givings.dashboard-summary") }}')
        .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
        .then(data => {
            if (!data.success) throw new Error(data.message || 'Server error');
            document.getElementById('total-month').textContent      = new Intl.NumberFormat().format(data.summary.total_amount) + ' UGX';
            document.getElementById('pending-count').textContent    = data.summary.pending_count || '0';
            document.getElementById('tithes-month').textContent     = new Intl.NumberFormat().format(data.summary.total_tithes) + ' UGX';
            document.getElementById('transaction-count').textContent = data.summary.transaction_count || '0';
            document.getElementById('last-updated').textContent     = 'Updated ' + new Date().toLocaleTimeString();
        })
        .catch(err => {
            ['total-month','pending-count','tithes-month','transaction-count'].forEach(id => {
                document.getElementById(id).innerHTML = '<span class="text-secondary text-sm font-normal">Error</span>';
            });
            showAlert('error', 'Failed to load data: ' + err.message);
        })
        .finally(() => {
            btn.disabled = false;
            setTimeout(() => { icon.style.transform = ''; }, 600);
        });
}

/* ── confirm modal ── */
function showConfirmModal(id, name, amount, currency) {
    currentGivingId = id;
    document.getElementById('confirm-details').innerHTML = `
        <div class="flex items-start gap-3 p-4 rounded-xl border" style="background:rgba(26,122,74,0.07);border-color:rgba(26,122,74,0.2)">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="#1a7a4a" stroke-width="2"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="text-sm" style="color:#1a7a4a">
                <p class="font-bold mb-1">Confirming giving for <strong>${name}</strong></p>
                <p>Amount: <strong>${new Intl.NumberFormat().format(amount)} ${currency}</strong></p>
            </div>
        </div>`;
    document.getElementById('verified_amount').value = '';
    document.getElementById('confirm_notes').value = '';
    openOverlay('confirm-modal');
}
function closeConfirmModal() { closeOverlay('confirm-modal'); currentGivingId = null; }

function confirmGiving() {
    if (!currentGivingId) return;
    const payload = { notes: document.getElementById('confirm_notes').value };
    const va = document.getElementById('verified_amount').value;
    if (va) payload.verified_amount = parseFloat(va);

    fetch(`/admin/givings/${currentGivingId}/confirm`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf() },
        body: JSON.stringify(payload)
    }).then(r => r.json()).then(data => {
        if (data.success) { showAlert('success', data.message); closeConfirmModal(); setTimeout(() => location.reload(), 1500); }
        else showAlert('error', data.message || 'Error confirming giving');
    }).catch(() => showAlert('error', 'An error occurred.'));
}

/* ── fail modal ── */
function showFailModal(id, name) {
    currentGivingId = id;
    document.getElementById('fail-details').innerHTML = `
        <div class="flex items-start gap-3 p-4 rounded-xl border" style="background:rgba(192,57,43,0.07);border-color:rgba(192,57,43,0.2)">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="#c0392b" stroke-width="2"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div class="text-sm" style="color:#c0392b">
                <p class="font-bold mb-1">Marking giving from <strong>${name}</strong> as failed</p>
                <p class="opacity-75">This action cannot be undone.</p>
            </div>
        </div>`;
    document.getElementById('failure_reason').value = '';
    openOverlay('fail-modal');
}
function closeFailModal() { closeOverlay('fail-modal'); currentGivingId = null; }

function failGiving() {
    if (!currentGivingId) return;
    const reason = document.getElementById('failure_reason').value.trim();
    if (!reason) { showAlert('error', 'Please provide a failure reason.'); return; }

    fetch(`/admin/givings/${currentGivingId}/fail`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf() },
        body: JSON.stringify({ failure_reason: reason })
    }).then(r => r.json()).then(data => {
        if (data.success) { showAlert('success', data.message); closeFailModal(); setTimeout(() => location.reload(), 1500); }
        else showAlert('error', data.message || 'Error marking as failed');
    }).catch(() => showAlert('error', 'An error occurred.'));
}

/* ── resend receipt ── */
function resendReceipt(id, email) {
    if (!confirm(`Resend receipt to ${email}?`)) return;
    fetch(`/admin/givings/${id}/resend-receipt`, {
        method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf() }
    }).then(r => r.json()).then(data => showAlert(data.success ? 'success' : 'error', data.message))
      .catch(() => showAlert('error', 'An error occurred.'));
}

/* ── export ── */
function exportCsv() {
    const params = new URLSearchParams();
    ['status','giving_type','payment_method','start_date'].forEach(k => {
        const el = document.getElementById(k); if (el && el.value) params.append(k, el.value);
    });
    const a = document.createElement('a');
    a.href = `/admin/givings/export-csv?${params}`;
    a.click();
    showAlert('success', 'CSV export started.');
}

/* ── view details ── */
function viewDetails(id) {
    openOverlay('giving-modal');
    document.getElementById('modal-content').innerHTML = `
        <div class="flex justify-center items-center py-16">
            <div class="w-8 h-8 border-2 rounded-full animate-spin border-accent border-t-transparent"></div>
            <span class="ml-3 text-muted text-sm">Loading details…</span>
        </div>`;

    fetch(`/admin/givings/${id}`, { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf() } })
        .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
        .then(data => { if (data.success) displayGivingDetails(data); else throw new Error(data.message); })
        .catch(err => {
            document.getElementById('modal-content').innerHTML = `
                <div class="text-center py-12">
                    <div class="w-14 h-14 rounded-2xl mx-auto mb-4 flex items-center justify-center" style="background:rgba(192,57,43,0.1)">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="#c0392b" stroke-width="1.5"><path d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                    </div>
                    <p class="font-bold text-primary mb-1">Failed to load details</p>
                    <p class="text-muted text-sm mb-5">${err.message}</p>
                    <button onclick="viewDetails(${id})" class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl mr-2">Try Again</button>
                    <button onclick="closeModal()" class="px-5 py-2.5 border border-border text-muted text-sm font-semibold rounded-xl">Close</button>
                </div>`;
        });
}

function displayGivingDetails(data) {
    const g = data.giving, history = data.history, fs = data.financial_summary, gi = data.giver_info;

    const statusStyle = {
        completed: 'background:rgba(26,122,74,0.1);color:#1a7a4a',
        pending:   'background:rgba(200,151,58,0.12);color:#9a6f1e',
        failed:    'background:rgba(192,57,43,0.1);color:#c0392b',
    }[g.status] || 'background:rgba(107,112,128,0.1);color:#6b7080';

    document.getElementById('modal-content').innerHTML = `
    <div class="space-y-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-black text-primary">Giving #${g.id}</h2>
                <p class="text-muted text-sm mt-0.5">${g.receipt_number || 'No receipt number'}</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="${statusStyle}">
                    ${g.status.charAt(0).toUpperCase() + g.status.slice(1)}
                </span>
                <p class="text-muted text-xs mt-1.5">Created: ${formatDateTime(g.created_at)}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="p-5 rounded-xl border border-border bg-sand/40">
                <h3 class="text-xs font-bold text-muted uppercase tracking-widest mb-3">Giver Information</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-muted">Name</span><span class="font-semibold text-primary">${gi.name}</span></div>
                    <div class="flex justify-between"><span class="text-muted">Type</span><span class="font-semibold text-primary">${gi.type}</span></div>
                    ${gi.email ? `<div class="flex justify-between"><span class="text-muted">Email</span><span class="font-medium text-primary">${gi.email}</span></div>` : ''}
                    ${gi.phone ? `<div class="flex justify-between"><span class="text-muted">Phone</span><span class="font-medium text-primary">${gi.phone}</span></div>` : ''}
                </div>
            </div>
            <div class="p-5 rounded-xl border" style="background:rgba(26,122,74,0.05);border-color:rgba(26,122,74,0.2)">
                <h3 class="text-xs font-bold text-muted uppercase tracking-widest mb-3">Financial Summary</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-muted">Gross Amount</span><span class="font-black text-lg" style="color:#1a7a4a">${formatCurrency(fs.gross_amount, fs.currency)}</span></div>
                    ${fs.processing_fee > 0 ? `
                        <div class="flex justify-between"><span class="text-muted">Processing Fee</span><span class="font-medium text-secondary">−${formatCurrency(fs.processing_fee, fs.currency)}</span></div>
                        <div class="pt-2 border-t border-border/60 flex justify-between"><span class="text-muted font-semibold">Net Amount</span><span class="font-black" style="color:#1a7a4a">${formatCurrency(fs.net_amount, fs.currency)}</span></div>
                    ` : ''}
                </div>
            </div>
        </div>

        <div class="p-5 rounded-xl border border-border">
            <h3 class="text-xs font-bold text-muted uppercase tracking-widest mb-3">Giving Details</h3>
            <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm">
                <div class="flex justify-between"><span class="text-muted">Type</span><span class="font-semibold text-primary">${g.giving_type.replace('_',' ').replace(/\b\w/g,l=>l.toUpperCase())}</span></div>
                <div class="flex justify-between"><span class="text-muted">Method</span><span class="font-semibold text-primary">${g.payment_method.replace('_',' ').replace(/\b\w/g,l=>l.toUpperCase())}</span></div>
                ${g.payment_provider ? `<div class="flex justify-between"><span class="text-muted">Provider</span><span class="font-medium text-primary">${g.payment_provider}</span></div>` : ''}
                ${g.transaction_reference ? `<div class="flex justify-between col-span-2"><span class="text-muted">Reference</span><span class="font-mono text-xs text-primary">${g.transaction_reference}</span></div>` : ''}
                ${g.purpose ? `<div class="flex justify-between"><span class="text-muted">Purpose</span><span class="font-medium text-primary">${g.purpose}</span></div>` : ''}
                <div class="flex justify-between"><span class="text-muted">Receipt Sent</span><span class="font-semibold" style="color:${g.receipt_sent ? '#1a7a4a' : '#6b7080'}">${g.receipt_sent ? 'Yes' : 'No'}</span></div>
            </div>
            ${g.notes ? `<div class="mt-4 pt-4 border-t border-border/60"><p class="text-xs font-bold text-muted uppercase tracking-widest mb-2">Notes</p><p class="text-sm text-primary/80 whitespace-pre-line">${g.notes}</p></div>` : ''}
        </div>

        <div class="p-5 rounded-xl border border-border">
            <h3 class="text-xs font-bold text-muted uppercase tracking-widest mb-4">Transaction History</h3>
            <div class="space-y-4">
                ${history.map((item, i) => `
                    <div class="timeline-item flex items-start gap-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-accent mt-1.5 flex-shrink-0 relative z-10"></div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <p class="font-semibold text-primary text-sm">${item.action}</p>
                                    <p class="text-muted text-xs mt-0.5">${item.description}</p>
                                    ${item.user ? `<p class="text-xs mt-0.5" style="color:#c8973a">by ${item.user}</p>` : ''}
                                </div>
                                <p class="text-muted text-xs flex-shrink-0">${formatDateTime(item.timestamp)}</p>
                            </div>
                            ${Object.keys(item.details).length > 0 ? `
                                <div class="mt-2 p-2.5 rounded-lg text-xs space-y-1 bg-sand/60 border border-border/60">
                                    ${Object.entries(item.details).map(([k,v]) => `<div class="flex justify-between"><span class="text-muted">${k.replace('_',' ')}</span><span class="font-medium text-primary">${v}</span></div>`).join('')}
                                </div>` : ''}
                        </div>
                    </div>`).join('')}
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-2 border-t border-border">
            ${g.status === 'completed' && g.giver_email ? `
                <button onclick="resendReceipt(${g.id}, '${g.giver_email}')" class="inline-flex items-center gap-2 px-5 py-2.5 border border-border text-muted text-sm font-semibold rounded-xl hover:border-accent/40 hover:text-primary transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Resend Receipt
                </button>` : ''}
            <button onclick="closeModal()" class="px-5 py-2.5 bg-primary hover:bg-primary-light text-white text-sm font-semibold rounded-xl transition-all">Close</button>
        </div>
    </div>`;
}

function closeModal() { closeOverlay('giving-modal'); }

/* ── outside click ── */
['giving-modal','confirm-modal','fail-modal'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) { if (e.target === this) closeOverlay(id); });
});

/* ── esc key ── */
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') ['giving-modal','confirm-modal','fail-modal'].forEach(id => closeOverlay(id));
});

/* ── utils ── */
function csrf() { return document.querySelector('meta[name="csrf-token"]').content; }
function formatDateTime(s) { return new Date(s).toLocaleString('en-US',{year:'numeric',month:'short',day:'numeric',hour:'2-digit',minute:'2-digit'}); }
function formatCurrency(n, c) { return new Intl.NumberFormat().format(n) + ' ' + c; }

function showAlert(type, message) {
    const el = document.createElement('div');
    const isSuccess = type === 'success';
    el.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;max-width:360px;padding:14px 18px;border-radius:14px;display:flex;align-items:center;gap:10px;font-family:Jost,sans-serif;font-size:14px;font-weight:600;box-shadow:0 10px 25px rgba(0,0,0,0.12);transform:translateX(120%);transition:transform 0.3s ease;';
    el.style.background = isSuccess ? 'rgba(26,122,74,0.95)' : 'rgba(192,57,43,0.95)';
    el.style.color = '#fff';
    el.innerHTML = `<svg style="width:18px;height:18px;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        ${isSuccess ? '<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>' : '<path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>'}
    </svg><span style="flex:1">${message}</span>
    <button onclick="this.parentElement.remove()" style="background:none;border:none;color:rgba(255,255,255,0.7);cursor:pointer;padding:0;margin-left:4px">
        <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12"/></svg>
    </button>`;
    document.body.appendChild(el);
    setTimeout(() => el.style.transform = 'translateX(0)', 10);
    setTimeout(() => { el.style.transform = 'translateX(120%)'; setTimeout(() => el.remove(), 300); }, 5000);
}
</script>
@endsection