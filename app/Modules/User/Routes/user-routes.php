<?php

use App\Modules\Auth\Middlewares\AuthMiddleware;
use App\Modules\User\Controllers\CreateUserController;
use App\Modules\User\Controllers\WhoamiController;
use Illuminate\Support\Facades\Route;

Route::name('users.')->middleware(AuthMiddleware::class)->group(function () {
    Route::post('/users', [CreateUserController::class, 'index'])->name('create');
    Route::get('/whoami', [WhoamiController::class, 'index'])->name('whoami');
});
