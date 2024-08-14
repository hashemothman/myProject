<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\City;
use App\Models\User;
use App\Models\Country;
use App\Models\UserInfo;
use App\Http\Traits\FileTrait;
use App\Http\Traits\GetCityId;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
            $photo_path = $request->hasFile('photo') ? $this->FileExists($request, $request->photo, 'photo', 'userInfos', 'BasImage') : null;
            $front_card_image_path =  $request->hasFile('front_card_image') ? $this->UploadFile($request, 'userInfos', 'front_card_image', 'BasImage') : null;
            $back_card_image_path = $request->hasFile('back_card_image') ? $this->UploadFile($request, 'userInfos', 'back_card_image', 'BasImage') : null;

            $countryResult = $this->getCountryId($request->country_name);
            $cityResult = $this->getCityId($request->city_name);

            if (!$countryResult['success']) {
                $newContry = Country::create([
                    'name' => $request->country_name,
                    'is_active' => false,
                ]);
                // dd($newContry);
                return $this->customeResponse(null, $countryResult['message'], 404);
            }
            if (!$cityResult['success']) {
                City::create([
                    'city' => $request->city_name,
                    'is_active' => false,
                ]);
                return $this->customeResponse(null, $cityResult['message'], 404);
            }


            $cityId = $cityResult['id'];
            $countryId = $countryResult['id'];
            $user_info = UserInfo::create([
                'country_id' => $countryId,
                'city_id' => $cityId,
                'fullName' => $request->full_name,
                'idNumber' => $request->id_number,
                'photo' => $photo_path,
                'front_card_image' => $front_card_image_path,
                'back_card_image' => $back_card_image_path
            ]);
            DB::commit();
            return $this->customeResponse(new UserInfoResource($user_info), 'Created Successfully', 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return $this->customeResponse(null, 'there is something error in the server', 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $user_info = $user->userInfo;
        return $this->customeResponse(new UserInfoResource($user_info), 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserInfoRequest $request)
    {
        try {
            $user_id = Auth::user()->id;
            $user = User::find($user_id);
            $userInfo = $user->userInfo;
            if (!$userInfo) {
                return $this->customeResponse(null, 'Not Found', 404);
            }
            DB::beginTransaction();
                $photo_path            = $this->FileExists($request, $request->photo, 'photo','userInfos','BasImage', false, $userInfo);
                $front_card_image_path = $this->FileExists($request, $request->front_card_image, 'front_card_image','userInfos','BasImage', false, $userInfo);
                $back_card_image_path  = $this->FileExists($request, $request->back_card_image, 'back_card_image','userInfos','BasImage', false, $userInfo);
                $userInfo->city_id = $request->input('city_id') ?? $userInfo->city_id;
                $userInfo->fullName = $request->input('full_name') ?? $userInfo->fullName;
                $userInfo->idNumber = $request->input('id_number') ?? $userInfo->idNumber;
                $userInfo->photo = $photo_path;
                $userInfo->front_card_image = $front_card_image_path;
                $userInfo->back_card_image = $back_card_image_path;
                $userInfo->save();

                $userModel = User::find(Auth::id());
                if (
                    $request->hasFile('photo') &&
                    $request->hasFile('front_card_image') &&
                    $request->hasFile('back_card_image') &&
                    $request->input('id_number')
                ) {
                    $userModel->status = "Pending";
                }
                $userModel->save();
            DB::commit();
            return $this->customeResponse(new UserInfoResource($userInfo), 'Successfully Updated', 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return $this->customeResponse(null, 'Not Found', 404);
        }

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
