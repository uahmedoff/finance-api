<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\WalletController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\ExchangeRateController;
use App\Http\Controllers\Api\V1\FirmResourceController;
use App\Http\Controllers\Api\V1\UserResourceController;
use App\Http\Controllers\Api\V1\WalletResourceController;
use App\Http\Controllers\Api\V1\CategoryResourceController;
use App\Http\Controllers\Api\V1\CurrencyResourceController;
use App\Http\Controllers\Api\V1\TransactionResourceController;
use App\Http\Controllers\Api\V1\ExchangeRateResourceController;
use App\Http\Controllers\Api\V1\HistoryController;
use App\Http\Controllers\Api\V1\PaymentMethodResourceController;

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
        Route::put('update', [AuthController::class,'update']);
    });

    Route::group(['middleware' => 'jwt.auth'], function ($router) {

        Route::apiResources([
            'users' => UserResourceController::class,
            'currencies' => CurrencyResourceController::class,
            'firms' => FirmResourceController::class,
            'wallets' => WalletResourceController::class,
            'categories' => CategoryResourceController::class,
            'payment_methods' => PaymentMethodResourceController::class,
            'transactions' => TransactionResourceController::class,
            'exchange_rates' => ExchangeRateResourceController::class
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
            Route::put('{wallet}/users',[WalletController::class,'attach_users']);
            Route::put('{wallet}/users/{user_id}/detach',[WalletController::class,'detach_user']);
            Route::put('{wallet}/balance',[WalletController::class,'balance']);
            Route::put('{wallet}/monthly_cash_flow',[WalletController::class,'monthly_cash_flow']);
        });

        Route::group(['prefix' => 'exchange_rates'],function($router){
            Route::get('latest/{ccy}',[ExchangeRateController::class,'get_latest']);
        });

        Route::group(['prefix' => 'history'],function($router){
            Route::get('/',HistoryController::class);
        });
        
    });

});