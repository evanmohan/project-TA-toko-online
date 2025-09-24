<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\UserController;

// ================= ADMIN =================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::resource('produk', ProdukController::class);
    Route::resource('pesanan', PesananController::class)->only(['index','show','update']);
    Route::resource('user', UserController::class)->only(['index','destroy']);
});

// ================= AUTH =================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
// Route::post('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= USER DASHBOARD =================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'user'])->name('user.dashboard');
});
