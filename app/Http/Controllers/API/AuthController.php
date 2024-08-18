<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\SendNotification;
use App\Http\Traits\WalletAndAccountTrait;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Requests\Auth\UserPhoneRegisterRequest;

class AuthController extends Controller
{
    use ApiResponseTrait, WalletAndAccountTrait,SendNotification;

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
        try {
            DB::beginTransaction();
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
            $userModel = User::find(Auth::id());
            $newFcmToken = $request->input('fcm_token');
            if ($newFcmToken) {
                $userModel->fcm_token = $newFcmToken;
            }
            $userModel->save();
            $data = ['user' => new UserResource($userModel), 'token' => $token];
            DB::commit();
            //test notification
            // $this->sendNotification('wer','rwer','werwer','werwerew');
            return $this->customeResponse($data, 'User Login successfully', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return $this->customeResponse(null, 'there is something wrong', 500);
        }
    }


    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'fcm_token' => $request->fcm_token

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
            'fcm_token' => $request->fcm_token
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
        return $this->customeResponse(['token'=>'deleted'],'Successfully logged out',200);

    }


    public function refresh()
    {
        $user = Auth::user();
        $token = Auth::refresh();
        $data = ['user' => new UserResource($user), 'token' => $token];
        return $this->customeResponse($data, 'Done!', 200);
    }
}
