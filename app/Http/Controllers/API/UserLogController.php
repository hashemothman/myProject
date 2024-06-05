<?php

namespace App\Http\Controllers\API;

use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLogRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\UserLogResource;
use App\Http\Requests\UpdateUserLogRequest;

class UserLogController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_logs = UserLog::all();
        return $this->customeResponse(UserLogResource::collection($user_logs),"Done",200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UserLogRequest $request)
    {
        try {
            $userLog_file = $this->UploadPhoto($request, 'userLogs', 'file', 'files');
            $user_log = UserLog::create([
                'title'             => $request->title,
                'description'       => $request->description,
                'file'              => $userLog_file,
            ]);
            return $this->customeResponse(new UserLogResource($user_log), 'userLog Created Successfuly', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserLog $user_log)
    {
        try{
            return $this->customeResponse(new UserLogResource($user_log),"Done",200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserLogRequest $request,UserLog $user_log)
    {
        try {
            if (!empty($request->file)) {
                $userLog_file = $this->UploadPhoto($request, 'userLogs', 'file', 'files');
            } else {
                $userLog_file = $user_log->file;
            }
            $user_log->title = $request->input('title') ?? $user_log->title;
            $user_log->description = $request->input('description') ?? $user_log->description;
            $user_log->file = $userLog_file;
            $user_log->save();
            return $this->customeResponse(new UserLogResource($user_log),"UserLog updated successfully",200);

        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserLog $user_log)
    {
        try{
            $user_log->delete();
            return $this->customeResponse("","UserLog deleted successfully",200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }
}
