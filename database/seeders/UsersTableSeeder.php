<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Employee;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employee = Employee::first(); // Assign to first employee
        $employeeId = $employee ? $employee->id : 1; 

        // Create sample users
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'Customer ' . $i,
                'email' => "customer{$i}@example.com",
                'mobile' => '98765432' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'password' => Hash::make('123456'), // Default password
                'customer_id' => 'CUST-' . strtoupper(Str::random(4)) . '-' . time() . $i,
                'address' => 'Sample Address ' . $i,
                'id_proof' => 'ID_PROOF_' . $i,
                'created_by' => $employeeId,
                'status' => 'active',
                'dob' => '1990-01-0' . ($i % 9 + 1), // Sample DOB
            ]);
        }
    }
}
