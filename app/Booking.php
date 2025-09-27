<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'client_id',
        'start',
        'end',
        'notes',
    ];

    protected $dates = [
        'start',
        'end',
    ];

    public function scopeFuture($query)
    {
        return $query->where('start', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('end', '<', now());
    }

    public function scopeTimeFilter($query, $filter)
    {
        switch ($filter) {
            case 'future':
                return $query->future();
            case 'past':
                return $query->past();
            case 'all':
            default:
                return $query;
        }
    }
}
