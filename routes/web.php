<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

// 1. User/Session Management (Landing Page)
Route::get('/', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/users/{user}/select', [UserController::class, 'select'])->name('users.select');

// 2. Project Management (Standard Resource)
Route::resource('projects', ProjectController::class);

// 3. Task Management (Nested for Creation & Bulk Actions)
// These require the {project} ID to know the context
Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])
    ->name('tasks.store');

Route::delete('/projects/{project}/tasks/completed', [TaskController::class, 'deleteCompleted'])
    ->name('tasks.deleteCompleted');

// 4. Task Management (Shallow/Individual Actions)
// These only need the {task} ID to identify the specific record
Route::patch('/tasks/{task}', [TaskController::class, 'update'])
    ->name('tasks.update');

Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])
    ->name('tasks.destroy');