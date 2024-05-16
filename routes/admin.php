<?php

use App\Http\Controllers\AdminWalletController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\CoinController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\API\MaxAmountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\WalletController;

Route::middleware('admin')->group(function () {
    Route::get('/coin/{coin}', [CoinController::class, 'show']);


    Route::post('/login', [AdminController::class, 'login']);

    Route::middleware('CheckAdminToken:admin-api')->group(function () {
        // Role
        Route::get('/roles', [RoleController::class, 'index']);
        Route::post('/add-role', [RoleController::class, 'store']);
        Route::get('/role/{role}', [RoleController::class, 'show']);
        Route::put('/update-role/{role}', [RoleController::class, 'update']);
        Route::delete('/delete-role/{role}', [RoleController::class, 'destroy']);
        // End Role

        // User
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/add-user', [UserController::class, 'store']);
        Route::get('/user/{user}', [UserController::class, 'show']);
        Route::put('/update-user/{user}', [UserController::class, 'update']);
        Route::delete('/delete-user/{user}', [UserController::class, 'destroy']);
        // End User

        Route::post('/logout', [AdminController::class, 'logout']);

        //Wallet Route
        Route::apiResource('wallet', WalletController::class);
        //End Wallet Route

        //Max Amount Route
        Route::apiResource('max_amoun', MaxAmountController::class);
        //End Max Amount Route

        ###########################################################################################################
        ########################################## Employee CONTROLLER ############################################
        ###########################################################################################################

        Route::get('/employees', [EmployeeController::class, 'index']);
        Route::get('/employee/{employee}', [EmployeeController::class, 'show']);
        Route::post('/creat_employee', [EmployeeController::class, 'store']);
        Route::post('/update_employee/{employee}', [EmployeeController::class, 'update']);
        Route::delete('/delete_employee/{employee}', [EmployeeController::class, 'destroy']);

        ###########################################################################################################
        ###########################################################################################################
        ###########################################################################################################

        ###########################################################################################################
        ########################################### Coin CONTROLLER ###############################################
        ###########################################################################################################

        Route::get('/coins', [CoinController::class, 'index']);
        Route::post('/creat_coin', [CoinController::class, 'store']);
        Route::post('/update_coin/{coin}', [CoinController::class, 'update']);
        Route::delete('/delete_coin/{coin}', [CoinController::class, 'destroy']);

        ###########################################################################################################
        ###########################################################################################################
        ###########################################################################################################

        ###########################################################################################################
        ####################################### Admin Wallet CONTROLLER ###########################################
        ###########################################################################################################

        Route::get('/adminWallets', [AdminWalletController::class, 'index']);
        Route::get('/adminWallet/{adminWallet}', [AdminWalletController::class, 'show']);
        Route::post('/creat_adminWallet', [AdminWalletController::class, 'store']);
        Route::post('/update_adminWallet/{adminWallet}', [AdminWalletController::class, 'update']);
        Route::delete('/delete_adminWallet/{adminWallet}', [AdminWalletController::class, 'destroy']);

        ###########################################################################################################
        ###########################################################################################################
        ###########################################################################################################
    });
});
