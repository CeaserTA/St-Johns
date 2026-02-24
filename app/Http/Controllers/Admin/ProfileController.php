<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the admin's profile page with statistics and activity history.
     */
    public function show(Request $request)
    {
        try {
            $admin = Auth::user();

            // Calculate statistics
            $stats = [
                'givings_approved_count' => $this->getGivingsApprovedCount($admin),
                'givings_approved_total' => $this->getGivingsApprovedTotal($admin),
                'service_registrations_approved_count' => $this->getServiceRegistrationsApprovedCount($admin),
                'group_approvals_count' => $this->getGroupApprovalsCount($admin),
                'events_created_count' => $this->getEventsCreatedCount($admin),
            ];

            // Get activity history (paginated)
            $activeTab = $request->get('tab', 'givings');
            
            $activityData = match($activeTab) {
                'givings' => $this->getGivingsApproved($admin),
                'registrations' => $this->getRegistrationsApproved($admin),
                'groups' => $this->getGroupApprovalsHistory($admin),
                'events' => $this->getEventsCreated($admin),
                default => $this->getGivingsApproved($admin),
            };

            return view('admin.profile', compact('admin', 'stats', 'activityData', 'activeTab'));

        } catch (\Exception $e) {
            \Log::error('Error loading admin profile', [
                'admin_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.dashboard')
                ->with('error', 'Error loading profile: ' . $e->getMessage());
        }
    }

    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $admin = Auth::user();
        return view('admin.profile-edit', compact('admin'));
    }

    /**
     * Update the admin's profile information.
     */
    public function update(Request $request)
    {
        try {
            $admin = Auth::user();

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $admin->id],
                'profile_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            ]);

            // Update basic info
            $admin->name = $validated['name'];
            $admin->email = $validated['email'];

            // Handle profile image upload if provided
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                
                try {
                    // Generate unique filename
                    $filename = 'admin_' . $admin->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                    
                    // Try to upload to Supabase first
                    $path = $file->storeAs('admins', $filename, 'supabase');
                    $admin->profile_image = $path;
                    
                    \Log::info('Admin profile image uploaded to Supabase', ['path' => $path]);
                    
                } catch (\Exception $e) {
                    \Log::error('Error uploading admin profile image to Supabase', [
                        'error' => $e->getMessage(),
                    ]);
                    
                    // Fall back to local storage
                    try {
                        $path = $file->store('admins', 'public');
                        $admin->profile_image = $path;
                        \Log::info('Admin profile image uploaded to local storage', ['path' => $path]);
                    } catch (\Exception $localError) {
                        \Log::error('Both Supabase and local storage failed for admin profile image', [
                            'supabase_error' => $e->getMessage(),
                            'local_error' => $localError->getMessage()
                        ]);
                    }
                }
            }

            $admin->save();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profile updated successfully!'
                ]);
            }

            return redirect()->route('admin.profile')
                ->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Error updating admin profile', [
                'admin_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating profile: ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Error updating profile: ' . $e->getMessage());
        }
    }

    /**
     * Update the admin's password.
     */
    public function updatePassword(Request $request)
    {
        try {
            $validated = $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Password::min(8)],
            ]);

            $admin = Auth::user();
            $admin->password = Hash::make($validated['password']);
            $admin->save();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password changed successfully!'
                ]);
            }

            return redirect()->route('admin.profile')
                ->with('success', 'Password changed successfully!');

        } catch (\Exception $e) {
            \Log::error('Error changing admin password', [
                'admin_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error changing password: ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->with('error', 'Error changing password: ' . $e->getMessage());
        }
    }

    /**
     * Helper Methods for Statistics
     */

    /**
     * Get count of givings approved by admin.
     */
    private function getGivingsApprovedCount(User $admin): int
    {
        try {
            return $admin->givingsApproved()->count();
        } catch (\Exception $e) {
            \Log::error('Error getting givings approved count', ['error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Get total amount of givings approved by admin.
     */
    private function getGivingsApprovedTotal(User $admin): float
    {
        try {
            return $admin->givingsApproved()
                ->where('status', 'completed')
                ->sum('amount');
        } catch (\Exception $e) {
            \Log::error('Error getting givings approved total', ['error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Get count of service registrations approved by admin.
     */
    private function getServiceRegistrationsApprovedCount(User $admin): int
    {
        try {
            return $admin->serviceRegistrationsApproved()->count();
        } catch (\Exception $e) {
            \Log::error('Error getting service registrations approved count', ['error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Get count of group approvals by admin.
     */
    private function getGroupApprovalsCount(User $admin): int
    {
        try {
            return DB::table('group_member')
                ->where('approved_by', $admin->id)
                ->where('status', 'approved')
                ->count();
        } catch (\Exception $e) {
            \Log::error('Error getting group approvals count', ['error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Get count of events created by admin.
     */
    private function getEventsCreatedCount(User $admin): int
    {
        try {
            return $admin->eventsCreated()->count();
        } catch (\Exception $e) {
            \Log::error('Error getting events created count', ['error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Helper Methods for Activity History
     */

    /**
     * Get paginated list of givings approved by admin.
     */
    private function getGivingsApproved(User $admin)
    {
        try {
            return $admin->givingsApproved()
                ->with('member')
                ->orderBy('confirmed_at', 'desc')
                ->paginate(10);
        } catch (\Exception $e) {
            \Log::error('Error getting givings approved', ['error' => $e->getMessage()]);
            return collect();
        }
    }

    /**
     * Get paginated list of service registrations approved by admin.
     */
    private function getRegistrationsApproved(User $admin)
    {
        try {
            return $admin->serviceRegistrationsApproved()
                ->with(['member', 'service'])
                ->orderBy('paid_at', 'desc')
                ->paginate(10);
        } catch (\Exception $e) {
            \Log::error('Error getting registrations approved', ['error' => $e->getMessage()]);
            return collect();
        }
    }

    /**
     * Get paginated list of group approvals by admin.
     */
    private function getGroupApprovalsHistory(User $admin)
    {
        try {
            return DB::table('group_member')
                ->join('members', 'group_member.member_id', '=', 'members.id')
                ->join('groups', 'group_member.group_id', '=', 'groups.id')
                ->where('group_member.approved_by', $admin->id)
                ->where('group_member.status', 'approved')
                ->select(
                    'group_member.id',
                    'members.full_name as member_name',
                    'groups.name as group_name',
                    'group_member.updated_at as approved_at',
                    'groups.id as group_id'
                )
                ->orderBy('group_member.updated_at', 'desc')
                ->paginate(10);
        } catch (\Exception $e) {
            \Log::error('Error getting group approvals history', ['error' => $e->getMessage()]);
            return collect();
        }
    }

    /**
     * Get paginated list of events created by admin.
     */
    private function getEventsCreated(User $admin)
    {
        try {
            return $admin->eventsCreated()
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } catch (\Exception $e) {
            \Log::error('Error getting events created', ['error' => $e->getMessage()]);
            return collect();
        }
    }
}
