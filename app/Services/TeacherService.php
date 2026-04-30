<?php


namespace App\Services;

use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use App\Services\AuthService;

class TeacherService {

  protected $authService;

  public function __construct(AuthService $authService) {

    $this->authService = $authService;
    
  }


  public function getAllTeachers () {

    return Teacher::with('user')->get()->map(function ($teacher) {
      return [
        'teacher_id' => $teacher->teacher_id,
        'user_id' => $teacher->user_id,
        'employee_id'  => $teacher->employee_id,
        'specialization' => $teacher->specialization,
        'department'  => $teacher->department,
        'status' => $teacher->status,
        'is_active' => $teacher->is_active,
        'first_name' => $teacher->user->first_name,
        'middle_name' => $teacher->user->middle_name,
        'last_name' => $teacher->user->last_name,
        'email' => $teacher->user->email,
        'username' => $teacher->user->username,
        'birth_date' => $teacher->user->birth_date,
        'created_at' => $teacher->created_at,
      ];
    });

  }

  public function createTeacher (array $data) {

    return DB::transaction(function () use ($data) {
      $data['role'] = 'teacher';

      $user = $this->authService->register($data); 

      return $user->teacher()->create([
          'employee_id' => $data['employee_id'],
          'department' => $data['department'],
          'specialization' => $data['specialization'] ?? null,
      ]);
    });

  }

  public function updateTeacher(int $id, array $data) {
    $student = Student::findOrFail($id);

    $student->update([
      'lrn' => $data['lrn'],
      'first_name' => $data['first_name'],
      'middle_name' => $data['middle_name'] ?? null,
      'last_name' => $data['last_name'],
      'email' => $data['email'],
      'grade_level' => $data['grade_level'],
      'section' => $data['section'],
      'birth_date' => $data['birth_date'],
      'is_active' => $data['is_active'],
    ]);
  }

  public function deleteTeacher(int $id) {
    $student = Student::findOrFail($id);
    return $student->delete();
  }

}