<?php

use App\Http\Controllers\API\Auth\ApiAuthController;
use App\Http\Controllers\API\Merchant\MerchantController;
use App\Http\Controllers\API\TransactionFeeController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['cors', 'json.response']], function () {
    // public routes
    Route::post('/register', [ApiAuthController::class, 'register']);
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/login-merchant', [ApiAuthController::class, 'merchantLogin']);

    Route::group(['prefix' => 'merchant', 'middleware' => ['merchant']], function () {
        Route::middleware('auth:api')->group(function () {
            Route::controller(MerchantController::class)->group(function () {
                Route::get('/balance', 'checkBalance');
                Route::get('/transfer-money', 'moneyTransfer');
                Route::get('/transfer-money', 'moneyTransfer');
            });

            Route::get('/search-customer', [UserController::class, 'searchCustomer']);
        });
    });

    Route::middleware('auth:api')->group(function () {
        Route::get('/transaction-fees', [TransactionFeeController::class, 'fees']);
        Route::post('/logout', [ApiAuthController::class, 'logout']);
    });
});

Route::get('/', function (Request $request) {
    return 'Hello World';
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
