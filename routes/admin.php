<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\API\CoinController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\WalletController;
use App\Http\Controllers\AdminWalletController;
use App\Http\Controllers\API\PercentController;
use App\Http\Controllers\API\UserLogController;
use App\Http\Controllers\API\ComplainController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\API\MaxAmountController;

Route::middleware('admin')->group(function () {


    Route::post('/login', [AdminController::class, 'login']);

    Route::middleware(['CheckAdminToken:admin-api', ])->group(function () {

        // create Admin
        Route::post('create-admin', [AdminController::class, 'create_admin']);

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
        Route::patch('/update-status/{user}', [UserController::class, 'updateUserStatus']);
        // End User

        Route::post('/logout', [AdminController::class, 'logout']);

        //Wallet Route
        Route::apiResource('wallet', WalletController::class);
        //End Wallet Route

        //Max Amount Route
        Route::apiResource('max_amount', MaxAmountController::class);
        //End Max Amount Route


        ####################### complain ###########################
        Route::get('/complains', [ComplainController::class, 'index']);
        Route::get('/complain/{complain}', [ComplainController::class, 'show']);
        Route::put('/update-complain/{complain}', [ComplainController::class, 'update']);
        Route::delete('/delete-complain/{complain}', [ComplainController::class, 'destroy']);



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
        Route::get('/coin/{coin}', [CoinController::class, 'show']);
        Route::post('/creat_coin', [CoinController::class, 'store']);
        Route::post('/update_coin/{coin}', [CoinController::class, 'update']);
        Route::delete('/delete_coin/{coin}', [CoinController::class, 'destroy']);

        ###########################################################################################################
        ###########################################################################################################
        ###########################################################################################################



        #################### Percent Controller  ##########################
        Route::apiResource('percents', PercentController::class);
        ############################################################################

        Route::apiResource('userlogs', UserLogController::class);


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
