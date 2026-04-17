<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\TicketController as UserTicketController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// ========== GUEST ROUTES (belum login) ==========
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ========== PROFILE ROUTES (tanpa middleware profile.complete) ==========
Route::middleware(['auth'])->group(function () {
    // Profile User
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
});

// ========== USER ROUTES (auth + profile lengkap) ==========
Route::middleware(['auth', 'profile.complete'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard User
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Tickets User
    Route::resource('tickets', UserTicketController::class);
    Route::post('tickets/{id}/close', [UserTicketController::class, 'close'])->name('tickets.close');
});

// ========== ADMIN ROUTES ==========
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Tickets Admin
        Route::resource('tickets', AdminTicketController::class);
        Route::put('tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.updateStatus');
        
        // Profile Admin
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
    });