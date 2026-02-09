@extends('layouts.dashboard_layout')

@section('title', 'Events & Announcements')
@section('header_title', 'Events & Announcements Manager')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

<style>
.material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    display: inline-block;
    vertical-align: middle;
}
.filled-icon {
    font-variation-settings: 'FILL' 1;
}
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 32px;
    height: 16px;
}
.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #cbd5e1;
    transition: .3s;
    border-radius: 16px;
}
.toggle-slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 0;
    bottom: 0;
    background-color: white;
    transition: .3s;
    border-radius: 50%;
    border: 2px solid #cbd5e1;
}
input:checked + .toggle-slider {
    background-color: #0d59f2;
}
input:checked + .toggle-slider:before {
    transform: translateX(16px);
    border-color: #0d59f2;
}

</style>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-lg">
                <span class="material-symbols-outlined">campaign</span>
            </span>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Active</p>
        <p class="text-2xl font-bold mt-1">{{ $stats['active'] ?? 0 }}</p>
    </div>

    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="p-2 bg-purple-100 dark:bg-purple-900/30 text-purple-600 rounded-lg">
                <span class="material-symbols-outlined">event_upcoming</span>
            </span>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Upcoming Events</p>
        <p class="text-2xl font-bold mt-1">{{ $stats['upcoming'] ?? 0 }}</p>
    </div>

    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="p-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 rounded-lg">
                <span class="material-symbols-outlined filled-icon">grade</span>
            </span>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Pinned Items</p>
        <p class="text-2xl font-bold mt-1">{{ $stats['pinned'] ?? 0 }}</p>
    </div>

    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="p-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-lg">
                <span class="material-symbols-outlined">event</span>
            </span>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Items</p>
        <p class="text-2xl font-bold mt-1">{{ $stats['total'] ?? 0 }}</p>
    </div>
</div>


