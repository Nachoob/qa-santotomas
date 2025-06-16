<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackofficeController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CacheController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [BackofficeController::class, 'index'])->name('admin.index');
});

Route::middleware(['auth'])->group(function () {
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
