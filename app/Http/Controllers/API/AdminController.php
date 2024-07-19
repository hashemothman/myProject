<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Http\Resources\AdminResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\GenerateAccount;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminController extends Controller
{
    use ApiResponseTrait, GenerateAccount;

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $data['token'] = Auth::guard('admin-api')->attempt($credentials);

        if (!$data['token']) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $admin = Auth::guard('admin-api')->user();
        $data['admin'] = new AdminResource($admin);
        return $this->apiResponse($data, 'Admin Login successfully', 200);
    }

    public function logout(Request $request)
    {
        JWTAuth::parseToken()->invalidate();
        Auth::guard('admin-api')->logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function create_admin(StoreAdminRequest $request)
    {
        try {
            $admin = Admin::create([
                'email'          => $request->email,
                'password'       => $request->password,
                'role_name'      => $request->role_name,
                'account_number' => $this->generateAdminAccountNumber()
            ]);
            $data['token'] = Auth::guard('admin-api')->login($admin);

            $data['admin'] = new AdminResource($admin);
            return $this->apiResponse($data, 'Admin Created successfully', 201);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['message'=> 'Something Error!'],500);
        }
    }
}
