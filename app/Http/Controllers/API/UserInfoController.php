<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\UserInfo;
use App\Http\Traits\FileTrait;
use App\Http\Traits\GetCityId;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\UserInfoRequest;
use App\Http\Resources\UserInfoResource;
use App\Http\Requests\UpdateUserInfoRequest;

class UserInfoController extends Controller
{
    use ApiResponseTrait, FileTrait,GetCityId;

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
        try {
            DB::beginTransaction();
            $photo_path = $this->FileExists($request, $request->photo, 'photo', 'userInfos', 'BasImage');
            $front_card_image_path = $this->UploadFile($request, 'userInfos', 'front_card_image', 'BasImage');
            $back_card_image_path = $this->UploadFile($request, 'userInfos', 'back_card_image', 'BasImage');
            
            $cityId = $this->getCityId($request->cityName);
            $user_info = UserInfo::create([
                'city_id' => $cityId,
                'fullName' => $request->fullName,
                'idNumber' => $request->idNumber,
                'photo' => $photo_path,
                'front_card_image' => $front_card_image_path,
                'back_card_image' => $back_card_image_path
            ]);
            DB::commit();
            return $this->customeResponse(new UserinfoResource($user_info), 'Created Successfully', 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return $this->customeResponse(null, 'there is something error in the server', 500);
        }
        

            return $this->customeResponse(null, 'Failed To Create', 400);
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
    public function update(UpdateUserInfoRequest $request, UserInfo $userInfo)
    {
        if (!$userInfo) {
            return $this->customeResponse(null, 'Not Found', 404);
        }

        $photo_path            = $this->FileExists($request, $request->photo, 'photo','userInfos','BasImage', false, $userInfo);
        $front_card_image_path = $this->FileExists($request, $request->front_card_image, 'front_card_image','userInfos','BasImage', false, $userInfo);
        $back_card_image_path  = $this->FileExists($request, $request->back_card_image, 'back_card_image','userInfos','BasImage', false, $userInfo);
        $userInfo->city_id = $request->input('city_id') ?? $userInfo->city_id;
        $userInfo->fullName = $request->input('fullName') ?? $userInfo->fullName;
        $userInfo->idNumber = $request->input('idNumber') ?? $userInfo->idNumber;
        $userInfo->photo = $photo_path;
        $userInfo->front_card_image = $front_card_image_path;
        $userInfo->back_card_image = $back_card_image_path;
        $userInfo->save();
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
