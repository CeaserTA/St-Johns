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
        // Fetch all registrations with their related services
        $registrations = ServiceRegistration::with('service')->latest()->get();
        
        // Group by service
        $services = $registrations->groupBy('service.name');

        // Get count per service
        $serviceCounts = $services->map(function ($regs) {
            return $regs->count();
        });

        return view('service_registrations', compact('services', 'serviceCounts', 'registrations'));
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
            'service_id'  => 'required|exists:services,id',
        ]);

        $registration = ServiceRegistration::create([
            'service_id'        => $validated['service_id'],
            'guest_full_name'   => $validated['fullname'],
            'guest_email'       => $validated['email'],
            'guest_address'     => $validated['address'] ?? null,
            'guest_phone'       => $validated['contact'] ?? null,
        ]);

        // Get the service name for the success message
        $serviceName = $registration->service->name;

        return back()->with('success', 'Thank you! You are registered for ' . $serviceName . '.');
    }

  
}
