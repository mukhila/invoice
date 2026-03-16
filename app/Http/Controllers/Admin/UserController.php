<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $query = User::with('creator')->latest();
        
        if (session('admin_role') !== 'SuperAdmin') {
            $query->where('created_by', session('admin_id'));
        }

        $users = $query->paginate(20);
        return view('Admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('Admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'fin_no' => 'required',
            'mobile' => 'required|unique:users',
            'dob'    => 'nullable|date',
            'address' => 'nullable',
        ]);

        $data = $request->only(['name', 'fin_no', 'mobile', 'dob', 'address']);
        $data['created_by'] = session('admin_id');

        // Auto-generate customer ID: CUST-{RANDOM}-{TIMESTAMP}
        $data['customer_id'] = 'CUST-' . strtoupper(Str::random(4)) . '-' . time();

        // Set a secure random password (customers authenticate via mobile + DOB)
        $data['password'] = Hash::make(Str::random(16));

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully with Customer ID: ' . $data['customer_id']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('Admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name'   => 'required',
            'fin_no' => 'required',
            'mobile' => 'required|unique:users,mobile,' . $id,
            'dob'    => 'nullable|date',
            'address' => 'nullable',
        ]);

        $data = $request->only(['name', 'fin_no', 'mobile', 'dob', 'address']);

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
