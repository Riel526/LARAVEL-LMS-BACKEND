<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use App\Services\StudentService;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService) {
        $this->studentService = $studentService;
    }

    public function index (Request $request): JsonResponse {
        $students = $this->studentService->getAllStudents();

        return response()->json($students, 200);
    }

    public function store (Request $request): JsonResponse {
        $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:students,email',
        'grade_level' => 'required|string',
        'section' => 'required|string',
        'is_active' => 'boolean',
        'birth_date' => 'required|date_format:Y/m/d|before:today',
        ]);

        $student = $this->studentService->createStudent();

        return response()->json([
            'status' => 'success',
            'code' => 201,
            'message' => 'Student created successfully!',
            'data' => $student
        ], 201);
    }
}
