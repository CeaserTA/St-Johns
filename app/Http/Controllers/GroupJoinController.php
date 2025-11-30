<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\Request;

class GroupJoinController extends Controller
{
    /**
     * Public: join a group by email (from the homepage modal).
     * Validates email and group name, ensures member exists, creates group if needed,
     * then attaches the member to the group.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'group' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $member = Member::where('email', $data['email'])->first();
        if (! $member) {
            return redirect()->back()->with('error', 'Member not found. Please register before joining a group.');
        }

        $group = Group::firstOrCreate([
            'name' => $data['group'],
        ], [
            'description' => null,
            'meeting_day' => null,
            'location' => null,
        ]);

        $group->members()->syncWithoutDetaching([$member->id]);

        return redirect()->back()->with('success', 'You have been added to the group: ' . $group->name);
    }

    /**
     * Optional: handle full join from modal when additional details provided.
     * This method is provided but not currently routed by default.
     */
    public function joinFromModal(Request $request)
    {
        $data = $request->validate([
            'group' => 'required',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|string|max:20',
        ]);

        $group = Group::where('name', $data['group'])->first();
        if (! $group) {
            return redirect()->back()->with('error', 'Selected group not found.');
        }

        $member = Member::firstOrCreate([
            'email' => $data['email'],
        ], [
            'fullname' => $data['full_name'],
            'phone' => $data['contact'],
            'dateOfBirth' => now()->subYears(18)->format('Y-m-d'),
            'gender' => 'male',
            'maritalStatus' => 'single',
            'address' => 'Not provided',
            'dateJoined' => now()->format('Y-m-d'),
            'cell' => 'north',
        ]);

        $group->members()->syncWithoutDetaching([$member->id]);

        return redirect()->back()->with('success', 'You have been added to the group: ' . $group->name);
    }
}

