<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthenController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\FolderController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Admin\Question\QuestionTypeController;
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

        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileAdminController::class, 'show'])->name('admin.show');
            Route::put('/update', [ProfileAdminController::class, 'update'])->name('admin.update');
            Route::put('/reset-password', [ProfileAdminController::class, 'changePassword'])->name('admin.changePassword');
            Route::post('/delete', [ProfileAdminController::class, 'destroy'])->name('admin.destroy');
            Route::post('/update-image', [ProfileAdminController::class, 'personal_change_image'])->name('admin.personal.change-image');
        });

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

        // Quản lý  bài tập, đề thi
        Route::prefix('exams')->group(function () {
            Route::get('/', [ExamController::class, 'index'])->name('admin.exam.index');
            Route::get('/{id}', [ExamController::class, 'detail'])->name('admin.exam.detail');
            Route::post('/store', [ExamController::class, 'store'])->name('admin.exam.store');
            Route::get('/edit/{id}', [ExamController::class, 'edit'])->name('admin.exam.edit');
            Route::post('/update/{id}', [ExamController::class, 'update'])->name('admin.exam.update');
            Route::post('/delete', [QuestionTypeController::class, 'destroy'])->name('admin.exam.destroy');
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
            Route::put('/reset-password/{id}', [UserController::class, 'resetPassword'])->name('admin.user.reset');
            Route::get('/export', [UserController::class, 'export'])->name('admin.user.export');
            Route::get('user/{id}/profile', [UserController::class, 'showProfileForm'])->name('admin.user.profile.form');
            Route::post('user/{id}/profile', [UserController::class, 'storeProfile'])->name('admin.user.profile.store');
        });

            // admin
            Route::prefix('teacher')->group(function () {
                Route::get('/', [AdminController::class, 'index'])->name('teacher.index');
                Route::get('/create', [AdminController::class, 'create'])->name('teacher.create');
                Route::post('/store', [AdminController::class, 'store'])->name('teacher.store');
                Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('teacher.edit');
                Route::post('/update/{id}', [AdminController::class, 'update'])->name('teacher.update');
                Route::post('/delete', [AdminController::class, 'destroy'])->name('teacher.destroy');
                Route::put('/reset-password/{id}', [AdminController::class, 'resetPassword'])->name('teacher.reset');
                Route::get('/export', [AdminController::class, 'export'])->name('teacher.export');
            });
        });
    });
});
