<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Services\AssignmentService;

class AssignmentController extends Controller
{

    protected $assignmentService;

    public function __construct(AssignmentService $assignmentService) {
        $this->assignmentService = $assignmentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->assignmentService->getAssignments();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedRequest = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,subject_id',
            'grade_level'  => 'required|integer',
            'section' => 'required|string',
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'due_date' => 'required|date|after:now',

            'questions' => 'required|array|min:1',
            'questions.*.type' => 'required|in:identification,essay,multiple_choice',
            'questions.*.question_text' => 'required|string',
            'questions.*.correct_answer'  => 'nullable|string',
            'questions.*.options' => 'nullable|array',
            'questions.*.points' => 'required|integer',

        ]);

        $assignment = $this->assignmentService->addAssignment($validatedRequest);


        return response()->json([
            'code' => 201,
            'message' => 'Assignment Created Successfully',
            'data' => $assignment
        ]);
    }

    public function show($id)
    {
        $assignment = $this->assignmentService->getAssignmentById($id);

        return response()->json(
            $assignment,
            200
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $updatedAssignment = $this->assignmentService->updateAssignment($id, $request->all());

        return response()->json([

            'code' => 200,
            'message' => 'Assignment updated successfully',
            'data' => $updatedAssignment
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $this->assignmentService->deleteAssignment($id);

        return response()->json([
            'code' => 200,
            'message' => 'Assignment Deleted Successfully'
        ], 200);
    }

    public function indexStudent() {
        return $this->assignmentService->getStudentAssignment();
    }

    public function submitAssignment(Request $request) {
        $assignment = $this->assignmentService->submitAssignment($request->all());


        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Assignment submitted successfully!'
        ], 200);

    }
}
