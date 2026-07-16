<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index')->middleware('auth');
    
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::resource('applications', ApplicationController::class)
    ->except(['create', 'edit', 'show']);
});

require __DIR__.'/settings.php';
