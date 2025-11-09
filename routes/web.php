<?php

use App\Http\Controllers\Admin\EkspedisiController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===================== AUTH =====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ===================== ADMIN =====================
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // ✅ Produk CRUD (otomatis: index, create, store, show, edit, update, destroy)
    Route::resource('produk', ProdukController::class);
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    // ✅ Kategori CRUD (manual routes)
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // ✅ Pesanan & User
    Route::resource('pesanan', PesananController::class)->only(['index', 'show', 'update']);
    Route::resource('user', UserController::class)->only(['index', 'destroy']);

    // ✅ Ekspedisi
    Route::get('/ekspedisi', [EkspedisiController::class, 'index'])->name('ekspedisi.index');
    Route::post('/ekspedisi', [EkspedisiController::class, 'store'])->name('ekspedisi.store');
    Route::put('/ekspedisi/{id}', [EkspedisiController::class, 'update'])->name('ekspedisi.update');
    Route::delete('/ekspedisi/{id}', [EkspedisiController::class, 'destroy'])->name('ekspedisi.destroy');

    // ✅ Halaman tambahan admin
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/billing', [DashboardController::class, 'billing'])->name('billing');
    Route::get('/management', [DashboardController::class, 'management'])->name('management');
});


// ===================== USER =====================
Route::middleware(['role:customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'user'])->name('user.dashboard');
});

// ===================== HOME PAGE =====================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ===================== RESET PASSWORD =====================
Route::get('/reset-password', fn() => view('auth.reset-password'))->name('reset-password');
