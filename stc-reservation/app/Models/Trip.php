<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'route_id',
        'bus_id',
        'departure_date',
        'departure_time',
        'price',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'departure_time' => 'datetime:H:i',
        'price' => 'decimal:2',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the effective price for this trip
     * Returns trip-specific price if set, otherwise falls back to route price
     */
    public function getEffectivePriceAttribute()
    {
        return $this->price ?? $this->route->price;
    }

    /**
     * Check if this trip has a custom price
     */
    public function hasCustomPrice()
    {
        return $this->price !== null;
    }
}
