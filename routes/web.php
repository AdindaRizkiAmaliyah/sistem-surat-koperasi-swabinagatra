
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncomingLetterController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //khusus admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function () {
            return 'Halaman khusus Admin SIRKA';
        })->name('admin.index');

        Route::resource('users', UserController::class)
            ->except(['show', 'destroy']);

        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');
    });

    //khusus admin dan sekretasris
    Route::middleware(['role:admin,sekretaris'])->group(function () {
    Route::resource('incoming-letters', IncomingLetterController::class)
        ->only(['index', 'create', 'store', 'show']);
    Route::get('/incoming-letters/{incomingLetter}/attachments/{attachment}/view',
        [IncomingLetterController::class, 'viewAttachment']
    )->name('incoming-letters.attachments.view');

    Route::get('/incoming-letters/{incomingLetter}/attachments/{attachment}/download',
        [IncomingLetterController::class, 'downloadAttachment']
    )->name('incoming-letters.attachments.download');
});
});
