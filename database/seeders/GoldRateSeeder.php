<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DailyGoldRate;
use App\Models\Employee;
use Carbon\Carbon;

class GoldRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first employee (admin) ID or create a dummy one if none exists
        $admin = Employee::first();
        $adminId = $admin ? $admin->id : 1;

        $startDate = Carbon::today();
        
        for ($i = 0; $i < 20; $i++) {
            $date = $startDate->copy()->addDays($i);
            
            // Random fluctuation logic for realistic simulation
            // Base around 7500 with +/- 200 randomness
            $rate = 7500 + rand(-200, 200);

            DailyGoldRate::updateOrCreate(
                ['rate_date' => $date->format('Y-m-d')],
                [
                    'rate_per_gram' => $rate,
                    'created_by' => $adminId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
