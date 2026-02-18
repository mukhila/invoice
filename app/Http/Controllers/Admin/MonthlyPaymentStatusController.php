<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MonthlyPaymentStatusController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));

        // Parse format ensuring it matches database storing convention for emi_month
        // Assuming emi_month in EmiSchedule is stored as 'YYYY-MM-DD' or 'YYYY-MM'
        // Based on EmiSchedule model, let's assume it matches strict date or month string.
        // If emi_month is a date (e.g. 2024-01-01), we need to check the month part.
        
        // Let's refine the query using whereHas on userPlans -> emiSchedules
        
        $paidUsers = User::whereHas('userPlans.emiSchedules', function ($query) use ($selectedMonth) {
            $query->where('due_date', 'like', "$selectedMonth%")
                  ->where('status', 'paid');
        })->with(['userPlans.emiSchedules' => function ($query) use ($selectedMonth) {
             $query->where('due_date', 'like', "$selectedMonth%");
        }])->get();

        $unpaidUsers = User::whereHas('userPlans.emiSchedules', function ($query) use ($selectedMonth) {
            $query->where('due_date', 'like', "$selectedMonth%")
                  ->where('status', '!=', 'paid');
        })->with(['userPlans.emiSchedules' => function ($query) use ($selectedMonth) {
             $query->where('due_date', 'like', "$selectedMonth%");
        }])->get();

        return view('Admin.user-payments.monthly', compact('paidUsers', 'unpaidUsers', 'selectedMonth'));
    }
}
