<?php


namespace App\Services;

use App\Models\Assignment;
use Illuminate\Support\Facades\DB;
use App\Models\Student;

class AssignmentService {

  protected $authService;

  public function __construct(AuthService $authService) {

    $this->authService = $authService;
    
  }


  public function getAssignments () {
    $teacher_id = auth()->id();

    return Assignment::where('teacher_id', $teacher_id)
    ->with(['subject', 'questions'])
    ->latest()
    ->get();
  }

  public function addAssignment ($data) {

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
      $assignment->questions()->create($questionData);
    }

    });

  }

  public function getAssignmentById ($id) {
    return Assignment::with(['questions'])->findOrFail($id);
  }


  public function updateAssignment(int $id, array $data) {
    DB::transaction(function() use($id, $data){
     $assignment = Assignment::findOrFail($id);

     $assignment->update([
      'title' => $data['title'],
      'instructions' => $data['instructions'],
      'due_date' => $data['due_date'],
      'subject_id' => $data['subject_id'],
      'grade_level' => $data['grade_level'],
      'section' => $data['section'],
     ]);

     $assignment->questions()->delete();

     foreach ($data['questions'] as $q) {
        $assignment->questions()->create([
            'type' => $q['type'],
            'question_text' => $q['question_text'],
            'correct_answer' => $q['correct_answer'] ?? null,
            'options' => $q['options'] ?? null,
            'points' => $q['points'] ?? 1,
        ]);
      }

    return $assignment->load('questions');
    });
    }

  public function deleteAssignment(int $id) {
    $assignment = Assignment::findOrFail($id);

    return $assignment->delete();
  }

    public function getStudentAssignment () {
      $user = auth()->user();

      $student = Student::where('user_id', $user->id)->first();

      $assignment = Assignment::where('grade_level', $student->grade_level)
      ->where('section', $student->section)
      ->with(['subject', 'questions'])
      ->latest()
      ->get();


      return $assignment;
    }

}