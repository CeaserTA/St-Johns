<?php
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\ServiceRegistrationController;
use App\Http\Controllers\EventController as PublicEventController;
use App\Http\Controllers\ServiceController as PublicServiceController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\GivingController;
use App\Http\Controllers\HomeController;
use App\Models\Event;
use App\Models\Group;
use App\Models\Service;
use App\Models\Announcement;
use App\Models\ServiceRegistration;
use App\Models\Member;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', [MemberController::class, 'index'])
    ->name('dashboard')
    ->middleware('admin');

// Notification routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/api/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/api/notifications/unread', [NotificationController::class, 'getUnreadNotifications'])->name('notifications.unread');
    Route::post('/api/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/api/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Public site pages: index/home, events and services
Route::get('/index', [HomeController::class, 'index'])->name('index');

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Group join endpoints removed — group management deleted per request

Route::get('/updates', [PublicEventController::class, 'index'])->name('updates');
Route::get('/updates/{event}', [PublicEventController::class, 'show'])->name('updates.show');

// GIVING/TITHE ROUTES
// Public giving page (accessible to everyone, including via QR codes)
Route::get('/give', [GivingController::class, 'index'])->name('giving.index');
Route::post('/give', [GivingController::class, 'store'])->name('giving.store');

// Member giving history (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/my-giving', [GivingController::class, 'history'])->name('giving.history');
    
    // Member service registrations API
    Route::get('/api/my-service-registrations', [ServiceRegistrationController::class, 'myRegistrations'])->name('api.my-registrations');
    Route::get('/api/my-pending-payments', [ServiceRegistrationController::class, 'myPendingPayments'])->name('api.my-pending-payments');
});

// Admin giving management (requires admin role)
Route::middleware('admin')->group(function () {
    Route::get('/admin/givings', [GivingController::class, 'adminIndex'])->name('admin.givings');
    Route::get('/admin/givings/dashboard-summary', [GivingController::class, 'dashboardSummary'])->name('admin.givings.dashboard-summary');
    Route::get('/admin/givings/export-csv', [GivingController::class, 'exportCsv'])->name('admin.givings.export-csv');
    Route::get('/admin/givings/{giving}', [GivingController::class, 'show'])->name('admin.givings.show');
    Route::post('/admin/givings/{giving}/confirm', [GivingController::class, 'confirm'])->name('admin.givings.confirm');
    Route::post('/admin/givings/{giving}/fail', [GivingController::class, 'markFailed'])->name('admin.givings.fail');
    Route::post('/admin/givings/{giving}/resend-receipt', [GivingController::class, 'resendReceipt'])->name('admin.givings.resend-receipt');
    Route::get('/admin/giving-reports', [GivingController::class, 'reports'])->name('admin.giving.reports');
});

