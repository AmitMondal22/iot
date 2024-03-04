<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\DeviceController;
use App\Http\Controllers\admin\DeviceDataController;
use App\Http\Controllers\admin\OriginationController;
use App\Http\Controllers\iot\DeviceController as IotDeviceController;
use App\Http\Controllers\iot\DeviceDataController as IotDeviceDataController;
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

    Route::prefix('device')->group(function () {
        Route::get('/list', [DeviceController::class, 'device_list']);
    });

    Route::prefix('device-data')->group(function () {
        Route::post('/list', [DeviceDataController::class, 'device_data_list']);
        Route::post('/last', [DeviceDataController::class, 'last_device_data']);
    });
    Route::prefix('/master')->group(function () {
        Route::post('/add-origination', [OriginationController::class, 'add_origination']);
        Route::post('/edit-origination', [OriginationController::class, 'edit_origination']);
        Route::post('/delete-origination', [OriginationController::class, 'delete_origination']);
        Route::get('/list-origination', [OriginationController::class, 'list_origination']);


        Route::get('/list-organization-user', [AuthController::class, 'list_user_organization']);


        Route::post('/add-user', [AuthController::class, 'add_user']);
        Route::post('/edit-user', [AuthController::class, 'edit_user']);
        Route::get('/list-user', [AuthController::class, 'list_user']);
    });

    Route::prefix('assign-device')->group(function () {
        ///
        Route::post('/add-origination', [OriginationController::class, 'assign_origination']);

        Route::post('/add-multiple-origination', [OriginationController::class, 'assign_multiple_origination']);

        Route::post('/edit-origination', [OriginationController::class, 'edit_assign_origination']);

        Route::get('/list-origination', [OriginationController::class, 'list_assign_origination']);

        Route::get('/list-origination-to-device', [OriginationController::class, 'list_origination_to_device']);

    });
});



Route::middleware(['auth:sanctum', 'user-access:1'])->group(function () {
    Route::prefix('origination')->group(function () {
        Route::prefix('device')->group(function () {
            Route::get('/list', [DeviceController::class, 'device_list_user']);
        });

        Route::prefix('device-data')->group(function () {
            Route::post('/list', [DeviceDataController::class, 'device_data_list_user']);
            Route::post('/last', [DeviceDataController::class, 'last_device_data_user']);
        });
    });
});


Route::middleware(['api-access'])->group(function () {
    Route::prefix('iot')->group(function () {
        Route::get('/add-device', [IotDeviceController::class, 'add_device']);
        Route::get('/checked-device', [IotDeviceController::class, 'checked_device']);
        Route::get('/add-device-data', [IotDeviceDataController::class, 'add_device_data']);
    });
});
