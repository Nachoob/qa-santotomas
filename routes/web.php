<?php

use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verify/{code}', [CertificateController::class, 'verify'])->name('certificates.verify');

Route::middleware(['auth'])->group(function () {
    Route::resource('certificates', CertificateController::class);
});
