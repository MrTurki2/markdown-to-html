<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\MarkdownController;

// PUBLIC ROUTES - للمستخدمين العاديين
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::post('/convert', [PublicController::class, 'convert'])->name('convert');

// Markdown API (للتجارب)
Route::post('/api/convert', [MarkdownController::class, 'convert'])->name('api.convert');

// LAB ROUTES - للتجارب والتطوير
Route::prefix('lab')->name('lab.')->group(function () {
    Route::get('/', [LabController::class, 'index'])->name('index');
    Route::get('/experiments', [LabController::class, 'experiments'])->name('experiments');
    Route::post('/test-engine', [LabController::class, 'testEngine'])->name('test-engine');

    // Test Experiments Routes (using MarkdownController)
    Route::get('/test2', [MarkdownController::class, 'test2'])->name('test2');
    Route::post('/test2/save', [MarkdownController::class, 'saveFile'])->name('test2.save');
    Route::get('/test2/files', [MarkdownController::class, 'getFiles'])->name('test2.files');
    Route::get('/test2/file/{id}', [MarkdownController::class, 'getFile'])->name('test2.file');

    Route::get('/test3', [MarkdownController::class, 'test3'])->name('test3');
    Route::post('/test3/save', [MarkdownController::class, 'saveTextFile'])->name('test3.save');

    Route::get('/test4', [MarkdownController::class, 'test4'])->name('test4');

    Route::get('/test5', [MarkdownController::class, 'test5'])->name('test5');
    Route::post('/test5/generate-pdf', [MarkdownController::class, 'generatePDF'])->name('test5.pdf');

    Route::get('/test6', [MarkdownController::class, 'test6'])->name('test6');
    Route::post('/test6/generate-content', [MarkdownController::class, 'generateContent'])->name('test6.generate');
    Route::post('/test6/edit-content', [MarkdownController::class, 'editContent'])->name('test6.edit');

    Route::get('/test8', [MarkdownController::class, 'test8'])->name('test8');
    Route::post('/test8/screenshot', [MarkdownController::class, 'takeScreenshot'])->name('test8.screenshot');
    Route::post('/test8/pdf', [MarkdownController::class, 'convertToPdf'])->name('test8.pdf');

    Route::get('/test9', [MarkdownController::class, 'test9'])->name('test9');
    Route::post('/test9/generate-pdf', [MarkdownController::class, 'test9GeneratePdf'])->name('test9.pdf');
});
