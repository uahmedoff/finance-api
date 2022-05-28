<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CurrencyController;
use App\Http\Controllers\Api\V1\FirmController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\WalletController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix'=>'v1'],function(){
    Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
        Route::post('login', [AuthController::class,'login']);
        Route::post('logout', [AuthController::class,'logout']);
        Route::post('refresh', [AuthController::class,'refresh']);
        Route::post('me', [AuthController::class,'me']);
    });

    Route::group(['middleware' => 'jwt.auth'], function ($router) {
        
        Route::apiResources([
            'users' => UserController::class,
            'currencies' => CurrencyController::class,
            'firms' => FirmController::class,
            'wallets' => WalletController::class
        ]);

        Route::group(['prefix' => 'roles'], function($router){
            Route::get('/',[PermissionController::class, 'roles']);
            Route::get('/{id}',[PermissionController::class, 'role']);
            Route::get('{id}/permissions',[PermissionController::class, 'permissions']);
            Route::put('{id}/permissions',[PermissionController::class, 'attach_permissions_to_role']);
        });

        Route::group(['prefix' => 'permissions'], function($router){
            Route::get('/',[PermissionController::class, 'permissions']);
            Route::get('/{id}',[PermissionController::class, 'permission']);
        });

        Route::group(['prefix' => 'wallets'],function($router){
            Route::put('{id}/users',[WalletController::class,'attach_users']);
            Route::put('{id}/users/{user_id}/detach',[WalletController::class,'detach_user']);
        });
        
    });

});