<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ScheduleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('students')->group(function() {
        Route::get('/get-students', [StudentController::class, 'index']);
        Route::post('/add-student', [StudentController::class, 'store']);
        Route::put('/update-student/{id}', [StudentController::class, 'update']);
        Route::delete('/delete-student/{id}', [StudentController::class, 'delete']);
    });

    Route::prefix('subjects')->group(function() {
        Route::get('/get-subjects', [SubjectController::class, 'index']);
        Route::post('/add-subject', [SubjectController::class, 'store']);
        Route::put('/update-subject/{id}', [SubjectController::class, 'update']);
        Route::delete('/delete-subject/{id}', [SubjectController::class, 'delete']);
    });

    Route::prefix('teachers')->group(function() {
        Route::get('/get-teachers', [TeacherController::class, 'index']);
        Route::post('/add-teacher', [TeacherController::class, 'store']);
        Route::put('/update-teacher/{id}', [TeacherController::class, 'update']);
        Route::delete('/delete-teacher/{id}', [TeacherController::class, 'delete']);
    });


    Route::prefix('schedule')->group(function() {
        Route::get('/get-schedule', [ScheduleController::class, 'index']);
    });
});
