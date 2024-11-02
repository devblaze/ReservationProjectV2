<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $primaryKey = 'uid';  // Declaring `uid` as the primary key
    public $incrementing = false;  // Since 'uid' is not auto-incrementing
    protected $keyType = 'string';  // UID is a string

    protected $fillable = [
        'uid',
        'event_id',
        'label',
        'type',
        'icon',
        'booked',
        'selected',
        'x',
        'y'
    ];

    // Define relationship with Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'seat_id', 'uid');
    }
}
