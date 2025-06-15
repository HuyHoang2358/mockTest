<?php

use App\Http\Controllers\Admin\Auth\AuthenController;
use App\Http\Controllers\Admin\FolderController;
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

        // Quản lý folder bài tập, đề thi
        Route::prefix('folders')->group(function () {
            Route::get('/', [FolderController::class, 'index'])->name('admin.folder.index');
            Route::post('/', [FolderController::class, 'store'])->name('admin.folder.store');
            Route::put('/{id}', [FolderController::class, 'update'])->name('admin.folder.update');
            Route::get('/{id}', [FolderController::class, 'copy'])->name('admin.folder.copy');
            Route::post('/delete', [FolderController::class, 'destroy'])->name('admin.folder.destroy');
        });

    });




});
