@extends('layouts.dashboard_layout')

@section('title', 'Newsletter Subscribers')
@section('header_title', 'Newsletter Subscribers')

@section('content')
<div class="space-y-6">

    {{-- ── Page Header ── --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-primary">Newsletter Subscribers</h1>
            <p class="text-muted text-sm mt-1">Manage newsletter subscriptions and track subscriber engagement</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.location.reload()" 
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-border text-muted text-sm font-semibold rounded-xl hover:border-accent/40 hover:text-primary transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Refresh
            </button>
            <a href="{{ route('admin.subscribers.export') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-border text-muted text-sm font-semibold rounded-xl hover:border-accent/40 hover:text-primary transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export CSV
            </a>
            <button onclick="document.getElementById('addSubscriberModal').classList.remove('hidden')"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-light text-white text-sm font-semibold rounded-xl shadow-card transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card-hover">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 4v16m8-8H4"/></svg>
                Add Subscriber
            </button>
        </div>
    </div>

    {{-- ── KPI Cards ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        {{-- Total Subscribers --}}
        <div class="bg-white rounded-2xl border border-border shadow-card p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover relative overflow-hidden group">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-primary to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(12,27,58,0.07)">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="#0c1b3a" stroke-width="1.8"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2 py-0.5 rounded-full" style="background:rgba(12,27,58,0.07);color:#0c1b3a">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary inline-block"></span>Active
                </span>
            </div>
            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-1">Total Subscribers</p>
            <p class="text-2xl font-black text-primary">{{ $subscriberCount ?? 0 }}</p>
            <p class="text-xs text-muted mt-2">Active newsletter subscribers</p>
        </div>

        {{-- Members --}}
        <div class="bg-white rounded-2xl border border-border shadow-card p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover relative overflow-hidden group">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-accent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(200,151,58,0.1)">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="#c8973a" stroke-width="1.8"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <span class="text-xs font-semibold text-muted">Registered</span>
            </div>
            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-1">Members</p>
            <p class="text-2xl font-black text-primary">{{ $memberCount ?? 0 }}</p>
            <p class="text-xs text-muted mt-2">Church members subscribed</p>
        </div>

        {{-- Visitors --}}
        <div class="bg-white rounded-2xl border border-border shadow-card p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover relative overflow-hidden group">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-secondary to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(220,38,38,0.08)">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="1.8"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <span class="text-xs font-semibold text-muted">Guest</span>
            </div>
            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-1">Visitors</p>
            <p class="text-2xl font-black text-primary">{{ $visitorCount ?? 0 }}</p>
            <p class="text-xs text-muted mt-2">Non-member subscribers</p>
        </div>

    </div>

    {{-- ── Search & Filter Bar ── --}}
    <div class="bg-white rounded-2xl border border-border shadow-card p-5">
        <form method="GET" action="{{ route('admin.subscribers.index') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Search by email address..." 
                    class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-border-hover"
                />
            </div>
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-light text-white text-sm font-semibold rounded-xl transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.subscribers.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-border text-muted text-sm font-semibold rounded-xl hover:border-accent/40 hover:text-primary transition-all duration-200">
                    Clear
                </a>
            @endif
        </form>
    </div>

    {{-- ── Subscribers Table ── --}}
    <div class="bg-white rounded-2xl border border-border shadow-card overflow-hidden">
        
        {{-- Table Header --}}
        <div class="px-6 py-4 border-b border-border flex items-center justify-between">
            <h2 class="text-lg font-bold text-primary flex items-center gap-2">
                <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Subscribers List
                @if(isset($paginationData))
                    <span class="text-sm font-medium text-muted">({{ $paginationData['total'] }} {{ request('search') ? 'filtered' : 'total' }})</span>
                @endif
            </h2>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-border">
                <thead class="bg-background">
                    <tr>
                        <th class="px-5 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-wider border-r border-gray-100/50">
                            Email
                        </th>
                        <th class="px-5 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-wider border-r border-gray-100/50">
                            Type
                        </th>
                        <th class="px-5 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-wider border-r border-gray-100/50">
                            Status
                        </th>
                        <th class="px-5 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-wider border-r border-gray-100/50">
                            Subscribed Date
                        </th>
                        <th class="px-5 py-3.5 text-center text-xs font-bold text-muted uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-border">
                    @forelse($subscribers as $subscriber)
                        <tr class="hover:bg-background transition-colors duration-150">
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm border-r border-gray-100/50">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" style="background:rgba(12,27,58,0.07)">
                                        <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <span class="font-medium text-primary">{{ $subscriber['email'] ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm border-r border-gray-100/50">
                                @if(isset($subscriber['fields']['member_status']) && $subscriber['fields']['member_status'] === 'member')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Member
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Visitor
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm border-r border-gray-100/50">
                                @php
                                    $status = $subscriber['type'] ?? $subscriber['status'] ?? 'active';
                                @endphp
                                @if($status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium" style="background:rgba(26,122,74,0.1);color:#1a7a4a">
                                        <span class="w-1.5 h-1.5 rounded-full bg-success inline-block"></span>
                                        Active
                                    </span>
                                @elseif($status === 'unsubscribed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Unsubscribed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm text-muted border-r border-gray-100/50">
                                {{ isset($subscriber['date_subscribe']) ? \Carbon\Carbon::parse($subscriber['date_subscribe'])->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-center text-sm">
                                <form method="POST" action="{{ route('admin.subscribers.destroy', $subscriber['email'] ?? '') }}" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this subscriber?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors duration-150">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-muted/30 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <p class="text-muted font-medium">No subscribers found</p>
                                    @if(request('search'))
                                        <p class="text-sm text-muted/70 mt-1">Try adjusting your search criteria</p>
                                    @else
                                        <p class="text-sm text-muted/70 mt-1">Add your first subscriber to get started</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($paginationData) && $paginationData['last_page'] > 1)
            <div class="px-6 py-4 border-t border-border flex items-center justify-between">
                <div class="text-sm text-muted">
                    Showing <span class="font-medium text-primary">{{ $paginationData['from'] }}</span> to <span class="font-medium text-primary">{{ $paginationData['to'] }}</span> of <span class="font-medium text-primary">{{ $paginationData['total'] }}</span> results
                </div>
                <div class="flex items-center gap-2">
                    @if($paginationData['current_page'] > 1)
                        <a href="{{ route('admin.subscribers.index', array_merge(request()->query(), ['page' => $paginationData['current_page'] - 1])) }}" 
                           class="px-3 py-1.5 text-sm font-medium text-muted hover:text-primary hover:bg-background rounded-lg transition-colors duration-150">
                            Previous
                        </a>
                    @endif
                    
                    @for($i = max(1, $paginationData['current_page'] - 2); $i <= min($paginationData['last_page'], $paginationData['current_page'] + 2); $i++)
                        <a href="{{ route('admin.subscribers.index', array_merge(request()->query(), ['page' => $i])) }}" 
                           class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ $i == $paginationData['current_page'] ? 'bg-primary text-white' : 'text-muted hover:text-primary hover:bg-background' }}">
                            {{ $i }}
                        </a>
                    @endfor
                    
                    @if($paginationData['current_page'] < $paginationData['last_page'])
                        <a href="{{ route('admin.subscribers.index', array_merge(request()->query(), ['page' => $paginationData['current_page'] + 1])) }}" 
                           class="px-3 py-1.5 text-sm font-medium text-muted hover:text-primary hover:bg-background rounded-lg transition-colors duration-150">
                            Next
                        </a>
                    @endif
                </div>
            </div>
        @endif

    </div>

</div>

{{-- Add Subscriber Modal --}}
<div id="addSubscriberModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl">
        <div class="px-6 py-4 border-b border-border flex items-center justify-between">
            <h3 class="text-lg font-bold text-primary">Add New Subscriber</h3>
            <button onclick="document.getElementById('addSubscriberModal').classList.add('hidden')" class="text-muted hover:text-primary transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.subscribers.store') }}" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-primary mb-2">Email Address *</label>
                <input type="email" name="email" required
                       class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/10"
                       placeholder="subscriber@example.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-primary mb-2">Name (Optional)</label>
                <input type="text" name="name"
                       class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/10"
                       placeholder="John Doe">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('addSubscriberModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 border border-border text-muted font-medium rounded-xl hover:bg-background transition-colors duration-150">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-primary hover:bg-primary-light text-white font-semibold rounded-xl transition-colors duration-150">
                    Add Subscriber
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-slide-up">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-slide-up">
        {{ session('error') }}
    </div>
@endif

@endsection
