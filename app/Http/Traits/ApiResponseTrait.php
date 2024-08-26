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

        //this function do the same functionality of the previous paginated function , but accepts resources as input
    public function resourcePaginated($data,$message = 'Operation Success',$status = 200){
        $paginator = $data->resource;
        $resourceData = $data->items();

        $array = [
            'status' => 'success',
            'message'=>trans($message),
            'data'=>$resourceData,
            'pagination' => [
                'total'        => $paginator->total(),
                'count'        => $paginator->count(),
                'per_page'     => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'total_pages'  => $paginator->lastPage(),
            ],
        ];
        return response()->json($array,$status);
    }
}
