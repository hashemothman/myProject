<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\API\UserController;

Route::middleware('admin')->group(function () {

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
    });
});
