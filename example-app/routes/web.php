<?php

use App\Http\Controllers\UsemeJobController;
use App\Models\UsemeJob;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('show/{UsemeJob}', [UsemeJobController::class, 'show'])->name('show');
    Route::delete('show/{UsemeJob}', [UsemeJobController::class, 'show'])->name('delete');

    Route::get('show/{UsemeJob}/presentation', [UsemeJobController::class, 'presentation'])->name('presentation');
    
});