<!-- Filters & Table Section -->
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col">
    <!-- Table Header/Filters -->
    <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center bg-slate-100 dark:bg-slate-800 p-1 rounded-lg">
            <a href="{{ route('admin.events') }}" class="px-6 py-1.5 {{ !request('type') ? 'bg-white dark:bg-slate-700 shadow-sm' : '' }} rounded-md text-sm font-bold {{ !request('type') ? 'text-primary' : 'text-slate-500 hover:text-slate-700' }} transition-all">
                All
            </a>
            <a href="{{ route('admin.events', ['type' => 'event']) }}" class="px-6 py-1.5 {{ request('type') === 'event' ? 'bg-white dark:bg-slate-700 shadow-sm' : '' }} rounded-md text-sm font-bold {{ request('type') === 'event' ? 'text-primary' : 'text-slate-500 hover:text-slate-700' }} transition-all">
                Events
            </a>
            <a href="{{ route('admin.events', ['type' => 'announcement']) }}" class="px-6 py-1.5 {{ request('type') === 'announcement' ? 'bg-white dark:bg-slate-700 shadow-sm' : '' }} rounded-md text-sm font-bold {{ request('type') === 'announcement' ? 'text-primary' : 'text-slate-500 hover:text-slate-700' }} transition-all">
                Announcements
            </a>
        </div>

        <div class="flex items-center gap-3">
            <div class="relative">
                <select id="categoryFilter" class="appearance-none bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg pl-4 pr-10 py-2 text-sm focus:ring-primary focus:border-primary">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\Event::getCategories() as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
            </div>

            <div class="relative">
                <select id="statusFilter" class="appearance-none bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg pl-4 pr-10 py-2 text-sm focus:ring-primary focus:border-primary">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="pinned" {{ request('status') === 'pinned' ? 'selected' : '' }}>Pinned</option>
                    <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="past" {{ request('status') === 'past' ? 'selected' : '' }}>Past</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
            </div>

            <button id="addNewBtn" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold shadow-md shadow-primary/20 hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-xl">add</span>
                Create New
            </button>
        </div>
    </div>


    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200 dark:border-slate-800">Title</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200 dark:border-slate-800">Type</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200 dark:border-slate-800">Category</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200 dark:border-slate-800">Date/Time</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200 dark:border-slate-800 text-center">Pinned</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200 dark:border-slate-800">Status</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200 dark:border-slate-800 text-right w-48">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                @forelse($events as $event)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            @if($event->image_url)
                            <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                                <img class="w-full h-full object-cover" src="{{ $event->image_url }}" alt="{{ $event->title }}"/>
                            </div>
                            @else
                            <div class="w-10 h-10 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                                <span class="material-symbols-outlined">{{ $event->is_event ? 'event' : 'campaign' }}</span>
                            </div>
                            @endif
                            <div>
                                <p class="text-sm font-semibold">{{ $event->title }}</p>
                                <p class="text-xs text-slate-500">{{ $event->location ?? 'No location' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $event->is_event ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                            {{ strtoupper($event->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">
                        {{ $event->category ?? 'General' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="text-xs font-medium">{{ $event->formatted_date ?? 'N/A' }}</p>
                        @if($event->expires_at)
                        <p class="text-[10px] text-slate-400">Expires: {{ $event->expires_at->format('M d, Y') }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <button class="toggle-pin-btn" data-id="{{ $event->id }}" data-pinned="{{ $event->is_pinned ? 'true' : 'false' }}">
                            <span class="material-symbols-outlined {{ $event->is_pinned ? 'text-yellow-500 filled-icon' : 'text-slate-300 dark:text-slate-700' }} cursor-pointer hover:text-yellow-500 transition-colors">grade</span>
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <label class="toggle-switch">
                                <input type="checkbox" class="toggle-active-btn" data-id="{{ $event->id }}" {{ $event->is_active ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="status-text text-[11px] font-bold {{ $event->is_active ? 'text-slate-500' : 'text-slate-400' }}" data-id="{{ $event->id }}">
                                {{ $event->is_active ? 'Live' : 'Draft' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="edit-btn flex items-center gap-1 px-3 py-1.5 text-slate-600 hover:text-primary hover:bg-primary/10 rounded-md text-sm font-medium transition-colors" data-id="{{ $event->id }}">
                                <span class="material-symbols-outlined text-lg">edit</span>
                                <span>Edit</span>
                            </button>
                            <button class="delete-btn flex items-center gap-1 px-3 py-1.5 text-slate-600 hover:text-red-500 hover:bg-red-50 rounded-md text-sm font-medium transition-colors" data-id="{{ $event->id }}">
                                <span class="material-symbols-outlined text-lg">delete</span>
                                <span>Delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                        <span class="material-symbols-outlined text-4xl mb-2 block">event_busy</span>
                        <p class="text-sm">No events or announcements found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<!-- Create/Edit Modal -->
<div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-slate-900 rounded-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold" id="modalTitle">Create New Event</h3>
            <button id="closeModal" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="eventForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="methodField"></div>

            <div class="space-y-4">
                <!-- Type Selection -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Type</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="event" checked class="text-primary focus:ring-primary">
                            <span class="text-sm">Event</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="announcement" class="text-primary focus:ring-primary">
                            <span class="text-sm">Announcement</span>
                        </label>
                    </div>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Title *</label>
                    <input type="text" name="title" required class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary dark:bg-slate-800">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Category</label>
                    <select name="category" class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary dark:bg-slate-800">
                        <option value="">Select Category</option>
                        @foreach(\App\Models\Event::getCategories() as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary dark:bg-slate-800"></textarea>
                </div>

                <!-- Event-specific fields -->
                <div id="eventFields" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Date</label>
                            <input type="date" name="date" class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary dark:bg-slate-800">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Time</label>
                            <input type="time" name="time" class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary dark:bg-slate-800">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Location</label>
                        <input type="text" name="location" class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary dark:bg-slate-800">
                    </div>
                </div>

                <!-- Announcement-specific fields -->
                <div id="announcementFields" class="space-y-4 hidden">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Content</label>
                        <textarea name="content" rows="5" class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary dark:bg-slate-800"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Expires At</label>
                        <input type="datetime-local" name="expires_at" class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary dark:bg-slate-800">
                    </div>
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Image <span class="text-xs text-slate-500">(Optional, max 5MB)</span>
                    </label>
                    <input type="file" name="image" accept="image/*" class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary dark:bg-slate-800">
                    <p class="text-xs text-slate-500 mt-1">Supported formats: JPEG, PNG, JPG, GIF, WEBP</p>
                </div>

                <!-- Checkboxes -->
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="text-primary focus:ring-primary">
                        <span class="text-sm">Active</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_pinned" value="1" class="text-primary focus:ring-primary">
                        <span class="text-sm">Pinned</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="cancelBtn" class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-primary/90 transition-colors">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('eventModal');
    const modalTitle = document.getElementById('modalTitle');
    const eventForm = document.getElementById('eventForm');
    const methodField = document.getElementById('methodField');
    const addNewBtn = document.getElementById('addNewBtn');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const eventFields = document.getElementById('eventFields');
    const announcementFields = document.getElementById('announcementFields');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');

    // Toggle type-specific fields
    function toggleFields() {
        const selectedType = document.querySelector('input[name="type"]:checked').value;
        if (selectedType === 'event') {
            eventFields.classList.remove('hidden');
            announcementFields.classList.add('hidden');
        } else {
            eventFields.classList.add('hidden');
            announcementFields.classList.remove('hidden');
        }
    }

    typeRadios.forEach(radio => {
        radio.addEventListener('change', toggleFields);
    });

    // Open modal for new item
    addNewBtn.addEventListener('click', function() {
        modalTitle.textContent = 'Create New Event/Announcement';
        eventForm.reset();
        eventForm.action = '{{ route("admin.events.store") }}';
        methodField.innerHTML = '';
        toggleFields();
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });

    // Close modal
    function closeModalFunc() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    closeModal.addEventListener('click', closeModalFunc);
    cancelBtn.addEventListener('click', closeModalFunc);

    // Edit buttons
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const id = this.dataset.id;
            
            try {
                const response = await fetch(`/admin/events/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    const event = data.event;
                    
                    modalTitle.textContent = 'Edit ' + (event.type === 'event' ? 'Event' : 'Announcement');
                    eventForm.action = `/admin/events/${id}`;
                    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                    
                    // Fill form
                    eventForm.querySelector('[name="title"]').value = event.title || '';
                    eventForm.querySelector('[name="category"]').value = event.category || '';
                    eventForm.querySelector('[name="description"]').value = event.description || '';
                    eventForm.querySelector(`[name="type"][value="${event.type}"]`).checked = true;
                    
                    if (event.type === 'event') {
                        eventForm.querySelector('[name="date"]').value = event.date || '';
                        eventForm.querySelector('[name="time"]').value = event.time || '';
                        eventForm.querySelector('[name="location"]').value = event.location || '';
                    } else {
                        eventForm.querySelector('[name="content"]').value = event.content || '';
                        if (event.expires_at) {
                            eventForm.querySelector('[name="expires_at"]').value = event.expires_at;
                        }
                    }
                    
                    eventForm.querySelector('[name="is_active"]').checked = event.is_active;
                    eventForm.querySelector('[name="is_pinned"]').checked = event.is_pinned;
                    
                    toggleFields();
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }
            } catch (error) {
                console.error('Error fetching event:', error);
                alert('Error loading event data');
            }
        });
    });

    // Delete buttons
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this item?')) {
                const id = this.dataset.id;
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/events/${id}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // Toggle pin
    document.querySelectorAll('.toggle-pin-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const id = this.dataset.id;
            
            try {
                const response = await fetch(`/admin/events/${id}/toggle-pin`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const icon = this.querySelector('.material-symbols-outlined');
                    if (data.is_pinned) {
                        icon.classList.add('text-yellow-500', 'filled-icon');
                        icon.classList.remove('text-slate-300', 'dark:text-slate-700');
                    } else {
                        icon.classList.remove('text-yellow-500', 'filled-icon');
                        icon.classList.add('text-slate-300', 'dark:text-slate-700');
                    }
                }
            } catch (error) {
                console.error('Error toggling pin:', error);
            }
        });
    });

    // Toggle active
    document.querySelectorAll('.toggle-active-btn').forEach(checkbox => {
        checkbox.addEventListener('change', async function() {
            const id = this.dataset.id;
            
            try {
                const response = await fetch(`/admin/events/${id}/toggle-active`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update status text
                    const statusText = document.querySelector(`.status-text[data-id="${id}"]`);
                    if (statusText) {
                        statusText.textContent = data.is_active ? 'Live' : 'Draft';
                        statusText.className = `status-text text-[11px] font-bold ${data.is_active ? 'text-slate-500' : 'text-slate-400'}`;
                    }
                }
            } catch (error) {
                console.error('Error toggling active:', error);
                this.checked = !this.checked; // Revert on error
            }
        });
    });

    // Filters
    categoryFilter.addEventListener('change', function() {
        const url = new URL(window.location.href);
        if (this.value) {
            url.searchParams.set('category', this.value);
        } else {
            url.searchParams.delete('category');
        }
        window.location.href = url.toString();
    });

    statusFilter.addEventListener('change', function() {
        const url = new URL(window.location.href);
        if (this.value) {
            url.searchParams.set('status', this.value);
        } else {
            url.searchParams.delete('status');
        }
        window.location.href = url.toString();
    });
});
</script>

@endsection
