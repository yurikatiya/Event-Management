<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.legacy');
    Route::resource('/admin/categories', CategoryController::class)
        ->except('show')
        ->names('admin.categories');
    Route::resource('/admin/events', EventController::class)
        ->except('show')
        ->names('admin.events');
});

Route::middleware(['auth', 'role:participant'])->prefix('participant')->name('participant.')->group(function () {
    Route::get('/dashboard', function () {
        return view('participant.dashboard');
    })->name('dashboard');
});
