<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
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
        return view('dashboard', compact('totalMembers', 'newRegistrations', 'activeMembers', 'monthlyNewMembers', 'monthLabels'));
    }

    /**
     * Display the members management page with table.
     */
    public function members(Request $request)
    {
        $search = $request->query('search');
        $members = Member::when($search, function ($query, $search) {
            return $query->where('first_name', 'like', "%$search%")
                         ->orWhere('last_name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%");
        })->paginate(10); // Changed to paginate for better performance
        return view('members', compact('members'));
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
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:members,email',
            'address' => 'nullable|string|max:255',
        ]);
        Member::create($request->all());
        return redirect()->route('members')->with('success', 'Member added successfully');
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
            'gender' => 'required|in:Male,Female,Other',
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