<?php
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AdminAuthenticatedSessionController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\ServiceRegistrationController;
use App\Http\Controllers\EventController as PublicEventController;
use App\Http\Controllers\ServiceController as PublicServiceController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Models\Event;
use App\Models\Service;
use App\Models\Announcement;
use App\Models\ServiceRegistration;
use App\Models\Member;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $groups = [];
    return view('index', compact('groups'));
});

// Admin login: dedicated admin sign-in form and POST handler (guest-only)
Route::middleware('guest')->group(function () {
    Route::get('/admin-login', [AdminAuthenticatedSessionController::class, 'create'])
        ->name('admin.login');

    Route::post('/admin-login', [AdminAuthenticatedSessionController::class, 'store'])
        ->name('admin.login.submit');
});

Route::get('/dashboard', [MemberController::class, 'index'])
    ->name('dashboard')
    ->middleware('admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Public site pages: index/home, events and services
Route::get('/index', function () {
    $groups = [];
    return view('index', compact('groups'));
})->name('index');

Route::get('/home', function () {
    $groups = [];
    return view('index', compact('groups'));
})->name('home');

// Group join endpoints removed — group management deleted per request

Route::get('/events', [PublicEventController::class, 'index'])->name('events');

// Admin dashboard-specific events page (rendered as section within dashboard)
Route::middleware('admin')->group(function () {
    Route::get('/admin/events', [EventController::class, 'index'])->name('admin.events');
    Route::post('/admin/events', [EventController::class, 'store'])->name('admin.events.store');
    Route::put('/admin/events/{event}', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/admin/events/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');

    // Groups dashboard and management
    Route::get('/admin/groups', [\App\Http\Controllers\Admin\GroupController::class, 'index'])
        ->name('admin.groups');
    Route::post('/admin/groups', [\App\Http\Controllers\Admin\GroupController::class, 'store'])->name('admin.groups.store');
    Route::put('/admin/groups/{group}', [\App\Http\Controllers\Admin\GroupController::class, 'update'])->name('admin.groups.update');
    Route::delete('/admin/groups/{group}', [\App\Http\Controllers\Admin\GroupController::class, 'destroy'])->name('admin.groups.destroy');
    Route::post('/admin/groups/{group}/members', [\App\Http\Controllers\Admin\GroupController::class, 'addMember'])->name('admin.groups.members.store');
    Route::delete('/admin/groups/{group}/members/{member}', [\App\Http\Controllers\Admin\GroupController::class, 'removeMember'])->name('admin.groups.members.destroy');

    // Admin dashboard-specific services page
    Route::get('/admin/services', [ServiceController::class, 'index'])->name('admin.services');
    Route::post('/admin/services', [ServiceController::class, 'store'])->name('admin.services.store');
    Route::put('/admin/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/admin/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');

    // Admin dashboard-specific announcements page
    Route::get('/admin/announcements', [AnnouncementController::class, 'index'])->name('admin.announcements');
    Route::post('/admin/announcements', [AnnouncementController::class, 'store'])->name('admin.announcements.store');
    Route::put('/admin/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('admin.announcements.update');
    Route::delete('/admin/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('admin.announcements.destroy');

    // Admin dashboard-specific members page
    Route::get('/admin/members', function () {
        $members = Member::orderBy('fullname')->get();
        return view('admin.members_dashboard', compact('members'));
    })->name('admin.members');
});

Route::get('/services', [PublicServiceController::class, 'index'])->name('services');



// Public endpoint: allow anyone to register (modal posts here)
Route::post('/members', [MemberController::class, 'store'])->name('members.store');

// Public: join a group by email (if member exists) or redirect to registration
Route::post('/groups/join', [\App\Http\Controllers\GroupJoinController::class, 'store'])->name('groups.join');

// Protect member-management routes behind auth so only admins can view/manage members
Route::middleware('auth')->group(function () {
    Route::get('/members', [MemberController::class, 'members'])->name('members');
    Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
    Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');
    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
});




Route::get('/service-register', [ServiceRegistrationController::class, 'index'])
    ->name('service.register');


Route::post('/service-register', [ServiceRegistrationController::class, 'store'])
    ->name('service.register');




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
   



