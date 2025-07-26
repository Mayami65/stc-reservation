<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Seat;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::withCount('seats')->latest()->paginate(10);
        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        return view('admin.buses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'seat_count' => 'required|integer|min:1|max:100',
        ]);

        $bus = Bus::create($request->only(['name', 'seat_count']));

        // Create seats for the bus
        $this->createSeats($bus);

        return redirect()->route('admin.buses.index')
            ->with('success', 'Bus created successfully with ' . $bus->seat_count . ' seats.');
    }

    public function show(Bus $bus)
    {
        $bus->load('seats', 'trips');
        return view('admin.buses.show', compact('bus'));
    }

    public function edit(Bus $bus)
    {
        return view('admin.buses.edit', compact('bus'));
    }

    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'seat_count' => 'required|integer|min:1|max:100',
        ]);

        $oldSeatCount = $bus->seat_count;
        $bus->update($request->only(['name', 'seat_count']));

        // Update seats if seat count changed
        if ($oldSeatCount !== (int)$request->seat_count) {
            $bus->seats()->delete();
            $this->createSeats($bus);
        }

        return redirect()->route('admin.buses.index')
            ->with('success', 'Bus updated successfully.');
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();
        return redirect()->route('admin.buses.index')
            ->with('success', 'Bus deleted successfully.');
    }

    private function createSeats(Bus $bus)
    {
        $seats = [];
        for ($i = 1; $i <= $bus->seat_count; $i++) {
            $seats[] = [
                'bus_id' => $bus->id,
                'seat_number' => $this->generateSeatNumber($i),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Seat::insert($seats);
    }

    private function generateSeatNumber($index)
    {
        $row = chr(65 + intval(($index - 1) / 4)); // A, B, C, etc.
        $number = (($index - 1) % 4) + 1; // 1, 2, 3, 4
        return $row . $number;
    }
}
