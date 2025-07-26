<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'trip_id', 'seat_id', 'status', 'qr_code_path', 'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    /**
     * Check if the ticket has expired
     */
    public function isExpired(): bool
    {
        if (!$this->expires_at) {
            return false; // No expiry set
        }
        return $this->expires_at->isPast();
    }

    /**
     * Check if the ticket is valid (not expired and not cancelled)
     */
    public function isValid(): bool
    {
        return $this->status !== 'cancelled' && !$this->isExpired();
    }

    /**
     * Get the time remaining until expiry
     */
    public function getTimeUntilExpiry(): ?string
    {
        if (!$this->expires_at) {
            return null;
        }
        
        if ($this->isExpired()) {
            return 'Expired';
        }
        
        return $this->expires_at->diffForHumans();
    }
}
