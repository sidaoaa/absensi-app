<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// User routes
Route::middleware(['auth', 'access-level:user'])->group(function () {
    Route::get('/presence', [PresenceController::class, 'index'])->name('presence.index');
    
    
    Route::get('/presence/sign-in', [PresenceController::class, 'signIn'])->name('presence.in');
    Route::post('/presence/sign-in', [PresenceController::class, 'storeSignIn'])->name('presence.in_store');

    Route::get('/presence/sign-out', [PresenceController::class, 'signOut'])->name('presence.out');
    Route::post('/presence/sign-out', [PresenceController::class, 'storeSignOut'])->name('presence.out_store');
});

// Admin routes
Route::middleware(['auth', 'access-level:admin'])->group(function () {
    Route::get('/admin', [SummaryController::class, 'index'])->name('admin.summary');

    // Create user
    
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/admin/adduser', [UserController::class, 'index'])->name('admin.createuser');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');

    // Edit user
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.edituser');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');

    // Delete user
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Master Data routes
    Route::get('/admin/karyawan', [SummaryController::class, 'karyawan'])->name('admin.karyawan');
    Route::get('/admin/absen-masuk', [SummaryController::class, 'absenIn'])->name('admin.in');
    Route::get('/admin/absen-keluar', [SummaryController::class, 'absenOut'])->name('admin.out');

    // Report route
    Route::get('/admin/report', [SummaryController::class, 'report'])->name('admin.report');

});

Auth::routes();
