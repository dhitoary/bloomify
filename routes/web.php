<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Product routes
Route::get('/katalog', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/kategori/{category:slug}', [ProductController::class, 'filterByCategory'])->name('products.category');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Cart Routes (only for authenticated users, not admin)
Route::middleware(['auth', 'verified'])->prefix('keranjang')->name('cart.')->group(function () {
    Route::get('/', [\App\Http\Controllers\CartController::class, 'index'])->name('index');
    Route::post('/tambah', [\App\Http\Controllers\CartController::class, 'add'])->name('add');
    Route::patch('/{cart}/update', [\App\Http\Controllers\CartController::class, 'update'])->name('update');
    Route::delete('/{cart}', [\App\Http\Controllers\CartController::class, 'remove'])->name('remove');
});

// Checkout Routes (only for authenticated users, not admin)
Route::middleware(['auth', 'verified'])->prefix('checkout')->name('checkout.')->group(function () {
    Route::post('/create', [\App\Http\Controllers\CheckoutController::class, 'create'])->name('create');
    // Fallback: jika user akses GET /checkout/create (misal back button), redirect ke keranjang
    Route::get('/create', function () {
        return redirect()->route('cart.index')->with('info', 'Silakan pilih produk dari keranjang untuk checkout.');
    });
    Route::get('/', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('index');
    Route::post('/submit', [\App\Http\Controllers\CheckoutController::class, 'submit'])->name('submit');
    Route::get('/shipping-cost', [\App\Http\Controllers\CheckoutController::class, 'getShippingCost'])->name('shipping-cost');
});

// Order Routes (only for authenticated users, not admin)
Route::middleware(['auth', 'verified'])->prefix('orders')->name('order.')->group(function () {
    Route::get('/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('show');
});

// Payment Routes (only for authenticated users, not admin)
Route::middleware(['auth', 'verified'])->prefix('payment')->name('payment.')->group(function () {
    Route::get('/{orderId}', [PaymentController::class, 'show'])->name('show');
    Route::post('/{orderId}/token', [PaymentController::class, 'createToken'])->name('token');
    Route::get('/{orderId}/finish', [PaymentController::class, 'finish'])->name('finish');
    Route::get('/{orderId}/error', [PaymentController::class, 'error'])->name('error');
    Route::get('/{orderId}/pending', [PaymentController::class, 'pending'])->name('pending');
});

// Midtrans notification webhook (no auth, excluded from CSRF)
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');

// Admin Dashboard Routes
Route::middleware(['auth', 'verified', 'is_admin'])->prefix('admin-dashboard')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    
    // Orders Management
    Route::patch('/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Products CRUD
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    
    // Categories CRUD
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Review Routes
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__.'/auth.php';
