<?php

use App\Http\Controllers\API\RegisterController;
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

Route::post('/register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::get('/', function (Request $request) {
    return 'Hello World';
});

Route::middleware('auth:api')->group(function () {
    Route::resource('products', 'API\ProductController');
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
