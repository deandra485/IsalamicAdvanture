<?php
// ==========================================
// FILE UPLOAD TRAIT
// ==========================================

// app/Traits/HasFileUpload.php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasFileUpload
{
    public function uploadImage($file, $folder = 'images')
    {
        if (!$file) return null;

        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, 'public');
        
        return $path;
    }

    public function uploadMultipleImages($files, $folder = 'images')
    {
        $uploadedFiles = [];
        
        foreach ($files as $file) {
            $uploadedFiles[] = $this->uploadImage($file, $folder);
        }
        
        return $uploadedFiles;
    }

    public function deleteImage($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return true;
        }
        return false;
    }
}

