<?php

namespace App\Http\Traits;

use App\Http\Resources\CategoryResource;

trait ApiResponseTrait
{
    public function apiResponse($data,$token,$message,$status){

        $array = [
            'data' =>$data,
            'message' =>$message,
            'token' => $token,
            'token_type' => 'Bearer',
        ];

        return response()->json($array,$status);
    }


    public function customeResponse($data, $message, $status) {
        $array = [
            'data'=>$data,
            'message'=>$message
        ];

        return response()->json($array, $status);
    }
}
