<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRegistrationController extends Controller
{
    /**
     * Store a new registration (called by events page modal via AJAX).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'nullable|integer',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        // If a logged-in member is registering, link to their member profile
        if (Auth::check() && Auth::user()->member) {
            $member = Auth::user()->member;

            $registration = EventRegistration::create([
                'event_id' => $data['event_id'] ?? null,
                'member_id' => $member->id,
                // Guest fields remain null so dashboard can distinguish members vs guests
            ]);
        } else {
            // Guest registration path – use provided name/contact fields
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
            ]);

            $registration = EventRegistration::create([
                'event_id' => $data['event_id'] ?? null,
                'guest_first_name' => $data['first_name'],
                'guest_last_name' => $data['last_name'],
                'guest_email' => $data['email'] ?? null,
                'guest_phone' => $data['phone'] ?? null,
            ]);
        }

        return response()->json([
            'message' => 'Registered successfully',
            'id' => $registration->id,
        ], 201);
    }

    /**
     * Optional admin index of registrations
     */
    public function index()
    {
        $registrations = EventRegistration::latest()->paginate(20);
        return view('event_registrations.index', compact('registrations'));
    }
}
