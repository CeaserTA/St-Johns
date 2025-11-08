<?php

namespace App\Http\Controllers;

use App\Models\ServiceRegistration;
use Illuminate\Http\Request;

class ServiceRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        // Fetch all registrations, grouped by service
        $services = ServiceRegistration::all()->groupBy('service');

        // Optionally, you can get total count per service
        $serviceCounts = $services->map(function ($regs) {
            return $regs->count();
        });

        return view('service_registrations', compact('services', 'serviceCounts'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'address'  => 'nullable|string|max:500',
            'contact'  => 'nullable|string|max:50',
            'service'  => 'required|in:Counseling,Baptism,Youth Retreat',
        ]);

        ServiceRegistration::create([
            'full_name'    => $validated['fullname'],
            'email'        => $validated['email'],
            'address'      => $validated['address'] ?? null,
            'phone_number' => $validated['contact'] ?? null,
            'service'      => $validated['service'],
        ]);

        return back()->with('success', 'Thank you! You are registered for ' . $validated['service'] . '.');
    }

  
}
