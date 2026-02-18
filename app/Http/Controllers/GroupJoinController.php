<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupJoinController extends Controller
{
    /**
     * Apply authentication middleware to all methods.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Join a group (auth required).
     * Uses the authenticated user's linked Member record.
     * Returns JSON response for AJAX handling.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'group' => 'required|string|max:255',
        ]);

        $member = Auth::user()?->member;
        if (! $member) {
            return response()->json([
                'success' => false,
                'message' => 'You need to complete church member registration before joining a group. Please contact the church office.'
            ], 403);
        }

        $group = Group::where('name', $data['group'])->first();
        if (! $group) {
            return response()->json([
                'success' => false,
                'message' => 'Group not found.'
            ], 404);
        }

        // Prevent duplicate memberships
        $group->members()->syncWithoutDetaching([$member->id]);

        return response()->json([
            'success' => true,
            'message' => 'You have been added to the group: ' . $group->name,
            'group_id' => $group->id,
            'group_name' => $group->name
        ]);
    }
}

