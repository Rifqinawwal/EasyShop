<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;


// Halaman Depan
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman untuk melihat semua produk (untuk publik)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Halaman Dashboard default dari Breeze
Route::get('/dashboard', function () {
    $user = Auth::user(); // Ambil data user yang login
    return view('dashboard', ['user' => $user]); // Kirim variabel $user ke view
})->middleware(['auth', 'verified'])->name('dashboard');

// GRUP ROUTE KHUSUS ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class);
    // Nanti route untuk manajemen user, kategori, dll. ditaruh di sini
});

// Grup route yang memerlukan login
Route::middleware('auth')->group(function () {
    // Route untuk profile (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

    // Grup route untuk produk milik user
    Route::prefix('user/products')->name('user.products.')->group(function () {
        Route::get('/', [UserProductController::class, 'index'])->name('index');
        Route::get('/create', [UserProductController::class, 'create'])->name('create');
        Route::post('/', [UserProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [UserProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [UserProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [UserProductController::class, 'destroy'])->name('destroy');

    
    });
});

require __DIR__.'/auth.php';