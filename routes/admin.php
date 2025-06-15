<?php

use App\Http\Controllers\Admin\Auth\AuthenController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    // Routes for admin authentication
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthenController::class, 'login'])->name('admin.login');
        Route::post('/login', [AuthenController::class, 'adminLogin']);
    });

    Route::middleware('guest:admin')->get('/', [HomeController::class, 'index'])->name('admin.dashboard');

    // Quản lý tài khoản
    Route::prefix('accounts')->group(function () {
        //users
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
            Route::get('/add', [UserController::class, 'create'])->name('admin.user.create');
            Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
            Route::post('/delete', [UserController::class, 'destroy'])->name('admin.user.destroy');
        });

        // admin
        Route::prefix('teacher')->group(function () {
            Route::get('/', [TeacherController::class, 'index'])->name('admin.teacher.index');
            Route::get('/create', [TeacherController::class, 'create'])->name('admin.teacher.create');
            Route::post('/store', [TeacherController::class, 'store'])->name('admin.teacher.store');
            Route::get('/edit/{id}', [TeacherController::class, 'edit'])->name('admin.teacher.edit');
            Route::post('/update/{id}', [TeacherController::class, 'update'])->name('admin.teacher.update');
            Route::post('/delete', [TeacherController::class, 'destroy'])->name('admin.teacher.destroy');
            Route::put('/reset-password/{id}', [TeacherController::class, 'resetPassword'])->name('admin.teacher.reset');
            Route::get('/export', [TeacherController::class, 'export'])->name('admin.teacher.export');
        });
    });


});
