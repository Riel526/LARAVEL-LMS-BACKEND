<?php


namespace App\Services;

use App\Models\Subject;
use Illuminate\Support\Facades\Storage;

class SubjectService
{
    public function getAllSubjects() {
        return Subject::orderBy('name', 'asc')->get();
    }

    public function createSubject(array $data) {
        return Subject::create($data);
    }
    
    public function findSubjectById($id) {
        return Subject::findOrFail($id);
    }

    public function updateSubject($id, array $data, $image = null, $removeImage = false) {
        $subject = Subject::findOrFail($id);

            if ($removeImage) {
                if ($subject->image_path) {
                    Storage::disk('public')->delete($subject->image_path);
                }
                $data['image_path'] = null;
            } 
            
            else if ($image) {
                if ($subject->image_path) {
                    Storage::disk('public')->delete($subject->image_path);
                }
                $data['image_path'] = $image->store('subjects', 'public');
            }


        $subject->update($data);
        return $subject;
    }

    public function deleteSubject($id) {
        $subject = Subject::findOrFail($id);
        return $subject->delete();
    }
}