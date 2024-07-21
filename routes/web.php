<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\EditProject;
use App\Livewire\Projects;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/projects', Projects::class)->name('projects');
    Route::get('/projects/{project}', EditProject::class)->name('projects.show');
});

require __DIR__ . '/auth.php';
