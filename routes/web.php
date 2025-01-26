<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('roles', RoleController::class, ['except' => ['show']]);
    Route::resource('users', UserController::class, ['except' => ['show']]);
    Route::resource('employees', EmployeeController::class , ['except' => ['show']]);
    Route::resource('positions', PositionController::class, ['except' => ['show']]);
    Route::resource('departments', DepartmentController::class, ['except' => ['show']]);
});

require __DIR__.'/auth.php';
