<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'user_id'
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function generateSeatMap()
    {
        if ($this->seats->isEmpty()){
            return [];
        }

        $seat_map = $this->seats->map(function ($seat) {
            return [
                'id' => $seat->uid,
                'label' => $seat->label,
                'type' => $seat->type,
                'icon' => $seat->icon,
                'booked' => (bool)$seat->booked,
                'x' => $seat->x,
                'y' => $seat->y,
            ];
        });

        return json_encode($seat_map);
    }
}
