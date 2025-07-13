<?php

use App\Modules\Auth\Controllers\LoginController;
use App\Modules\Auth\Controllers\LogoutController;
use App\Modules\Auth\Middlewares\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::post('/login', [LoginController::class, 'index'])->name('login');
});

Route::name('auth.logout')->middleware(AuthMiddleware::class)->group(function () {
    Route::post('/logout', [LogoutController::class, 'index']);
});
