<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'origin',
        'destination',
        'price',
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
