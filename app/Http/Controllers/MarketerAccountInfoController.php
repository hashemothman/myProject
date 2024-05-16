<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarketerAccountInfo\StoreMarketerAccountInfoRequest;
use App\Http\Requests\MarketerAccountInfo\UpdateMarketerAccountInfoRequest;
use App\Http\Resources\MarketerAccountResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\UploadFileTrait;
use App\Models\MarketerAccountInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MarketerAccountInfoController extends Controller
{
    use ApiResponseTrait, UploadFileTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MarketerAccountInfos = MarketerAccountInfo::all();
        $data = MarketerAccountResource::collection($MarketerAccountInfos);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarketerAccountInfoRequest $request)
    {
        try {
            $commercialRegister_photo_path  = $this->UploadFile($request, 'MarketerAccountInfos', 'commercialRegister_photo', 'BasImage');

            $wallet = MarketerAccountInfo::create([
                'account_id'                => $request->account_id,
                'campany_name'              => $request->campany_name,
                'commercialRegister_number' => $request->commercialRegister_number,
                'commercialRegister_photo'  => $commercialRegister_photo_path
            ]);
            $data = new MarketerAccountResource($wallet);
            return $this->customeResponse($data, 'Created Successfully', 201);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Failed To Create', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MarketerAccountInfo $marketerAccountInfo)
    {
        try {
            $data = new MarketerAccountResource($marketerAccountInfo);
            return $this->customeResponse($data, 'Done!', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Not Found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarketerAccountInfoRequest $request, MarketerAccountInfo $marketerAccountInfo)
    {
        try {
            $marketerAccountInfo->account_id                = $request->input('account_id') ?? $marketerAccountInfo->account_id;
            $marketerAccountInfo->campany_name              = $request->input('campany_name') ?? $marketerAccountInfo->campany_name;
            $marketerAccountInfo->commercialRegister_number = $request->input('commercialRegister_number') ?? $marketerAccountInfo->commercialRegister_number;
            $marketerAccountInfo->commercialRegister_photo  = $this->FileExists($request, $request->commercialRegister_photo, 'commercialRegister_photo','MarketerAccountInfos','BasImage', false, $marketerAccountInfo);
            $marketerAccountInfo->save();

            $data = new MarketerAccountResource($marketerAccountInfo);
            return $this->customeResponse($data, 'Successfully Updated', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return response()->json(['message' => 'Something Error !'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarketerAccountInfo $marketerAccountInfo)
    {
        try {
            $marketerAccountInfo->delete();
            return $this->customeResponse('', 'MarketerAccountInfo Deleted', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Not Found', 404);
        }
    }
}
