<?php

use App\Http\Controllers\Admin\Auth\AuthenController;
use App\Http\Controllers\Admin\FolderController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Question\QuestionTypeController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UserController;
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
            Route::post('/update', [FolderController::class, 'update'])->name('admin.folder.update');
            Route::post('/delete', [FolderController::class, 'destroy'])->name('admin.folder.destroy');
            Route::get('/copy/{id}', [FolderController::class, 'copy'])->name('admin.folder.copy');
        });

        // Quản lý danh mục
        Route::prefix('question-types')->group(function () {
            Route::get('/', [QuestionTypeController::class, 'index'])->name('admin.question-type.index');
            Route::post('/store', [QuestionTypeController::class, 'store'])->name('admin.question-type.store');
            Route::get('/edit/{id}', [QuestionTypeController::class, 'edit'])->name('admin.question-type.edit');
            Route::post('/update/{id}', [QuestionTypeController::class, 'update'])->name('admin.question-type.update');
            Route::post('/delete', [QuestionTypeController::class, 'destroy'])->name('admin.question-type.destroy');
        });


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
});
