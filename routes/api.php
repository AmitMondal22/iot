<?php

use App\Http\Controllers\admin\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::prefix('iot')->group(function () {
    Route::get('/get', [AuthController::class, 'register']);
});
//auth Routing
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// auth user tipe admin
Route::middleware(['auth:sanctum', 'user-access:0'])->group(function () {
    Route::prefix('test')->group(function () {
        Route::get('/user', [AuthController::class, 'test']);
        Route::get('/user2', [AuthController::class, 'test']);
    });
});


