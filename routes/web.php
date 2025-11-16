<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\TaskController;

Route::redirect('/', '/tasks');
Route::get('/tasks', TaskController::class)->name('tasks.index');
