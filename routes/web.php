<?php
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\ServiceRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Serve the custom admin login page at /admin-login
Route::get('/admin-login', function () {
    return view('login');
})->name('admin.login');

Route::get('/dashboard', [MemberController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Public site pages: index/home, events and services
Route::get('/index', function () {
    return view('index');
})->name('index');

Route::get('/home', function () {
    return view('index');
})->name('home');

Route::get('/events', function () {
    return view('events');
})->name('events');

Route::get('/services', function () {
    return view('services');
})->name('services');



// Public endpoint: allow anyone to register (modal posts here)
Route::post('/members', [MemberController::class, 'store'])->name('members.store');

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
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/admin/service-registrations', [ServiceRegistrationController::class, 'index'])
        ->name('service.registrations');

    // import/export removed per rollback request
});
   




