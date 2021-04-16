<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

trait UploadTrait
{
    public function uploadImage(UploadedFile $file, $folder = '')
    {
        $originName = $file->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension =  $file->getClientOriginalExtension();
        $fileName = $fileName.'_'.Str::random(16).'.'.$extension;
        $file->move(public_path("uploads/$folder"), $fileName);
        return "uploads/$folder/".$fileName;
    }
}