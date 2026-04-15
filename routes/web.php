<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\TicketController;
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
// DITEMBAHKAN INI
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// ========== USER ROUTES (auth user biasa + profile lengkap) ==========
// UBAH middleware dari 'auth' menjadi ['auth', 'profile.complete']
Route::middleware(['auth', 'profile.complete'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile User Biasa (index saja)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // Tickets User Biasa
    Route::resource('tickets', TicketController::class);
    Route::post('tickets/{id}/close', [TicketController::class, 'close'])->name('tickets.close');
});

// ========== ADMIN ROUTES ==========
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('dashboard');
        Route::resource('tickets', AdminTicketController::class);
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });