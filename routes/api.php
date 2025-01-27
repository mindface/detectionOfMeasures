<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BTaskApiController;
use App\Http\Controllers\TaskController;

Route::get('/api-data', [BTaskApiController::class, 'getApiData']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
  Route::get('/me', [AuthController::class, 'me']);
  Route::post('/logout', [AuthController::class, 'logout']);

  Route::get('/tasks', [TaskController::class, 'index']);
  Route::post('/task', [TaskController::class, 'store']);
  Route::get('/task/{id}', [TaskController::class, 'show']);
  Route::put('/task/{id}', [TaskController::class, 'update']);
  Route::delete('/task/{id}', [TaskController::class, 'destroy']);
});
