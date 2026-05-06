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
    public function index(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedRequest = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,subject_id',
            'grade_level'  => 'required|string',
            'section' => 'required|string',
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'due_date' => 'required|date',

            'questions' => 'required|array|min:1',
            'questions.*.type' => 'required|in:identification,essay,multiple_choice',
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Assignment $assignment)
    {
        //
    }
}
