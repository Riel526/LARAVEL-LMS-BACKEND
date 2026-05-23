<?php

namespace App\Services;

use App\Models\Subject;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

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
            $this->deleteCloudinaryImage($subject->image_path);
            $data['image_path'] = null;
        } else if ($image) {
            $this->deleteCloudinaryImage($subject->image_path);

            Configuration::instance(config('services.cloudinary.url') ?? env('CLOUDINARY_URL'));

            $uploadApi = new UploadApi();
            $response = $uploadApi->upload($image->getRealPath(), [
                'folder' => env('APP_ENV', 'local') . '_subjects'
            ]);
            
            $data['image_path'] = $response['secure_url'];
        }

        $subject->update($data);
        return $subject;
    }

    public function deleteSubject($id) {
        $subject = Subject::findOrFail($id);
        $this->deleteCloudinaryImage($subject->image_path);
        return $subject->delete();
    }

    private function deleteCloudinaryImage(?string $imageUrl): void
    {
        if (!$imageUrl || !str_contains($imageUrl, 'cloudinary.com')) {
            return;
        }

        try {
            Configuration::instance(config('services.cloudinary.url') ?? env('CLOUDINARY_URL'));

            $pathParts = explode('/upload/', $imageUrl);
            if (isset($pathParts[1])) {
                $fileWithVersion = $pathParts[1];
                $cleanPath = preg_replace('/^v\d+\//', '', $fileWithVersion);
                $publicId = pathinfo($cleanPath, PATHINFO_DIRNAME) . '/' . pathinfo($cleanPath, PATHINFO_FILENAME);

                $uploadApi = new UploadApi();
                $uploadApi->destroy($publicId);
            }
        } catch (\Exception $e) {
            logger('Cloudinary deletion failed: ' . $e->getMessage());
        }
    }
}