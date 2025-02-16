<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
    use HasFactory;

    protected $fillable = [
        'pickup_id', 'arrival_time', 'destination_id', 'departure_time', 'description', 'available_seats', 'price'
    ];

    public function pickup()
    {
        return $this->belongsTo(Locations::class, 'pickup_id');
    }

    public function destination()
    {
        return $this->belongsTo(Locations::class, 'destination_id');
    }

    public function bookings()
    {
        return $this->hasMany(Bookings::class);
    }
}
