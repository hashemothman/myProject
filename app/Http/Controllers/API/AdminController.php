<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Http\Resources\AdminResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminController extends Controller
{
    use ApiResponseTrait;

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = Auth::guard('admin-api')->attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $admin = Auth::guard('admin-api')->user();
        $data = new AdminResource($admin);
        return $this->apiResponse($data, $token, 'Admin Login successfully', 200);
    }

    public function logout(Request $request)
    {
        JWTAuth::parseToken()->invalidate();
        Auth::guard('admin-api')->logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
