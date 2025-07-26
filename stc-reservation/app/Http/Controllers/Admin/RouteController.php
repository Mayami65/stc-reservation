<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::latest()->paginate(10);
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
        ]);

        Route::create($request->only(['origin', 'destination']));

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route created successfully.');
    }

    public function show(Route $route)
    {
        $route->load('trips.bus', 'trips.bookings');
        return view('admin.routes.show', compact('route'));
    }

    public function edit(Route $route)
    {
        return view('admin.routes.edit', compact('route'));
    }

    public function update(Request $request, Route $route)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
        ]);

        $route->update($request->only(['origin', 'destination']));

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route updated successfully.');
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return redirect()->route('admin.routes.index')
            ->with('success', 'Route deleted successfully.');
    }
}
