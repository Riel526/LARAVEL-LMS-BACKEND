<?php


namespace App\Services;

use App\Models\Assignment;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\StudentAssignment;

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

    if (!$student) {
        return collect([]);
    }

    $assignments = Assignment::where('grade_level', $student->grade_level)
    ->where('section', $student->section)
    ->with(['subject', 'questions'])
    ->latest()
    ->get();

    $completedAssignmentIds = StudentAssignment::where('student_id', $student->student_id)
        ->pluck('assignment_id')
        ->toArray();

    $assignmentsArray = $assignments->toArray();

    foreach ($assignmentsArray as &$assignment) {
      if (in_array($assignment['assignment_id'], $completedAssignmentIds)) {
            $assignment['completed'] = true;
        } else {
            $assignment['completed'] = false;
        }
    }

    return [$assignment];
  }

  public function submitAssignment ($data) {
    $user = auth()->user();
    $student = Student::where('user_id', $user->id)->firstOrFail();

    $assignmentId = $data['assignment_id'];
    $submittedAnswers = $data['answers'];

    $assignment = Assignment::with('questions')->findOrFail($assignmentId);

    $totalPointsAvailable = 0;
    $pointsEarned = 0;
    $answersSnapshot = [];

    foreach ($assignment->questions as $question) {
      $totalPointsAvailable += $question->points;

      $studentInput = isset($submittedAnswers[$question->id]) ? trim($submittedAnswers[$question->id]) : '';

      $isCorrect = false;
      if ($question->type === 'multiple_choice' || $question->type === 'identification') {
            $isCorrect = strtolower($studentInput) === strtolower(trim($question->correct_answer));
      } else if ($question->type === 'essay') {
          // Essays for manual grading
          $isCorrect = false; 
      }
      $earnedForThisQuestion = $isCorrect ? $question->points : 0;
      $pointsEarned += $earnedForThisQuestion;

      // Build log history detail for archiving
        $answersSnapshot[] = [
            'question_id' => $question->id,
            'question_text' => $question->question_text,
            'student_answer' => $studentInput,
            'correct_answer' => $question->correct_answer,
            'is_correct' => $isCorrect,
            'points_earned' => $earnedForThisQuestion
        ];
    }

    return DB::transaction(function() use ($student, $assignmentId, $pointsEarned, $totalPointsAvailable, $answersSnapshot) {
        return StudentAssignment::create([
            'student_id' => $student->student_id,
            'assignment_id' => $assignmentId,
            'total_score' => $pointsEarned,
            'max_score' => $totalPointsAvailable,
            'answers_snapshot' => json_encode($answersSnapshot),
            'completed_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    });
  }

}