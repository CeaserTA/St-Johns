@extends('layouts.dashboard_layout')

@section('title', 'Groups Management')
@section('header_title', 'Groups Management')

@section('content')
<div class="space-y-6">

    {{-- ── Page Header ── --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-primary">Groups Management</h1>
            <p class="text-muted text-sm mt-1">Oversee church groups, memberships and approvals</p>
        </div>
        <button id="addGroupBtn"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-light text-white text-sm font-semibold rounded-xl shadow-card transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card-hover">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 4v16m8-8H4"/></svg>
            Add Group
        </button>
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
        <div class="flex items-start gap-3 bg-success/8 border border-success/25 text-success px-5 py-4 rounded-2xl" style="background:rgba(26,122,74,0.07)">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div><p class="font-semibold text-sm">Success</p><p class="text-sm opacity-80">{{ session('success') }}</p></div>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-start gap-3 border border-secondary/25 px-5 py-4 rounded-2xl" style="background:rgba(192,57,43,0.07);color:#c0392b">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div><p class="font-semibold text-sm">Error</p><p class="text-sm opacity-80">{{ session('error') }}</p></div>
        </div>
    @endif

    @if($errors->any())
        <div class="flex items-start gap-3 border border-secondary/25 px-5 py-4 rounded-2xl" style="background:rgba(192,57,43,0.07);color:#c0392b">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div>
                <p class="font-semibold text-sm">Please fix the following errors</p>
                <ul class="mt-1 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li class="text-sm opacity-80">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- ── KPI Summary Cards ── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="bg-white rounded-2xl border border-border shadow-card p-6 flex items-center gap-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover group">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors" style="background:rgba(12,27,58,0.08)">
                <svg class="w-7 h-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m0-4a4 4 0 110-8 4 4 0 010 8z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-muted uppercase tracking-widest">Total Groups</p>
                <p class="text-4xl font-black text-primary mt-0.5">{{ $stats['total_groups'] ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-border shadow-card p-6 flex items-center gap-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover group">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(26,122,74,0.09)">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="#1a7a4a" stroke-width="1.8">
                    <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-muted uppercase tracking-widest">Total Members</p>
                <p class="text-4xl font-black text-primary mt-0.5">{{ $stats['total_members_in_groups'] ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-border shadow-card p-6 flex items-center gap-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover group">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(200,151,58,0.1)">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="#c8973a" stroke-width="1.8">
                    <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-muted uppercase tracking-widest">Avg. Group Size</p>
                <p class="text-4xl font-black text-primary mt-0.5">{{ round($stats['average_group_size'] ?? 0, 1) }}</p>
            </div>
        </div>

    </div>

    {{-- ── Search & Filter Bar ── --}}
    <div class="bg-white rounded-2xl border border-border shadow-card p-5">
        <form method="GET" action="{{ route('admin.groups') }}">
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label for="search" class="block text-xs font-semibold text-muted uppercase tracking-widest mb-2">Search Groups</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Search by name, description, location or day…"
                               class="w-full pl-10 pr-4 py-2.5 border border-border rounded-xl text-sm bg-cream/50 focus:outline-none focus:ring-2 focus:border-accent transition"
                               style="focus:ring-color:rgba(200,151,58,0.2)">
                    </div>
                </div>
                <div class="w-52">
                    <label for="meeting_day" class="block text-xs font-semibold text-muted uppercase tracking-widest mb-2">Meeting Day</label>
                    <select name="meeting_day" id="meeting_day"
                            class="w-full px-4 py-2.5 border border-border rounded-xl text-sm bg-cream/50 focus:outline-none focus:ring-2 transition">
                        <option value="all">All Days</option>
                        @foreach($filterOptions['meeting_days'] as $day)
                            <option value="{{ $day }}" {{ request('meeting_day') == $day ? 'selected' : '' }}>{{ ucfirst($day) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-light transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        Search
                    </button>
                    <a href="{{ route('admin.groups') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-sand border border-border text-muted text-sm font-semibold rounded-xl hover:border-accent/40 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($groups->count() > 0)

        {{-- ── Live Search + Status Filter ── --}}
        <div class="flex flex-col sm:flex-row gap-4 items-center">
            <div class="relative flex-1">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" id="searchGroups" placeholder="Live filter groups by name…"
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:border-accent transition">
            </div>
            <select id="statusFilter"
                    class="w-48 px-4 py-2.5 bg-white border border-border rounded-xl text-sm focus:outline-none focus:ring-2 transition">
                <option value="all">All Status</option>
                <option value="active">Active Only</option>
                <option value="inactive">Inactive Only</option>
            </select>
        </div>

        {{-- ── Groups Table ── --}}
        <div class="bg-white rounded-2xl border border-border shadow-card overflow-hidden">
            <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                <h2 class="text-lg font-bold text-primary">All Groups</h2>
                <span class="text-xs text-muted font-medium">{{ $groups->count() }} group{{ $groups->count() !== 1 ? 's' : '' }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr style="background:#fdf8f0">
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Group</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Description</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Meeting Info</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Members</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Status</th>
                            <th class="px-6 py-3.5 text-right text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/60">
                        @foreach($groups as $group)
                            <tr class="group-row hover:bg-cream/40 transition-colors duration-150"
                                data-group-name="{{ strtolower($group->name) }}"
                                data-status="{{ $group->is_active ? 'active' : 'inactive' }}">

                                {{-- Group name + icon --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($group->image_url)
                                            <img src="{{ $group->image_url }}" alt="{{ $group->name }}"
                                                 class="w-11 h-11 rounded-xl object-cover border border-border">
                                        @elseif($group->icon)
                                            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(12,27,58,0.07)">
                                                <span class="material-symbols-outlined text-primary text-xl">{{ $group->icon }}</span>
                                            </div>
                                        @else
                                            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 bg-sand border border-border">
                                                <span class="material-symbols-outlined text-muted text-xl">group</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-primary text-sm">{{ $group->name }}</div>
                                            @if($group->category)
                                                <span class="inline-block mt-0.5 text-xs font-medium px-2 py-0.5 rounded-full" style="background:rgba(200,151,58,0.1);color:#9a6f1e">{{ $group->category }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Description --}}
                                <td class="px-6 py-4 max-w-xs">
                                    <p class="text-sm text-muted leading-snug">{{ Str::limit($group->description, 80) ?: '—' }}</p>
                                </td>

                                {{-- Meeting info --}}
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        @if($group->meeting_day)
                                            <div class="flex items-center gap-1.5 text-sm text-primary/70">
                                                <svg class="w-3.5 h-3.5 text-accent flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                                {{ $group->meeting_day }}
                                            </div>
                                        @endif
                                        @if($group->location)
                                            <div class="flex items-center gap-1.5 text-sm text-primary/70">
                                                <svg class="w-3.5 h-3.5 text-accent flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                {{ $group->location }}
                                            </div>
                                        @endif
                                        @if(!$group->meeting_day && !$group->location)
                                            <span class="text-muted text-sm">—</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Members count button --}}
                                <td class="px-6 py-4">
                                    <button class="toggle-members-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold text-primary hover:bg-sand border border-border transition-all duration-150"
                                            data-group-id="{{ $group->id }}">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $group->members->count() }}
                                    </button>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if($group->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(26,122,74,0.1);color:#1a7a4a">
                                            <span class="w-1.5 h-1.5 rounded-full bg-success inline-block"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sand text-muted">
                                            <span class="w-1.5 h-1.5 rounded-full bg-muted inline-block"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button class="edit-group-btn inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg border border-border hover:border-accent/40 hover:bg-sand transition-all duration-150 text-primary"
                                                data-id="{{ $group->id }}"
                                                data-name="{{ $group->name }}"
                                                data-description="{{ $group->description }}"
                                                data-meeting-day="{{ $group->meeting_day }}"
                                                data-location="{{ $group->location }}"
                                                data-is-active="{{ $group->is_active ? '1' : '0' }}"
                                                data-sort-order="{{ $group->sort_order }}"
                                                data-icon="{{ $group->icon }}"
                                                data-image-url="{{ $group->image_url }}"
                                                data-category="{{ $group->category }}"
                                                title="Edit">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.groups.destroy', $group->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Delete {{ $group->name }}? This will remove all member associations.')"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg border border-secondary/20 hover:bg-secondary/8 text-secondary transition-all duration-150"
                                                    style="hover:background:rgba(192,57,43,0.08)"
                                                    title="Delete">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── Group Members Section ── --}}
        <div class="bg-white rounded-2xl border border-border shadow-card overflow-hidden">
            <div class="px-6 py-5 border-b border-border">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-primary">Group Members</h2>
                        <p class="text-sm text-muted mt-0.5">Manage and approve group memberships</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <select id="groupFilter"
                                class="border border-border rounded-xl px-4 py-2 text-sm bg-cream/50 focus:outline-none focus:ring-2 transition">
                            <option value="">All Groups</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        <select id="memberStatusFilter"
                                class="border border-border rounded-xl px-4 py-2 text-sm bg-cream/50 focus:outline-none focus:ring-2 transition">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr style="background:#fdf8f0">
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Member</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Group</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Contact</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Status</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Joined</th>
                            <th class="px-6 py-3.5 text-right text-xs font-bold text-muted uppercase tracking-widest border-b border-border">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/60" id="groupMembersTableBody">
                        @php
                            $allGroupMembers = [];
                            foreach($groups as $group) {
                                foreach($group->members as $member) {
                                    $allGroupMembers[] = ['member' => $member, 'group' => $group, 'status' => $member->pivot->status, 'joined_at' => $member->pivot->created_at];
                                }
                            }
                        @endphp

                        @forelse($allGroupMembers as $item)
                            <tr class="group-member-row hover:bg-cream/40 transition-colors duration-150"
                                data-group-id="{{ $item['group']->id }}"
                                data-status="{{ $item['status'] }}">

                                {{-- Member --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($item['member']->profile_image_url)
                                            <img src="{{ $item['member']->profile_image_url }}" alt="{{ $item['member']->full_name }}"
                                                 class="w-10 h-10 rounded-full object-cover border-2 border-border">
                                        @else
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-sm text-primary" style="background:rgba(12,27,58,0.08)">
                                                {{ strtoupper(substr($item['member']->full_name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-primary text-sm">{{ $item['member']->full_name }}</div>
                                            <div class="text-xs text-muted">ID: {{ $item['member']->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Group --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if($item['group']->icon)
                                            <span class="material-symbols-outlined text-accent text-sm">{{ $item['group']->icon }}</span>
                                        @endif
                                        <span class="text-sm font-medium text-primary">{{ $item['group']->name }}</span>
                                    </div>
                                </td>

                                {{-- Contact --}}
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        @if($item['member']->email)
                                            <div class="flex items-center gap-1.5 text-sm text-muted">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                                {{ $item['member']->email }}
                                            </div>
                                        @endif
                                        @if($item['member']->phone)
                                            <div class="flex items-center gap-1.5 text-sm text-muted">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                                {{ $item['member']->phone }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                {{-- Status badge --}}
                                <td class="px-6 py-4">
                                    @if($item['status'] === 'approved')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(26,122,74,0.1);color:#1a7a4a">
                                            <span class="w-1.5 h-1.5 rounded-full bg-success"></span>Approved
                                        </span>
                                    @elseif($item['status'] === 'rejected')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(192,57,43,0.1);color:#c0392b">
                                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(200,151,58,0.12);color:#9a6f1e">
                                            <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>Pending
                                        </span>
                                    @endif
                                </td>

                                {{-- Joined --}}
                                <td class="px-6 py-4 text-sm text-muted">{{ $item['joined_at']->format('M d, Y') }}</td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($item['status'] === 'pending')
                                            <form method="POST" action="{{ route('admin.groups.members.approve', [$item['group']->id, $item['member']->id]) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg text-white transition-all duration-150"
                                                        style="background:#1a7a4a"
                                                        onmouseover="this.style.background='#155f39'" onmouseout="this.style.background='#1a7a4a'">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M5 13l4 4L19 7"/></svg>
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.groups.members.reject', [$item['group']->id, $item['member']->id]) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        onclick="return confirm('Reject {{ $item['member']->full_name }} from {{ $item['group']->name }}?')"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg text-white bg-secondary hover:bg-red-700 transition-all duration-150">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                                    Reject
                                                </button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.groups.members.destroy', [$item['group']->id, $item['member']->id]) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Remove {{ $item['member']->full_name }} from {{ $item['group']->name }}?')"
                                                    class="p-2 rounded-lg text-secondary hover:bg-secondary/10 border border-secondary/20 transition-all duration-150"
                                                    title="Remove from group">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center bg-sand border border-border">
                                        <svg class="w-8 h-8 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <p class="font-semibold text-primary">No group members found</p>
                                    <p class="text-muted text-sm mt-1">Members will appear here once they join a group</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @else
        {{-- ── Empty State ── --}}
        <div class="bg-white rounded-2xl border border-border shadow-card p-16 text-center">
            <div class="w-20 h-20 rounded-2xl mx-auto mb-5 flex items-center justify-center" style="background:rgba(12,27,58,0.06)">
                <svg class="w-10 h-10 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m0-4a4 4 0 110-8 4 4 0 010 8z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-primary mb-2">No Groups Yet</h3>
            <p class="text-muted mb-6 text-sm">Get started by creating your first church group</p>
            <button id="addGroupBtnEmpty"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-light text-white font-semibold rounded-xl shadow-card hover:shadow-card-hover transition-all duration-200 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 4v16m8-8H4"/></svg>
                Add First Group
            </button>
        </div>
    @endif

</div>

{{-- ══════════════════════════════════════════════
     Add / Edit Group Modal
══════════════════════════════════════════════ --}}
<div id="groupModal" class="fixed inset-0 bg-primary/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto flex flex-col" style="animation:modalIn 0.25s ease">
        <div class="px-8 py-6 border-b border-border flex items-center justify-between sticky top-0 bg-white z-10 rounded-t-2xl">
            <h3 id="modalTitle" class="text-xl font-black text-primary">Add Group</h3>
            <button id="cancelBtn" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-sand text-muted hover:text-primary transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="groupForm" method="POST" action="{{ route('admin.groups.store') }}" enctype="multipart/form-data" class="flex-1">
            @csrf
            <input type="hidden" id="groupId" name="group_id">
            <input type="hidden" id="formMethod" name="_method" value="POST">

            <div class="px-8 py-6 space-y-5">

                <div>
                    <label class="block text-xs font-bold text-muted uppercase tracking-widest mb-2">Group Name <span class="text-secondary">*</span></label>
                    <input type="text" name="name" id="groupName" required
                           class="w-full border border-border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-accent bg-cream/30 text-primary transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-muted uppercase tracking-widest mb-2">Description</label>
                    <textarea name="description" id="groupDescription" rows="3"
                              class="w-full border border-border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-accent bg-cream/30 text-primary transition resize-none"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-muted uppercase tracking-widest mb-2">Meeting Day</label>
                        <input type="text" name="meeting_day" id="groupMeetingDay" placeholder="e.g., Every Sunday"
                               class="w-full border border-border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-accent bg-cream/30 text-primary transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-muted uppercase tracking-widest mb-2">Location</label>
                        <input type="text" name="location" id="groupLocation" placeholder="e.g., Main Hall"
                               class="w-full border border-border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-accent bg-cream/30 text-primary transition">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-muted uppercase tracking-widest mb-2">Category</label>
                        <input type="text" name="category" id="groupCategory" placeholder="e.g., Fellowship, Ministry"
                               class="w-full border border-border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-accent bg-cream/30 text-primary transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-muted uppercase tracking-widest mb-2">Sort Order</label>
                        <input type="number" name="sort_order" id="groupSortOrder" min="0" value="0"
                               class="w-full border border-border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-accent bg-cream/30 text-primary transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-muted uppercase tracking-widest mb-2">Icon (Material Symbol)</label>
                    <input type="text" name="icon" id="groupIcon" placeholder="e.g., group, church, volunteer_activism"
                           class="w-full border border-border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-accent bg-cream/30 text-primary transition">
                    <p class="text-xs text-muted mt-1.5">Browse at <a href="https://fonts.google.com/icons" target="_blank" class="text-accent hover:underline">Google Material Symbols ↗</a></p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-muted uppercase tracking-widest mb-2">Group Image</label>
                    <div class="border-2 border-dashed border-border rounded-xl p-4 text-center hover:border-accent/40 transition-colors cursor-pointer">
                        <input type="file" name="image" id="groupImage" accept="image/*" class="hidden">
                        <label for="groupImage" class="cursor-pointer">
                            <svg class="w-8 h-8 text-muted mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm text-muted">Click to upload image <span class="text-xs">(optional)</span></p>
                        </label>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-4 bg-sand rounded-xl border border-border">
                    <div class="relative inline-flex items-center cursor-pointer" onclick="this.querySelector('input').click()">
                        <input type="checkbox" name="is_active" id="groupIsActive" value="1" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-border rounded-full peer peer-checked:bg-success transition-colors duration-200 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:after:translate-x-5"></div>
                    </div>
                    <div>
                        <label for="groupIsActive" class="text-sm font-semibold text-primary cursor-pointer">Group is Active</label>
                        <p class="text-xs text-muted">Active groups are visible to members</p>
                    </div>
                </div>

            </div>

            <div class="px-8 py-5 border-t border-border flex justify-end gap-3 sticky bottom-0 bg-white rounded-b-2xl">
                <button type="button" id="cancelBtn2"
                        class="px-5 py-2.5 border border-border text-muted text-sm font-semibold rounded-xl hover:bg-sand transition-all duration-150">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-2.5 bg-primary hover:bg-primary-light text-white text-sm font-semibold rounded-xl shadow-card transition-all duration-200 hover:-translate-y-0.5">
                    Save Group
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════════
     Members Modal
══════════════════════════════════════════════ --}}
<div id="membersModal" class="fixed inset-0 bg-primary/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto" style="animation:modalIn 0.25s ease">
        <div class="px-8 py-6 border-b border-border flex items-center justify-between sticky top-0 bg-white z-10 rounded-t-2xl">
            <h3 id="membersModalTitle" class="text-xl font-black text-primary">Group Members</h3>
            <button id="closeMembersModal" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-sand text-muted hover:text-primary transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-6">
            <div id="membersContent" class="space-y-3"></div>
        </div>
    </div>
</div>

<style>
@keyframes modalIn {
    from { opacity:0; transform:scale(0.96) translateY(8px); }
    to   { opacity:1; transform:scale(1)    translateY(0); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('groupModal');
    const membersModal = document.getElementById('membersModal');
    const form = document.getElementById('groupForm');
    const modalTitle = document.getElementById('modalTitle');

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Add group buttons
    ['addGroupBtn', 'addGroupBtnEmpty'].forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.addEventListener('click', () => {
            modalTitle.textContent = 'Add Group';
            form.action = '{{ route("admin.groups.store") }}';
            document.getElementById('formMethod').value = 'POST';
            form.reset();
            document.getElementById('groupId').value = '';
            document.getElementById('groupIsActive').checked = true;
            openModal();
        });
    });

    // Edit buttons
    document.querySelectorAll('.edit-group-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            modalTitle.textContent = 'Edit Group';
            form.action = `/admin/groups/${id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('groupId').value = id;
            document.getElementById('groupName').value = btn.dataset.name;
            document.getElementById('groupDescription').value = btn.dataset.description || '';
            document.getElementById('groupMeetingDay').value = btn.dataset.meetingDay || '';
            document.getElementById('groupLocation').value = btn.dataset.location || '';
            document.getElementById('groupCategory').value = btn.dataset.category || '';
            document.getElementById('groupSortOrder').value = btn.dataset.sortOrder || '0';
            document.getElementById('groupIcon').value = btn.dataset.icon || '';
            document.getElementById('groupIsActive').checked = btn.dataset.isActive === '1';
            openModal();
        });
    });

    // Cancel / close modal
    ['cancelBtn', 'cancelBtn2'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('click', closeModal);
    });
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });

    // Members modal
    document.querySelectorAll('.toggle-members-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const groupId = btn.dataset.groupId;
            const groupName = btn.closest('tr').querySelector('.font-semibold.text-primary').textContent.trim();
            document.getElementById('membersModalTitle').textContent = `${groupName} — Members`;

            const content = document.getElementById('membersContent');
            content.innerHTML = `<div class="text-center py-8 text-muted text-sm">Loading…</div>`;
            membersModal.classList.remove('hidden');
            membersModal.classList.add('flex');

            try {
                const response = await fetch(`/admin/groups/${groupId}/members`);
                const data = await response.json();

                if (data.members.length === 0) {
                    content.innerHTML = `<div class="text-center py-12 text-muted text-sm">No members in this group yet.</div>`;
                } else {
                    content.innerHTML = data.members.map(member => {
                        const initials = member.full_name.substring(0, 2).toUpperCase();
                        const avatarHtml = member.image_url
                            ? `<img src="${member.image_url}" class="w-11 h-11 rounded-full object-cover border-2 border-border">`
                            : `<div class="w-11 h-11 rounded-full flex items-center justify-center text-sm font-bold text-primary flex-shrink-0" style="background:rgba(12,27,58,0.08)">${initials}</div>`;

                        const statusHtml = member.status === 'approved'
                            ? `<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(26,122,74,0.1);color:#1a7a4a">Approved</span>`
                            : member.status === 'rejected'
                            ? `<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(192,57,43,0.1);color:#c0392b">Rejected</span>`
                            : `<span class="px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(200,151,58,0.12);color:#9a6f1e">Pending</span>`;

                        return `
                        <div class="flex items-center justify-between p-4 bg-sand/60 border border-border rounded-xl">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                ${avatarHtml}
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-primary text-sm">${member.full_name}</div>
                                    <div class="text-xs text-muted truncate">${member.email || 'No email'}</div>
                                </div>
                                ${statusHtml}
                            </div>
                            <div class="flex items-center gap-2 ml-4 flex-shrink-0">
                                ${member.status === 'pending' ? `
                                    <form method="POST" action="/admin/groups/${groupId}/members/${member.id}/approve" class="inline">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white rounded-lg" style="background:#1a7a4a">✓ Approve</button>
                                    </form>
                                    <form method="POST" action="/admin/groups/${groupId}/members/${member.id}/reject" class="inline">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white rounded-lg" style="background:#c0392b">✕ Reject</button>
                                    </form>
                                ` : ''}
                                <form method="POST" action="/admin/groups/${groupId}/members/${member.id}" class="inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" onclick="return confirm('Remove ${member.full_name} from this group?')"
                                            class="p-2 rounded-lg text-secondary border border-secondary/20 hover:bg-secondary/10 transition-colors" title="Remove">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>`;
                    }).join('');
                }
            } catch {
                content.innerHTML = `<div class="text-center py-8 text-secondary text-sm">Failed to load members.</div>`;
            }
        });
    });

    document.getElementById('closeMembersModal').addEventListener('click', () => {
        membersModal.classList.add('hidden');
        membersModal.classList.remove('flex');
    });
    membersModal.addEventListener('click', e => {
        if (e.target === membersModal) { membersModal.classList.add('hidden'); membersModal.classList.remove('flex'); }
    });

    // Live group search
    const searchInput = document.getElementById('searchGroups');
    const statusFilter = document.getElementById('statusFilter');
    function filterGroups() {
        const term = searchInput ? searchInput.value.toLowerCase() : '';
        const status = statusFilter ? statusFilter.value : 'all';
        document.querySelectorAll('.group-row').forEach(row => {
            const nameMatch = row.dataset.groupName.includes(term);
            const statusMatch = status === 'all' || row.dataset.status === status;
            row.style.display = nameMatch && statusMatch ? '' : 'none';
        });
    }
    if (searchInput) searchInput.addEventListener('input', filterGroups);
    if (statusFilter) statusFilter.addEventListener('change', filterGroups);

    // Members table filter
    const groupFilter = document.getElementById('groupFilter');
    const memberStatusFilter = document.getElementById('memberStatusFilter');
    function filterMembers() {
        const gId = groupFilter ? groupFilter.value : '';
        const st  = memberStatusFilter ? memberStatusFilter.value : '';
        document.querySelectorAll('.group-member-row').forEach(row => {
            const gMatch = !gId || row.dataset.groupId === gId;
            const sMatch = !st  || row.dataset.status   === st;
            row.style.display = gMatch && sMatch ? '' : 'none';
        });
    }
    if (groupFilter)       groupFilter.addEventListener('change', filterMembers);
    if (memberStatusFilter) memberStatusFilter.addEventListener('change', filterMembers);
});
</script>

@endsection