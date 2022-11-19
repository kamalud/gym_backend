<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgetController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\SettingController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::post('auth/login', [AuthController::class , 'login']);
    Route::post('auth/register', [AuthController::class , 'register']);


    Route::group(['Middleware'=>'auth:api'],function(){
            Route::post('auth/forget', [ForgetController::class , 'forget']);
            Route::post('auth/logout', [AuthController::class , 'logout']);
        Route::apiResources([
            'members'=> MemberController::class,
            'invoice'=> InvoiceController::class,
            'expense'=> ExpenseController::class,
            'setting'=> SettingController::class,
        ]);
    });
});