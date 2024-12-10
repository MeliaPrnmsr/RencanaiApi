<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//memanggil controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalTaskController;
use App\Http\Controllers\WorkspacesController;
use App\Http\Controllers\AnnouncementController;


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

    //workspaces
    Route::get('workspaces', [WorkspacesController::class, 'index']); 
    Route::post('workspaces', [WorkspacesController::class, 'store']);
    Route::get('workspaces/{id}', [WorkspacesController::class, 'show']);
    Route::put('workspaces/{id}', [WorkspacesController::class, 'update']);
    Route::delete('workspaces/{id}', [WorkspacesController::class, 'destroy']);

    //TaskWorkspaces
    Route::get('taskws', [WorkspacesController::class, 'indexTaskWs']); 
    Route::post('taskws', [WorkspacesController::class, 'storeTaskWs']);
    Route::get('taskws/{id}', [WorkspacesController::class, 'showTaskWs']);
    Route::put('taskws/{id}', [WorkspacesController::class, 'updateTaskWs']);
    Route::delete('taskws/{id}', [WorkspacesController::class, 'destroyTaskWs']);

    //Announcement
    Route::get('announcement', [AnnouncementController::class, 'index']); 
    Route::post('announcement', [AnnouncementController::class, 'store']);
    Route::get('announcement/{id}', [AnnouncementController::class, 'show']);
    Route::put('announcement/{id}', [AnnouncementController::class, 'update']);
    Route::delete('announcement/{id}', [AnnouncementController::class, 'destroy']);

    
});