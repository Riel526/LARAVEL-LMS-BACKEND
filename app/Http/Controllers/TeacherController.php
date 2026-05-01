<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\TeacherService;

class TeacherController extends Controller
{
    protected $teacherService;

    public function __construct(TeacherService $teacherService) {
        $this->teacherService = $teacherService;
    }


    public function index(Request $request) : JsonResponse {
        $teachers = $this->teacherService->getAllTeachers();

        return response()->json($teachers, 200);
    }

    public function store(Request $request) : JsonResponse {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'employee_id' => 'required|string|unique:teachers,employee_id',
            'department' => 'required|string', 
            'birth_date' => 'required|date_format:Y/m/d|before:today',
            'status' => 'required|string|max:255',
        ]);

        $teacher = $this->teacherService->addTeacher($validatedData);

        return response()->json([
            'code' => 201,
            'status' => 'success',
            'message' => 'Teacher created successfully!',
            'data' => $teacher
        ], 201);
    }
}
