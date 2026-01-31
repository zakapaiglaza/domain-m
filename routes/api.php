<?php

use Illuminate\Support\Facades\Route;
use Api\Http\Controllers\Auth\AuthController;
use Api\Http\Controllers\DomainController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user',    [AuthController::class, 'user']);
    });
});

Route::middleware('auth:sanctum')->prefix('domains')->group(function () {
    Route::get('/', [DomainController::class, 'index']);
    Route::post('/', [DomainController::class, 'store']);
    Route::get('{id}', [DomainController::class, 'show']);
    Route::put('{id}', [DomainController::class, 'update']);
    Route::delete('{id}', [DomainController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->prefix('domains/{domain}/checks')->group(function () {
    Route::get('/', [DomainController::class, 'checks']);
});
