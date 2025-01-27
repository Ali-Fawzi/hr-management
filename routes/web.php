<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\NotificationController;
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

    Route::resource('employees', EmployeeController::class);
    Route::resource('roles', RoleController::class, ['except' => ['show']]);
    Route::resource('users', UserController::class, ['except' => ['show']]);
    Route::resource('positions', PositionController::class, ['except' => ['show']]);
    Route::resource('departments', DepartmentController::class, ['except' => ['show']]);

    Route::middleware('can:employee-approve-reject')->group(function () {
        Route::put('/employees/{employee}/approve', [EmployeeController::class, 'approve'])->name('employees.approve');
        Route::put('/employees/{employee}/reject', [EmployeeController::class, 'reject'])->name('employees.reject');
    });
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/logs', [LogsController::class, 'showLogs'])->name('logs.index');
});

require __DIR__.'/auth.php';
