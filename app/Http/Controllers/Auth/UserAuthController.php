<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.user_login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'dob' => 'required|date',
        ]);

        // Find user by mobile and DOB
        // Note: For real security, formatting matters. Assuming simple match for demo.
        $user = User::where('mobile', $request->mobile)
                    ->where('dob', $request->dob)
                    ->first();

        if ($user) {
            Auth::login($user);
            return redirect()->route('user.dashboard');
        }

        return back()->withErrors(['mobile' => 'Invalid credentials or account not found.']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|unique:users,mobile',
            'dob' => 'required|date',
            'email' => 'nullable|email|unique:users,email',
        ]);

        $user = User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'dob' => $request->dob,
            'email' => $request->email,
            'password' => Hash::make(Str::random(10)), // Random password since we use DOB Login
            'customer_id' => 'CUST-' . strtoupper(Str::random(4)) . '-' . time(),
            'status' => 'active',
            'created_by' => 1, // Default to Admin if self-registered
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        // Fetch User's first active plan
        $plan = $user->userPlans()->with('plan')->where('status', 'active')->first();
        
        $alert = null;
        $recentTransactions = [];
        $chartData = [0, 0, 0, 0, 0, 0];
        $chartLabels = ['M1', 'M2', 'M3', 'M4', 'M5', 'M6'];
        
        if ($plan) {
            // Check for overdue payments
            $overdueEmi = $plan->emiSchedules()
                             ->where('status', 'pending')
                             ->where('due_date', '<', now()->format('Y-m-d'))
                             ->orderBy('due_date')
                             ->first();

            if ($overdueEmi) {
                $alert = [
                    'amount' => $overdueEmi->emi_amount,
                    'due_date' => \Carbon\Carbon::parse($overdueEmi->due_date)->format('M jS'),
                    'days_overdue' => now()->diffInDays($overdueEmi->due_date)
                ];
            }

            // Recent Transactions
            $recentTransactions = $plan->payments()
                                       ->latest()
                                       ->take(3)
                                       ->get();

            // Chart Data (Last 6 months simulated or real)
            // Group payments by month?? Or just show accumulated growth?
            // "Rising graph showing consistent savings" -> Accumulative Total Paid
            
            // Let's create a simple trend of TOTAL PAID over time? 
            // Or just last 6 payments amounts.
            // Let's do Monthly Savings trend.
            
            $payments = $plan->payments()->latest()->take(6)->get()->reverse();
            $chartData = $payments->pluck('amount')->values()->toArray();
            $chartLabels = $payments->map(fn($p) => $p->created_at->format('M d'))->values()->toArray();
            
            // Fallback if no data
            if (empty($chartData)) {
                $chartData = [0, 0, 0, 0, 0, 0];
                $chartLabels = ['N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A'];
            }
        }

        // Fetch Today's Gold Rate
        $latestRate = \App\Models\DailyGoldRate::latest('rate_date')->first();
        $goldRatePerGram = $latestRate ? $latestRate->rate_per_gram : 7500; // Fallback to 7500 if no rate set

        return view('user.dashboard', compact('user', 'plan', 'alert', 'recentTransactions', 'chartData', 'chartLabels', 'goldRatePerGram'));
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.login');
    }
}
