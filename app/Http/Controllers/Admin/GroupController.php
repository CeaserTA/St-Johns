<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::orderBy('name')->get();
        return view('admin.groups_dashboard', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'meeting_day' => 'required|string|max:50',
            'meeting_time' => 'required|string|max:50',
        ]);

        Group::create($validated);

        return redirect()->route('admin.groups')->with('success', 'Group created successfully.');
    }

    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'meeting_day' => 'required|string|max:50',
            'meeting_time' => 'required|string|max:50',
        ]);

        $group->update($validated);

        return redirect()->route('admin.groups')->with('success', 'Group updated successfully.');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('admin.groups')->with('success', 'Group deleted successfully.');
    }
}
