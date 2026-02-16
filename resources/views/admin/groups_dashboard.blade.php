@extends('layouts.dashboard_layout')

@section('title', 'Groups')
@section('header_title', 'Groups')

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

    <div class="bg-white p-2 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Name</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Meeting Day</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Location</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Description</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Members</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($groups as $group)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700 font-semibold">{{ $group->name ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $group->meeting_day ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $group->location ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $group->description ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <button class="text-blue-600 hover:text-blue-800 font-semibold toggle-members" data-group-id="{{ $group->id }}">
                                    {{ $group->members->count() }} members
                                </button>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <button class="px-3 py-1 bg-yellow-500 text-white rounded edit-btn mr-2" 
                                        data-id="{{ $group->id }}" 
                                        data-name="{{ $group->name ?? '' }}" 
                                        data-meeting-day="{{ $group->meeting_day ?? '' }}" 
                                        data-location="{{ $group->location ?? '' }}" 
                                        data-description="{{ $group->description ?? '' }}">
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('admin.groups.destroy', $group->id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded delete-btn" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <!-- Members Row (Hidden by default) -->
                        <tr id="members-row-{{ $group->id }}" class="hidden">
                            <td colspan="6" class="px-4 py-4">
                                <div class="bg-gray-50 p-4 rounded">
                                    <h4 class="font-semibold text-gray-800 mb-3">Members of {{ $group->name }}</h4>
                                    
                                    @if($group->members->isEmpty())
                                        <p class="text-gray-400 text-sm mb-4">No members yet.</p>
                                    @else
                                        <div class="overflow-x-auto mb-4">
                                            <table class="min-w-full text-left text-sm divide-y divide-gray-300">
                                                <thead class="bg-gray-200">
                                                    <tr>
                                                        <th class="px-3 py-2 font-medium text-gray-700">Name</th>
                                                        <th class="px-3 py-2 font-medium text-gray-700">Email</th>
                                                        <th class="px-3 py-2 font-medium text-gray-700">Phone</th>
                                                        <th class="px-3 py-2 font-medium text-gray-700">Cell</th>
                                                        <th class="px-3 py-2 font-medium text-gray-700">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-300">
                                                    @foreach($group->members as $member)
                                                        <tr>
                                                            <td class="px-3 py-2 text-gray-800">{{ $member->full_name }}</td>
                                                            <td class="px-3 py-2 text-gray-600">{{ $member->email }}</td>
                                                            <td class="px-3 py-2 text-gray-600">{{ $member->phone ?? 'N/A' }}</td>
                                                            <td class="px-3 py-2 text-gray-600">{{ ucfirst($member->cell ?? 'N/A') }}</td>
                                                            <td class="px-3 py-2">
                                                                <form method="POST" action="{{ route('admin.groups.members.destroy', [$group->id, $member->id]) }}" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold" onclick="return confirm('Remove from group?')">
                                                                        Remove
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    <!-- Add Member to Group -->
                                    <div class="border-t pt-3">
                                        <form method="POST" action="{{ route('admin.groups.members.store', $group->id) }}" class="flex gap-2">
                                            @csrf
                                            <select name="member_id" class="flex-1 px-3 py-2 border border-gray-300 rounded text-sm" required>
                                                <option value="">Select a member to add...</option>
                                                @foreach($members as $m)
                                                    @if(!$group->members->contains($m->id))
                                                        <option value="{{ $m->id }}">{{ $m->fullname }} ({{ $m->email }})</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                                                Add Member
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit/Create Group Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-xl">
        <h3 class="text-xl font-bold mb-4" id="modalTitle">Add Group</h3>
        <form id="editForm" method="POST">
            @csrf
            <div id="methodField"></div>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                    <input name="name" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" required />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Meeting Day</label>
                        <input name="meeting_day" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="e.g., Monday 7pm" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Location</label>
                        <input name="location" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="e.g., Church Hall" />
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
    const addGroupBtn = document.getElementById('addGroupBtn');
    const editBtns = document.querySelectorAll('.edit-btn');
    const toggleMembersBtns = document.querySelectorAll('.toggle-members');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const cancelEdit = document.getElementById('cancelEdit');
    const modalTitle = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    let currentGroupId = null;
    let isAddingNew = false;

    // Toggle members visibility
    toggleMembersBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const groupId = this.dataset.groupId;
            const membersRow = document.getElementById(`members-row-${groupId}`);
            membersRow.classList.toggle('hidden');
        });
    });

    function openModalWithData(btn) {
        isAddingNew = false;
        currentGroupId = btn.dataset.id;
        modalTitle.textContent = 'Edit Group';
        const name = btn.dataset.name || '';
        const meetingDay = btn.dataset.meetingDay || '';
        const location = btn.dataset.location || '';
        const description = btn.dataset.description || '';

        editForm.elements['name'].value = name;
        editForm.elements['meeting_day'].value = meetingDay;
        editForm.elements['location'].value = location;
        editForm.elements['description'].value = description;

        editForm.action = `/admin/groups/${currentGroupId}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
    }

    function openAddModal() {
        isAddingNew = true;
        currentGroupId = null;
        modalTitle.textContent = 'Add New Group';
        editForm.reset();
        editForm.action = '/admin/groups';
        methodField.innerHTML = '';

        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
    }

    addGroupBtn.addEventListener('click', openAddModal);
    editBtns.forEach(b => b.addEventListener('click', (e) => { openModalWithData(e.currentTarget); }));
    cancelEdit.addEventListener('click', () => { editModal.classList.add('hidden'); editModal.classList.remove('flex'); });

    editForm.addEventListener('submit', (e) => {
        e.preventDefault();
        editForm.submit();
    });
</script>
@endsection
@extends('layouts.dashboard_layout')

@section('title', 'Groups')
@section('header_title', 'Groups')

@section('content')

<div class="max-w-full mx-auto">
    <!-- Create Group Form -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-2xl font-semibold mb-4">Create New Group</h2>
        <form action="{{ route('admin.groups.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Group Name</label>
                <input type="text" name="name" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Fathers Union">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Day</label>
                <input type="text" name="meeting_day" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Sunday">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Describe the group..."></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                <input type="text" name="location" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Optional: Meeting location">
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Create Group</button>
            </div>
        </form>
    </div>

    <!-- Groups & Members Table -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-4">Groups & Members</h2>
        
        @if($groups->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full text-left divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-sm font-medium text-gray-700">Group Name</th>
                            <th class="px-4 py-3 text-sm font-medium text-gray-700">Description</th>
                            <th class="px-4 py-3 text-sm font-medium text-gray-700">Meeting Day</th>
                            <th class="px-4 py-3 text-sm font-medium text-gray-700">Location</th>
                            <th class="px-4 py-3 text-sm font-medium text-gray-700">Members</th>
                            <th class="px-4 py-3 text-sm font-medium text-gray-700">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($groups as $group)
                            <tr>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $group->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ \Illuminate\Support\Str::limit($group->description, 50) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $group->meeting_day }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $group->location ?? '—' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 font-medium">{{ $group->members->count() }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <button type="button" class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700" onclick="toggleMembers({{ $group->id }})">View</button>
                                </td>
                            </tr>
                            <!-- Members Detail Row -->
                            <tr id="members-row-{{ $group->id }}" class="hidden bg-gray-50">
                                <td colspan="6" class="px-4 py-4">
                                    <div class="space-y-4">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-2">Add Member to Group</h4>
                                            <form method="POST" action="{{ route('admin.groups.members.store', $group->id) }}" class="flex gap-2">
                                                @csrf
                                                <select name="member_id" class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                                    <option value="">-- Select a member --</option>
                                                    @foreach($members as $member)
                                                        @if(!$group->members->contains($member->id))
                                                            <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded text-sm hover:bg-green-700">Add</button>
                                            </form>
                                        </div>
                                        
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-2">Current Members ({{ $group->members->count() }})</h4>
                                            @if($group->members->count() > 0)
                                                <div class="space-y-2">
                                                    @foreach($group->members as $member)
                                                        <div class="flex items-center justify-between bg-white p-3 rounded border border-gray-200">
                                                            <div>
                                                                <div class="text-sm text-gray-900 font-medium">{{ $member->full_name }}</div>
                                                                <div class="text-xs text-gray-500">Joined: {{ optional($member->pivot->created_at)->format('Y-m-d H:i') }}</div>
                                                            </div>
                                                            <form method="POST" action="{{ route('admin.groups.members.destroy', [$group->id, $member->id]) }}" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700" onclick="return confirm('Remove this member from the group?')">Remove</button>
                                                            </form>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-sm text-gray-600">No members in this group yet.</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600 text-center py-8">No groups created yet. Create one above to get started.</p>
        @endif
    </div>
</div>

<!-- Group Memberships Table: list every joined member per group -->
<div class="bg-white p-6 rounded-lg shadow mt-8">
    <h2 class="text-2xl font-semibold mb-4">Group Memberships</h2>

    @if($groups->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full text-left divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Group</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Member</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Email</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Phone</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Joined At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @php $hasMembers = false; @endphp
                    @foreach($groups as $group)
                        @foreach($group->members as $member)
                            @php $hasMembers = true; @endphp
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700 font-semibold">{{ $group->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $member->full_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $member->email ?? '—' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $member->phone ?? '—' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ optional($member->pivot->created_at)->format('Y-m-d H:i') ?? '—' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            @if(!$hasMembers)
                <p class="text-gray-600 text-center py-8">No members have joined any groups yet.</p>
            @endif
        </div>
    @else
        <p class="text-gray-600 text-center py-8">No groups created yet.</p>
    @endif
</div>

<script>
    function toggleMembers(id) {
        const row = document.getElementById('members-row-' + id);
        if (row) {
            row.classList.toggle('hidden');
        }
    }
</script>
</div>

@endsection
