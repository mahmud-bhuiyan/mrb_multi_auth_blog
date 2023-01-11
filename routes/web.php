<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin.login')->middleware('guest:admin');

Route::post('/admin/login/store', [AuthenticatedSessionController::class, 'store'])->name('admin.login.store');

Route::group(['middleware' => 'admin'], function () {

    Route::prefix('admin')->group(function () {

        Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');

        Route::prefix('category')->group(function () {
            Route::get('/', [CategoryController::class, 'categoryIndex'])->name('admin.category');
            Route::post('/add', [CategoryController::class, 'categoryCreate'])->name('admin.add_category');

            Route::post('/update/{category_id}', [CategoryController::class, 'categoryUpdate']);

            Route::post('/delete/{category_id}', [CategoryController::class, 'categoryDelete']);
        });
    });
});
