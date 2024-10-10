<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'seat_id',
        'price',
        'status'
    ];

    protected $casts = [
        'seat_numbers' => 'array',  // Cast seat_numbers to array type
    ];

    /**
     * The reservations must belong to an event.
     * @return BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * The reservation must belong to a user.
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The reservation can have many reserved seats.
     * @return HasMany
     */
    public function seat()
    {
        return $this->hasMany(Seat::class, 'seat_id', 'uid');  // Explicitly define 'seat_id' -> 'uid' in seats table
    }
}
