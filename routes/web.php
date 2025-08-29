<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/api/auth/redirect',  [AuthController::class, 'redirect']);

Route::get('/auth/callback',  [AuthController::class, 'callback']);

Route::view('/docs/api', 'scribe.index')->name('public_docs');
