<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\SubjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class SubjectController extends Controller
{
    protected $subjectService;

    public function __construct(SubjectService $subjectService) {
        $this->subjectService = $subjectService;
    }

    public function index(): JsonResponse {
        $subjects = $this->subjectService->getAllSubjects();
        return response()->json(['data' => $subjects, 'code' => 200]);
    }

    public function store(Request $request): JsonResponse {
        $validated = $request->validate([
            'subject_code' => 'required|unique:subjects,subject_code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'units' => 'required|integer|min:1',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        if ($request->hasFile('image')) {
        $path = $request->file('image')->store('subjects', 'public');
        $validated['image_path'] = $path;
    }

        $subject = $this->subjectService->createSubject($validated);

        return response()->json([
            'status' => 'success',
            'code' => 201,
            'message' => 'Subject created successfully!',
            'data' => $subject
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse {
        $validated = $request->validate([
            'subject_code' => 'required|unique:subjects,subject_code,' . $id . ',subject_id',
            'name' => 'required|string|max:255',
            'units' => 'required|integer|min:1',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $updatedSubject = $this->subjectService->updateSubject($id, $validated, $request->file('image'), $request->boolean('remove_image'));

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Subject updated successfully!',
            'data' => $updatedSubject
        ]);
    }

    public function delete($id): JsonResponse {
        $subject = $this->subjectService->findSubjectById($id);

        // Delete image from storage
        if ($subject->image_path) {
            Storage::disk('public')->delete($subject->image_path);
        }

        $this->subjectService->deleteSubject($id);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Subject deleted successfully!'
        ], 200);
    }
    
}