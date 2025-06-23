<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackofficeController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CacheController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [BackofficeController::class, 'index'])->name('admin.index');
    Route::get('/users', [BackofficeController::class, 'users'])->name('admin.users');
    Route::get('/users/search', [BackofficeController::class, 'searchUsers'])->name('admin.users.search');
    Route::get('/users/{id}/edit', [BackofficeController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{id}', [BackofficeController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [BackofficeController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::get('/certificates', [BackofficeController::class, 'certificates'])->name('admin.certificates');
    Route::delete('/certificates/{id}', [BackofficeController::class, 'destroyCertificate'])->name('admin.certificates.destroy');
});

Route::group(function () {
    Route::resource('certificates', CertificateController::class);
});

Route::get('/verify', function () {
    return view('certificates.verify');
})->name('certificates.verify.form');

Route::get('/verify/{code}', [CertificateController::class, 'verify'])->name('certificates.verify');

Route::post('/api/certificates/check', [CertificateController::class, 'checkValidity'])->name('certificates.checkValidity');

Route::get('/certificates/{code}/qrcode', [CertificateController::class, 'generateQrCode'])->name('certificates.qrcode');

Route::get('/limpiar-caches-seguro', [CacheController::class, 'clear']);

require __DIR__.'/auth.php';
