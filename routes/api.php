<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//memanggil controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalTaskController;

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
    Route::get('personaltask', [PersonalTaskController::class, 'index']); 
    Route::post('personaltask', [PersonalTaskController::class, 'store']);
    Route::get('personaltask/{id}', [PersonalTaskController::class, 'show']);
    Route::put('personaltask/{id}', [PersonalTaskController::class, 'update']);
    Route::delete('personaltask/{id}', [PersonalTaskController::class, 'destroy']);
});