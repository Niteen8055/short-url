<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShortURLController;
use Illuminate\Support\Facades\Route;

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

// Admin Group Middleware 
Route::middleware(['auth', 'roles:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

}); // End Admin Group Middleware 

Route::middleware(['auth','subscription'])->group(function () {

    Route::get('/short-url/show', [ShortURLController::class, 'show'])->name('short_url_show');
    Route::post('/short-url/create', [ShortURLController::class, 'create'])->name('short_url_create');
    Route::get('/short-url/list', [ShortURLController::class, 'list'])->name('short_url_list'); 


    //common route for user and admin
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');

    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
});


// Catch-all route for short URL redirection
Route::get('/{shortURLKey}', [ShortURLController::class, '__invoke'])->name('shortURL.redirect');

require __DIR__ . '/auth.php';
