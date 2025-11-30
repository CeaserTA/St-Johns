<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\ServiceRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MemberController extends Controller
{
    /**
     * Display the dashboard with summary cards and bar chart.
     */
    public function index()
    {
        
        $totalMembers = Member::count();
        $newRegistrations = Member::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $activeMembers = Member::where('created_at', '>=', Carbon::now()->subMonths(3))->count();
        $monthlyNewMembers = [];
        $monthLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->startOfMonth();
            $monthEnd = $month->endOfMonth();
            $monthLabels[] = $month->format('M');
            $count = Member::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $monthlyNewMembers[] = $count;
        }

        // Get latest service registrations to show on the admin dashboard
        $recentServiceRegistrations = ServiceRegistration::latest()->take(10)->get();

        return view('dashboard', compact('totalMembers', 'newRegistrations', 'activeMembers', 'monthlyNewMembers', 'monthLabels', 'recentServiceRegistrations'));
    }

    /**
     * Display the members management page with table.
     */
       public function members(Request $request)
        {
            $search = $request->query('search');

            $members = Member::query()
                ->when($search, function ($query, $search) {
                    $query->where('fullname', 'like', '%' . $search . '%');
                })
                ->orderBy('fullname') // fixed
                ->paginate(10)
                ->appends(['search' => $search]);

            return view('members', compact('members', 'search'));
        }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create'); // Updated to match resources/views/create.blade.php
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            // normalize to lowercase in the model; DB enum allows 'male' and 'female'
            'dateOfBirth' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            // maritalstatus
            'maritalStatus' => 'required|in:single,married,divorced,widowed',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:members,email',
            'address' => 'nullable|string|max:255',
            // date joined
            'dateJoined' => 'required|date|before_or_equal:today',
            // cell
            'cell' => 'required|in:north,east,south,west',
            // image upload validation
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = $request->except('_token');

        // Handle profile image upload if provided
        if ($request->hasFile('profileImage')) {
            $file = $request->file('profileImage');
            // store in storage/app/public/members
            $path = $file->store('members', 'public');
            $data['profileImage'] = $path;
        }

        Member::create($data);
        $member = Member::where('email', $data['email'] ?? null)->first();

        // If the registration was initiated from a join flow, attach the member to the group
        if ($request->filled('join_group')) {
            $groupId = $request->input('join_group');
            $group = \App\Models\Group::find($groupId);
            if ($group && $member) {
                $group->members()->syncWithoutDetaching([$member->id]);
            }
        }

        // If an admin (authenticated user) created the member from the admin UI,
        // send them to the members listing. If the member was created from the
        // public registration form (guest), redirect back to the homepage with a
        // friendly success message so the user is not taken to the admin area.
        if (Auth::check()) {
            return redirect()->route('members')->with('success', 'Member added successfully');
        }

        return redirect()->route('home')->with('success', 'Thank you for registering — we will contact you soon.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return view('show', compact('member')); // Updated to match resources/views/show.blade.php
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('edit', compact('member')); // Updated to match resources/views/edit.blade.php
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'dateOfBirth' => 'required|date|before:today',  
            'gender' => 'required|in:male,female',
            'maritalStatus' => 'required|in:single,married,divorced,widowed',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:members,email,' . $member->id,
            'address' => 'nullable|string|max:255',
            'dateJoined' => 'required|date|before_or_equal:today',      
            'cell' => 'required|in:north,east,south,west',
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = $request->except('_token', '_method');

        if ($request->hasFile('profileImage')) {
            $file = $request->file('profileImage');
            $path = $file->store('members', 'public');
            $data['profileImage'] = $path;
        }

        $member->update($data);
        return redirect()->route('members')->with('success', 'Member updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members')->with('success', 'Member deleted successfully');
    }
}