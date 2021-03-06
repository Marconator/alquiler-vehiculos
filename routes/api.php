<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentOrdersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
 | Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('cars', [CarController::class, 'index']);
Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);
Route::get('orders', [RentOrdersController::class, 'index']);
Route::middleware('auth:sanctum')->post('orders', [RentOrdersController::class, 'create']);
Route::middleware('auth:sanctum')->delete('orders/{id}', [RentOrdersController::class, 'delete']);
Route::middleware('auth:sanctum')->get('logout/{id}', [LoginController::class, 'logout']);
Route::middleware('auth:sanctum')->get('profile/{id}', [UserController::class, 'show']);
