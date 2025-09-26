<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

if(app()->environment('local')) {
    Route::post('/auth/dev', [AuthController::class, 'devAuth']);
}

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'getUser'])->middleware('auth:sanctum');

    Route::apiResource('/characters', \App\Http\Controllers\CharacterController::class);
    Route::get('/characters/search/{name}', [\App\Http\Controllers\CharacterController::class, 'search']);
    Route::get('/characters/verify/{lodestone_id}', [\App\Http\Controllers\CharacterController::class, 'verify']);

    Route::get('/lodestone/search/{name}', [\App\Http\Controllers\NodestoneController::class, 'search']);
    Route::get('/lodestone/character/{lodestone_id}', [\App\Http\Controllers\NodestoneController::class, 'find']);

    Route::apiResource('/groups', \App\Http\Controllers\GroupController::class);
    Route::post('/groups/{group}/add/{user}', [\App\Http\Controllers\GroupController::class, 'add_member']);
    Route::post('/groups/{group}/remove/{user}', [\App\Http\Controllers\GroupController::class, 'remove_member']);

    Route::get('/schedules/types', [\App\Http\Controllers\ScheduleController::class, 'getTypes']);
    Route::get('/schedules/{schedule}/registrations', [\App\Http\Controllers\ScheduleController::class, 'getRegistrations']);
    Route::get('/schedules/groups/{group}', [\App\Http\Controllers\ScheduleController::class, 'groupSchedules']);
    Route::get('/schedules/groups/{group}/summary', [\App\Http\Controllers\ScheduleController::class, 'groupSchedulesSummary']);
    Route::get('/schedules/groups/{group}/next', [\App\Http\Controllers\ScheduleController::class, 'groupSchedulesNext']);
    Route::apiResource('/schedules', \App\Http\Controllers\ScheduleController::class);
    Route::apiResource('/seats', \App\Http\Controllers\SeatController::class);

    Route::apiResource('/registrations/',  \App\Http\Controllers\RegistrationController::class);
//    Route::apiResource('/assignments', \App\Http\Controllers\AssignmentController::class);

    Route::get('/classes', [\App\Http\Controllers\FFClassController::class, 'index']);
    Route::get('/fights', [\App\Http\Controllers\FightController::class, 'index']);

});

