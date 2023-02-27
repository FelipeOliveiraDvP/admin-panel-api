<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;

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

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login');
    Route::post('recovery', 'recovery');
    Route::put('reset/{token}', 'reset');
});

Route::controller(UsersController::class)->prefix('users')->group(function () {
    Route::get('/', 'index');
});
