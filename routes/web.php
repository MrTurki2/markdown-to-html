<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\LabController;

// PUBLIC ROUTES - للمستخدمين العاديين
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::post('/convert', [PublicController::class, 'convert'])->name('convert');

// LAB ROUTES - للتجارب والتطوير
Route::prefix('lab')->name('lab.')->group(function () {
    Route::get('/', [LabController::class, 'index'])->name('index');
    Route::get('/experiments', [LabController::class, 'experiments'])->name('experiments');
    Route::post('/test-engine', [LabController::class, 'testEngine'])->name('test-engine');
});
