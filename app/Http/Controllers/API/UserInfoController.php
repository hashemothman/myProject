<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserInfoRequest;
use App\Http\Resources\UserInfoResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\PhotoTrait;
use App\Models\UserInfo;

class UserInfoController extends Controller
{
    use ApiResponseTrait, PhotoTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_info = UserInfo::all();

        return $this->customeResponse(UserInfoResource::collection($user_info), 'Data retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserInfoRequest $request)
    {
        $photo_path            = $this->PhotoExists($request,$request->photo,'photo');
        $front_card_image_path = $this->UploadPhoto($request, 'userInfos', 'front_card_image');
        $back_card_image_path  = $this->UploadPhoto($request, 'userInfos', 'back_card_image');

        $user_info = UserInfo::create([
            'city_id'          => $request->city_id,
            'fullName'         => $request->fullName,
            'idNumber'         => $request->idNumber,
            'photo'            => $photo_path,
            'front_card_image' => $front_card_image_path,
            'back_card_image'  => $back_card_image_path
        ]);

        if ($user_info) {
            return $this->customeResponse(new UserinfoResource($user_info), 'Created Successfully', 201);

            return $this->customeResponse(null, 'Failed To Create', 400);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(UserInfo $userInfo)
    {
        if (!$userInfo) {
            return $this->customeResponse(null, 'Not Found', 404);
        }

        return $this->customeResponse(new UserinfoResource($userInfo), 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserInfoRequest $request, UserInfo $userInfo)
    {
        if (!$userInfo) {
            return $this->customeResponse(null, 'Not Found', 404);
        }

        $photo_path            = $this->PhotoExists($request, $request->photo, 'photo', false, $userInfo);
        $front_card_image_path = $this->PhotoExists($request, $request->front_card_image, 'front_card_image', false, $userInfo);
        $back_card_image_path  = $this->PhotoExists($request, $request->back_card_image, 'back_card_image', false, $userInfo);

        $userInfo->update([
            'city_id'          => $request->city_id,
            'fullName'         => $request->fullName,
            'idNumber'         => $request->idNumber,
            'photo'            => $photo_path,
            'front_card_image' => $front_card_image_path,
            'back_card_image'  => $back_card_image_path
        ]);

        return $this->customeResponse(new UserinfoResource($userInfo), 'Successfully Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserInfo $userInfo)
    {
        if (!$userInfo) {
            return $this->customeResponse(null, 'Not Found', 404);
        }

        $userInfo->delete();
        return $this->customeResponse('', "UserInfo Deleted", 200);
    }
}
