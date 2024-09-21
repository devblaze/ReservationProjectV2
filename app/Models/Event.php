<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Event extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'is_canceled',
        'organizer_id',
    ];

    /**
     * Get the organizer that owns the event.
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * An event can have many reservations.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Event has many seats.
     */
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function generateSeatMap()
    {
        if ($this->seats->isEmpty()){
            return [];
        }

        $seat_map = $this->seats->map(function ($seat) {
            return [
                'id' => $seat->uid,       // Unique ID
                'label' => $seat->label, // Label like "Table", "Chair", etc.
                'type' => $seat->type,   // Type of seat ("chair", "table", etc.)
                'icon' => $seat->icon,   // Icon associated with this seat
                'booked' => (bool) $seat->booked,  // True if booked, false otherwise
                'x' => $seat->x,         // X coordinate on seat map
                'y' => $seat->y,         // Y coordinate on seat map
            ];
        });

        return json_encode($seat_map);
    }
}
