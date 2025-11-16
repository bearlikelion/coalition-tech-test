<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tasks');
Route::get('/tasks', function () {
    return view('tasks.index');
})->name('tasks.index');
