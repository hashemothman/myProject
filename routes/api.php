<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\OfficeInfoController;
use App\Http\Controllers\API\UserInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\ComplainController;
use App\Http\Controllers\API\WalletController;
use App\Http\Controllers\MarketerAccountInfoController;

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


    
// TODO : routes




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
    ###########################################################################################################

    ###########################################################################################################
    ########################################## Wallet CONTROLLER ##############################################
    ###########################################################################################################

    Route::get('/Wallets', [WalletController::class, 'index']);
    Route::get('/Wallet/{Wallet}', [WalletController::class, 'show']);
    Route::post('/creat_Wallet', [WalletController::class, 'store']);
    Route::post('/update_Wallet/{Wallet}', [WalletController::class, 'update']);
    Route::delete('/delete_Wallet/{Wallet}', [WalletController::class, 'destroy']);

    ###########################################################################################################
    ###########################################################################################################
    ###########################################################################################################

    ###########################################################################################################
    ################################## Marketer Account Info CONTROLLER #######################################
    ###########################################################################################################

    Route::get('/marketer-account-infos', [MarketerAccountInfoController::class, 'index']);
    Route::get('/marketer-account-info/{marketer-account-info}', [MarketerAccountInfoController::class, 'show']);
    Route::post('/creat_marketer-account-info', [MarketerAccountInfoController::class, 'store']);
    Route::post('/update_marketer-account-info/{marketer-account-info}', [MarketerAccountInfoController::class, 'update']);
    Route::delete('/delete_marketer-account-info/{marketer-account-info}', [MarketerAccountInfoController::class, 'destroy']);

    ###########################################################################################################
    ###########################################################################################################
    ###########################################################################################################

});
