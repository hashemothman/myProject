<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponseTrait;


    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        # By default we are using here auth:api middleware
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request)
    {
        if (!empty($request->email)) {
            $credentials = $request->only('email', 'password');
        }elseif (!empty($request->mobile_number)) {
            $credentials = $request->only('mobile_number', 'password');
        }else {
            return response()->json([
                'message' => 'Please Enter Your Email or Mobile Number',
            ],404);
        }
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        $data = new UserResource($user);
        return $this->apiResponse($data, $token, 'User Login successfully', 200);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'email'         => $request->email,
            'mobile_number' => $request->mobile_number,
            'password'      => Hash::make($request->password),
        ]);

        $data = new UserResource($user);
        return $this->customeResponse($data, 'User Register successfully', 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        $user = Auth::user();
        $token = Auth::refresh();

        $data = new UserResource($user);
        return $this->apiResponse($data, $token, 'Done!', 200);
    }
}
