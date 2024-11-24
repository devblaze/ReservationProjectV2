<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $primaryKey = 'uid';  // Declaring `uid` as the primary key
    public $incrementing = false;   // Since 'uid' is not auto-incrementing
    protected $keyType = 'string';  // UID is a string

    protected $fillable = [
        'uid',
        'venue_id',
        'label',
        'type',
        'booked',
        'x',
        'y'
    ];

    // Define relationship with Venue
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'seat_id', 'uid');
    }
}
