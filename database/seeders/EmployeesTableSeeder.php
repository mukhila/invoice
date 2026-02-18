<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure Admin exists
        Employee::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'mobile' => '9876543210',
                'password' => Hash::make('password'),
                'role' => 'SuperAdmin',
                'status' => 'active',
                'dob' => '1990-01-01',
            ]
        );

        $employees = [
            [
                'email' => 'john@example.com',
                'name' => 'John Doe',
                'mobile' => '9876543211',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'status' => 'active',
                'dob' => '1992-05-15',
            ],
            [
                'email' => 'jane@example.com',
                'name' => 'Jane Smith',
                'mobile' => '9876543212',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'status' => 'active',
                'dob' => '1995-08-20',
            ],
            [
                'email' => 'michael@example.com',
                'name' => 'Michael Brown',
                'mobile' => '9876543213',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'status' => 'active',
                'dob' => '1988-12-10',
            ],
            [
                'email' => 'emily@example.com',
                'name' => 'Emily Davis',
                'mobile' => '9876543214',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'status' => 'inactive',
                'dob' => '1993-03-25',
            ],
            [
                'email' => 'david@example.com',
                'name' => 'David Wilson',
                'mobile' => '9876543215',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'status' => 'active',
                'dob' => '1990-07-05',
            ],
        ];

        foreach ($employees as $emp) {
            Employee::firstOrCreate(
                ['email' => $emp['email']],
                $emp
            );
        }
    }
}
