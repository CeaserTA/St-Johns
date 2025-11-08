<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    /**
     * Store a new registration (called by events page modal via AJAX).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'nullable|integer',
            'event_name' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        $registration = EventRegistration::create($data);

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
