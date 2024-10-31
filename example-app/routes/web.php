<?php

use App\Http\Controllers\UsemeJobController;
use App\Models\UsemeJob;
use App\Services\ProposalMessagerService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $service = app(ProposalMessagerService::class);

    return $service->check();
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
    
});
Route::get('/{UsemeJob}', [UsemeJobController::class, 'presentation'])->name('presentation');