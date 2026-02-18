<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // We use the 'employees' table for admin login as per earlier seeder/migration
        $employee = DB::table('employees')->where('email', $request->email)->first();

        if ($employee && Hash::check($request->password, $employee->password)) {
            // Manually log the user in or using a custom guard if configured.
            // For simplicity in this step, let's use session or configure a guard.
            // Assuming we want to use the default web guard or a new admin guard.
            // Let's use session storage for simplicity if valid, or configure 'employees' guard.
            
            // NOTE: Laravel default Auth expects a User model. 
            // Since we used 'employees' table, we should ideally have an Employee model.
            // Let's create an Employee model quickly to make Auth::login working properly or use manual session.
            
            // Better approach: Create Employee model and use Auth guard.
            // For now, let's store ID in session to unblock 'Dashboard' access.
            session(['admin_id' => $employee->id, 'admin_role' => $employee->role, 'admin_name' => $employee->name]);
            
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        session()->forget(['admin_id', 'admin_role', 'admin_name']);
        return redirect()->route('admin.login');
    }

    public function showChangePasswordForm()
    {
        return view('Admin.password.change');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $employee = DB::table('employees')->where('id', session('admin_id'))->first();

        if (!Hash::check($request->current_password, $employee->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        DB::table('employees')->where('id', session('admin_id'))->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password updated successfully');
    }
}
