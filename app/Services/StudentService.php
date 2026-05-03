<?php


namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Facades\DB;
use App\Services\AuthService;

class StudentService {

  protected $authService;

  public function __construct(AuthService $authService) {
    $this->authService = $authService;
  }

  public function getAllStudents () {

    return Student::with('user')->get()->map(function ($student) {
      return [
            'student_id' => $student->student_id,
            'user_id' => $student->user_id,
            'lrn'  => $student->lrn,
            'grade_level' => $student->grade_level,
            'section'  => $student->section,
            'gwa' => $student->gwa,
            'is_active' => $student->is_active,
            'first_name' => $student->user->first_name,
            'middle_name' => $student->user->middle_name,
            'last_name' => $student->user->last_name,
            'email' => $student->user->email,
            'username' => $student->user->username,
            'birth_date' => $student->user->birth_date,
            'created_at' => $student->created_at,
        ];
    });

  }

  public function createStudent (array $data) {

    return DB::transaction(function () use ($data) {
      $data['role'] = 'student';

      $user = $this->authService->register($data);
      return Student::create([
        'user_id' => $user['user']->id,
        'lrn' => $data['lrn'],
        'grade_level' => $data['grade_level'],
        'section' => $data['section'],
        'gwa' => $data['gwa'] ?? 0.00,
      ]);
    });

  }

  public function updateStudent(int $id, array $data) {

    return DB::transaction(function () use ($id, $data) {
      $student = Student::findOrFail($id);

      $student->user->update([
        'first_name' => $data['first_name'],
        'middle_name' => $data['middle_name'] ?? null,
        'last_name' => $data['last_name'],
        'email' => $data['email'],
        'birth_date' => $data['birth_date'],
      ]);

      $student->update([
        'lrn' => $data['lrn'],
        'grade_level' => $data['grade_level'],
        'section' => $data['section'],
        'birth_date' => $data['birth_date'],
        'is_active' => $data['is_active'],
      ]);
    });
  }

  public function deleteStudent(int $id) {
    $student = Student::findOrFail($id);
    $user = $student->user;

    if ($user) {
      $user->delete();
    }
    
    return $student->delete();
  }

}