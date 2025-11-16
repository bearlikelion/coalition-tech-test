<?php

use App\Livewire\TaskController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tasks');
Route::get('/tasks', TaskController::class)->name('tasks.index');
