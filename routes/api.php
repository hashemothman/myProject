<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\ComplainController;

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


    ###########################################################
    ##################### ACCOUNT #############################
    ###########################################################
    Route::get('/accounts', [AccountController::class, 'index']);
    Route::post('/create-account', [AccountController::class, 'store']);
    Route::get('/account/{account}', [AccountController::class, 'show']);
    Route::put('/update-account/{account}', [AccountController::class, 'update']);
    Route::delete('/delete-account/{account}', [AccountController::class, 'destroy']);

    ###########################################################
    ##################### complain #############################
    ###########################################################
    Route::get('/complains', [ComplainController::class, 'index']);
    Route::post('/create-complain', [ComplainController::class, 'store']);
    Route::get('/complain/{complain}', [ComplainController::class, 'show']);
    Route::put('/update-complain/{complain}', [ComplainController::class, 'update']);
    Route::delete('/delete-complain/{complain}', [ComplainController::class, 'destroy']);


    ###########################################################
    ##################### Report #############################
    ###########################################################
    Route::get('/reports', [ReportController::class, 'index']);
    Route::post('/create-reports', [ReportController::class, 'store']);
    Route::get('/reports/{reports}', [ReportController::class, 'show']);
    Route::put('/update-reports/{reports}', [ReportController::class, 'update']);
    Route::delete('/delete-reports/{reports}', [ReportController::class, 'destroy']);




});

