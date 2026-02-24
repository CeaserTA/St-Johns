@extends('layouts.dashboard_layout')

@section('title', 'My Profile')
@section('header_title', 'My Profile')

@section('content')
<div class="space-y-6">
    <!-- Profile Header Section -->
    <div class="bg-white dark:bg-background-dark rounded-2xl shadow-md border border-primary/30 dark:border-primary/40 overflow-hidden">
        <div class="relative h-32 bg-gradient-to-r from-primary to-secondary"></div>
        <div class="px-6 pb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4 -mt-16">
                <!-- Profile Avatar -->
                <div class="relative">
                    @if($admin->profile_image_url)
                        <img src="{{ $admin->profile_image_url }}" 
                             alt="{{ $admin->name }}" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg">
                    @else
                        <div class="w-32 h-32 rounded-full bg-primary text-white flex items-center justify-center text-4xl font-bold border-4 border-white dark:border-gray-800 shadow-lg">
                            {{ $admin->initials }}
                        </div>
                    @endif
                </div>

                <!-- Profile Info -->
                <div class="flex-1 sm:ml-4 mt-4 sm:mt-0">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">{{ $admin->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $admin->email }}</p>
                    <div class="flex flex-wrap items-center gap-3 mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary/10 text-primary">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            {{ ucfirst($admin->role) }}
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Member since {{ $admin->created_at->format('M d, Y') }}
                        </span>
                        @if($admin->last_login_at)
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Last login {{ $admin->last_login_at->diffForHumans() }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Edit Profile Button -->
                <div class="sm:ml-auto">
                    <button onclick="toggleEditProfile()" 
                            class="bg-primary hover:bg-secondary text-white px-6 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5">
        <!-- Givings Approved -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 hover:border-primary/50 hover:shadow-md hover:-translate-y-1 transition-all duration-200 p-5">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg group-hover:bg-green-200 dark:group-hover:bg-green-800/40 transition-colors">
                    <svg class="h-7 w-7 text-green-600 dark:text-green-400 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Givings Approved</p>
                    <p class="text-3xl font-black text-green-600 dark:text-green-400 mt-0.5">{{ $stats['givings_approved_count'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-text-muted-dark mt-1">UGX {{ number_format($stats['givings_approved_total'], 0) }}</p>
                </div>
            </div>
        </div>

        <!-- Service Registrations Approved -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 hover:border-primary/50 hover:shadow-md hover:-translate-y-1 transition-all duration-200 p-5">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg group-hover:bg-blue-200 dark:group-hover:bg-blue-800/40 transition-colors">
                    <svg class="h-7 w-7 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Registrations Approved</p>
                    <p class="text-3xl font-black text-blue-600 dark:text-blue-400 mt-0.5">{{ $stats['service_registrations_approved_count'] }}</p>
                </div>
            </div>
        </div>

        <!-- Group Approvals -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 hover:border-primary/50 hover:shadow-md hover:-translate-y-1 transition-all duration-200 p-5">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg group-hover:bg-purple-200 dark:group-hover:bg-purple-800/40 transition-colors">
                    <svg class="h-7 w-7 text-purple-600 dark:text-purple-400 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Group Approvals</p>
                    <p class="text-3xl font-black text-purple-600 dark:text-purple-400 mt-0.5">{{ $stats['group_approvals_count'] }}</p>
                </div>
            </div>
        </div>

        <!-- Events Created -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 hover:border-primary/50 hover:shadow-md hover:-translate-y-1 transition-all duration-200 p-5">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-orange-100 dark:bg-orange-900/30 rounded-lg group-hover:bg-orange-200 dark:group-hover:bg-orange-800/40 transition-colors">
                    <svg class="h-7 w-7 text-orange-600 dark:text-orange-400 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Events Created</p>
                    <p class="text-3xl font-black text-orange-600 dark:text-orange-400 mt-0.5">{{ $stats['events_created_count'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity History Tabs Section -->
    <div class="bg-white dark:bg-background-dark rounded-2xl shadow-md border border-gray-200/70 dark:border-gray-700 overflow-hidden">
        <!-- Tab Headers -->
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex -mb-px overflow-x-auto" aria-label="Tabs">
                <a href="{{ route('admin.profile', ['tab' => 'givings']) }}" 
                   class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'givings' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Givings Approved
                </a>
                <a href="{{ route('admin.profile', ['tab' => 'registrations']) }}" 
                   class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'registrations' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Service Registrations
                </a>
                <a href="{{ route('admin.profile', ['tab' => 'groups']) }}" 
                   class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'groups' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Group Approvals
                </a>
                <a href="{{ route('admin.profile', ['tab' => 'events']) }}" 
                   class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'events' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Events Created
                </a>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            @if($activeTab === 'givings')
                <!-- Givings Approved Tab -->
                @if($activityData->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Member</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Approval Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-background-dark divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($activityData as $giving)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors cursor-pointer" 
                                        onclick="window.location.href='{{ route('admin.givings.show', $giving->id) }}'">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $giving->giver_name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $giving->member ? 'Member' : 'Guest' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($giving->amount, 0) }} {{ $giving->currency }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($giving->giving_type == 'tithe') bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-300
                                                @elseif($giving->giving_type == 'offering') bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300
                                                @else bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $giving->giving_type)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $giving->confirmed_at ? $giving->confirmed_at->format('M d, Y h:i A') : 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $activityData->appends(['tab' => 'givings'])->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No givings approved yet</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You haven't approved any givings yet.</p>
                    </div>
                @endif

            @elseif($activeTab === 'registrations')
                <!-- Service Registrations Tab -->
                @if($activityData->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Member</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Service</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Payment Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Approval Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-background-dark divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($activityData as $registration)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors cursor-pointer" 
                                        onclick="window.location.href='{{ route('admin.services') }}'">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $registration->guest_full_name ?? $registration->member->full_name ?? 'N/A' }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $registration->member_id ? 'Member' : 'Guest' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $registration->service->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                                @if($registration->payment_amount)
                                                    {{ number_format($registration->payment_amount, 0) }} UGX
                                                @elseif($registration->service && $registration->service->is_free)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300">
                                                        FREE
                                                    </span>
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $registration->paid_at ? $registration->paid_at->format('M d, Y h:i A') : 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $activityData->appends(['tab' => 'registrations'])->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No registrations approved yet</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You haven't approved any service registrations yet.</p>
                    </div>
                @endif

            @elseif($activeTab === 'groups')
                <!-- Group Approvals Tab -->
                @if($activityData->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Member</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Group</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Approval Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-background-dark divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($activityData as $approval)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors cursor-pointer" 
                                        onclick="window.location.href='{{ route('admin.groups') }}'">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $approval->member_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $approval->group_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($approval->approved_at)->format('M d, Y h:i A') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $activityData->appends(['tab' => 'groups'])->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No group approvals yet</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You haven't approved any group memberships yet.</p>
                    </div>
                @endif

            @elseif($activeTab === 'events')
                <!-- Events Created Tab -->
                @if($activityData->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Event Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Creation Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-background-dark divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($activityData as $event)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors cursor-pointer" 
                                        onclick="window.location.href='{{ route('admin.events.show', $event->id) }}'">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $event->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y') : 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $event->is_active ? 'bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' }}">
                                                {{ $event->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $event->created_at->format('M d, Y h:i A') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $activityData->appends(['tab' => 'events'])->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No events created yet</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You haven't created any events yet.</p>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Profile Settings Section (Collapsible) -->
    <div id="editProfileSection" class="hidden bg-white dark:bg-background-dark rounded-2xl shadow-md border border-gray-200/70 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Edit Profile</h2>
            <button onclick="toggleEditProfile()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div class="p-6 space-y-6">
            <!-- Profile Information Form -->
            <form id="profileForm" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $admin->name) }}" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="profile_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profile Image</label>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Accepted formats: JPEG, JPG, PNG, GIF. Max size: 2MB</p>
                    @error('profile_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="toggleEditProfile()" 
                            class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-primary hover:bg-secondary text-white rounded-lg transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="border-t border-gray-200 dark:border-gray-700 my-6"></div>

            <!-- Change Password Form -->
            <form id="passwordForm" method="POST" action="{{ route('admin.profile.password') }}" class="space-y-4">
                @csrf
                
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Change Password</h3>

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                    <input type="password" name="current_password" id="current_password" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimum 8 characters</p>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="toggleEditProfile()" 
                            class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-primary hover:bg-secondary text-white rounded-lg transition-colors">
                        Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleEditProfile() {
        const section = document.getElementById('editProfileSection');
        section.classList.toggle('hidden');
        
        // Scroll to the section if it's being shown
        if (!section.classList.contains('hidden')) {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
</script>
@endsection
