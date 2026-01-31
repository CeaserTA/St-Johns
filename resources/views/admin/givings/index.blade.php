@extends('layouts.dashboard_layout')

@section('title', 'Giving Management')
@section('header_title', 'Giving Management ❤️')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total This Month</p>
                    <p class="text-2xl font-bold text-gray-900" id="total-month">Loading...</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900" id="pending-count">Loading...</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tithes This Month</p>
                    <p class="text-2xl font-bold text-gray-900" id="tithes-month">Loading...</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Transactions</p>
                    <p class="text-2xl font-bold text-gray-900" id="transaction-count">Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.giving.reports') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                📊 View Reports
            </a>
            <a href="{{ route('giving.index') }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200">
                ❤️ Public Giving Page
            </a>
            <button onclick="refreshData()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200">
                🔄 Refresh Data
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Filter Givings</h2>
        <form method="GET" action="{{ route('admin.givings') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <label for="giving_type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="giving_type" id="giving_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Types</option>
                    <option value="tithe" {{ request('giving_type') == 'tithe' ? 'selected' : '' }}>Tithe</option>
                    <option value="offering" {{ request('giving_type') == 'offering' ? 'selected' : '' }}>Offering</option>
                    <option value="donation" {{ request('giving_type') == 'donation' ? 'selected' : '' }}>Donation</option>
                    <option value="special_offering" {{ request('giving_type') == 'special_offering' ? 'selected' : '' }}>Special Offering</option>
                </select>
            </div>

            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                <select name="payment_method" id="payment_method" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Methods</option>
                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="mobile_money" {{ request('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                    <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                    <option value="check" {{ request('payment_method') == 'check' ? 'selected' : '' }}>Check</option>
                </select>
            </div>

            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Givings Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Givings</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giver</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($givings as $giving)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        @if($giving->member)
                                            <span class="text-sm font-medium text-gray-700">{{ substr($giving->member->full_name, 0, 1) }}</span>
                                        @else
                                            <span class="text-sm font-medium text-gray-700">G</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $giving->giver_name }}</div>
                                    <div class="text-sm text-gray-500">
                                        @if($giving->member)
                                            Member
                                        @else
                                            Guest
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($giving->giving_type == 'tithe') bg-purple-100 text-purple-800
                                @elseif($giving->giving_type == 'offering') bg-blue-100 text-blue-800
                                @elseif($giving->giving_type == 'donation') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $giving->giving_type)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-medium">{{ number_format($giving->amount, 0) }} {{ $giving->currency }}</div>
                            @if($giving->processing_fee)
                                <div class="text-xs text-gray-500">Fee: {{ number_format($giving->processing_fee, 0) }} {{ $giving->currency }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div>{{ ucfirst(str_replace('_', ' ', $giving->payment_method)) }}</div>
                            @if($giving->payment_provider)
                                <div class="text-xs text-gray-500">{{ $giving->payment_provider }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($giving->status == 'completed') bg-green-100 text-green-800
                                @elseif($giving->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($giving->status == 'failed') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($giving->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $giving->payment_date ? $giving->payment_date->format('M d, Y') : $giving->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                @if($giving->status == 'pending')
                                    <button onclick="confirmGiving({{ $giving->id }})" 
                                            class="text-green-600 hover:text-green-900 transition duration-200">
                                        ✓ Confirm
                                    </button>
                                    <button onclick="failGiving({{ $giving->id }})" 
                                            class="text-red-600 hover:text-red-900 transition duration-200">
                                        ✗ Fail
                                    </button>
                                @endif
                                <button onclick="viewDetails({{ $giving->id }})" 
                                        class="text-blue-600 hover:text-blue-900 transition duration-200">
                                    👁 View
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No givings found. <a href="{{ route('giving.index') }}" class="text-blue-600 hover:underline">Share the giving page</a> to get started!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($givings->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $givings->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Giving Details Modal -->
<div id="giving-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-screen overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Giving Details</h3>
                <button onclick="closeModal()" class="float-right text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="modal-content" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
// Load summary data on page load
document.addEventListener('DOMContentLoaded', function() {
    refreshData();
});

function refreshData() {
    fetch('{{ route("admin.giving.reports") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('total-month').textContent = 
                    new Intl.NumberFormat().format(data.summary.total_amount) + ' UGX';
                document.getElementById('pending-count').textContent = 
                    data.summary.pending_count || '0';
                document.getElementById('tithes-month').textContent = 
                    new Intl.NumberFormat().format(data.summary.total_tithes) + ' UGX';
                document.getElementById('transaction-count').textContent = 
                    data.summary.transaction_count || '0';
            }
        })
        .catch(error => console.error('Error loading data:', error));
}

function confirmGiving(givingId) {
    if (confirm('Are you sure you want to confirm this giving?')) {
        fetch(`/admin/givings/${givingId}/confirm`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error confirming giving: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while confirming the giving.');
        });
    }
}

function failGiving(givingId) {
    if (confirm('Are you sure you want to mark this giving as failed?')) {
        fetch(`/admin/givings/${givingId}/fail`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error marking giving as failed: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the giving.');
        });
    }
}

function viewDetails(givingId) {
    // For now, just show a simple alert. You can enhance this to show a detailed modal
    alert('Viewing details for giving ID: ' + givingId + '\n\nThis feature can be enhanced to show full giving details, transaction history, and receipt information.');
}

function closeModal() {
    document.getElementById('giving-modal').classList.add('hidden');
}
</script>

<!-- Add CSRF token to head for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection