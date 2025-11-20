<?php

use App\Http\Controllers\Admin\BuktiPembayaranController;
use App\Http\Controllers\Admin\EkspedisiController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanPesananController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
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

    // Produk CRUD
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    // Kategori CRUD
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Ekspedisi
    Route::get('/ekspedisi', [EkspedisiController::class, 'index'])->name('ekspedisi.index');
    Route::post('/ekspedisi', [EkspedisiController::class, 'store'])->name('ekspedisi.store');
    Route::put('/ekspedisi/{id}', [EkspedisiController::class, 'update'])->name('ekspedisi.update');
    Route::delete('/ekspedisi/{id}', [EkspedisiController::class, 'destroy'])->name('ekspedisi.destroy');

    // Halaman tambahan admin
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/billing', [DashboardController::class, 'billing'])->name('billing');
    Route::get('/management', [DashboardController::class, 'management'])->name('management');

    // Metode Pembayaran (Admin)
    Route::get('/payment-method', [PaymentMethodController::class, 'index'])->name('payment.index');
    Route::post('/payment-method', [PaymentMethodController::class, 'store'])->name('payment.store');
    Route::put('/payment-method/{id}', [PaymentMethodController::class, 'update'])->name('payment.update');
    Route::delete('/payment-method/{id}', [PaymentMethodController::class, 'destroy'])->name('payment.destroy');

    // Bukti Pembayaran
    Route::get('/bukti-pembayaran', [BuktiPembayaranController::class, 'index'])
        ->name('bukti.index');

    // Detail
    Route::get('/bukti-pembayaran/{id}', [BuktiPembayaranController::class, 'show'])
        ->name('bukti.show');

    // Approve
    Route::post('/bukti-pembayaran/{id}/approve', [BuktiPembayaranController::class, 'approve'])
        ->name('bukti.approve');

    // Reject
    Route::post('/bukti-pembayaran/{id}/reject', [BuktiPembayaranController::class, 'reject'])
        ->name('bukti.reject');

    // Delete
    Route::delete('/bukti-pembayaran/{id}', [BuktiPembayaranController::class, 'destroy'])
        ->name('bukti.destroy');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::get('/laporan', [LaporanPesananController::class, 'index'])->name('laporan.index');
});


// ===================== USER =====================
Route::middleware(['auth'])->group(function () {

    // ================= CHECKOUT =================
    Route::post('/checkout/single', [CheckoutController::class, 'checkoutSingle'])
        ->name('checkout.single');

    Route::post('/checkout/cart', [CheckoutController::class, 'checkoutCart'])
        ->name('checkout.cart');

    Route::post('/checkout/buy-now/{id}', [CheckoutController::class, 'buyNow'])
        ->name('checkout.buy-now');

    // HALAMAN CHECKOUT PAKAI SATU ROUTE SAJA
    Route::get('/checkout', [CheckoutController::class, 'page'])
        ->name('checkout.page');

    // PROSES CHECKOUT
    Route::post('/checkout/submit', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    Route::post('/checkout/from-cart', [CheckoutController::class, 'checkoutCart'])->name('checkout.fromCart');

    // ================= KERANJANG =================
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/add/{product}', [KeranjangController::class, 'add'])->name('keranjang.add');
    Route::post('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::get('/keranjang/remove/{id}', [KeranjangController::class, 'remove'])->name('keranjang.remove');
    Route::get('/keranjang/clear', [KeranjangController::class, 'clear'])->name('keranjang.clear');

    // ================= PAYMENT =================
    Route::get('/payments', [PembayaranController::class, 'list'])->name('payment.index');
    // Route::get('/payment/{id}', [PembayaranController::class, 'show'])->name('payment.show');
    Route::get('/payment/{id}',  [PembayaranController::class, 'bayar'])->name('payment.bayar');
    Route::post('/payment/upload/{orderId}', [PembayaranController::class, 'uploadBukti'])
        ->name('payment.upload');

    Route::post('/payment/cancel/{id}', [PembayaranController::class, 'cancel'])->name('payment.cancel');


    Route::get('/pesanan', [App\Http\Controllers\RiwayatPesananController::class, 'index'])
        ->name('pesanan.index')
        ->middleware('auth');
});



// ===================== HOME PAGE =====================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ===================== PRODUK DETAIL =====================
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');
Route::get('/produk/live-search', [ProdukController::class, 'liveSearch'])->name('produk.liveSearch');

// ===================== RESET PASSWORD =====================
Route::get('/reset-password', fn() => view('auth.reset-password'))->name('reset-password');
