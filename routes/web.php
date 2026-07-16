<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AnalysisController;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index')->middleware('auth');
    
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::resource('applications', ApplicationController::class)
    ->except(['create', 'edit', 'show']);

    Route::get('/analysis', [AnalysisController::class, 'index'])->name('analysis.index');
    Route::get('/analysis/history', [AnalysisController::class, 'history'])->name('analysis.history');
    Route::get('/analysis/{analysis}', [AnalysisController::class, 'show'])->name('analysis.show');
    Route::post('/analysis', [AnalysisController::class, 'store'])->name('analysis.store');
});

require __DIR__.'/settings.php';
