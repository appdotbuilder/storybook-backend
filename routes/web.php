<?php

use App\Http\Controllers\Api\StorybookController as ApiStorybookController;
use App\Http\Controllers\StorybookController;
use App\Http\Controllers\StorybookPageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Public welcome page
Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

// Public storybooks showcase (anyone can view published books)
Route::get('/storybooks', [StorybookController::class, 'index'])->name('storybooks.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    // Storybook management routes (CMS) - authenticated only actions
    Route::get('/storybooks/create', [StorybookController::class, 'create'])->name('storybooks.create');
    Route::post('/storybooks', [StorybookController::class, 'store'])->name('storybooks.store');
    Route::get('/storybooks/{storybook}', [StorybookController::class, 'show'])->name('storybooks.show');
    Route::get('/storybooks/{storybook}/edit', [StorybookController::class, 'edit'])->name('storybooks.edit');
    Route::put('/storybooks/{storybook}', [StorybookController::class, 'update'])->name('storybooks.update');
    Route::patch('/storybooks/{storybook}', [StorybookController::class, 'update']);
    Route::delete('/storybooks/{storybook}', [StorybookController::class, 'destroy'])->name('storybooks.destroy');
    
    Route::resource('storybooks.pages', StorybookPageController::class);
});

// API routes for mobile app
Route::prefix('api')->group(function () {
    Route::get('/storybooks', [ApiStorybookController::class, 'index'])->name('api.storybooks.index');
    Route::get('/storybooks/{storybook}', [ApiStorybookController::class, 'show'])->name('api.storybooks.show');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
