@extends('layouts.dashboard_layout')

@section('title', 'Members')
@section('header_title', 'Members')

@section('content')
@php
    // Members collection provided by the route/controller
@endphp

<div class="max-w-full mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold">Manage Members</h2>
        <button id="addMemberBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">+ Add Member</button>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Full Name</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Gender</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">DOB</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Marital Status</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Phone</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Email</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Cell</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Joined</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($members as $m)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700 font-semibold">{{ $m->full_name ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ ucfirst($m->gender ?? '') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ optional($m->date_of_birth)->format('Y-m-d') ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ ucfirst($m->marital_status ?? '') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $m->phone ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $m->email ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ ucfirst($m->cell ?? '') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ optional($m->date_joined)->format('Y-m-d') ?? optional($m->created_at)->format('Y-m-d') ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <a href="{{ route('members.edit', $m->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded mr-2">Edit</a>
                                <form method="POST" action="{{ route('members.destroy', $m->id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-3 text-center text-gray-500">No members registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-xl">
        <h3 class="text-xl font-bold mb-4" id="modalTitle">Edit Member</h3>
        <form id="editForm">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input name="full_name" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input name="email" type="email" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input name="phone" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-3">
                <button type="button" id="cancelEdit" class="px-4 py-2 border rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save (simulated)</button>
            </div>
        </form>
    </div>
</div>

<script>
    const addMemberBtn = document.getElementById('addMemberBtn');
    const editBtns = document.querySelectorAll('.edit-btn');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const cancelEdit = document.getElementById('cancelEdit');
    const modalTitle = document.getElementById('modalTitle');
    let isAddingNew = false;

    function openModalWithData(btn) {
        isAddingNew = false;
        modalTitle.textContent = 'Edit Member';
        const name = btn.dataset.name || '';
        const email = btn.dataset.email || '';
        const phone = btn.dataset.phone || '';
        const status = btn.dataset.status || '';
        const joined = btn.dataset.joined || '';

        editForm.elements['full_name'].value = name;
        editForm.elements['email'].value = email;
        editForm.elements['phone'].value = phone;
        editForm.elements['status'].value = status;

        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
    }

    function openAddModal() {
        isAddingNew = true;
        modalTitle.textContent = 'Add New Member';
        editForm.reset();
        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
    }

    addMemberBtn.addEventListener('click', openAddModal);
    editBtns.forEach(b => b.addEventListener('click', (e) => { openModalWithData(e.currentTarget); }));
    cancelEdit.addEventListener('click', () => { editModal.classList.add('hidden'); editModal.classList.remove('flex'); });

    editForm.addEventListener('submit', (e) => {
        e.preventDefault();
        if (isAddingNew) {
            alert('New member added (simulated). This is a client-side demo; no DB changes are made.');
        } else {
            alert('Changes saved (simulated). This is a client-side demo; no DB changes are made.');
        }
        editModal.classList.add('hidden'); editModal.classList.remove('flex');
    });
</script>
@endsection
