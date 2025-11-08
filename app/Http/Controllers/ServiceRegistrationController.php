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

       

         // Fetch all registrations from the database
        // Provide an aggregated summary: count of registrations per service.
        // Also keep the latest registrations available if needed by the view in future.
        $serviceCounts = ServiceRegistration::select('service', \DB::raw('count(*) as total'))
            ->groupBy('service')
            ->orderByDesc('total')
            ->get();

        $registrations = ServiceRegistration::latest()->limit(50)->get();

        // Pass them to the view
        return view('service_registrations', compact('serviceCounts', 'registrations'));
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
