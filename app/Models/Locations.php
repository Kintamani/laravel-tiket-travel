<?php

namespace App\Models;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function schedules()
    {
        return $this->hasMany(Schedules::class, 'pickup_id')->orWhere('destination_id');
    }
}
