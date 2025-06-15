<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/* Import routes for authentication in role user*/
require __DIR__.'/auth.php';

/* Khai báo các route cho người dùng user */
Route::middleware('auth:web')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

