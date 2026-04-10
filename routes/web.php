<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\UserController;
use App\Models\Brand;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// User Routes
Route::get('/',[UserController::class,'index'])->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
// End User Routes


// Admin Routes
Route::group(['prefix' => 'admin','middleware' => 'redirectAdmin'], function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Product Routes
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::post('/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::patch('/products/update/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('admin.products.delete');
    Route::delete('/products/image/delete/{id}', [ProductController::class, 'deleteImage'])->name('admin.products.image.delete');

    // Brand Routes
    Route::get('/brands', [BrandController::class, 'index'])->name('admin.brands.index');
    Route::post('/brands/store', [BrandController::class, 'store'])->name('admin.brands.store');
    Route::patch('/brands/update/{id}', [BrandController::class, 'update'])->name('admin.brands.update');
    Route::delete('/brands/delete/{id}', [BrandController::class, 'destroy'])->name('admin.brands.delete');

});



// End Admin Routes


require __DIR__.'/auth.php';
