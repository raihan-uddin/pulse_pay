<?php

use App\Http\Controllers\API\Auth\ApiAuthController;
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
    Route::post('/register', [ApiAuthController::class, 'register']);
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/login-marchant', [ApiAuthController::class, 'merchantLogin']);
});

Route::get('/', function (Request $request) {
    return 'Hello World';
});

Route::middleware('auth:api')->group(function () {
    Route::resource('products', 'API\ProductController');
    Route::post('/logout', [ApiAuthController::class, 'logout']);

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
