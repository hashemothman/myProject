<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;


trait PhotoTrait
{
    public function UploadPhoto(Request $request, $folderName, $fileName)
    {
        $photo = time() . '.' . $request->file($fileName)->getClientOriginalName();
        $path = $request->file($fileName)->storeAs($folderName, $photo, 'BasImage');
        return $path;
    }

    public function PhotoExists(Request $request ,$requestColoumn, $coloumnName, $folderName, $create= true, $model= null) {
        if (!empty($requestColoumn)) {
            return $this->UploadPhoto($request, $folderName, $coloumnName);
        }
        if ($create) {
            return null;
        }
        return $model->$coloumnName;
    }
}
