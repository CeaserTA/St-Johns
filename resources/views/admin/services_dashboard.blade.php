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
                        <!-- <th class="px-4 py-3 text-sm font-medium text-gray-700">Time</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Location</th> -->
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Description</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($services as $service)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700 font-semibold">{{ $service->name ?? $service->title ?? '' }}</td>
                            <!-- <td class="px-4 py-3 text-sm text-gray-700">{{ $service->time ?? $service->day ?? '' }}</td> -->
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $service->schedule ?? '' }}</td>
                            <!-- <td class="px-4 py-3 text-sm text-gray-700">{{ $service->location ?? '' }}</td> -->
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $service->description ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <button class="px-3 py-1 bg-yellow-500 text-white rounded edit-btn mr-2" data-id="{{ $service->id }}" data-title="{{ $service->name ?? $service->title ?? '' }}" data-time="{{ $service->time ?? $service->day ?? '' }}" data-schedule="{{ $service->schedule ?? '' }}" data-location="{{ $service->location ?? '' }}" data-description="{{ $service->description ?? '' }}">Edit</button>
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
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Address</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Phone Number</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Service</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Registered On</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($serviceRegistrations ?? [] as $reg)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700 font-semibold">{{ $reg-> full_name ?? $reg->name ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->email ?? '' }}</td>
                            <th class="px-4 py-3 text-sm text-gray-700">{{ $reg->address ?? ''}}</th>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->phone_number??  ''}}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->service ?? ($reg->service_name ?? '') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->registered_on ?? (optional($reg->created_at)->format('Y-m-d') ?? '') }}</td>
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
            <div class="mt-4 flex justify-end gap-3">
                <button type="button" id="cancelEdit" class="px-4 py-2 border rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
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
    cancelEdit.addEventListener('click', () => { editModal.classList.add('hidden'); editModal.classList.remove('flex'); });

    editForm.addEventListener('submit', (e) => {
        e.preventDefault();
        editForm.submit();
    });
</script>
@endsection
