<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//memanggil controller
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//auth controller on resque:v
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//after login w/ middleware
Route::group(["middleware" =>  "auth:sanctum"], function (){
    //user profile routes
    Route::get('/userprofile', [AuthController::class, 'userprofile']);
    Route::put('/updateprofile', [AuthController::class, 'updateprofile']);

    //logout route
    Route::get('/logout', [AuthController::class, 'logout']);

    //personal task
});