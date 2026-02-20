<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\ServiceRegistration;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\NotificationService;
use App\Notifications\NewMemberRegistered;

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
        
        // Calculate engagement metrics
        $membersWithInteraction = DB::table('members')
            ->leftJoin('event_registrations', 'members.id', '=', 'event_registrations.id')
            ->leftJoin('service_registrations', 'members.id', '=', 'service_registrations.member_id')
            ->leftJoin('givings', 'members.id', '=', 'givings.member_id')
            ->where(function($query) {
                $query->whereNotNull('event_registrations.id')
                    ->orWhereNotNull('service_registrations.id')
                    ->orWhereNotNull('givings.id');
            })
            ->distinct('members.id')
            ->count('members.id');
        
        $membersJustViewing = $totalMembers - $membersWithInteraction;
        $interactionPercentage = $totalMembers > 0 ? round(($membersWithInteraction / $totalMembers) * 100, 1) : 0;
        $viewingPercentage = $totalMembers > 0 ? round(($membersJustViewing / $totalMembers) * 100, 1) : 0;
        
        // Calculate service registrations count
        $totalServiceRegistrations = DB::table('service_registrations')->count();
        
        // Calculate event registrations count
        $totalEventRegistrations = DB::table('event_registrations')->count();
        
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
        $recentServiceRegistrations = ServiceRegistration::with('service', 'member')->latest()->take(10)->get();
        
        // Aggregate service registrations by service
        $serviceRegistrationCounts = ServiceRegistration::with('service')
            ->select('service_id')
            ->groupBy('service_id')
            ->get()
            ->map(function($item) {
                return [
                    'service' => $item->service->name ?? 'Unknown',
                    'count' => ServiceRegistration::where('service_id', $item->service_id)->count()
                ];
            });

        // Prepare service distribution arrays for charts
        $serviceDistributionLabels = $serviceRegistrationCounts->pluck('service')->toArray();
        $serviceDistributionData = $serviceRegistrationCounts->pluck('count')->toArray();

        // Member distribution by cell (or other grouping) for charts
        $memberDistribution = Member::select('cell', DB::raw('count(*) as count'))
            ->groupBy('cell')
            ->get();
        $memberDistributionLabels = $memberDistribution->pluck('cell')->map(function($v){ return ucfirst($v); })->toArray();
        $memberDistributionData = $memberDistribution->pluck('count')->toArray();

        return view('dashboard', compact(
            'totalMembers', 'newRegistrations', 'activeMembers', 'monthlyNewMembers', 'monthLabels', 'recentServiceRegistrations', 'serviceRegistrationCounts',
            'serviceDistributionLabels', 'serviceDistributionData', 'memberDistributionLabels', 'memberDistributionData',
            'membersWithInteraction', 'membersJustViewing', 'interactionPercentage', 'viewingPercentage',
            'totalServiceRegistrations', 'totalEventRegistrations'
        ));
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
        Log::info('Member store request received', [
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
            
            Log::info('Validation passed successfully');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
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
        
        // Check if user wants to create an account
        $createAccount = $request->boolean('create_account');
        $user = null;

        if ($createAccount) {
            // Validate password fields
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            
            // Check if email already has a user account
            if ($request->email && \App\Models\User::where('email', $request->email)->exists()) {
                if ($request->wantsJson() || $request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'An account with this email already exists. Please login instead.'
                    ], 422);
                }
                return back()->withErrors(['email' => 'An account with this email already exists. Please login instead.'])->withInput();
            }
            
            // Create user account
            $user = \App\Models\User::create([
                'name' => $request->fullname,
                'email' => $request->email,
                'password' => \Hash::make($request->password),
                'role' => 'member',
            ]);
            
            Log::info('User account created for member', ['user_id' => $user->id]);
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
            
            Log::info('Processing profile image upload', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'is_valid' => $file->isValid()
            ]);
            
            if (!$file->isValid()) {
                Log::error('Uploaded file is not valid', [
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
                    
                    Log::info('Image uploaded to Supabase successfully', ['path' => $path]);
                    
                } catch (\Exception $e) {
                    Log::error('Error uploading profile image to Supabase', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'file' => $file->getClientOriginalName()
                    ]);
                    
                    // Fall back to local storage if Supabase fails
                    try {
                        $path = $file->store('members', 'public');
                        $data['profile_image'] = $path;
                        Log::info('Image uploaded to local storage as fallback', ['path' => $path]);
                    } catch (\Exception $localError) {
                        Log::error('Both Supabase and local storage failed', [
                            'supabase_error' => $e->getMessage(),
                            'local_error' => $localError->getMessage()
                        ]);
                        // Don't fail the entire member creation, just skip the image
                        Log::warning('Skipping image upload due to errors, creating member without image');
                    }
                }
            }
        } else {
            Log::info('No profile image uploaded');
        }

        Log::info('Creating member with data', $data);

        try {
            $member = Member::create($data);
            Log::info('Member created successfully', ['member_id' => $member->id, 'member_name' => $member->full_name]);
            
            // Send notification to admins
            try {
                $notificationService = app(NotificationService::class);
                $notificationService->notifyAdmins(new NewMemberRegistered($member));
            } catch (\Exception $e) {
                Log::error('Failed to send member registration notification', [
                    'member_id' => $member->id,
                    'error' => $e->getMessage()
                ]);
                // Don't fail member creation if notification fails
            }
        } catch (\Exception $e) {
            Log::error('Error creating member', [
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

        // Add user_id to member if account was created
        if ($user) {
            $member->update(['user_id' => $user->id]);
        }

        // Auto-login if account was created
        if ($user) {
            Auth::login($user);
            Log::info('User auto-logged in after registration', ['user_id' => $user->id]);
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

        // After member creation, check if user was logged in
        if (Auth::check() && !$request->wantsJson()) {
            // If admin created the member
            if (Auth::user()->role === 'admin') {
                return redirect()->route('members')->with('success', 'Member added successfully');
            }
            
            // If member just registered with account
            return redirect()->route('services')->with('success', 'Welcome! Your account has been created. You can now register for services.');
        }

        // Guest registration (no account created)
        // Redirect to services page with flash message to show account creation modal
        return redirect()->route('services')
            ->with('success', 'Thank you for registering as a member!')
            ->with('show_account_creation', true)
            ->with('prefill_email', $member->email)
            ->with('member_registration_complete', 'Next step: Create your account to access services and groups.');
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
                
                Log::info('Image uploaded to Supabase successfully', ['path' => $path]);
                
            } catch (\Exception $e) {
                Log::error('Error uploading profile image to Supabase', [
                    'error' => $e->getMessage(),
                    'file' => $file->getClientOriginalName()
                ]);
                
                // Fall back to local storage if Supabase fails
                try {
                    $path = $file->store('members', 'public');
                    $data['profile_image'] = $path;
                    Log::info('Image uploaded to local storage as fallback', ['path' => $path]);
                } catch (\Exception $localError) {
                    Log::error('Both Supabase and local storage failed', [
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
     * Create user account for existing member
     */
    public function createAccount(Request $request)
    {
        // Log account creation attempt
        Log::info('Account creation attempt', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);
        
        $request->validate([
            'email' => 'required|email|exists:members,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        DB::beginTransaction();
        try {
            // Find member by email
            $member = Member::where('email', $request->email)->first();
            
            if (!$member) {
                Log::warning('Account creation failed: Member not found', [
                    'email' => $request->email
                ]);
                throw new \Exception('Member not found with this email.');
            }
            
            Log::info('Member found for account creation', [
                'member_id' => $member->id,
                'member_name' => $member->full_name,
                'email' => $member->email
            ]);
            
            // Check if member already has an account
            if ($member->user_id) {
                $existingUser = \App\Models\User::find($member->user_id);
                if ($existingUser) {
                    Log::warning('Account creation failed: Member already has account', [
                        'member_id' => $member->id,
                        'user_id' => $member->user_id,
                        'email' => $member->email
                    ]);
                    throw new \Exception('This member already has an account. Please login.');
                }
            }
            
            // Check for orphaned user accounts with same email
            if (\App\Models\User::where('email', $request->email)->exists()) {
                Log::warning('Account creation failed: Orphaned user account exists', [
                    'email' => $request->email,
                    'member_id' => $member->id
                ]);
                throw new \Exception('An account with this email already exists. Please login.');
            }
            
            // Create user account
            $user = \App\Models\User::create([
                'name' => $member->full_name,
                'email' => $member->email,
                'password' => \Hash::make($request->password),
                'role' => 'member',
            ]);
            
            Log::info('User account created', [
                'user_id' => $user->id,
                'email' => $user->email,
                'member_id' => $member->id
            ]);
            
            // Link user to member
            $member->user_id = $user->id;
            $member->save();
            
            Log::info('User successfully linked to member', [
                'user_id' => $user->id,
                'member_id' => $member->id,
                'email' => $member->email
            ]);
            
            DB::commit();
            
            // Auto-login
            Auth::login($user);
            
            Log::info('User auto-logged in after account creation', [
                'user_id' => $user->id,
                'member_id' => $member->id
            ]);
            
            return redirect()->route('services')->with('success', 'Account created successfully! You can now register for services.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Account creation failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', $e->getMessage())->withInput();
        }
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