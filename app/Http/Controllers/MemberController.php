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
                    $query->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                })
                ->orderBy('firstname') // fixed
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // normalize to lowercase in the model; DB enum allows 'male' and 'female'
            'gender' => 'required|in:male,female',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:members,email',
            'address' => 'nullable|string|max:255',
        ]);
        Member::create($request->all());

        // If an admin (authenticated user) created the member from the admin UI,
        // send them to the members listing. If the member was created from the
        // public registration modal (guest), redirect back to the homepage with a
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:members,email,' . $member->id,
            'address' => 'nullable|string|max:255',
        ]);
        $member->update($request->all());
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