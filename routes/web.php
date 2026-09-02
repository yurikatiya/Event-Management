<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

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
    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('admin.settings.store');
    Route::resource('/gallery', GalleryController::class)
        ->except('show')
        ->names('admin.gallery');
    Route::resource('/categories', CategoryController::class)
        ->except('show')
        ->names('admin.categories');
    Route::resource('/events', EventController::class)
        ->except('show')
        ->names('admin.events');
    Route::patch('/services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('admin.services.toggle-status');
    Route::resource('/services', ServiceController::class)
        ->except('show')
        ->names('admin.services');
    Route::patch('/partners/{partner}/toggle-status', [PartnerController::class, 'toggleStatus'])->name('admin.partners.toggle-status');
    Route::resource('/partners', PartnerController::class)
        ->except('show')
        ->names('admin.partners');
    Route::patch('/sponsors/{sponsor}/toggle-status', [SponsorController::class, 'toggleStatus'])->name('admin.sponsors.toggle-status');
    Route::resource('/sponsors', SponsorController::class)
        ->except('show')
        ->names('admin.sponsors');
    Route::patch('/teams/{team}/toggle-status', [TeamController::class, 'toggleStatus'])->name('admin.teams.toggle-status');
    Route::resource('/teams', TeamController::class)
        ->except('show')
        ->names('admin.teams');
    Route::redirect('/admin/categories', '/categories', 301);
    Route::redirect('/admin/events', '/events', 301);
});

Route::middleware(['auth', 'role:participant'])->prefix('participant')->name('participant.')->group(function () {
    Route::get('/dashboard', function () {
        return view('participant.dashboard');
    })->name('dashboard');
});
