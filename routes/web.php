<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect('/login');
});

// Show login view
Route::get('/login', function () {
    return view('login');
})->name('login');

// Handle Firebase login
Route::post('/firebase-login', [AuthController::class, 'firebaseLogin'])->name('firebase.login');

// Logout and clear session
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Group protected routes with middleware
Route::middleware(['firebase.auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // AJAX route to get tasks
    Route::post('/get-tasks', [TaskController::class, 'getTasks']);
});
