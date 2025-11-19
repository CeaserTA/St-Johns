@extends('layouts.dashboard_layout')

@section('title', 'Events')
@section('header_title', 'Events')

@section('content')
@php
    // Events are provided by the controller/route as a collection: $events
    // Each $event should be an Eloquent model (use properties below).
@endphp

<!-- Events Table Section (rendered within dashboard layout) -->
<div class="max-w-full mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold">Manage Events</h2>
        <button id="addEventBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">+ Add Event</button>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Title</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Date</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Time</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Location</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Description</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($events as $event)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700 font-semibold">{{ $event->title ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $event->date ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $event->time ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $event->location ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $event->description ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <button class="px-3 py-1 bg-yellow-500 text-white rounded edit-btn mr-2" data-id="{{ $event->id }}" data-title="{{ $event->title ?? '' }}" data-date="{{ $event->date ?? '' }}" data-time="{{ $event->time ?? '' }}" data-location="{{ $event->location ?? '' }}" data-description="{{ $event->description ?? '' }}">Edit</button>
                                <form method="POST" action="{{ route('admin.events.destroy', $event->id) }}" style="display:inline;">
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

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-xl">
        <h3 class="text-xl font-bold mb-4" id="modalTitle">Edit Event</h3>
        <form id="editForm" method="POST">
            @csrf
            <div id="methodField"></div>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input name="title" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <input name="date" type="date" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Time</label>
                        <input name="time" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Location</label>
                    <input name="location" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
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
    const addEventBtn = document.getElementById('addEventBtn');
    const editBtns = document.querySelectorAll('.edit-btn');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const cancelEdit = document.getElementById('cancelEdit');
    const modalTitle = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    let currentEventId = null;
    let isAddingNew = false;

    function openModalWithData(btn) {
        isAddingNew = false;
        currentEventId = btn.dataset.id;
        modalTitle.textContent = 'Edit Event';
        const title = btn.dataset.title || '';
        const date = btn.dataset.date || '';
        const time = btn.dataset.time || '';
        const location = btn.dataset.location || '';
        const description = btn.dataset.description || '';

        editForm.elements['title'].value = title;
        editForm.elements['date'].value = date;
        editForm.elements['time'].value = time;
        editForm.elements['location'].value = location;
        editForm.elements['description'].value = description;

        editForm.action = `/admin/events/${currentEventId}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
    }

    function openAddModal() {
        isAddingNew = true;
        currentEventId = null;
        modalTitle.textContent = 'Add New Event';
        editForm.reset();
        editForm.action = '/admin/events';
        methodField.innerHTML = '';

        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
    }

    addEventBtn.addEventListener('click', openAddModal);
    editBtns.forEach(b => b.addEventListener('click', (e) => { openModalWithData(e.currentTarget); }));
    cancelEdit.addEventListener('click', () => { editModal.classList.add('hidden'); editModal.classList.remove('flex'); });

    editForm.addEventListener('submit', (e) => {
        e.preventDefault();
        editForm.submit();
    });
</script>
@endsection
