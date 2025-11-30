<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::with('members')->orderBy('name')->get();
        $members = \App\Models\Member::orderBy('fullname')->get();
        return view('admin.groups_dashboard', compact('groups', 'members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_day' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:100',
        ]);

        Group::create($validated);

        return redirect()->route('admin.groups')->with('success', 'Group created successfully.');
    }

    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_day' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:100',
        ]);

        $group->update($validated);

        return redirect()->route('admin.groups')->with('success', 'Group updated successfully.');
    }

    public function addMember(Request $request, Group $group)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        $group->members()->syncWithoutDetaching([$data['member_id']]);

        return redirect()->route('admin.groups')->with('success', 'Member added to group.');
    }

    public function removeMember(Group $group, \App\Models\Member $member)
    {
        $group->members()->detach($member->id);
        return redirect()->route('admin.groups')->with('success', 'Member removed from group.');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('admin.groups')->with('success', 'Group deleted successfully.');
    }
}
