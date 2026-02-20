<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use App\Notifications\MemberJoinedGroup;

class GroupJoinController extends Controller
{
    /**
     * Apply authentication middleware to all methods.
     */
    public function __construct()
    {
        if (method_exists($this, 'middleware')) {
            $this->middleware('auth');
        }
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

        // Send notification to admins
        try {
            $notificationService = app(NotificationService::class);
            $notificationService->notifyAdmins(new MemberJoinedGroup($member, $group));
        } catch (\Exception $e) {
            \Log::error('Failed to send group join notification', [
                'member_id' => $member->id,
                'group_id' => $group->id,
                'error' => $e->getMessage()
            ]);
            // Don't fail group join if notification fails
        }

        return response()->json([
            'success' => true,
            'message' => 'You have been added to the group: ' . $group->name,
            'group_id' => $group->id,
            'group_name' => $group->name
        ]);
    }
}

