<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Route;
use App\Models\Bus;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with(['route', 'bus'])
            ->latest('departure_date')
            ->latest('departure_time')
            ->paginate(15);
        return view('admin.trips.index', compact('trips'));
    }

    public function create()
    {
        $routes = Route::all();
        $buses = Bus::all();
        return view('admin.trips.create', compact('routes', 'buses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'bus_id' => 'required|exists:buses,id',
            'departure_date' => 'required|date|after_or_equal:today',
            'departure_time' => 'required|date_format:H:i',
        ]);

        Trip::create($request->only(['route_id', 'bus_id', 'departure_date', 'departure_time']));

        return redirect()->route('admin.trips.index')
            ->with('success', 'Trip created successfully.');
    }

    public function show(Trip $trip)
    {
        $trip->load(['route', 'bus.seats', 'bookings.user', 'bookings.seat']);
        $bookedSeats = $trip->bookings->pluck('seat_id')->toArray();
        return view('admin.trips.show', compact('trip', 'bookedSeats'));
    }

    public function edit(Trip $trip)
    {
        $routes = Route::all();
        $buses = Bus::all();
        return view('admin.trips.edit', compact('trip', 'routes', 'buses'));
    }

    public function update(Request $request, Trip $trip)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'bus_id' => 'required|exists:buses,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
        ]);

        $trip->update($request->only(['route_id', 'bus_id', 'departure_date', 'departure_time']));

        return redirect()->route('admin.trips.index')
            ->with('success', 'Trip updated successfully.');
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('admin.trips.index')
            ->with('success', 'Trip deleted successfully.');
    }
}
