<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource (public services page).
     */
    public function index()
    {
        $services = Service::all();
        return view('services', compact('services'));
    }

    /**
     * Display the specified service (public detail page).
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }
}
