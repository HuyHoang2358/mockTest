<?php

use App\Http\Controllers\Admin\Auth\AuthenController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    // Routes for admin authentication
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthenController::class, 'login'])->name('admin.login');
        Route::post('/login', [AuthenController::class, 'adminLogin'])->name('admin.login.post');
    });

    Route::middleware('auth:admin')->group(function (){
        // Auth routes
        Route::get('/logout', [AuthenController::class, 'logout'])->name('admin.logout');

        // Admin dashboard
        Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');

    });




});
