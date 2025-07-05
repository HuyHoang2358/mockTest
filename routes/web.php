<?php


use App\Http\Controllers\Front\ExamController;
use App\Http\Controllers\Front\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProfileUserController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;

/* Import routes for authentication in role user*/
require __DIR__.'/auth.php';

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
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


    Route::prefix('exam/{code}')->group(function () {
        Route::get('/', [ExamController::class, 'index'])->name('user.exam.index'); // Chế độ kiểm tra
        Route::get('/exercise', [ExamController::class, 'exercise'])->name('user.exam.exercise'); // Chế độ kiểm tra
        Route::get('/todo', [ExamController::class, 'todo'])->name('user.exam.todo'); // Chế độ tự luyện
        Route::post('/{questionId}/submit-answer', [ExamController::class, 'answerHistory'])->name('user.exam.answer'); // Lưu đáp án
        Route::get('/finish', [ExamController::class, 'finishExam'])->name('user.exam.finish'); // Kết thúc bài thi
        Route::get('/view/answer', [ExamController::class, 'viewAnswer'])->name('user.exam.view-answer'); // Xem đáp án đã làm
    });
});


