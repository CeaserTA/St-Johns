
@extends('layouts.dashboard_layout')

@section('title', 'Services')
@section('header_title', 'Services')

@section('content')
@php
    // Services and service registrations should be provided by the controller/route
    // Collections available here: $services, $serviceRegistrations
@endphp

<!-- Services Table Section (rendered within dashboard layout) -->
<div class="max-w-full mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold">Manage Services</h2>
        <button id="addServiceBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">+ Add Service</button>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left divide-y divide-gray-200">
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
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Service Registrations Table Section -->
<div class="max-w-full mx-auto mt-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold">Service Registrations</h2>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left divide-y divide-gray-200">
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-xl">
        <h3 class="text-xl font-bold mb-4" id="modalTitle">Edit Service</h3>
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
            <div class="mt-4 flex justify-end gap-3">
                <button type="button" id="cancelEdit" class="px-4 py-2 border rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    const addServiceBtn = document.getElementById('addServiceBtn');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const cancelEdit = document.getElementById('cancelEdit');
    const modalTitle = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    let currentServiceId = null;
    let isAddingNew = false;

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
