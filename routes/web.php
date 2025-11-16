<?php

use App\Livewire\Tasks\TaskController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tasks');
Route::get('/tasks', function() {
    return view('tasks.index');
})->name('tasks.index');
