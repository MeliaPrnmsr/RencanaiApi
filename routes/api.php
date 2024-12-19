<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//memanggil controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalTaskController;
use App\Http\Controllers\WorkspacesController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\InviteController;

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

    // Workspaces
    Route::get('workspaces', [WorkspacesController::class, 'index']); 
    Route::post('workspaces', [WorkspacesController::class, 'store']);
    Route::get('workspaces/{id}', [WorkspacesController::class, 'show']);
    Route::put('workspaces/{id}', [WorkspacesController::class, 'update']);

    // Task Workspaces (per workspace)
    Route::get('workspaces/{ws_id}/taskws', [WorkspacesController::class, 'indexTaskWs']);
    Route::post('workspaces/{ws_id}/taskws', [WorkspacesController::class, 'storeTaskWs']);
    Route::get('workspaces/{ws_id}/taskws/{id}', [WorkspacesController::class, 'showTaskWs']);
    Route::put('workspaces/{ws_id}/taskws/{id}', [WorkspacesController::class, 'updateTaskWs']);
    Route::delete('workspaces/{ws_id}/taskws/{id}', [WorkspacesController::class, 'destroyTaskWs']);

    // Announcement (per workspace)
    Route::get('workspaces/{ws_id}/announcement', [AnnouncementController::class, 'index']);
    Route::post('workspaces/{ws_id}/announcement', [AnnouncementController::class, 'store']);

    // Invite
    Route::get('invite', [InviteController::class, 'index']); 
    Route::get('invite/{id}', [InviteController::class, 'show']);
    Route::put('invite/{id}', [InviteController::class, 'update']);
    
});