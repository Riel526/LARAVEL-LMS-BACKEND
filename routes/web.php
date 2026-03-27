<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::prefix('auth')->group(function() {
     Route::post('/login', [AuthController::class, 'login']);
    });
});
