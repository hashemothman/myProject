<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserPhoneRegisterRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\WalletAndAccountTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponseTrait, WalletAndAccountTrait;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        # By default we are using here auth:api middleware
        $this->middleware('auth:api', ['except' => ['login', 'register', 'registerPhone']]);
    }

    public function login(UserLoginRequest $request)
    {
        if (!empty($request->email)) {
            $credentials = $request->only('email', 'password');
        } elseif (!empty($request->mobile_number)) {
            $credentials = $request->only('mobile_number', 'password');
        } else {
            return response()->json([
                'message' => 'Please Enter Your Email or Mobile Number',
            ], 404);
        }
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        $user = Auth::user();
        $data = ['user' => new UserResource($user), 'token' => $token];
        return $this->apiResponse($data, 'User Login successfully', 200);
    }


    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('user');
        $token = Auth::login($user);
        $data = ['user' => new UserResource($user), 'token' => $token];
        return $this->customeResponse($data, 'User Register successfully', 201);
    }

    public function registerPhone(UserPhoneRegisterRequest $request)
    {
        $user = User::create([
            'mobile_number' => $request->mobile_number,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('user');
        $token = Auth::login($user);
        $data = ['user' => new UserResource($user), 'token' => $token];
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
        $data = ['user' => new UserResource($user), 'token' => $token];
        return $this->apiResponse($data, 'Done!', 200);
    }
}
