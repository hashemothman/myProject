<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CoinController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\API\PercentController;
use App\Http\Controllers\API\UserLogController;
use App\Http\Controllers\API\ComplainController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\API\UserInfoController;
use App\Http\Controllers\Api\OfficeInfoController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\BusinessAccountController;

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

    ###########################################################################################################
    ########################################## Invoice CONTROLLER #############################################
    ###########################################################################################################

    Route::get('/invoices', [InvoiceController::class, 'index']);
    Route::get('/invoice/{invoice}', [InvoiceController::class, 'show']);
    Route::post('/creat_invoice', [InvoiceController::class, 'store']);
    Route::post('/update_invoice/{invoice}', [InvoiceController::class, 'update']);
    Route::delete('/delete_invoice/{invoice}', [InvoiceController::class, 'destroy']);

    ###########################################################################################################
    ###########################################################################################################
    ###########################################################################################################

    ###########################################################################################################
    ######################################### OfficeInfo CONTROLLER ###########################################
    ###########################################################################################################

    Route::get('/officeInfos', [OfficeInfoController::class, 'index']);
    Route::get('/officeInfo/{officeInfo}', [OfficeInfoController::class, 'show']);
    Route::post('/creat_officeInfo', [OfficeInfoController::class, 'store']);
    Route::post('/update_officeInfo/{officeInfo}', [OfficeInfoController::class, 'update']);
    Route::delete('/delete_officeInfo/{officeInfo}', [OfficeInfoController::class, 'destroy']);

    ###########################################################################################################
    ###########################################################################################################
  


    #################### Business Account Controller ##########################
    Route::apiResource('business-accounts', BusinessAccountController::class);
    ############################################################################




    #################### Transaction Controller ##########################
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/store-transacrion', [TransactionController::class,'store'])->middleware('daily.transfer.limit');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show']);
    ############################################################################






});

