@extends('layouts.dashboard_layout')

@section('title', 'Services')
@section('header_title', 'Services')

@section('content')
@php
    // Services and service registrations should be provided by the controller/route
    // Collections available here: $services, $serviceRegistrations, $stats
@endphp

<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-blue-100 rounded-lg flex-shrink-0">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Services</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['total_services'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-green-100 rounded-lg flex-shrink-0">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Registrations</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['total_registrations'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-purple-100 rounded-lg flex-shrink-0">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">This Month</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['registrations_this_month'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-yellow-100 rounded-lg flex-shrink-0">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7-1a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Active Services</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['active_services'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Search & Filter Services</h2>
        <form method="GET" action="{{ route('admin.services') }}" class="space-y-4">
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Services</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Search by name, description, or schedule..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 sm:items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-6 py-2 rounded-md transition duration-200 text-sm font-medium">
                        🔍 Search
                    </button>
                    <a href="{{ route('admin.services') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 sm:px-6 py-2 rounded-md transition duration-200 text-sm font-medium text-center">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Services Table Section -->
    <div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4 sm:mb-6">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-900">Manage Services</h2>
            <button id="addServiceBtn" class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition text-sm font-medium">+ Add Service</button>
        </div>

        <div class="bg-white p-4 sm:p-6 rounded-lg shadow overflow-x-auto">
            <table class="min-w-full text-left divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Title</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Schedule</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Fee</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Description</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($services as $service)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700 font-semibold">{{ $service->name ?? $service->title ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $service->schedule ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                @if($service->is_free)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">FREE</span>
                                @else
                                    <span class="font-semibold text-secondary">{{ $service->formatted_fee }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $service->description ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <button class="px-3 py-1 bg-yellow-500 text-white rounded edit-btn mr-2" 
                                    data-id="{{ $service->id }}" 
                                    data-title="{{ $service->name ?? $service->title ?? '' }}" 
                                    data-schedule="{{ $service->schedule ?? '' }}" 
                                    data-fee="{{ $service->fee ?? 0 }}"
                                    data-is-free="{{ $service->is_free ? '1' : '0' }}"
                                    data-currency="{{ $service->currency ?? 'UGX' }}"
                                    data-description="{{ $service->description ?? '' }}">Edit</button>
                                <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 sm:px-3 py-1 bg-red-600 text-white rounded delete-btn text-xs hover:bg-red-700 transition" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 sm:px-4 py-4 text-center text-gray-500">No services found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Service Registrations Table Section -->
    <div>
        <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4 sm:mb-6">Service Registrations</h2>

        <div class="bg-white p-4 sm:p-6 rounded-lg shadow overflow-x-auto">
            <table class="min-w-full text-left divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Full Name</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Email</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Phone Number</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Service</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Amount</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Payment Status</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Transaction Ref</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Registered On</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($serviceRegistrations ?? [] as $reg)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700 font-semibold">{{ $reg->guest_full_name ?? $reg->member->full_name ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->guest_email ?? $reg->member->email ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->guest_phone ?? $reg->member->phone ?? ''}}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->service->name ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700 font-semibold">
                                @if($reg->service && $reg->service->isFree())
                                    <span class="text-green-600">FREE</span>
                                @else
                                    {{ $reg->service->formatted_fee ?? '' }}
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @php
                                    $statusColors = [
                                        'paid' => 'bg-green-100 text-green-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'failed' => 'bg-red-100 text-red-800',
                                        'refunded' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $colorClass = $statusColors[$reg->payment_status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 {{ $colorClass }} text-xs font-semibold rounded uppercase">
                                    {{ $reg->payment_status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                @if($reg->transaction_reference)
                                    <span class="font-mono text-xs">{{ $reg->transaction_reference }}</span>
                                    <br><span class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $reg->payment_method ?? '')) }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ optional($reg->created_at)->format('Y-m-d') ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                @if($reg->payment_status === 'pending')
                                    <button onclick="confirmPayment({{ $reg->id }})" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs mr-1">
                                        Confirm
                                    </button>
                                    <button onclick="rejectPayment({{ $reg->id }})" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                                        Reject
                                    </button>
                                @elseif($reg->payment_status === 'paid')
                                    <span class="text-green-600 text-xs">✓ Verified</span>
                                @elseif($reg->payment_status === 'failed')
                                    <span class="text-red-600 text-xs">✗ Rejected</span>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg p-6 w-full max-w-xl max-h-screen overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold" id="modalTitle">Edit Service</h3>
            <button type="button" id="closeModal" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            <div id="methodField"></div>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input name="name" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Schedule</label>
                        <input name="schedule" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fee (UGX)</label>
                        <input name="fee" id="feeInput" type="number" step="0.01" min="0" value="0" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                    </div>
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_free" value="1" class="rounded border-gray-300 text-primary focus:ring-primary">
                        <span class="ml-2 text-sm text-gray-700">This service is free</span>
                    </label>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="cancelEdit" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-50 transition">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    const addServiceBtn = document.getElementById('addServiceBtn');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const cancelEdit = document.getElementById('cancelEdit');
    const closeModal = document.getElementById('closeModal');
    const modalTitle = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    let currentServiceId = null;
    let isAddingNew = false;

    function closeEditModal() {
        editModal.classList.add('hidden');
        editModal.classList.remove('flex');
    }

    function openModalWithData(btn) {
        isAddingNew = false;
        currentServiceId = btn.dataset.id;
        modalTitle.textContent = 'Edit Service';
        const name = btn.dataset.title || '';
        const schedule = btn.dataset.schedule || '';
        const fee = btn.dataset.fee || '0';
        const isFree = btn.dataset.isFree === '1';
        const description = btn.dataset.description || '';

        editForm.elements['name'].value = name;
        editForm.elements['schedule'].value = schedule;
        editForm.elements['fee'].value = fee;
        editForm.elements['is_free'].checked = isFree;
        editForm.elements['description'].value = description;

        editForm.action = `/admin/services/${currentServiceId}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
    }

    function openAddModal() {
        isAddingNew = true;
        currentServiceId = null;
        modalTitle.textContent = 'Add New Service';
        editForm.reset();
        editForm.action = '/admin/services';
        methodField.innerHTML = '';

        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
    }

    function attachEditListeners() {
        const editBtns = document.querySelectorAll('.edit-btn');
        editBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                openModalWithData(e.currentTarget);
            });
        });
    }

    // Initial attachment
    attachEditListeners();

    addServiceBtn.addEventListener('click', openAddModal);
    cancelEdit.addEventListener('click', () => { 
        editModal.classList.add('hidden'); 
        editModal.classList.remove('flex'); 
    });

    editForm.addEventListener('submit', (e) => {
        e.preventDefault();
        editForm.submit();
    });

    // Payment confirmation functions
    async function confirmPayment(registrationId) {
        if (!confirm('Confirm this payment? This will mark the registration as paid.')) {
            return;
        }

        try {
            const response = await fetch(`/admin/service-registrations/${registrationId}/confirm-payment`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (data.success) {
                alert('Payment confirmed successfully!');
                window.location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to confirm payment'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        }
    }

    async function rejectPayment(registrationId) {
        const reason = prompt('Reason for rejection (optional):');
        if (reason === null) return; // User cancelled

        try {
            const response = await fetch(`/admin/service-registrations/${registrationId}/reject-payment`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ reason })
            });

            const data = await response.json();

            if (data.success) {
                alert('Payment rejected.');
                window.location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to reject payment'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        }
    }

    // Make functions globally available
    window.confirmPayment = confirmPayment;
    window.rejectPayment = rejectPayment;
</script>
@endsection
