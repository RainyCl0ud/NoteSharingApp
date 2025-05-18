<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notes routes
    Route::resource('notes', NoteController::class);
    Route::post('/notes/{note}/share', [NoteController::class, 'share'])->name('notes.share');
    Route::delete('/notes/{note}/share/{user}', [NoteController::class, 'unshare'])->name('notes.unshare');
});

require __DIR__.'/auth.php';
