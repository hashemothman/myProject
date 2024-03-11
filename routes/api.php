<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);





Route::middleware('jwt.verify')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    ###########################################################################################################
    ######################################### USER INFO CONTROLLER ############################################
    ###########################################################################################################

    Route::get('/userInfos', [UserInfoController::class, 'index']);
    Route::get('/userInfo/{userInfo}', [UserInfoController::class, 'show']);
    Route::post('/creat_userInfo', [UserInfoController::class, 'store']);
    Route::post('/update_userInfo/{userInfo}', [UserInfoController::class, 'update']);
    Route::delete('/delete_userInfo/{userInfo}', [UserInfoController::class, 'destroy']);

    ###########################################################################################################
    ###########################################################################################################
    ###########################################################################################################
});

