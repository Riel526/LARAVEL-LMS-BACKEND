<?php


namespace App\Services;

use App\Models\Assignment;
use Illuminate\Support\Facades\DB;

class AssignmentService {

  protected $authService;

  public function __construct(AuthService $authService) {

    $this->authService = $authService;
    
  }


  public function getAssignments () {

  }

  public function addAssignments ($data) {

    DB::transaction(function() use ($data) {
      $assignment = Assignment::create([
        'teacher_id' => $data['teacher_id'],
        'subject_id' => $data['subject_id'],
        'grade_level' => $data['grade_level'],
        'section' => $data['section'],
        'title' => $data['title'],
        'instructions' => $data['instructions'],
        'due_date'=> $data['due_date']
    ]);

    foreach ($data['questions'] as $questionData) {
      $assignment->questions->create($questionData);
    }

    });

    return $assignment;

  }

  public function updateAssignment(int $id, array $data) {

    }

  public function deleteAssignment(int $id) {

  }

}