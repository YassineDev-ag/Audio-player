<?php
use App\Http\Controllers\AudioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AudioController::class, 'index']);
Route::post('/upload', [AudioController::class, 'store'])->name('audio.upload');
Route::delete('/delete/{id}', [AudioController::class, 'destroy'])->name('audio.delete');
