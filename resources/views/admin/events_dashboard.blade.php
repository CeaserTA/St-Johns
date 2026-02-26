@extends('layouts.dashboard_layout')

@section('title', 'Events & Announcements')
@section('header_title', 'Events & Announcements Manager')

@section('content')

    {{-- ═══════════════════════════════════════════════════
         KPI CARDS
    ═══════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-7">

        <div class="card-base card-hover group">
            <div class="h-1 bg-primary rounded-t-2xl"></div>
            <div class="p-5 flex items-start justify-between">
                <div>
                    <p class="card-muted uppercase tracking-widest font-semibold">Total Active</p>
                    <p class="card-number text-primary">{{ $stats['active'] ?? 0 }}</p>
                    <p class="card-muted mt-1.5">Live right now</p>
                </div>
                <div class="card-icon-container bg-primary/8 group-hover:bg-primary/15 mt-1 shrink-0">
                    <svg class="card-icon text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card-base card-hover group">
            <div class="h-1 bg-accent rounded-t-2xl"></div>
            <div class="p-5 flex items-start justify-between">
                <div>
                    <p class="card-muted uppercase tracking-widest font-semibold">Upcoming Events</p>
                    <p class="card-number text-accent">{{ $stats['upcoming'] ?? 0 }}</p>
                    <p class="card-muted mt-1.5">Scheduled ahead</p>
                </div>
                <div class="card-icon-container bg-accent/10 group-hover:bg-accent/20 mt-1 shrink-0">
                    <svg class="card-icon text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card-base card-hover group">
            <div class="h-1 bg-accent rounded-t-2xl"></div>
            <div class="p-5 flex items-start justify-between">
                <div>
                    <p class="card-muted uppercase tracking-widest font-semibold">Pinned Items</p>
                    <p class="card-number text-accent">{{ $stats['pinned'] ?? 0 }}</p>
                    <p class="card-muted mt-1.5">Featured at top</p>
                </div>
                <div class="card-icon-container bg-accent/10 group-hover:bg-accent/20 mt-1 shrink-0">
                    <svg class="card-icon text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card-base card-hover group">
            <div class="h-1 bg-primary/25 rounded-t-2xl"></div>
            <div class="p-5 flex items-start justify-between">
                <div>
                    <p class="card-muted uppercase tracking-widest font-semibold">Total Items</p>
                    <p class="card-number text-primary">{{ $stats['total'] ?? 0 }}</p>
                    <p class="card-muted mt-1.5">All time</p>
                </div>
                <div class="card-icon-container bg-primary/8 group-hover:bg-primary/15 mt-1 shrink-0">
                    <svg class="card-icon text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════
         EVENTS TABLE
    ═══════════════════════════════════════════════════ --}}
    <div class="card-base overflow-hidden mb-7">

        {{-- Toolbar --}}
        <div class="px-5 py-4 border-b border-border flex flex-wrap items-center justify-between gap-4">

            {{-- Type tabs --}}
            <div class="flex items-center gap-1 bg-sand border border-border rounded-xl p-1">
                <a href="{{ route('admin.events') }}"
                   class="px-5 py-2 rounded-lg text-xs font-semibold transition-all duration-200
                          {{ !request('type') ? 'bg-primary text-white shadow-sm' : 'text-muted hover:text-primary' }}">
                    All
                </a>
                <a href="{{ route('admin.events', ['type' => 'event']) }}"
                   class="px-5 py-2 rounded-lg text-xs font-semibold transition-all duration-200
                          {{ request('type') === 'event' ? 'bg-primary text-white shadow-sm' : 'text-muted hover:text-primary' }}">
                    Events
                </a>
                <a href="{{ route('admin.events', ['type' => 'announcement']) }}"
                   class="px-5 py-2 rounded-lg text-xs font-semibold transition-all duration-200
                          {{ request('type') === 'announcement' ? 'bg-primary text-white shadow-sm' : 'text-muted hover:text-primary' }}">
                    Announcements
                </a>
            </div>

            {{-- Filters + Create --}}
            <div class="flex items-center gap-3 flex-wrap">
                <select id="categoryFilter"
                        class="px-3 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                               focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\Event::getCategories() as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>

                <select id="statusFilter"
                        class="px-3 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                               focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all">
                    <option value="">All Status</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="pinned"   {{ request('status') === 'pinned'   ? 'selected' : '' }}>Pinned</option>
                    <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="past"     {{ request('status') === 'past'     ? 'selected' : '' }}>Past</option>
                    <option value="expired"  {{ request('status') === 'expired'  ? 'selected' : '' }}>Expired</option>
                </select>

                <button id="addNewBtn"
                        class="bg-secondary hover:bg-secondary/90 text-white px-5 py-2.5 rounded-xl text-sm font-semibold
                               flex items-center gap-2 shadow-sm hover:shadow-card transition-all duration-200 shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create New
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-sand/60 border-b border-border">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Title</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Type</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Category</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Date / Time</th>
                        <th class="px-5 py-3 text-center text-xs font-bold text-primary uppercase tracking-wider">Pinned</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-primary uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/60">
                    @forelse($events as $event)
                        <tr class="group hover:bg-sand/40 transition-colors duration-150">

                            {{-- Title --}}
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    @if($event->image_url)
                                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}"
                                             class="w-10 h-10 rounded-xl object-cover shrink-0 border border-border"/>
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-sand border border-border flex items-center justify-center shrink-0">
                                            @if($event->is_event)
                                                <svg class="w-5 h-5 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                                </svg>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-primary truncate max-w-[180px]">{{ $event->title }}</p>
                                        <p class="text-xs text-muted mt-0.5">{{ $event->location ?? 'No location' }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Type badge --}}
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @if($event->is_event)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary border border-primary/20 uppercase">Event</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-sand text-muted border border-border uppercase">Announce</span>
                                @endif
                            </td>

                            {{-- Category --}}
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <p class="text-sm text-primary">{{ $event->category ?? 'General' }}</p>
                            </td>

                            {{-- Date --}}
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <p class="text-sm font-medium text-primary">{{ $event->formatted_date ?? 'N/A' }}</p>
                                @if($event->expires_at)
                                    <p class="text-xs text-muted mt-0.5">Expires {{ $event->expires_at->format('M d, Y') }}</p>
                                @endif
                            </td>

                            {{-- Pin --}}
                            <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                <button class="toggle-pin-btn inline-flex items-center justify-center w-8 h-8 rounded-lg hover:bg-accent/10 transition-colors"
                                        data-id="{{ $event->id }}"
                                        data-pinned="{{ $event->is_pinned ? 'true' : 'false' }}"
                                        title="{{ $event->is_pinned ? 'Unpin' : 'Pin' }}">
                                    <svg class="w-4 h-4 pin-icon transition-colors {{ $event->is_pinned ? 'text-accent' : 'text-border' }}"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"
                                         fill="{{ $event->is_pinned ? 'currentColor' : 'none' }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                </button>
                            </td>

                            {{-- Active toggle — pure Tailwind peer --}}
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                        <input type="checkbox"
                                               class="toggle-active-btn sr-only peer"
                                               data-id="{{ $event->id }}"
                                               {{ $event->is_active ? 'checked' : '' }}>
                                        <div class="w-9 h-5 rounded-full border-2 border-border bg-sand
                                                    peer-checked:border-success peer-checked:bg-success/15
                                                    transition-all duration-200 relative">
                                            <div class="absolute top-0.5 left-0.5 w-3.5 h-3.5 rounded-full
                                                        bg-muted/50 peer-checked:bg-success
                                                        transition-all duration-200
                                                        peer-checked:translate-x-4 toggle-knob">
                                            </div>
                                        </div>
                                    </label>
                                    <span class="status-text text-xs font-semibold {{ $event->is_active ? 'text-success' : 'text-muted' }}"
                                          data-id="{{ $event->id }}">
                                        {{ $event->is_active ? 'Live' : 'Draft' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-3.5 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button class="edit-btn p-2 rounded-lg text-accent/60 hover:text-accent hover:bg-accent/10 transition-all duration-150"
                                            data-id="{{ $event->id }}" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button class="delete-btn p-2 rounded-lg text-secondary/50 hover:text-secondary hover:bg-secondary/8 transition-all duration-150"
                                            data-id="{{ $event->id }}" title="Delete">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-14 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-sand border border-border flex items-center justify-center">
                                        <svg class="w-6 h-6 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-primary">No events or announcements found</p>
                                    <button id="addNewBtnEmpty" class="text-xs text-accent hover:underline font-semibold">Create your first item</button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         REGISTRATIONS TABLE
    ═══════════════════════════════════════════════════ --}}
    <div class="card-base overflow-hidden">

        <div class="px-5 py-4 border-b border-border flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-accent shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <div>
                    <h2 class="font-display font-bold text-lg text-primary">Event Registrations</h2>
                    <p class="text-xs text-muted mt-0.5">Recent sign-ups for events</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-muted bg-sand border border-border px-2.5 py-1 rounded-full shrink-0">
                    {{ $registrations->count() }} total
                </span>
                <a href="{{ route('admin.events.export') }}"
                   class="bg-accent hover:bg-accent/90 text-white px-4 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2 shadow-sm hover:shadow-card transition-all duration-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v4m0-4h4M4 4l5 5m11-1v12m0-12h-4m4 0l-5 5M9 17h6" />
                    </svg>
                    Export CSV
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-sand/60 border-b border-border">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Name</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Contact</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Event</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Type</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider">Registered</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/60">
                    @forelse($registrations as $registration)
                        <tr class="group hover:bg-sand/40 transition-colors duration-150">

                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary/10 border border-primary/20 flex items-center justify-center shrink-0">
                                        <span class="text-xs font-bold text-primary">
                                            {{ strtoupper(substr($registration->first_name ?? 'G', 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-primary">{{ $registration->full_name }}</p>
                                        @if($registration->member_id)
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-success">
                                                <span class="w-1.5 h-1.5 rounded-full bg-success"></span>Member
                                            </span>
                                        @else
                                            <span class="text-xs text-muted">Guest</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @if($registration->email)
                                    <p class="text-sm text-primary">{{ $registration->email }}</p>
                                @endif
                                @if($registration->phone)
                                    <p class="text-xs text-muted mt-0.5">{{ $registration->phone }}</p>
                                @endif
                                @if(!$registration->email && !$registration->phone)
                                    <span class="text-xs text-muted">No contact info</span>
                                @endif
                            </td>

                            <td class="px-5 py-3.5 max-w-[200px]">
                                <p class="text-sm font-medium text-primary truncate">{{ $registration->event->title ?? 'N/A' }}</p>
                                @if($registration->event)
                                    <p class="text-xs text-muted mt-0.5">{{ $registration->event->formatted_date ?? 'Date TBD' }}</p>
                                @endif
                            </td>

                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @if($registration->event)
                                    @if($registration->event->is_event)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary border border-primary/20 uppercase">Event</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-sand text-muted border border-border uppercase">Announce</span>
                                    @endif
                                @else
                                    <span class="text-xs text-muted">—</span>
                                @endif
                            </td>

                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <p class="text-sm text-primary">{{ $registration->created_at->diffForHumans() }}</p>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-sand border border-border flex items-center justify-center">
                                        <svg class="w-6 h-6 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-primary">No registrations yet</p>
                                    <p class="text-xs text-muted">Sign-ups will appear here once members register for events.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         MODAL: CREATE / EDIT
    ═══════════════════════════════════════════════════ --}}
    <div id="eventModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-primary/60 backdrop-blur-sm" id="modalBackdrop"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-card-hover w-full max-w-2xl max-h-[90vh] flex flex-col
                        transition-all duration-200 scale-100 opacity-100">

                <div class="flex items-center justify-between px-6 py-4 border-b border-border shrink-0">
                    <h3 id="modalTitle" class="font-display font-bold text-lg text-primary">Create New Event</h3>
                    <button id="closeModal" class="p-2 rounded-xl text-muted hover:text-primary hover:bg-sand transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="overflow-y-auto flex-1 p-6">
                    <form id="eventForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div id="methodField"></div>

                        <div>
                            <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-2">Type</label>
                            <div class="flex gap-5">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="type" value="event" checked class="w-4 h-4 accent-primary"/>
                                    <span class="text-sm font-medium text-primary">Event</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="type" value="announcement" class="w-4 h-4 accent-primary"/>
                                    <span class="text-sm font-medium text-primary">Announcement</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1.5">
                                Title <span class="text-secondary">*</span>
                            </label>
                            <input type="text" name="title" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                                          placeholder-muted focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all"
                                   placeholder="Enter title…"/>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1.5">Category</label>
                            <select name="category"
                                    class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                                           focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all">
                                <option value="">Select category</option>
                                @foreach(\App\Models\Event::getCategories() as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1.5">Description</label>
                            <textarea name="description" rows="3"
                                      class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                                             placeholder-muted focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all resize-none"
                                      placeholder="Brief description…"></textarea>
                        </div>

                        <div id="eventFields" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1.5">Date</label>
                                    <input type="date" name="date"
                                           class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                                                  focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all"/>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1.5">Time</label>
                                    <input type="time" name="time"
                                           class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                                                  focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all"/>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1.5">Location</label>
                                <input type="text" name="location"
                                       class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                                              placeholder-muted focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all"
                                       placeholder="e.g. Main Sanctuary"/>
                            </div>
                        </div>

                        <div id="announcementFields" class="space-y-4 hidden">
                            <div>
                                <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1.5">Content</label>
                                <textarea name="content" rows="5"
                                          class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                                                 placeholder-muted focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all resize-none"
                                          placeholder="Full announcement content…"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1.5">Expires At</label>
                                <input type="datetime-local" name="expires_at"
                                       class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                                              focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all"/>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1.5">
                                Image <span class="text-muted normal-case font-normal">(optional · max 5MB)</span>
                            </label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full px-4 py-2.5 rounded-xl border border-border bg-white text-sm text-primary
                                          file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0
                                          file:text-xs file:font-semibold file:bg-sand file:text-primary hover:file:bg-border
                                          transition-all"/>
                            <p class="text-xs text-muted mt-1">JPEG, PNG, JPG, GIF, WEBP</p>
                        </div>

                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" checked
                                       class="w-4 h-4 rounded border-border accent-primary"/>
                                <span class="text-sm font-medium text-primary">Active</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input type="checkbox" name="is_pinned" value="1"
                                       class="w-4 h-4 rounded border-border accent-primary"/>
                                <span class="text-sm font-medium text-primary">Pinned</span>
                            </label>
                        </div>

                        <div class="flex justify-end gap-3 pt-2 border-t border-border">
                            <button type="button" id="cancelBtn"
                                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-muted border border-border
                                           hover:border-primary/30 hover:text-primary bg-sand transition-all duration-200">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-primary
                                           hover:bg-primary/90 shadow-sm hover:shadow transition-all duration-200">
                                Save
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const modal       = document.getElementById('eventModal');
        const modalTitle  = document.getElementById('modalTitle');
        const eventForm   = document.getElementById('eventForm');
        const methodField = document.getElementById('methodField');
        const eventFields = document.getElementById('eventFields');
        const annoFields  = document.getElementById('announcementFields');

        function openModal()  { modal.classList.remove('hidden'); document.body.classList.add('overflow-hidden'); }
        function closeModal() { modal.classList.add('hidden');    document.body.classList.remove('overflow-hidden'); }

        document.getElementById('modalBackdrop').addEventListener('click', closeModal);
        document.getElementById('closeModal').addEventListener('click', closeModal);
        document.getElementById('cancelBtn').addEventListener('click', closeModal);
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

        function toggleFields() {
            const type = document.querySelector('input[name="type"]:checked').value;
            eventFields.classList.toggle('hidden', type !== 'event');
            annoFields.classList.toggle('hidden',  type === 'event');
        }
        document.querySelectorAll('input[name="type"]').forEach(r => r.addEventListener('change', toggleFields));

        function openAddModal() {
            modalTitle.textContent = 'Create New Event / Announcement';
            eventForm.reset();
            eventForm.action = '{{ route("admin.events.store") }}';
            methodField.innerHTML = '';
            toggleFields();
            openModal();
        }
        document.getElementById('addNewBtn').addEventListener('click', openAddModal);
        const emptyBtn = document.getElementById('addNewBtnEmpty');
        if (emptyBtn) emptyBtn.addEventListener('click', openAddModal);

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', async function () {
                try {
                    const res  = await fetch(`/admin/events/${this.dataset.id}`);
                    const data = await res.json();
                    if (!data.success) throw new Error(data.message);
                    const ev = data.event;

                    modalTitle.textContent = 'Edit ' + (ev.type === 'event' ? 'Event' : 'Announcement');
                    eventForm.action = `/admin/events/${this.dataset.id}`;
                    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';

                    eventForm.querySelector('[name="title"]').value       = ev.title       || '';
                    eventForm.querySelector('[name="category"]').value    = ev.category    || '';
                    eventForm.querySelector('[name="description"]').value = ev.description || '';
                    eventForm.querySelector(`[name="type"][value="${ev.type}"]`).checked = true;

                    if (ev.type === 'event') {
                        eventForm.querySelector('[name="date"]').value     = ev.date     || '';
                        eventForm.querySelector('[name="time"]').value     = ev.time     || '';
                        eventForm.querySelector('[name="location"]').value = ev.location || '';
                    } else {
                        eventForm.querySelector('[name="content"]').value    = ev.content    || '';
                        eventForm.querySelector('[name="expires_at"]').value = ev.expires_at || '';
                    }

                    eventForm.querySelector('[name="is_active"]').checked = ev.is_active;
                    eventForm.querySelector('[name="is_pinned"]').checked  = ev.is_pinned;

                    toggleFields();
                    openModal();
                } catch { showToast('Error loading event data', 'error'); }
            });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                if (!confirm('Delete this item? This cannot be undone.')) return;
                const f = document.createElement('form');
                f.method = 'POST';
                f.action = `/admin/events/${this.dataset.id}`;
                f.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
                document.body.appendChild(f);
                f.submit();
            });
        });

        document.querySelectorAll('.toggle-pin-btn').forEach(btn => {
            btn.addEventListener('click', async function () {
                try {
                    const res  = await fetch(`/admin/events/${this.dataset.id}/toggle-pin`, {
                        method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                    const data = await res.json();
                    if (!data.success) throw new Error();
                    const icon = this.querySelector('.pin-icon');
                    if (data.is_pinned) {
                        icon.setAttribute('fill', 'currentColor');
                        icon.classList.remove('text-border');
                        icon.classList.add('text-accent');
                    } else {
                        icon.setAttribute('fill', 'none');
                        icon.classList.add('text-border');
                        icon.classList.remove('text-accent');
                    }
                } catch { showToast('Failed to update pin', 'error'); }
            });
        });

        document.querySelectorAll('.toggle-active-btn').forEach(checkbox => {
            checkbox.addEventListener('change', async function () {
                try {
                    const res  = await fetch(`/admin/events/${this.dataset.id}/toggle-active`, {
                        method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                    const data = await res.json();
                    if (!data.success) throw new Error();
                    const label = document.querySelector(`.status-text[data-id="${this.dataset.id}"]`);
                    if (label) {
                        label.textContent = data.is_active ? 'Live' : 'Draft';
                        label.className   = `status-text text-xs font-semibold ${data.is_active ? 'text-success' : 'text-muted'}`;
                    }
                } catch {
                    this.checked = !this.checked;
                    showToast('Failed to update status', 'error');
                }
            });
        });

        ['categoryFilter', 'statusFilter'].forEach(id => {
            document.getElementById(id)?.addEventListener('change', function () {
                const url = new URL(window.location.href);
                const key = id === 'categoryFilter' ? 'category' : 'status';
                this.value ? url.searchParams.set(key, this.value) : url.searchParams.delete(key);
                window.location.href = url.toString();
            });
        });

        window.showToast = function (msg, type) {
            const t = document.createElement('div');
            t.className = `fixed top-5 right-5 z-[100] flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-card-hover text-sm font-semibold border
                ${type === 'success'
                    ? 'bg-success/10 border-success/30 text-success'
                    : 'bg-secondary/10 border-secondary/30 text-secondary'}`;
            t.innerHTML = `<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                ${type === 'success'
                    ? '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>'}
                </svg><span>${msg}</span>`;
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 3500);
        };

    });
    </script>

@endsection