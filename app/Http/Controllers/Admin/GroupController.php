<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $groups = Group::with('members')->ordered()->get();
        $members = \App\Models\Member::orderBy('full_name')->get();

        // Get filter options
        $filterOptions = [
            'meeting_days' => Group::select('meeting_day')->distinct()->whereNotNull('meeting_day')->pluck('meeting_day')->toArray(),
        ];

        // Get summary statistics
        $stats = [
            'total_groups' => Group::count(),
            'total_members_in_groups' => \App\Models\Member::whereHas('groups')->count(),
            'average_group_size' => Group::withCount('members')->get()->avg('members_count') ?? 0,
        ];

        return view('admin.groups_dashboard', compact('groups', 'members', 'filterOptions', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_day' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'icon' => 'nullable|string|max:50',
            'image_url' => 'nullable|url|max:500',
            'category' => 'nullable|string|max:50',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

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
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'icon' => 'nullable|string|max:50',
            'image_url' => 'nullable|url|max:500',
            'category' => 'nullable|string|max:50',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? $group->sort_order);

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
