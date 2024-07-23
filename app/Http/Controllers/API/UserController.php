<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AccountRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Traits\WalletAndAccountTrait;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\UpdateUserStatusRequest;
use App\Http\Requests\Wallet\StoreWalletRequest;

class UserController extends Controller
{
    use ApiResponseTrait,WalletAndAccountTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->get();
        return $this->customeResponse(UserResource::collection($users),"Done",200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, AccountRequest $account_request,StoreWalletRequest $wallet_request)
    {
        try {
            $validatedData = $request->validated();
            DB::beginTransaction();
                $user = User::create([
                    'email'         => $request->email,
                    'mobile_number' => $request->mobile_number,
                    'status'        => $request->status,
                    'type'          => $request->type,
                    'password'      => Hash::make($request->password),
                ]);
                $this->createAccount($user->id, $account_request);
                $this->createDolarWallet($wallet_request);
            DB::commit();
            return $this->customResponse(new UserResource($user), 'User created successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
            return $this->customResponse(null, "Error, something went wrong", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if($user) {
            return $this->customeResponse(new UserResource($user), 'Done', 200);
        }
        return $this->customeResponse(null, 'user not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($user) {
            $user->update([
                'email'         => $request->email,
                'mobile_number' => $request->mobile_number,
                'status'        => $request->status,
                'type'          => $request->type,
                'password'      => Hash::make($request->password),
            ]);
            return $this->customeResponse(new UserResource($user), 'user updated successfully', 200);
        }
        return $this->customeResponse(null, 'user not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user) {
            $user->delete();
            return $this->customeResponse("", 'user deleted successfully', 200);
        }
        return $this->customeResponse(null, 'user not found', 404);
    }


    public function updateUserStatus(UpdateUserStatusRequest $request, User $user){
        try {
            $user->status = $request->input('status') ?? $user->status;
            $user->save();
            return $this->customeResponse(new UserResource($user), 'user status updated successfully', 200);
        } catch (\Exception $e) {
            Log::error($e);
            return $this->customResponse(null, "Error, something went wrong", 500);
        }
    }
}
