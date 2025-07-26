<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RouteController as AdminRouteController;
use App\Http\Controllers\Admin\BusController as AdminBusController;
use App\Http\Controllers\Admin\TripController as AdminTripController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

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
});

Route::middleware(['auth'])->group(function () {
    Route::get('/routes', [BookingController::class, 'showRoutes'])->name('routes.index');
    Route::get('/routes/{route}/trips', [BookingController::class, 'showTrips'])->name('routes.trips');
    Route::get('/trips/{trip}/seats', [BookingController::class, 'showSeats'])->name('trips.seats');
    Route::post('/trips/{trip}/book', [BookingController::class, 'bookSeat'])->name('trips.book');
});

Route::middleware(['auth'])->get('/my-bookings', [BookingController::class, 'userBookings'])->name('user.bookings');

Route::get('/bookings/{booking}', [BookingController::class, 'showBooking'])->name('bookings.show');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Resource routes for admin management
    Route::resource('routes', AdminRouteController::class);
    Route::resource('buses', AdminBusController::class);
    Route::resource('trips', AdminTripController::class);
    Route::resource('bookings', AdminBookingController::class)->only(['index', 'show', 'update']);
    Route::resource('users', AdminUserController::class)->only(['index', 'show', 'edit', 'update']);
    
    // QR Scanner route
    Route::get('/scanner', [AdminController::class, 'scanner'])->name('scanner');
    Route::post('/scan-ticket', [AdminController::class, 'scanTicket'])->name('scan.ticket');
});

require __DIR__.'/auth.php';
