<?php

use BotAcademy\Users\Http\Controllers\PublicApi\Auth\AuthController;
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

Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::withoutMiddleware('auth:api')->group(function () {
            Route::post('/', [AuthController::class, 'store']);
            Route::post('/sign-in', [AuthController::class, 'signIn']);
        });
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
