<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
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
}
