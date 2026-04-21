<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::prefix('students')->group(function() {
    Route::get('/get-students', [StudentController::class, 'index']);
    Route::post('/add-student', [StudentController::class, 'store']);
    Route::put('/update-student/{id}', [StudentController::class, 'update']);
});
