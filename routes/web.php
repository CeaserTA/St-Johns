<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [MemberController::class, 'index'])->name('dashboard');
Route::get('/members', [MemberController::class, 'members'])->name('members');
Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
Route::post('/members', [MemberController::class, 'store'])->name('members.store');
Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');
Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');