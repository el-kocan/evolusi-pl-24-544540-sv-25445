<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/tugas', [TaskController::class, 'apiIndex'])->name('api.tasks.index');
