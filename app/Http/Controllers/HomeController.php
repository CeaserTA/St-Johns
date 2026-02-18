<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the homepage with active groups and user membership status.
     *
     * @return View
     */
    public function index(): View
    {
        // Retrieve all active groups ordered by sort_order and name, with member counts
        $groups = Group::active()
            ->ordered()
            ->withCount('members')
            ->get();
        
        // Determine which groups the authenticated user is already a member of
        $memberGroupIds = auth()->check() && auth()->user()->member
            ? auth()->user()->member->groups()->pluck('groups.id')->toArray()
            : [];
        
        return view('index', compact('groups', 'memberGroupIds'));
    }
}