// Admin dashboard-specific events page (rendered as section within dashboard)
Route::middleware('admin')->group(function () {
    // Events & Announcements Management
    Route::get('/admin/events', [EventController::class, 'index'])->name('admin.events');
    Route::post('/admin/events', [EventController::class, 'store'])->name('admin.events.store');
    Route::get('/admin/events/{event}', [EventController::class, 'show'])->name('admin.events.show');
    Route::put('/admin/events/{event}', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/admin/events/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');
    
    // Event Actions
    Route::post('/admin/events/{event}/toggle-pin', [EventController::class, 'togglePin'])->name('admin.events.toggle-pin');
    Route::post('/admin/events/{event}/toggle-active', [EventController::class, 'toggleActive'])->name('admin.events.toggle-active');
    Route::post('/admin/events/{event}/set-expiration', [EventController::class, 'setExpiration'])->name('admin.events.set-expiration');
    Route::post('/admin/events/{event}/remove-expiration', [EventController::class, 'removeExpiration'])->name('admin.events.remove-expiration');
    
    // Bulk Operations
    Route::post('/admin/events/bulk-delete', [EventController::class, 'bulkDelete'])->name('admin.events.bulk-delete');
    Route::post('/admin/events/bulk-activate', [EventController::class, 'bulkActivate'])->name('admin.events.bulk-activate');
    Route::post('/admin/events/bulk-deactivate', [EventController::class, 'bulkDeactivate'])->name('admin.events.bulk-deactivate');
    Route::post('/admin/events/bulk-pin', [EventController::class, 'bulkPin'])->name('admin.events.bulk-pin');

    // Groups dashboard and management
    Route::get('/admin/groups', [\App\Http\Controllers\Admin\GroupController::class, 'index'])
        ->name('admin.groups');
    Route::get('/admin/groups/{group}/members', [\App\Http\Controllers\Admin\GroupController::class, 'getMembers'])->name('admin.groups.members.get');
    Route::post('/admin/groups', [\App\Http\Controllers\Admin\GroupController::class, 'store'])->name('admin.groups.store');
    Route::put('/admin/groups/{group}', [\App\Http\Controllers\Admin\GroupController::class, 'update'])->name('admin.groups.update');
    Route::delete('/admin/groups/{group}', [\App\Http\Controllers\Admin\GroupController::class, 'destroy'])->name('admin.groups.destroy');
    Route::post('/admin/groups/{group}/members', [\App\Http\Controllers\Admin\GroupController::class, 'addMember'])->name('admin.groups.members.store');
    Route::delete('/admin/groups/{group}/members/{member}', [\App\Http\Controllers\Admin\GroupController::class, 'removeMember'])->name('admin.groups.members.destroy');
    Route::post('/admin/groups/{group}/members/{member}/approve', [\App\Http\Controllers\Admin\GroupController::class, 'approveMember'])->name('admin.groups.members.approve');
    Route::post('/admin/groups/{group}/members/{member}/reject', [\App\Http\Controllers\Admin\GroupController::class, 'rejectMember'])->name('admin.groups.members.reject');

    // Admin dashboard-specific services page
    Route::get('/admin/services', [ServiceController::class, 'index'])->name('admin.services');
    Route::post('/admin/services', [ServiceController::class, 'store'])->name('admin.services.store');
    Route::put('/admin/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/admin/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');
    
    // Admin service registration payment actions
    Route::post('/admin/service-registrations/{registration}/confirm-payment', [ServiceController::class, 'confirmPayment'])->name('admin.service-registrations.confirm-payment');
    Route::post('/admin/service-registrations/{registration}/reject-payment', [ServiceController::class, 'rejectPayment'])->name('admin.service-registrations.reject-payment');

    // Admin dashboard-specific announcements page
    Route::get('/admin/announcements', [AnnouncementController::class, 'index'])->name('admin.announcements');
    Route::post('/admin/announcements', [AnnouncementController::class, 'store'])->name('admin.announcements.store');
    Route::put('/admin/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('admin.announcements.update');
    Route::delete('/admin/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('admin.announcements.destroy');

    // Admin dashboard-specific members page
    Route::get('/admin/members', [\App\Http\Controllers\Admin\MemberController::class, 'index'])->name('admin.members');
    Route::get('/admin/members/{member}', [\App\Http\Controllers\Admin\MemberController::class, 'show'])->name('admin.members.show');

    // QR Code Management
    Route::get('/admin/qr-codes', [\App\Http\Controllers\QRCodeController::class, 'index'])->name('admin.qr-codes');
    Route::post('/admin/qr-codes/member-registration', [\App\Http\Controllers\QRCodeController::class, 'generateMemberRegistration'])->name('qr-codes.generate.member');
    Route::post('/admin/qr-codes/event-registration', [\App\Http\Controllers\QRCodeController::class, 'generateEventRegistration'])->name('qr-codes.generate.event');
    Route::post('/admin/qr-codes/giving', [\App\Http\Controllers\QRCodeController::class, 'generateGiving'])->name('qr-codes.generate.giving');
    Route::post('/admin/qr-codes/custom', [\App\Http\Controllers\QRCodeController::class, 'generateCustom'])->name('qr-codes.generate.custom');
    Route::get('/admin/qr-codes/cleanup', [\App\Http\Controllers\QRCodeController::class, 'cleanup'])->name('qr-codes.cleanup');
});

// QR Code download (public access)
Route::get('/qr-codes/download/{filename}', [\App\Http\Controllers\QRCodeController::class, 'download'])->name('qr-codes.download');

Route::get('/services', [PublicServiceController::class, 'index'])->name('services');



// Public endpoint: allow anyone to register (modal posts here)
Route::post('/members', [MemberController::class, 'store'])->name('members.store');

// Quick account creation for existing members
Route::post('/member/create-account', [MemberController::class, 'createAccount'])->name('member.create-account');

// API endpoint for recent members (for testing)
Route::get('/api/recent-members', function() {
    try {
        $members = \App\Models\Member::latest()->take(5)->get();
        
        $membersData = $members->map(function($member) {
            return [
                'id' => $member->id,
                'full_name' => $member->full_name,
                'email' => $member->email,
                'profile_image' => $member->profile_image,
                'profile_image_url' => $member->profile_image_url,
                'created_at' => $member->created_at->format('Y-m-d H:i:s')
            ];
        });
        
        return response()->json([
            'success' => true,
            'members' => $membersData
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
});

// Join group (auth required - only registered church members)
Route::post('/groups/join', [\App\Http\Controllers\GroupJoinController::class, 'store'])
    ->name('groups.join')
    ->middleware('auth');

// Get member's groups (auth required)
Route::get('/api/my-groups', function() {
    if (!auth()->check() || !auth()->user()->member) {
        return response()->json(['groups' => []]);
    }
    
    $member = auth()->user()->member;
    $groups = $member->groups()->with('members')->get()->map(function($group) use ($member) {
        return [
            'id' => $group->id,
            'name' => $group->name,
            'description' => $group->description,
            'meeting_day' => $group->meeting_day,
            'location' => $group->location,
            'image_url' => $group->image_url,
            'status' => $group->pivot->status,
            'joined_at' => $group->pivot->created_at->format('M d, Y'),
        ];
    });
    
    return response()->json(['groups' => $groups]);
})->middleware('auth');

// Leave a group (auth required)
Route::post('/api/groups/{group}/leave', function(\App\Models\Group $group) {
    if (!auth()->check() || !auth()->user()->member) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    }
    
    $member = auth()->user()->member;
    
    // Check if member is in the group
    if (!$member->groups()->where('groups.id', $group->id)->exists()) {
        return response()->json(['success' => false, 'message' => 'You are not in this group'], 400);
    }
    
    // Remove member from group
    $member->groups()->detach($group->id);
    
    return response()->json(['success' => true, 'message' => 'Successfully left the group']);
})->middleware('auth');

// Protect member-management routes behind auth so only admins can view/manage members
Route::middleware('auth')->group(function () {
    Route::get('/members', [MemberController::class, 'members'])->name('members');
    Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
    Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');
    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
    
    // Test route for Supabase connection
    Route::get('/test-supabase', [MemberController::class, 'testSupabaseConnection'])->name('test.supabase');
    
    // Test page for image upload
    Route::get('/test-image-upload', function() {
        return view('test-image-upload');
    })->name('test.image.upload');
    
    // Simple debug page
    Route::get('/debug-info', function() {
        return response()->json([
            'csrf_token' => csrf_token(),
            'storage_path_exists' => file_exists(storage_path('app/public/members')),
            'storage_writable' => is_writable(storage_path('app/public')),
            'php_upload_max' => ini_get('upload_max_filesize'),
            'php_post_max' => ini_get('post_max_size'),
            'recent_members' => \App\Models\Member::latest()->take(3)->get(['id', 'full_name', 'profile_image', 'created_at'])
        ]);
    });
    
    // Test member API response
    Route::get('/test-member-api/{id}', function($id) {
        $member = \App\Models\Member::findOrFail($id);
        
        // Simulate the same response as the show method
        $memberData = $member->toArray();
        $memberData['profile_image_url'] = $member->profile_image_url;
        $memberData['has_profile_image'] = $member->hasProfileImage();
        
        return response()->json([
            'success' => true,
            'member' => $memberData,
            'debug_info' => [
                'profile_image_raw' => $member->profile_image,
                'profile_image_url_method' => $member->profile_image_url,
                'has_profile_image_method' => $member->hasProfileImage(),
                'app_url' => config('app.url'),
                'storage_url' => asset('storage/' . $member->profile_image)
            ]
        ]);
    });
});




// Protect service registration with auth
Route::middleware(['auth'])->group(function () {
    Route::post('/service-register', [ServiceRegistrationController::class, 'store'])->name('service.register');
    Route::post('/service-payment-proof', [ServiceRegistrationController::class, 'submitPaymentProof'])->name('service.payment.proof');
});



Route::post('/event-registrations', [EventRegistrationController::class, 'store'])
    ->name('event.registrations.store');

// Admin listing of event registrations (protected)
Route::get('/admin/event-registrations', [EventRegistrationController::class, 'index'])
    ->name('event.registrations')
    ->middleware('admin');

Route::middleware('admin')->group(function () {
    Route::get('/admin/service-registrations', [ServiceRegistrationController::class, 'index'])
        ->name('service.registrations');
});
   



