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


@endsection