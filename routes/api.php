<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DataController;


Route::prefix('v1')->group(function() {

    Route::post('registration', RegistrationController::class)
        ->name('registration');

    Route::post('login', AuthController::class)
        ->name('login');

    Route::post('user/forgot_password', [UsersController::class, 'forgotPassword'])
        ->name('user.forgot_password');


    Route::middleware('auth:sanctum')->group(function() {
        Route::prefix('data')->group(function() {

            Route::post('create', [DataController::class, 'create'])
                ->name('data.create');

            Route::post('delete', [DataController::class, 'delete'])
                ->name('data.delete');

            Route::post('update', [DataController::class, 'update'])
                ->name('data.update');

            Route::post('get_all', [DataController::class, 'getAll'])
                ->name('data.get_all');

            Route::post('get_by_id', [DataController::class, 'getById'])
                ->name('data.get_by_id');
        });

    });
});
