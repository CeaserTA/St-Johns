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

<!-- Recent Service Registrations -->
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent Service Registrations</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Name</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Email</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Phone</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Service</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Registered At</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($recentServiceRegistrations as $reg)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->full_name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->email ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->phone_number ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->service }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700" colspan="5">No service registrations yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection