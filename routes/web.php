<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::resource('tasks', TaskController::class)->except(['create', 'show', 'edit']);
Route::post('tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');

Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');