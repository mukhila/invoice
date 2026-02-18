<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPlan;
use App\Models\GoldPlan;
use App\Models\EmiSchedule;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserPlanController extends Controller
{
    // Global methods for Sidebar Menu
    public function allUserPlans()
    {
        $query = UserPlan::with(['user', 'plan'])->latest();

        if (session('admin_role') !== 'SuperAdmin') {
            $query->where('employee_id', session('admin_id'));
        }

        $userPlans = $query->get();
        return view('Admin.user_plans.all_index', compact('userPlans'));
    }

    public function assignPlan()
    {
        $users = User::where('status', 'active')->get();
        $goldPlans = GoldPlan::where('status', 'active')->get();
        return view('Admin.user_plans.assign', compact('users', 'goldPlans'));
    }

    public function storeAssignedPlan(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:gold_plans,id',
            'start_date' => 'required|date',
        ]);

        $user = User::findOrFail($request->user_id);
        $goldPlan = GoldPlan::findOrFail($request->plan_id);
        
        $startDate = Carbon::parse($request->start_date);
        $maturityDate = $startDate->copy()->addMonths($goldPlan->duration_months);

        DB::transaction(function () use ($user, $goldPlan, $startDate, $maturityDate) {
            // Create User Plan
            $userPlan = UserPlan::create([
                'user_id' => $user->id,
                'plan_id' => $goldPlan->id,
                'employee_id' => 1, // Defaulting to Admin/System
                'start_date' => $startDate->format('Y-m-d'),
                'maturity_date' => $maturityDate->format('Y-m-d'),
                'total_paid' => 0,
                'total_pending' => $goldPlan->total_amount,
                'status' => 'active',
            ]);

            // Generate EMI Schedule
            for ($i = 1; $i <= $goldPlan->duration_months; $i++) {
                EmiSchedule::create([
                    'user_plan_id' => $userPlan->id,
                    'emi_month' => $i,
                    'due_date' => $startDate->copy()->addMonths($i - 1)->format('Y-m-d'),
                    'emi_amount' => $goldPlan->monthly_emi,
                    'paid_amount' => 0,
                    'status' => 'pending',
                ]);
            }
        });

        return redirect()->route('admin.all-user-plans.index')->with('success', 'Gold Plan assigned successfully to ' . $user->name);
    }

    public function showPayForm(EmiSchedule $emiSchedule)
    {
        $emiSchedule->load(['userPlan.user', 'userPlan.plan']);
        return view('Admin.user_plans.pay', compact('emiSchedule'));
    }

    public function processPayment(Request $request, EmiSchedule $emiSchedule)
    {
        $request->validate([
            'amount' => 'required|numeric|min:' . $emiSchedule->emi_amount, // Enforce full amount for now
            'payment_mode' => 'required|in:Cash,UPI,Bank',
        ]);

        // Proceed with transaction
        DB::transaction(function () use ($request, $emiSchedule) {
            $userPlan = $emiSchedule->userPlan;

            // 1. Create Payment Record
            Payment::create([
                'user_id' => $userPlan->user_id,
                'user_plan_id' => $userPlan->id,
                'employee_id' => 1, // Default Admin/System
                'amount' => $request->amount,
                'payment_mode' => $request->payment_mode,
                'payment_date' => now(),
                'remarks' => $request->remarks,
            ]);

            // 2. Update EMI Schedule
            $emiSchedule->update([
                'status' => 'paid',
                'paid_amount' => $request->amount,
            ]);

            // 3. Update User Plan Totals
            $userPlan->increment('total_paid', $request->amount);
            $userPlan->decrement('total_pending', $request->amount);
            
            // Check if plan is completed
            if ($userPlan->total_pending <= 0) {
                $userPlan->update(['status' => 'completed']);
            }
        });

        return redirect()->route('admin.user-plans.show', $emiSchedule->user_plan_id)->with('success', 'EMI Payment successful');
    }
    public function index(User $user)
    {
        $plans = $user->userPlans()->with('plan')->latest()->get();
        return view('Admin.user_plans.index', compact('user', 'plans'));
    }

    public function create(User $user)
    {
        $goldPlans = GoldPlan::where('status', 'active')->get();
        return view('Admin.user_plans.create', compact('user', 'goldPlans'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'plan_id' => 'required|exists:gold_plans,id',
            'start_date' => 'required|date',
        ]);

        $goldPlan = GoldPlan::findOrFail($request->plan_id);
        
        $startDate = Carbon::parse($request->start_date);
        $maturityDate = $startDate->copy()->addMonths($goldPlan->duration_months);

        DB::transaction(function () use ($user, $goldPlan, $startDate, $maturityDate) {
            // Create User Plan
            $userPlan = UserPlan::create([
                'user_id' => $user->id,
                'plan_id' => $goldPlan->id,
                'employee_id' => 1, // Defaulting to Admin/System. Ideally session('admin_id') or Auth::user()->id
                'start_date' => $startDate->format('Y-m-d'),
                'maturity_date' => $maturityDate->format('Y-m-d'),
                'total_paid' => 0,
                'total_pending' => $goldPlan->total_amount,
                'status' => 'active',
            ]);

            // Generate EMI Schedule
            for ($i = 1; $i <= $goldPlan->duration_months; $i++) {
                EmiSchedule::create([
                    'user_plan_id' => $userPlan->id,
                    'emi_month' => $i,
                    'due_date' => $startDate->copy()->addMonths($i - 1)->format('Y-m-d'), // 1st EMI due on start date? or next month? Usually start date for advance, or 1 month later. Let's assume typical monthly scheme: 1st installment on start.
                    'emi_amount' => $goldPlan->monthly_emi,
                    'paid_amount' => 0,
                    'status' => 'pending',
                ]);
            }
        });

        return redirect()->route('admin.users.plans.index', $user->id)->with('success', 'Gold Plan assigned successfully');
    }

    public function show(UserPlan $userPlan)
    {
        $userPlan->load(['user', 'plan', 'emiSchedules', 'payments']);
        
        $paidEmis = $userPlan->emiSchedules->where('status', 'paid');
        $pendingEmis = $userPlan->emiSchedules->where('status', 'pending');
        
        return view('Admin.user_plans.show', compact('userPlan', 'paidEmis', 'pendingEmis'));
    }
}
