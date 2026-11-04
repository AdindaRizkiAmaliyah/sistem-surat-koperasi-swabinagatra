
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncomingLetterController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\OutgoingLetterController;

// ==========================================
// AUTHENTICATION
// ==========================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ==========================================
// ROUTE YANG MEMERLUKAN LOGIN
// ==========================================

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');


    // ==========================================
    // KHUSUS ADMIN
    // ==========================================

    Route::middleware('role:admin')->group(function () {

        Route::get('/admin', function () {
            return 'Halaman khusus Admin SIRKA';
        })->name('admin.index');

        // Manajemen pengguna
        Route::resource('users', UserController::class)
            ->except(['show', 'destroy']);

        Route::patch('/users/{user}/toggle-status', [
            UserController::class,
            'toggleStatus'
        ])->name('users.toggle-status');

    });


    // ==========================================
    // KHUSUS ADMIN DAN SEKRETARIS
    // ==========================================

    Route::middleware('role:admin,sekretaris')->group(function () {

        // --------------------------------------
        // SURAT MASUK
        // --------------------------------------

        Route::resource('incoming-letters', IncomingLetterController::class)
            ->only(['index', 'create', 'store', 'show']);


        // --------------------------------------
        // LAMPIRAN PDF SURAT MASUK
        // --------------------------------------

        Route::get(
            '/incoming-letters/{incomingLetter}/attachments/{attachment}/view',
            [IncomingLetterController::class, 'viewAttachment']
        )->name('incoming-letters.attachments.view');

        Route::get(
            '/incoming-letters/{incomingLetter}/attachments/{attachment}/download',
            [IncomingLetterController::class, 'downloadAttachment']
        )->name('incoming-letters.attachments.download');


        // --------------------------------------
        // DISPOSISI SURAT MASUK
        // --------------------------------------

        // Menampilkan form pembuatan disposisi
        Route::get(
            '/incoming-letters/{incomingLetter}/dispositions/create',
            [DispositionController::class, 'create']
        )->name('dispositions.create');

        // Menyimpan disposisi
        Route::post(
            '/incoming-letters/{incomingLetter}/dispositions',
            [DispositionController::class, 'store']
        )->name('dispositions.store');

    });
    // ==========================================
    // SURAT KELUAR
    // ==========================================

    Route::resource('outgoing-letters', OutgoingLetterController::class)
        ->only(['index', 'create', 'store', 'show']);

    Route::get(
        '/outgoing-letters/{outgoingLetter}/attachments/{attachment}/view',
        [OutgoingLetterController::class, 'viewAttachment']
    )->name('outgoing-letters.attachments.view');

    Route::get(
        '/outgoing-letters/{outgoingLetter}/attachments/{attachment}/download',
        [OutgoingLetterController::class, 'downloadAttachment']
    )->name('outgoing-letters.attachments.download');

});
