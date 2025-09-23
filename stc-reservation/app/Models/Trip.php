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

    protected static function boot()
    {
        parent::boot();

        // Set trip price equal to route price if not provided
        static::creating(function ($trip) {
            if ($trip->price === null && $trip->route_id) {
                $route = Route::find($trip->route_id);
                if ($route) {
                    $trip->price = $route->price;
                }
            }
        });

        // Update trip price when route changes
        static::updating(function ($trip) {
            if ($trip->isDirty('route_id') && $trip->price === null) {
                $route = Route::find($trip->route_id);
                if ($route) {
                    $trip->price = $route->price;
                }
            }
        });
    }

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
     * Returns trip price (which is now always set to route price if not custom)
     */
    public function getEffectivePriceAttribute()
    {
        return $this->price ?? $this->route->price;
    }

    /**
     * Check if this trip has a custom price (different from route price)
     */
    public function hasCustomPrice()
    {
        return $this->price !== null && $this->price != $this->route->price;
    }

    /**
     * Set the trip price to route price (reset to default)
     */
    public function resetToRoutePrice()
    {
        $this->price = $this->route->price;
        $this->save();
    }
}
