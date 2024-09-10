<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

//tasks
Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'create']);
Route::put('/tasks', [TaskController::class, 'edit']);
Route::delete('/tasks', [TaskController::class, 'destroy']);
