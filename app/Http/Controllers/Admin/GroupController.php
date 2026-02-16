<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $query = Group::with('members');

        // Search functionality
        if ($request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('location', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('meeting_day', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter by meeting day
        if ($request->meeting_day && $request->meeting_day !== 'all') {
            $query->where('meeting_day', $request->meeting_day);
        }

        // Sorting
        $sortBy = $request->sort_by ?? 'name';
        $sortOrder = $request->sort_order ?? 'asc';
        
        if (in_array($sortBy, ['name', 'meeting_day', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('name', 'asc');
        }

        $groups = $query->get();
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
