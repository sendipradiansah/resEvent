<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Route
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('dashboard');
    Route::get('/checkin/{id}', [ReservationController::class, 'showCheckin'])->name('checkin.form');
    Route::post('/checkin/{id}', [ReservationController::class, 'processCheckin'])->name('checkin.process');
    Route::resource('/event', EventController::class); // /admin/event, /admin/event/create, etc.
    Route::resource('/reservation', ReservationController::class); // /admin/event, /admin/event/create, etc.
});

// User Route
Route::prefix('event')->middleware(['auth'])->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('event.index');         // /event
    Route::get('/{event}', [EventController::class, 'show'])->name('event.show');    // /event/{id}
    Route::post('/{event}/reservation', [ReservationController::class, 'store'])->name('event.reservation'); // /event/{id}/reservation
});

Route::prefix('reservation')->middleware(['auth'])->group(function () {
    Route::get('/', [ReservationController::class, 'index'])->name('reservation.index'); // /reservation
    Route::get('/{id}', [ReservationController::class, 'show'])->name('reservation.show'); // /reservation/{id}
});
