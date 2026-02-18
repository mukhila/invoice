<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GoldPlan;

class GoldPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'plan_name' => '11-Month Gold Saver',
                'duration_months' => 11,
                'monthly_emi' => 1000.00,
                'total_amount' => 11000.00,
                'bonus_amount' => 1000.00,
                'status' => 'active',
            ],
            [
                'plan_name' => '11-Month Premium Saver',
                'duration_months' => 11,
                'monthly_emi' => 5000.00,
                'total_amount' => 55000.00,
                'bonus_amount' => 5000.00,
                'status' => 'active',
            ],
            [
                'plan_name' => '6-Month Short Term',
                'duration_months' => 6,
                'monthly_emi' => 2000.00,
                'total_amount' => 12000.00,
                'bonus_amount' => 500.00,
                'status' => 'active',
            ],
            [
                'plan_name' => '24-Month Long Term',
                'duration_months' => 24,
                'monthly_emi' => 1000.00,
                'total_amount' => 24000.00,
                'bonus_amount' => 2500.00,
                'status' => 'active',
            ],
            [
                'plan_name' => 'Special Festival Plan',
                'duration_months' => 10,
                'monthly_emi' => 10000.00,
                'total_amount' => 100000.00,
                'bonus_amount' => 8000.00,
                'status' => 'inactive',
            ],
        ];

        foreach ($plans as $plan) {
            GoldPlan::create($plan);
        }
    }
}
