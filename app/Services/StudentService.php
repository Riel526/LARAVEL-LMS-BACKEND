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

}