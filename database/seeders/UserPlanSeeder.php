<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\GoldPlan;
use App\Models\Employee;
use App\Models\UserPlan;
use App\Models\EmiSchedule;
use App\Models\Payment;
use Carbon\Carbon;

class UserPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $plans = GoldPlan::where('status', 'active')->get();
        $employee = Employee::first(); // Assign to first employee/admin

        if ($users->isEmpty() || $plans->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            // Assign a random plan to each user
            $plan = $plans->random();
            
            // Random start date within last 3 months to simulate ongoing plans
            $startDate = Carbon::today()->subDays(rand(1, 90));
            $maturityDate = $startDate->copy()->addMonths($plan->duration_months);

            $userPlan = UserPlan::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'employee_id' => $employee->id ?? 1,
                'start_date' => $startDate->format('Y-m-d'),
                'maturity_date' => $maturityDate->format('Y-m-d'),
                'total_paid' => 0,
                'total_pending' => $plan->total_amount, // Will update as we pay EMIs
                'status' => 'active',
            ]);

            $totalPaid = 0;

            // Generate EMI Schedule
            for ($i = 1; $i <= $plan->duration_months; $i++) {
                $dueDate = $startDate->copy()->addMonths($i - 1);
                $status = 'pending';
                $paidAmount = 0;

                // Simulate payment if due date is in the past
                if ($dueDate->isPast()) {
                    $status = 'paid';
                    $paidAmount = $plan->monthly_emi;
                    $totalPaid += $paidAmount;

                    // Create Payment Record (Simulated)
                    Payment::create([
                        'user_id' => $user->id,
                        'user_plan_id' => $userPlan->id,
                        'employee_id' => $employee->id ?? 1,
                        'amount' => $paidAmount,
                        'payment_mode' => 'Cash', // Default
                        'payment_date' => $dueDate->format('Y-m-d'), // Assume paid on due date
                        'remarks' => 'Seeded Payment',
                    ]);
                }

                EmiSchedule::create([
                    'user_plan_id' => $userPlan->id,
                    'emi_month' => $i,
                    'due_date' => $dueDate->format('Y-m-d'),
                    'emi_amount' => $plan->monthly_emi,
                    'paid_amount' => $paidAmount,
                    'status' => $status,
                ]);
            }

            // Update UserPlan totals
            $userPlan->update([
                'total_paid' => $totalPaid,
                'total_pending' => $plan->total_amount - $totalPaid,
            ]);
        }
    }
}
