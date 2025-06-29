<?php


use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Front\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProfileUserController;
use Illuminate\Support\Facades\Route;

/* Import routes for authentication in role user*/
require __DIR__.'/auth.php';

/* Khai báo các route cho người dùng user */
Route::middleware('auth:web')->group(function () {
    Route::get('/logout', [AuthenticatedSessionController::class, 'userLogout'])->name('user.logout');

    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileUserController::class, 'show'])->name('user.show');
        Route::put('/update', [ProfileUserController::class, 'update'])->name('user.update');
        Route::put('/reset-password', [ProfileUserController::class, 'changePassword'])->name('user.changePassword');
        Route::post('/delete', [ProfileUserController::class, 'destroy'])->name('user.destroy');
        Route::post('/update-image', [ProfileUserController::class, 'personal_change_image'])->name('profile.personal.change-image');
    });

    Route::prefix('exam')->group(function () {
        Route::get('/listening', [ExamController::class, 'listen'])->name('exam.listen');
        Route::get('/reading', [ExamController::class, 'read'])->name('exam.read');

    });
});

