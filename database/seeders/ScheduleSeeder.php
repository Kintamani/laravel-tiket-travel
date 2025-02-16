<?php

namespace Database\Seeders;

use App\Models\Locations;
use App\Models\Schedules;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = Locations::all();
        
        if ($locations->count() < 2) {
            return;
        }
        
        for ($i = 0; $i < 5; $i++) {
            Schedules::create([
                'pickup_id' => $locations->random()->id,
                'arrival_time' => Carbon::now()->addHours(rand(1, 5)),
                'destination_id' => $locations->random()->id,
                'departure_time' => Carbon::now()->addMinutes(rand(30, 120)),
                'description' => 'Perjalanan nyaman dengan fasilitas lengkap.',
                'available_seats' => rand(1, 12),
                'price' => rand(10000, 50000),
            ]);
        }
    }
}
