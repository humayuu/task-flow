<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::resource('todo', TodoController::class)->middleware('auth');
Route::get('all/todo', [TodoController::class, 'AllTodo']);
Route::post('todo/status/{id}', [TodoController::class, 'TaskStatus'])->name('task.status');
