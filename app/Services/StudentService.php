<?php


namespace App\Services;

use App\Models\Student;

class StudentService {

  public function getAllStudents () {

    return Student::orderBy('created_at', 'desc')->get();

  }

  public function createStudent (array $data) {

    return Student::create($data);

  }

  public function updateStudent(int $id, array $data) {
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

  public function deleteStudent(int $id) {
    $student = Student::findOrFail($id);
    return $student->delete();
  }

}