<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

if(app()->environment('local')) {
    Route::post('/auth/dev', [AuthController::class, 'devAuth']);
}

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'getUser'])->middleware('auth:sanctum');

    Route::apiResource('/characters', \App\Http\Controllers\CharacterController::class);
    Route::get('/characters/search/{name}', [\App\Http\Controllers\CharacterController::class, 'search']);
    Route::get('/characters/verify/{lodestone_id}', [\App\Http\Controllers\CharacterController::class, 'verify']);

    Route::get('/lodestone/search/{name}', [\App\Http\Controllers\NodestoneController::class, 'search']);
    Route::get('/lodestone/character/{lodestone_id}', [\App\Http\Controllers\NodestoneController::class, 'find']);
});

