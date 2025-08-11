<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

if(app()->environment('local')) {
    Route::post('/auth/dev', [AuthController::class, 'devAuth']);
}

Route::get('/user', [\App\Http\Controllers\UserController::class, 'getUser'])->middleware('auth:sanctum');
