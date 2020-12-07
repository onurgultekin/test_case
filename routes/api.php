<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MeditationController;

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

Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('/user',[UserController::class, 'index']);
    Route::post('/meditation',[MeditationController::class, 'index']);
    Route::get('/lastSevenDays',[MeditationController::class, 'lastSevenDays']);
    Route::get('/thisMonth',[MeditationController::class, 'thisMonth']);
});