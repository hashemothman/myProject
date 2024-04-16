<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;


trait UploadFileTrait
{

    public function UploadFile(Request $request, $folderName, $fileName, $disk)
    {
        $file = time() . '.' . $request->file($fileName)->getClientOriginalName();
        $path = $request->file($fileName)->storeAs($folderName, $file, $disk);
        return $path;
    }

    public function FileExists(Request $request ,$requestColoumn, $coloumnName, $folderName, $diskName, $create= true, $model= null) {
        if (!empty($requestColoumn)) {
            return $this->UploadFile($request, $folderName, $coloumnName, $diskName);
        }
        if ($create) {
            return null;
        }
        return $model->$coloumnName;
    }
}


