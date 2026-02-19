<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function getMembers(Group $group)
    {
        $members = $group->members()->get()->map(function ($member) {
            return [
                'id' => $member->id,
                'full_name' => $member->full_name,
                'email' => $member->email,
                'phone' => $member->phone,
                'image_url' => $member->profile_image_url,
                'status' => $member->pivot->status,
                'approved_at' => $member->pivot->approved_at,
            ];
        });

        return response()->json(['members' => $members]);
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
            'category' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        // Handle image upload to Supabase
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            \Log::info('Processing group image upload', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
            ]);
            
            try {
                // Generate unique filename
                $filename = 'group_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Upload to Supabase
                $path = $file->storeAs('groups', $filename, 'supabase');
                $validated['image_url'] = $path;
                
                \Log::info('Group image uploaded to Supabase successfully', ['path' => $path]);
                
            } catch (\Exception $e) {
                \Log::error('Error uploading group image to Supabase', [
                    'error' => $e->getMessage(),
                ]);
                
                // Fall back to local storage if Supabase fails
                try {
                    $path = $file->store('groups', 'public');
                    $validated['image_url'] = $path;
                    \Log::info('Group image uploaded to local storage as fallback', ['path' => $path]);
                } catch (\Exception $localError) {
                    \Log::error('Both Supabase and local storage failed for group image');
                    unset($validated['image_url']);
                }
            }
        }

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
            'category' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? $group->sort_order);

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            \Log::info('Processing group image update', [
                'group_id' => $group->id,
                'original_name' => $file->getClientOriginalName(),
            ]);
            
            try {
                // Delete old image from Supabase if exists
                if ($group->image_url) {
                    try {
                        Storage::disk('supabase')->delete($group->image_url);
                        \Log::info('Old group image deleted from Supabase', ['path' => $group->image_url]);
                    } catch (\Exception $e) {
                        \Log::warning('Could not delete old group image from Supabase', [
                            'path' => $group->image_url,
                            'error' => $e->getMessage()
                        ]);
                        
                        // Try deleting from local storage as fallback
                        if (Storage::disk('public')->exists($group->image_url)) {
                            Storage::disk('public')->delete($group->image_url);
                        }
                    }
                }
                
                // Generate unique filename
                $filename = 'group_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Upload new image to Supabase
                $path = $file->storeAs('groups', $filename, 'supabase');
                $validated['image_url'] = $path;
                
                \Log::info('New group image uploaded to Supabase successfully', ['path' => $path]);
                
            } catch (\Exception $e) {
                \Log::error('Error uploading group image to Supabase', [
                    'error' => $e->getMessage(),
                ]);
                
                // Fall back to local storage
                try {
                    $path = $file->store('groups', 'public');
                    $validated['image_url'] = $path;
                    \Log::info('Group image uploaded to local storage as fallback', ['path' => $path]);
                } catch (\Exception $localError) {
                    \Log::error('Both Supabase and local storage failed for group image');
                    unset($validated['image_url']);
                }
            }
        }

        $group->update($validated);

        return redirect()->route('admin.groups')->with('success', 'Group updated successfully.');
    }

    public function addMember(Request $request, Group $group)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        // Add member with pending status
        $group->members()->syncWithoutDetaching([
            $data['member_id'] => [
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        return redirect()->route('admin.groups')->with('success', 'Member added to group (pending approval).');
    }

    public function approveMember(Request $request, Group $group, \App\Models\Member $member)
    {
        $group->members()->updateExistingPivot($member->id, [
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.groups')->with('success', 'Member approved successfully.');
    }

    public function rejectMember(Request $request, Group $group, \App\Models\Member $member)
    {
        $group->members()->updateExistingPivot($member->id, [
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.groups')->with('success', 'Member rejected.');
    }

    public function removeMember(Group $group, \App\Models\Member $member)
    {
        $group->members()->detach($member->id);
        return redirect()->route('admin.groups')->with('success', 'Member removed from group.');
    }

    public function destroy(Group $group)
    {
        // Delete image from Supabase if exists
        if ($group->image_url) {
            try {
                Storage::disk('supabase')->delete($group->image_url);
                \Log::info('Group image deleted from Supabase', ['path' => $group->image_url]);
            } catch (\Exception $e) {
                \Log::warning('Could not delete group image from Supabase', [
                    'path' => $group->image_url,
                    'error' => $e->getMessage()
                ]);
                
                // Try deleting from local storage as fallback
                if (Storage::disk('public')->exists($group->image_url)) {
                    Storage::disk('public')->delete($group->image_url);
                }
            }
        }
        
        $group->delete();
        return redirect()->route('admin.groups')->with('success', 'Group deleted successfully.');
    }
}
