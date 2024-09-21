<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'event_id',
        'label',
        'type',
        'icon',
        'booked',
        'selected',
        'x',
        'y',
    ];

    // Define relationship with Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
