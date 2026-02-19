@extends('layouts.dashboard_layout')

@section('title', 'Services')
@section('header_title', 'Services')

@section('content')
    @php
        // Services and service registrations should be provided by the controller/route
        // Collections available here: $services, $serviceRegistrations
    @endphp

    <!-- Manage Services – Blue Theme & Interactive Hover -->
    <div class="max-w-full mx-auto">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold text-primary flex items-center gap-3">
                <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Manage Services
            </h2>

            <button id="addServiceBtn"
                    class="bg-secondary hover:bg-accent text-white px-5 py-2.5 rounded-xl font-medium transition-all duration-300 shadow-md hover:shadow-lg flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-accent/30">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Service
            </button>
        </div>

        <div class="bg-white dark:bg-background-dark rounded-2xl shadow-lg border border-l-2 border-primary overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200/70 dark:divide-gray-700/70">
                    <thead class="bg-primary/5 dark:bg-primary/10 border-b border-primary/30 dark:border-primary/40">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider">
                                Title
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider">
                                Schedule
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider">
                                Fee
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider">
                                Description
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100/80 dark:divide-gray-700/60">
                        @forelse($services as $service)
                            <tr class="group hover:bg-primary/5 dark:hover:bg-primary/10 hover:shadow-md hover:-translate-y-1 hover:border-x hover:border-primary/30 dark:hover:border-primary/40 transition-all duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-text-dark group-hover:text-primary transition-colors">
                                    {{ $service->name ?? $service->title ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-text-muted-dark group-hover:text-primary/90 transition-colors">
                                    {{ $service->schedule ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($service->is_free)
                                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 text-xs font-semibold rounded-full">
                                            FREE
                                        </span>
                                    @else
                                        <span class="font-semibold text-secondary group-hover:text-secondary/90 transition-colors">
                                            {{ $service->formatted_fee ?? '—' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-text-muted-dark group-hover:text-primary/90 transition-colors">
                                    <div class="max-w-xs truncate">
                                        {{ $service->description ?? '—' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex gap-3 opacity-80 group-hover:opacity-100 transition-opacity">
                                        <button class="edit-btn px-3.5 py-1.5 bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 hover:bg-yellow-100 dark:hover:bg-yellow-800/50 rounded-lg transition duration-200 text-xs flex items-center gap-1 border border-yellow-200/50 dark:border-yellow-700/40 hover:border-yellow-300 dark:hover:border-yellow-600/60 group-hover:scale-105">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
                                        </button>

                                        <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn px-3.5 py-1.5 bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-800/50 rounded-lg transition duration-200 text-xs flex items-center gap-1 border border-red-200/50 dark:border-red-700/40 hover:border-red-300 dark:hover:border-red-600/60 group-hover:scale-105"
                                                    onclick="return confirm('Are you sure you want to delete this service?')">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-text-muted-dark text-sm">
                                    No services added yet.
                                    <button id="addServiceBtnEmpty" class="ml-2 text-accent hover:underline font-medium">
                                        Add your first service
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Service Registrations – Modern, Intuitive & Sacred -->
    <div class="max-w-full mx-auto mt-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-primary flex items-center gap-3">
                <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Service Registrations
            </h2>
        </div>

        <div class="bg-white dark:bg-background-dark rounded-2xl shadow-lg border border-l-2 border-primary overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200/70 dark:divide-gray-700/70">
                    <thead class="bg-primary/5 dark:bg-primary/10 border-b border-primary/30 dark:border-primary/40">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                                Full Name
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                                Email
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                                Phone Number
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                                Service
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                                Amount
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                                Payment Status
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                                Transaction Ref
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider border-r border-primary/20 dark:border-primary/30">
                                Registered On
                            </th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-primary uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100/80 dark:divide-gray-700/60">
                        @forelse($serviceRegistrations ?? [] as $reg)
                            <tr class="group hover:bg-primary/5 dark:hover:bg-primary/10 hover:shadow-md hover:-translate-y-1 hover:border-x hover:border-primary/30 dark:hover:border-primary/40 transition-all duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-text-dark group-hover:text-primary transition-colors border-r border-gray-100/50 dark:border-gray-700/40">
                                    {{ $reg->guest_full_name ?? $reg->member->full_name ?? '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-text-muted-dark group-hover:text-primary/90 transition-colors border-r border-gray-100/50 dark:border-gray-700/40">
                                    {{ $reg->guest_email ?? $reg->member->email ?? '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-text-muted-dark group-hover:text-primary/90 transition-colors border-r border-gray-100/50 dark:border-gray-700/40">
                                    {{ $reg->guest_phone ?? $reg->member->phone ?? '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-text-muted-dark group-hover:text-primary/90 transition-colors border-r border-gray-100/50 dark:border-gray-700/40">
                                    {{ $reg->service->name ?? '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold group-hover:text-primary/90 transition-colors border-r border-gray-100/50 dark:border-gray-700/40">
                                    @if($reg->service && $reg->service->isFree())
                                        <span class="px-3 py-1 bg-green-100/80 dark:bg-green-900/40 text-green-800 dark:text-green-300 text-xs font-semibold rounded-full">
                                            FREE
                                        </span>
                                    @else
                                        {{ $reg->service->formatted_fee ?? '' }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm border-r border-gray-100/50 dark:border-gray-700/40">
                                    @php
                                        $statusColors = [
                                            'paid' => 'bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300',
                                            'pending' => 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300',
                                            'failed' => 'bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300',
                                            'refunded' => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-text-muted-dark',
                                        ];
                                        $colorClass = $statusColors[$reg->payment_status] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-text-muted-dark';
                                    @endphp
                                    <span class="px-3 py-1 {{ $colorClass }} text-xs font-semibold rounded-full uppercase">
                                        {{ $reg->payment_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-text-muted-dark group-hover:text-primary/90 transition-colors border-r border-gray-100/50 dark:border-gray-700/40">
                                    @if($reg->transaction_reference)
                                        <span class="font-mono text-xs">{{ $reg->transaction_reference }}</span>
                                        <br><span class="text-xs text-gray-500 dark:text-text-muted-dark">
                                            {{ ucfirst(str_replace('_', ' ', $reg->payment_method ?? '')) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-600">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-text-muted-dark border-r border-gray-100/50 dark:border-gray-700/40">
                                    {{ optional($reg->created_at)->format('Y-m-d') ?? '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex gap-3 opacity-80 group-hover:opacity-100 transition-opacity">
                                        @if($reg->payment_status === 'pending')
                                            <button onclick="confirmPayment({{ $reg->id }})"
                                                    class="px-3.5 py-1.5 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-green-800/50 rounded-lg transition duration-200 text-xs flex items-center gap-1 border border-green-200/50 dark:border-green-700/40 hover:border-green-300 dark:hover:border-green-600/60 group-hover:scale-105">
                                                Confirm
                                            </button>
                                            <button onclick="rejectPayment({{ $reg->id }})"
                                                    class="px-3.5 py-1.5 bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-800/50 rounded-lg transition duration-200 text-xs flex items-center gap-1 border border-red-200/50 dark:border-red-700/40 hover:border-red-300 dark:hover:border-red-600/60 group-hover:scale-105">
                                                Reject
                                            </button>
                                        @elseif($reg->payment_status === 'paid')
                                            <span class="text-green-600 dark:text-green-400 text-xs flex items-center gap-1">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Verified
                                            </span>
                                        @elseif($reg->payment_status === 'failed')
                                            <span class="text-red-600 dark:text-red-400 text-xs flex items-center gap-1">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Rejected
                                            </span>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-600 text-xs">—</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-500 dark:text-text-muted-dark text-sm">
                                    No service registrations yet.
                                </td>
                            </tr>
                        @endforelse
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
                            <input name="schedule" required
                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fee (UGX)</label>
                            <input name="fee" id="feeInput" type="number" step="0.01" min="0" value="0"
                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                        </div>
                    </div>
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_free" value="1"
                                class="rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-700">This service is free</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="4" required
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"></textarea>
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