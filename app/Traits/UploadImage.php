<?php


namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadImage{
    protected function UploadImage($file){
        if($file){
            $filename = Str::random(20).'.'.'jpg';
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
            Storage::disk('public')->put($filename, $imageData);
            return $filename;
        }
        return null;
    }




}