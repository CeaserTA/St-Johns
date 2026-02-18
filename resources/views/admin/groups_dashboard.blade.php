@extends('layouts.dashboard_layout')

@section('title', 'Groups Management')
@section('header_title', 'Groups Management')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m0-4a4 4 0 110-8 4 4 0 010 8z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Groups</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_groups'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Members in Groups</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_members_in_groups'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Average Group Size</p>
                    <p class="text-2xl font-bold text-gray-900">{{ round($stats['average_group_size'] ?? 0, 1) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Search & Filter Groups</h2>
        <form method="GET" action="{{ route('admin.groups') }}" class="space-y-4">
            <!-- Search Bar -->
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Search by name, description, location, or meeting day..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-200">
                        🔍 Search
                    </button>
                </div>
            </div>

            <!-- Filters Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="meeting_day" class="block text-sm font-medium text-gray-700 mb-1">Meeting Day</label>
                    <select name="meeting_day" id="meeting_day" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Days</option>
                        @foreach($filterOptions['meeting_days'] as $day)
                            <option value="{{ $day }}" {{ request('meeting_day') == $day ? 'selected' : '' }}>
                                {{ ucfirst($day) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <a href="{{ route('admin.groups') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-center transition duration-200">
                        Reset Filters
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Manage Groups Section -->
    <div class="max-w-full mx-auto">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-semibold">Manage Groups</h2>
            <button id="addGroupBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">+ Add Group</button>
        </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
            <p class="font-bold">Validation Errors</p>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($groups->count() > 0)
        <!-- Search and Filter Bar -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-4 flex items-center gap-4">
            <div class="flex-1">
                <input type="text" 
                       id="searchGroups" 
                       placeholder="Search groups by name..." 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            <div class="w-48">
                <select id="statusFilter" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="all">All Groups</option>
                    <option value="active">Active Only</option>
                    <option value="inactive">Inactive Only</option>
                </select>
            </div>
        </div>

        <!-- Groups Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Group Name
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Description
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Meeting Info
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Members
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($groups as $group)
                            <tr class="group-row hover:bg-gray-50 transition" 
                                data-group-name="{{ strtolower($group->name) }}"
                                data-status="{{ $group->is_active ? 'active' : 'inactive' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($group->image_url)
                                            <img src="{{ $group->image_url }}" alt="{{ $group->name }}" class="w-10 h-10 rounded-lg object-cover">
                                        @elseif($group->icon)
                                            <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                                <span class="material-symbols-outlined text-primary text-xl">{{ $group->icon }}</span>
                                            </div>
                                        @else
                                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <span class="material-symbols-outlined text-gray-400 text-xl">group</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $group->name }}</div>
                                            @if($group->category)
                                                <div class="text-xs text-gray-500">{{ $group->category }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-700 max-w-xs">
                                        {{ Str::limit($group->description, 80) ?: '—' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 space-y-1">
                                        @if($group->meeting_day)
                                            <div class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-xs">schedule</span>
                                                {{ $group->meeting_day }}
                                            </div>
                                        @endif
                                        @if($group->location)
                                            <div class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-xs">location_on</span>
                                                {{ $group->location }}
                                            </div>
                                        @endif
                                        @if(!$group->meeting_day && !$group->location)
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <button class="toggle-members-btn text-blue-600 hover:text-blue-800 font-semibold text-sm flex items-center gap-1"
                                            data-group-id="{{ $group->id }}">
                                        <span class="material-symbols-outlined text-sm">people</span>
                                        {{ $group->members->count() }}
                                    </button>
                                </td>
                                <td class="px-6 py-4">
                                    @if($group->is_active)
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Active</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button class="edit-group-btn p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                                data-id="{{ $group->id }}"
                                                data-name="{{ $group->name }}"
                                                data-description="{{ $group->description }}"
                                                data-meeting-day="{{ $group->meeting_day }}"
                                                data-location="{{ $group->location }}"
                                                data-is-active="{{ $group->is_active ? '1' : '0' }}"
                                                data-sort-order="{{ $group->sort_order }}"
                                                data-icon="{{ $group->icon }}"
                                                data-image-url="{{ $group->image_url }}"
                                                data-category="{{ $group->category }}"
                                                title="Edit">
                                            <span class="material-symbols-outlined text-sm">edit</span>
                                        </button>
                                        <form method="POST" action="{{ route('admin.groups.destroy', $group->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                    onclick="return confirm(&quot;Delete {{ $group->name }}? This will remove all member associations.&quot;)"
                                                    title="Delete">
                                                <span class="material-symbols-outlined text-sm">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <span class="material-symbols-outlined text-gray-300 text-6xl mb-4">group</span>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Groups Yet</h3>
            <p class="text-gray-500 mb-6">Get started by creating your first group</p>
            <button id="addGroupBtnEmpty" 
                    class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-secondary shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center gap-2">
                <span class="material-symbols-outlined">add</span>
                Add First Group
            </button>
        </div>
    @endif
</div>

<!-- Add/Edit Group Modal -->
<div id="groupModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <h3 id="modalTitle" class="text-2xl font-bold text-gray-900">Add Group</h3>
        </div>
        <form id="groupForm" method="POST" action="{{ route('admin.groups.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="groupId" name="group_id">
            <input type="hidden" id="formMethod" name="_method" value="POST">
            
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Group Name *</label>
                    <input type="text" name="name" id="groupName" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="groupDescription" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Meeting Day</label>
                        <input type="text" name="meeting_day" id="groupMeetingDay"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary"
                               placeholder="e.g., Every Sunday">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                        <input type="text" name="location" id="groupLocation"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary"
                               placeholder="e.g., Main Hall">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                        <input type="text" name="category" id="groupCategory"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary"
                               placeholder="e.g., Fellowship, Ministry">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sort Order</label>
                        <input type="number" name="sort_order" id="groupSortOrder" min="0" value="0"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Icon (Material Symbol)</label>
                    <input type="text" name="icon" id="groupIcon"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary"
                           placeholder="e.g., group, church, volunteer_activism">
                    <p class="text-xs text-gray-500 mt-1">Browse icons at <a href="https://fonts.google.com/icons" target="_blank" class="text-blue-600 hover:underline">Google Material Symbols</a></p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Group Image</label>
                    <input type="file" name="image" id="groupImage" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary">
                    <p class="text-xs text-gray-500 mt-1">Upload an image for the group (optional)</p>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="groupIsActive" value="1" checked
                           class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                    <label for="groupIsActive" class="text-sm font-semibold text-gray-700">Active</label>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" id="cancelBtn"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition">
                    Save Group
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Members Modal -->
<div id="membersModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 id="membersModalTitle" class="text-2xl font-bold text-gray-900">Group Members</h3>
            <button id="closeMembersModal" class="text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6">
            <div id="membersContent" class="space-y-4">
                <!-- Members will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('groupModal');
    const membersModal = document.getElementById('membersModal');
    const form = document.getElementById('groupForm');
    const modalTitle = document.getElementById('modalTitle');
    const addGroupBtn = document.getElementById('addGroupBtn');
    const addGroupBtnEmpty = document.getElementById('addGroupBtnEmpty');
    const cancelBtn = document.getElementById('cancelBtn');
    const closeMembersModal = document.getElementById('closeMembersModal');
    const searchInput = document.getElementById('searchGroups');
    const statusFilter = document.getElementById('statusFilter');

    // Open modal for adding
    [addGroupBtn, addGroupBtnEmpty].forEach(btn => {
        if (btn) {
            btn.addEventListener('click', () => {
                modalTitle.textContent = 'Add Group';
                form.action = '{{ route("admin.groups.store") }}';
                document.getElementById('formMethod').value = 'POST';
                form.reset();
                document.getElementById('groupId').value = '';
                document.getElementById('groupIsActive').checked = true;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        }
    });

    // Open modal for editing
    document.querySelectorAll('.edit-group-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            modalTitle.textContent = 'Edit Group';
            form.action = `/admin/groups/${id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('groupId').value = id;
            document.getElementById('groupName').value = btn.dataset.name;
            document.getElementById('groupDescription').value = btn.dataset.description || '';
            document.getElementById('groupMeetingDay').value = btn.dataset.meetingDay || '';
            document.getElementById('groupLocation').value = btn.dataset.location || '';
            document.getElementById('groupCategory').value = btn.dataset.category || '';
            document.getElementById('groupSortOrder').value = btn.dataset.sortOrder || '0';
            document.getElementById('groupIcon').value = btn.dataset.icon || '';
            document.getElementById('groupIsActive').checked = btn.dataset.isActive === '1';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    // Close modal
    cancelBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    // Close modal on outside click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });

    // Toggle members modal
    document.querySelectorAll('.toggle-members-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const groupId = btn.dataset.groupId;
            const groupName = btn.closest('tr').querySelector('.font-semibold').textContent;
            document.getElementById('membersModalTitle').textContent = `${groupName} - Members`;
            
            try {
                const response = await fetch(`/admin/groups/${groupId}/members`);
                const data = await response.json();
                
                const membersContent = document.getElementById('membersContent');
                if (data.members.length === 0) {
                    membersContent.innerHTML = '<p class="text-gray-500 text-center py-8">No members in this group yet.</p>';
                } else {
                    membersContent.innerHTML = data.members.map(member => `
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                ${member.image_url ? 
                                    `<img src="${member.image_url}" alt="${member.full_name}" class="w-12 h-12 rounded-full object-cover">` :
                                    `<div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary">person</span>
                                    </div>`
                                }
                                <div>
                                    <div class="font-semibold text-gray-900">${member.full_name}</div>
                                    <div class="text-sm text-gray-500">${member.email || 'No email'}</div>
                                </div>
                            </div>
                            <form method="POST" action="/admin/groups/${groupId}/members/${member.id}/remove" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                        onclick="return confirm(&quot;Remove ${member.full_name} from this group?&quot;)"
                                        title="Remove from group">
                                    <span class="material-symbols-outlined text-sm">person_remove</span>
                                </button>
                            </form>
                        </div>
                    `).join('');
                }
                
                membersModal.classList.remove('hidden');
                membersModal.classList.add('flex');
            } catch (error) {
                console.error('Error loading members:', error);
                alert('Failed to load members');
            }
        });
    });

    // Close members modal
    closeMembersModal.addEventListener('click', () => {
        membersModal.classList.add('hidden');
        membersModal.classList.remove('flex');
    });

    membersModal.addEventListener('click', (e) => {
        if (e.target === membersModal) {
            membersModal.classList.add('hidden');
            membersModal.classList.remove('flex');
        }
    });

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', filterGroups);
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', filterGroups);
    }

    function filterGroups() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const statusValue = statusFilter ? statusFilter.value : 'all';
        const rows = document.querySelectorAll('.group-row');

        rows.forEach(row => {
            const name = row.dataset.groupName;
            const status = row.dataset.status;
            
            const matchesSearch = name.includes(searchTerm);
            const matchesStatus = statusValue === 'all' || status === statusValue;
            
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
});
</script>
</div>

@endsection
