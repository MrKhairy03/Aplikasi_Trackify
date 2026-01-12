<?php

use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivitiesController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('log.view:dashboard')
        ->name('dashboard');

    Route::get('/activities', [ActivitiesController::class, 'index'])
        ->middleware('log.view:activities')
        ->name('activities.index');
});

require __DIR__ . '/auth.php';
