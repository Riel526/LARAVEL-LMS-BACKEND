<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\TeacherService;
use App\Models\Teacher;

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
            'middle_name' => 'nullable|string|max:255',
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

    public function update(Request $request, $id) : JsonResponse {
        $teacher = Teacher::findOrFail($id);
        $user_id = $request['user_id'];

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user_id}",
            'employee_id' => "required|string|unique:teachers,employee_id,{$id},teacher_id",
            'department' => 'nullable|string', 
            'birth_date' => 'required|date|before:today',
            'status' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean'
        ]);

        $teacher = $this->teacherService->updateTeacher($id, $validatedData);

        return response()->json([
            'code' => 200,
            'data' => $teacher
        ], 200);
    }

    public function delete ($id) {
        $this->teacherService->deleteTeacher($id);

        return response()->json([
            'code' => 200,
            'message' => 'Teacher has successfully been deleted'
        ]);
    }
}
