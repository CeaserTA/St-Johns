@extends('layouts.dashboard_layout')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard')

@section('content')
<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Total Members</h2>
        <p class="text-3xl font-bold text-blue-600">{{ $totalMembers }}</p>
        <p class="text-sm text-gray-500 mt-1">All registered members</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">New Registrations</h2>
        <p class="text-3xl font-bold text-green-600">{{ $newRegistrations }}</p>
        <p class="text-sm text-gray-500 mt-1">This month</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Active Members</h2>
        <p class="text-3xl font-bold text-yellow-600">{{ $activeMembers }}</p>
        <p class="text-sm text-gray-500 mt-1">Attended in last 3 months</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <a href="{{ route('admin.members') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Manage Members</h3>
                <p class="text-sm text-gray-500">View and manage church members</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.events') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Manage Events</h3>
                <p class="text-sm text-gray-500">Create and manage church events</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.givings') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg">
                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Giving Management</h3>
                <p class="text-sm text-gray-500">Track tithes and offerings</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.qr-codes') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 16h4.01M12 8h4.01M8 12h.01M16 8h.01M8 16h.01M8 8h.01M12 16h.01" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">QR Codes</h3>
                <p class="text-sm text-gray-500">Generate QR codes for registration</p>
            </div>
        </div>
    </a>
</div>


@endsection