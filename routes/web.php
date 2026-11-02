
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function () {
            return 'Halaman khusus Admin SIRKA';
        })->name('admin.index');

        Route::resource('users', UserController::class)
            ->except(['show', 'destroy']);

        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');
    });
});
