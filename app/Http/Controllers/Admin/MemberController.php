<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * Display a listing of members with search and filter functionality
     */
    public function index(Request $request)
    {
        try {
            $query = Member::query();

            // Search functionality
            if ($request->search) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('full_name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('address', 'LIKE', "%{$searchTerm}%");
                });
            }

            // Filter by gender
            if ($request->gender && $request->gender !== 'all') {
                $query->where('gender', $request->gender);
            }

            // Filter by marital status
            if ($request->marital_status && $request->marital_status !== 'all') {
                $query->where('marital_status', $request->marital_status);
            }

            // Filter by cell
            if ($request->cell && $request->cell !== 'all') {
                $query->where('cell', $request->cell);
            }

            // Filter by age range
            if ($request->age_range && $request->age_range !== 'all') {
                switch ($request->age_range) {
                    case 'under_18':
                        $query->where('date_of_birth', '>', now()->subYears(18));
                        break;
                    case '18_30':
                        $query->whereBetween('date_of_birth', [now()->subYears(30), now()->subYears(18)]);
                        break;
                    case '31_50':
                        $query->whereBetween('date_of_birth', [now()->subYears(50), now()->subYears(31)]);
                        break;
                    case 'over_50':
                        $query->where('date_of_birth', '<', now()->subYears(50));
                        break;
                }
            }

            // Filter by date joined
            if ($request->joined_period && $request->joined_period !== 'all') {
                switch ($request->joined_period) {
                    case 'this_month':
                        $query->whereMonth('date_joined', now()->month)
                              ->whereYear('date_joined', now()->year);
                        break;
                    case 'this_year':
                        $query->whereYear('date_joined', now()->year);
                        break;
                    case 'last_year':
                        $query->whereYear('date_joined', now()->subYear()->year);
                        break;
                }
            }

            // Sorting
            $sortBy = $request->sort_by ?? 'full_name';
            $sortOrder = $request->sort_order ?? 'asc';
            
            if (in_array($sortBy, ['full_name', 'date_of_birth', 'date_joined', 'email'])) {
                $query->orderBy($sortBy, $sortOrder);
            } else {
                $query->orderBy('full_name', 'asc');
            }

            // Load relationships safely
            $members = $query->with(['user'])->paginate(20)->withQueryString();

            // Get filter options safely
            $filterOptions = [
                'genders' => Member::select('gender')->distinct()->whereNotNull('gender')->pluck('gender')->toArray(),
                'marital_statuses' => Member::select('marital_status')->distinct()->whereNotNull('marital_status')->pluck('marital_status')->toArray(),
                'cells' => Member::select('cell')->distinct()->whereNotNull('cell')->pluck('cell')->toArray(),
            ];

            // Get summary statistics
            $stats = [
                'total_members' => Member::count(),
                'active_members' => Member::whereHas('user')->count(),
                'new_this_month' => Member::whereMonth('date_joined', now()->month)
                                        ->whereYear('date_joined', now()->year)
                                        ->count(),
                'average_age' => $this->calculateAverageAge(),
            ];

            return view('admin.members_dashboard', compact('members', 'filterOptions', 'stats'));

        } catch (\Exception $e) {
            \Log::error('Error in members index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return a simple view with error message for debugging
            $members = collect();
            $filterOptions = [
                'genders' => [],
                'marital_statuses' => [],
                'cells' => [],
            ];
            $stats = [
                'total_members' => 0,
                'active_members' => 0,
                'new_this_month' => 0,
                'average_age' => 0,
            ];

            return view('admin.members_dashboard', compact('members', 'filterOptions', 'stats'))
                ->with('error', 'Error loading members: ' . $e->getMessage());
        }
    }

    /**
     * Calculate average age safely
     */
    private function calculateAverageAge()
    {
        try {
            $members = Member::whereNotNull('date_of_birth')->get();
            if ($members->isEmpty()) {
                return null;
            }

            $totalAge = 0;
            $validAges = 0;

            foreach ($members as $member) {
                $age = $member->age; // Use the model's age accessor
                if ($age !== null) {
                    $totalAge += $age;
                    $validAges++;
                }
            }

            return $validAges > 0 ? round($totalAge / $validAges) : null;
        } catch (\Exception $e) {
            \Log::error('Error calculating average age', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Display detailed information about a specific member
     */
    public function show(Request $request, Member $member)
    {
        try {
            // Load relationships safely
            $member->load(['user']);
            
            // Try to load givings if the relationship exists
            try {
                $member->load(['givings' => function($query) {
                    $query->orderBy('created_at', 'desc')->limit(10);
                }]);
            } catch (\Exception $e) {
                \Log::warning('Could not load givings for member', ['member_id' => $member->id, 'error' => $e->getMessage()]);
            }

            // Try to load other relationships
            try {
                $member->load(['eventRegistrations.event', 'serviceRegistrations.service']);
            } catch (\Exception $e) {
                \Log::warning('Could not load registrations for member', ['member_id' => $member->id, 'error' => $e->getMessage()]);
            }

            // Calculate member statistics safely
            $memberStats = [
                'total_givings' => $this->getMemberGivingTotal($member),
                'total_tithes' => $this->getMemberTithes($member),
                'total_offerings' => $this->getMemberOfferings($member),
                'total_donations' => $this->getMemberDonations($member),
                'giving_count' => $this->getMemberGivingCount($member),
                'events_attended' => $member->eventRegistrations ? $member->eventRegistrations->count() : 0,
                'services_attended' => $member->serviceRegistrations ? $member->serviceRegistrations->count() : 0,
                'groups_count' => 0, // Will be updated when groups relationship is fixed
                'member_since_days' => $member->date_joined ? now()->diffInDays($member->date_joined) : null,
                'age' => $member->date_of_birth ? now()->diffInYears($member->date_of_birth) : null,
            ];

            // If this is an AJAX request, return JSON
            if ($request->wantsJson()) {
                // Add image URL to the member data
                $memberData = $member->toArray();
                $memberData['profile_image_url'] = $member->profile_image_url;
                $memberData['has_profile_image'] = $member->hasProfileImage();
                
                return response()->json([
                    'success' => true,
                    'member' => $memberData,
                    'stats' => $memberStats
                ]);
            }

            // Otherwise return view (for future use)
            return view('admin.members.show', compact('member', 'memberStats'));

        } catch (\Exception $e) {
            \Log::error('Error showing member details', [
                'member_id' => $member->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error loading member details: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.members')->with('error', 'Error loading member details');
        }
    }

    /**
     * Get member giving total safely
     */
    private function getMemberGivingTotal($member)
    {
        try {
            return $member->givings ? $member->givings->where('status', 'completed')->sum('amount') : 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get member tithes safely
     */
    private function getMemberTithes($member)
    {
        try {
            return $member->givings ? $member->givings->where('status', 'completed')->where('giving_type', 'tithe')->sum('amount') : 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get member offerings safely
     */
    private function getMemberOfferings($member)
    {
        try {
            return $member->givings ? $member->givings->where('status', 'completed')->where('giving_type', 'offering')->sum('amount') : 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get member donations safely
     */
    private function getMemberDonations($member)
    {
        try {
            return $member->givings ? $member->givings->where('status', 'completed')->whereIn('giving_type', ['donation', 'special_offering'])->sum('amount') : 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get member giving count safely
     */
    private function getMemberGivingCount($member)
    {
        try {
            return $member->givings ? $member->givings->where('status', 'completed')->count() : 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
}