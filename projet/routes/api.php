<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
Route::middleware('api')->middleware('auth:sanctum')->group(function () {

    Route::resource('clients', ClientController::class);
    Route::resource('drivers', DriverController::class);
    Route::resource('reservations', ReservationController::class);
    Route::resource('rides', RideController::class);
    Route::resource('vehicles', VehicleController::class);

    // Additional routes or middleware specific to your application can be added here

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class,
'logout']);

Route::middleware('api')->group(function($router) {
 Route::post('/createpayment', [PaymentController::class,'createPaymentIntent']);});