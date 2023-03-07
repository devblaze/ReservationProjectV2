<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Event extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are searchable.
     *
     * @var array
     */
    protected $searchable = [
        'title',
        'description',
    ];

    /**
     * The attributes that are used as filters.
     *
     * @var array
     */
    protected $filterable = [
        'start_time',
        'end_time',
        'location',
    ];

    public function searchableAs(): string
    {
        return 'events';
    }
}
