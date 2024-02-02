<?php


namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadFile{
    protected function UploadFile($file){

       
    
        if ($file) {
            preg_match('/data:([^;]+);base64,(.+)/', $file, $matches);
    
            $fileType = $matches[1] ?? 'text/plain'; // Default to plain text if type is not provided
            $fileData = base64_decode($matches[2]);
    
            // Determine file extension based on file type
            $extension = $this->getFileExtensionFromMimeType($fileType);
            $filename = Str::random(20) . '.' . $extension;
    
            // Store the file
            Storage::disk('public')->put($filename, $fileData);
    
            return $filename;
        }
    
        return null;
    }

    private function getFileExtensionFromMimeType($mimeType)
{
    $extensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'application/pdf' => 'pdf',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx'
    ];

    // Default to 'unknown' if no match is found
    return $extensions[$mimeType] ?? 'unknown';
}
}