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
                        <th class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium text-gray-700">Title</th>
                        <th class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium text-gray-700">Schedule</th>
                        <th class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium text-gray-700">Description</th>
                        <th class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($services as $service)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-700 font-semibold">{{ $service->name ?? $service->title ?? '' }}</td>
                            <td class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-700">{{ $service->schedule ?? '' }}</td>
                            <td class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-700 truncate">{{ $service->description ?? '' }}</td>
                            <td class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-700">
                                <button class="px-2 sm:px-3 py-1 bg-yellow-500 text-white rounded edit-btn mr-1 sm:mr-2 text-xs hover:bg-yellow-600 transition" data-id="{{ $service->id }}" data-title="{{ $service->name ?? $service->title ?? '' }}" data-time="{{ $service->time ?? $service->day ?? '' }}" data-schedule="{{ $service->schedule ?? '' }}" data-location="{{ $service->location ?? '' }}" data-description="{{ $service->description ?? '' }}">Edit</button>
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
                        <th class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium text-gray-700">Full Name</th>
                        <th class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium text-gray-700">Email</th>
                        <th class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium text-gray-700">Service</th>
                        <th class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium text-gray-700">Registered On</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($serviceRegistrations ?? [] as $reg)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-700 font-semibold">
                                {{ $reg->member ? $reg->member->full_name : ($reg->guest_full_name ?? 'Unknown') }}
                            </td>
                            <td class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-700 truncate">{{ $reg->member ? $reg->member->email : ($reg->guest_email ?? '—') }}</td>
                            <td class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-700">{{ $reg->service->name ?? 'N/A' }}</td>
                            <td class="px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-700">{{ optional($reg->created_at)->format('M d, Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 sm:px-4 py-4 text-center text-gray-500">No registrations found</td>
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
                    <input name="name" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Schedule</label>
                        <input name="schedule" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Location</label>
                        <input name="location" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"></textarea>
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
    const editBtns = document.querySelectorAll('.edit-btn');
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
        const location = btn.dataset.location || '';
        const description = btn.dataset.description || '';

        editForm.elements['name'].value = name;
        editForm.elements['schedule'].value = schedule;
        editForm.elements['location'].value = location;
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

    addServiceBtn.addEventListener('click', openAddModal);
    editBtns.forEach(b => b.addEventListener('click', (e) => { openModalWithData(e.currentTarget); }));
    cancelEdit.addEventListener('click', closeEditModal);
    closeModal.addEventListener('click', closeEditModal);
    
    // Close modal when clicking outside it
    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) closeEditModal();
    });

    editForm.addEventListener('submit', (e) => {
        e.preventDefault();
        editForm.submit();
    });
</script>
@endsection
