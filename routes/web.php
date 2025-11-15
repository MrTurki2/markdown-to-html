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

    // Test Experiments Routes
    Route::get('/test2', [LabController::class, 'test2'])->name('test2');
    Route::post('/test2/save', [LabController::class, 'saveFile'])->name('test2.save');
    Route::get('/test2/files', [LabController::class, 'getFiles'])->name('test2.files');
    Route::get('/test2/file/{id}', [LabController::class, 'getFile'])->name('test2.file');

    Route::get('/test3', [LabController::class, 'test3'])->name('test3');
    Route::post('/test3/save', [LabController::class, 'saveTextFile'])->name('test3.save');

    Route::get('/test4', [LabController::class, 'test4'])->name('test4');

    Route::get('/test5', [LabController::class, 'test5'])->name('test5');
    Route::post('/test5/generate-pdf', [LabController::class, 'generatePDF'])->name('test5.pdf');

    Route::get('/test6', [LabController::class, 'test6'])->name('test6');
    Route::post('/test6/generate-content', [LabController::class, 'generateContent'])->name('test6.generate');
    Route::post('/test6/edit-content', [LabController::class, 'editContent'])->name('test6.edit');

    Route::get('/test8', [LabController::class, 'test8'])->name('test8');
    Route::post('/test8/screenshot', [LabController::class, 'takeScreenshot'])->name('test8.screenshot');
    Route::post('/test8/pdf', [LabController::class, 'convertToPdf'])->name('test8.pdf');

    Route::get('/test9', [LabController::class, 'test9'])->name('test9');
    Route::post('/test9/generate-pdf', [LabController::class, 'test9GeneratePdf'])->name('test9.pdf');
});
