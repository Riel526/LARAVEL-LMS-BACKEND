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
        // user fields
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',


        // student fields
        'grade_level' => 'required|string',
        'section' => 'required|string',
        'lrn' => 'required|string|unique:students,lrn',
        'birth_date' => 'required|date_format:Y/m/d|before:today',
        ]);

        $student = $this->studentService->createStudent($validatedData);

        return response()->json([
            'status' => 'success',
            'code' => 201,
            'message' => 'Student created successfully!',
            'data' => $student
        ], 201);
    }

    public function update (Request $request, $id): JsonResponse {
        $validatedData = $request->validate([
        'lrn' => 'required|string|size:10|unique:students,lrn,' . $id,
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:students,email,' . $id,
        'grade_level' => 'required|string',
        'section' => 'required|string',
        'birth_date' => 'required|date',
        'is_active' => 'required|boolean'
        ]);

        $student = $this->studentService->updateStudent($id, $validatedData);

        return response()->json([
        'success' => true,
        'code' => 200,
        'data' => $student,
        'message' => 'Student updated successfully'
        ]);
    }

        public function delete (int $id): JsonResponse {
        $studentId = (int) $id;

        $student = $this->studentService->deleteStudent($studentId);

        return response()->json([
        'success' => true,
        'code' => 200,
        'data' => $student,
        'message' => 'Student deleted successfully'
        ]);
    }
}
