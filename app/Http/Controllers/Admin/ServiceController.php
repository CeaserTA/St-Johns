<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceRegistration;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $services = Service::withCount('registrations')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('schedule', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->get();
        
        // fetch recent service registrations with their related service
        $serviceRegistrations = ServiceRegistration::with('service', 'member')->latest()->take(100)->get();
        
        // Calculate statistics
        $stats = [
            'total_services' => Service::count(),
            'total_registrations' => ServiceRegistration::count(),
            'registrations_this_month' => ServiceRegistration::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'active_services' => Service::whereHas('registrations')->count(),
        ];

        return view('admin.services_dashboard', compact('services', 'serviceRegistrations', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'schedule' => 'required|string|max:255',
        ]);

        Service::create($validated);

        return redirect()->route('admin.services')->with('success', 'Service created successfully.');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'schedule' => 'required|string|max:255',
        ]);

        $service->update($validated);

        return redirect()->route('admin.services')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services')->with('success', 'Service deleted successfully.');
    }
}
