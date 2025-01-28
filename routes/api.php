<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BTaskApiController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\GroupCategoriesController;

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

  Route::get('/group-categories', [GroupCategoriesController::class, 'index']);
  Route::post('/group-categories', [GroupCategoriesController::class, 'store']);
  Route::put('/group-categories/{groupId}', [GroupCategoriesController::class, 'update']);
  Route::delete('/group-categories/{groupId}', [GroupCategoriesController::class, 'delete']);

  Route::get('/case-studies/{group_id}', [CaseStudyController::class, 'getCaseStudiesByTag']);
  Route::post('/case-studies', [CaseStudyController::class, 'store']);
  Route::put('/case-studies/{group_id}', [CaseStudyController::class, 'update']);
  Route::delete('/case-studies/{group_id}', [CaseStudyController::class, 'delete']);

});
