<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPlan;
use App\Models\EmiSchedule;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Simple middleware check simulation
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $adminId = session('admin_id');
        $role = session('admin_role');

        // Base Queries
        $customersQuery = User::query();
        $userPlansQuery = UserPlan::query();
        $emiQuery = EmiSchedule::query()->whereHas('userPlan', function($q) use ($adminId, $role) {
            if ($role !== 'SuperAdmin') {
                $q->where('employee_id', $adminId);
            }
        });
        $paymentsQuery = Payment::query()->whereHas('userPlan', function($q) use ($adminId, $role) {
             if ($role !== 'SuperAdmin') {
                $q->where('employee_id', $adminId);
            }
        });

        // Apply Employee Filters
        if ($role !== 'SuperAdmin') {
            $customersQuery->where('created_by', $adminId);
            $userPlansQuery->where('employee_id', $adminId);
        }

        // 1. Top Section: KPI Metrics
        $totalCustomers = $customersQuery->count();
        
        $newCustomers = (clone $customersQuery)->whereMonth('created_at', now()->month)
                                              ->whereYear('created_at', now()->year)
                                              ->count();
        
        $activeCustomers = (clone $userPlansQuery)->where('status', 'active')
                                                 ->distinct('user_id')
                                                 ->count('user_id');
        
        $totalOverdue = (clone $emiQuery)->where('status', 'pending')
                                         ->where('due_date', '<', now()->format('Y-m-d'))
                                         ->sum('emi_amount');

        // Total EMI Demand for Current Month
        $currentMonthEmi = (clone $emiQuery)->whereMonth('due_date', now()->month)
                                            ->whereYear('due_date', now()->year)
                                            ->sum('emi_amount');

        // 2. Middle Section: Budget/Finance Summary (Current Month)
        $monthlyPending = (clone $emiQuery)->whereMonth('due_date', now()->month)
                                           ->whereYear('due_date', now()->year)
                                           ->where('status', 'pending')
                                           ->sum('emi_amount');
        
        $monthlyPaid = (clone $paymentsQuery)->whereMonth('payment_date', now()->month)
                                             ->whereYear('payment_date', now()->year)
                                             ->sum('amount');

        // 3. Bottom Section: Overdue Aging
        // 1-30 days overdue
        $overdue30 = (clone $emiQuery)->where('status', 'pending')
                                      ->whereBetween('due_date', [
                                          now()->subDays(30)->format('Y-m-d'), 
                                          now()->subDays(1)->format('Y-m-d')
                                      ])->sum('emi_amount');
        
        // 31-60 days overdue
        $overdue60 = (clone $emiQuery)->where('status', 'pending')
                                      ->whereBetween('due_date', [
                                          now()->subDays(60)->format('Y-m-d'), 
                                          now()->subDays(31)->format('Y-m-d')
                                      ])->sum('emi_amount');

        // 61-90 days overdue
        $overdue90 = (clone $emiQuery)->where('status', 'pending')
                                      ->whereBetween('due_date', [
                                          now()->subDays(90)->format('Y-m-d'), 
                                          now()->subDays(61)->format('Y-m-d')
                                      ])->sum('emi_amount');

        return view('Admin.dashboard', compact(
            'totalCustomers', 'newCustomers', 'activeCustomers', 'totalOverdue', 'currentMonthEmi',
            'monthlyPending', 'monthlyPaid',
            'overdue30', 'overdue60', 'overdue90'
        ));
    }
    public function profile()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $admin = \App\Models\Employee::findOrFail(session('admin_id'));
        return view('Admin.profile', compact('admin'));
    }
}
