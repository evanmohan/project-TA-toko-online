<?php

use App\Http\Controllers\Admin\EkspedisiController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PembayaranController;
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

    Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/profile/update', [UserController::class, 'update'])->name('user.update');
    // ✅ Produk CRUD (otomatis: index, create, store, show, edit, update, destroy)

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
    // Route::resource('pesanan', PesananController::class)->only(['index', 'show', 'update']);
    // Route::resource('user', UserController::class)->only(['index', 'destroy']);

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
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [PesananController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [PesananController::class, 'store'])->name('checkout.store');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/add/{product}', [KeranjangController::class, 'add'])->name('keranjang.add');
    Route::post('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::get('/keranjang/remove/{id}', [KeranjangController::class, 'remove'])->name('keranjang.remove');
    Route::get('/keranjang/clear', [KeranjangController::class, 'clear'])->name('keranjang.clear');

    // Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    // Route::post('/checkout/beli', [CheckoutController::class, 'beliLangsung'])->name('checkout.beliLangsung');
    // Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
    // Route::get('/checkout/bayar/{id}', [CheckoutController::class, 'bayar'])->name('checkout.bayar');
    // Route::post('/checkout/upload/{id}', [CheckoutController::class, 'uploadBukti'])->name('checkout.upload');
    // CHECKOUT (PesananController sudah kamu punya)
    Route::get('/checkout', [App\Http\Controllers\PesananController::class, 'checkout'])->name('pesanan.checkout');

    // PAYMENT
    Route::get('/payment/{id}', [PembayaranController::class, 'index'])->name('payment.index');
    Route::post('/payment/{id}', [PembayaranController::class, 'uploadProof'])->name('payment.upload');
});


// ===================== HOME PAGE =====================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ===================== PRODUK DETAIL =====================
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');
Route::get('/produk/live-search', [ProdukController::class, 'liveSearch'])->name('produk.liveSearch');
// ===================== RESET PASSWORD =====================
Route::get('/reset-password', fn() => view('auth.reset-password'))->name('reset-password');
