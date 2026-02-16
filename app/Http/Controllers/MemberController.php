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
                    $query->where('full_name', 'like', '%' . $search . '%');
                })
                ->orderBy('full_name') // fixed
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
        // Debug: Log the incoming request
        \Log::info('Member store request received', [
            'has_file' => $request->hasFile('profileImage'),
            'all_data' => $request->all(),
            'files' => $request->allFiles()
        ]);

        try {
            $request->validate([
                'fullname' => 'required|string|max:255',
                // normalize to lowercase in the model; DB enum allows 'male' and 'female'
                'dateOfBirth' => 'required|date|before:today',
                'gender' => 'required|in:male,female',
                // maritalstatus
                'maritalStatus' => 'required|in:single,married,divorced,widowed',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|unique:members,email',
                'address' => 'nullable|string|max:255',
                // date joined
                'dateJoined' => 'required|date|before_or_equal:today',
                // cell
                'cell' => 'required|in:north,east,south,west',
                // image upload validation - simplified and more permissive
                'profileImage' => 'nullable|image|max:5120', // Just use 'image' rule
            ]);
            
            \Log::info('Validation passed successfully');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            
            // Handle AJAX validation errors
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            
            throw $e;
        }
        
        // Map old field names to new database column names
        $data = [
            'full_name' => $request->fullname,
            'date_of_birth' => $request->dateOfBirth,
            'gender' => $request->gender,
            'marital_status' => $request->maritalStatus,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'date_joined' => $request->dateJoined,
            'cell' => $request->cell,
        ];

        // Handle profile image upload if provided
        if ($request->hasFile('profileImage')) {
            $file = $request->file('profileImage');
            
            \Log::info('Processing profile image upload', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'is_valid' => $file->isValid()
            ]);
            
            if (!$file->isValid()) {
                \Log::error('Uploaded file is not valid', [
                    'error' => $file->getError(),
                    'error_message' => $file->getErrorMessage()
                ]);
            } else {
                try {
                    // Generate unique filename
                    $filename = 'member_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    // Try to upload to Supabase first
                    $path = $file->storeAs('members', $filename, 'supabase');
                    $data['profile_image'] = $path;
                    
                    \Log::info('Image uploaded to Supabase successfully', ['path' => $path]);
                    
                } catch (\Exception $e) {
                    \Log::error('Error uploading profile image to Supabase', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'file' => $file->getClientOriginalName()
                    ]);
                    
                    // Fall back to local storage if Supabase fails
                    try {
                        $path = $file->store('members', 'public');
                        $data['profile_image'] = $path;
                        \Log::info('Image uploaded to local storage as fallback', ['path' => $path]);
                    } catch (\Exception $localError) {
                        \Log::error('Both Supabase and local storage failed', [
                            'supabase_error' => $e->getMessage(),
                            'local_error' => $localError->getMessage()
                        ]);
                        // Don't fail the entire member creation, just skip the image
                        \Log::warning('Skipping image upload due to errors, creating member without image');
                    }
                }
            }
        } else {
            \Log::info('No profile image uploaded');
        }

        \Log::info('Creating member with data', $data);

        try {
            $member = Member::create($data);
            \Log::info('Member created successfully', ['member_id' => $member->id, 'member_name' => $member->full_name]);
        } catch (\Exception $e) {
            \Log::error('Error creating member', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);
            
            // Handle AJAX errors
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create member: ' . $e->getMessage()
                ], 500);
            }
            
            // Return with error message for regular form submissions
            if (Auth::check()) {
                return redirect()->back()->withErrors(['error' => 'Failed to create member: ' . $e->getMessage()])->withInput();
            }
            
            return redirect()->route('home')->withErrors(['error' => 'Registration failed. Please try again.']);
        }

        // If the registration was initiated from a join flow, attach the member to the group
        if ($request->filled('join_group')) {
            $groupId = $request->input('join_group');
            $group = \App\Models\Group::find($groupId);
            if ($group && $member) {
                $group->members()->syncWithoutDetaching([$member->id]);
            }
        }

        // Handle AJAX requests (from admin modal)
        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Member added successfully',
                'member' => [
                    'id' => $member->id,
                    'full_name' => $member->full_name,
                    'email' => $member->email,
                    'phone' => $member->phone,
                    'profile_image_url' => $member->profile_image_url,
                ]
            ]);
        }

        // If an admin (authenticated user) created the member from the admin UI,
        // send them to the members listing. If the member was created from the
        // public registration form (guest), redirect back to the homepage with a
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
            'fullname' => 'required|string|max:255',
            'dateOfBirth' => 'required|date|before:today',  
            'gender' => 'required|in:male,female',
            'maritalStatus' => 'required|in:single,married,divorced,widowed',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:members,email,' . $member->id,
            'address' => 'nullable|string|max:255',
            'dateJoined' => 'required|date|before_or_equal:today',      
            'cell' => 'required|in:north,east,south,west',
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        
        // Map old field names to new database column names
        $data = [
            'full_name' => $request->fullname,
            'date_of_birth' => $request->dateOfBirth,
            'gender' => $request->gender,
            'marital_status' => $request->maritalStatus,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'date_joined' => $request->dateJoined,
            'cell' => $request->cell,
        ];

        if ($request->hasFile('profileImage')) {
            $file = $request->file('profileImage');
            
            try {
                // Generate unique filename
                $filename = 'member_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Try to upload to Supabase first
                $path = $file->storeAs('members', $filename, 'supabase');
                $data['profile_image'] = $path;
                
                \Log::info('Image uploaded to Supabase successfully', ['path' => $path]);
                
            } catch (\Exception $e) {
                \Log::error('Error uploading profile image to Supabase', [
                    'error' => $e->getMessage(),
                    'file' => $file->getClientOriginalName()
                ]);
                
                // Fall back to local storage if Supabase fails
                try {
                    $path = $file->store('members', 'public');
                    $data['profile_image'] = $path;
                    \Log::info('Image uploaded to local storage as fallback', ['path' => $path]);
                } catch (\Exception $localError) {
                    \Log::error('Both Supabase and local storage failed', [
                        'supabase_error' => $e->getMessage(),
                        'local_error' => $localError->getMessage()
                    ]);
                    // Don't update the image field if upload fails
                    unset($data['profile_image']);
                }
            }
        }

        $member->update($data);
        
        // Return JSON response for AJAX requests
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Member updated successfully',
                'member' => $member
            ]);
        }
        
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

    /**
     * Test Supabase connection and image upload functionality
     */
    public function testSupabaseConnection()
    {
        try {
            $disk = \Storage::disk('supabase');
            
            // Test basic connection by trying to list files
            $files = $disk->files('members');
            
            // Test upload capability with a small test file
            $testContent = 'Test file for Supabase connection - ' . now();
            $testFileName = 'test_' . time() . '.txt';
            
            try {
                $disk->put('members/' . $testFileName, $testContent);
                $uploadTest = 'Success - Test file uploaded';
                
                // Clean up test file
                $disk->delete('members/' . $testFileName);
            } catch (\Exception $uploadError) {
                $uploadTest = 'Failed - ' . $uploadError->getMessage();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Supabase connection successful',
                'files_count' => count($files),
                'upload_test' => $uploadTest,
                'config' => [
                    'endpoint' => config('filesystems.disks.supabase.endpoint'),
                    'bucket' => config('filesystems.disks.supabase.bucket'),
                    'url' => config('filesystems.disks.supabase.url'),
                    'has_credentials' => !empty(config('filesystems.disks.supabase.key')) && !empty(config('filesystems.disks.supabase.secret')),
                ],
                'sample_files' => array_slice($files, 0, 5)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Supabase connection failed: ' . $e->getMessage(),
                'config' => [
                    'endpoint' => config('filesystems.disks.supabase.endpoint'),
                    'bucket' => config('filesystems.disks.supabase.bucket'),
                    'url' => config('filesystems.disks.supabase.url'),
                    'has_credentials' => !empty(config('filesystems.disks.supabase.key')) && !empty(config('filesystems.disks.supabase.secret')),
                ]
            ], 500);
        }
    }
}