<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;


trait FileTrait
{
    public function UploadFile(Request $request, $folderName, $fileName, $diskName)
    {
        $photo = time() . '.' . $request->file($fileName)->getClientOriginalName();
        $path = $request->file($fileName)->storeAs($folderName, $photo, $diskName);
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
