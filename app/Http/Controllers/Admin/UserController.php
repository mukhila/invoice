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

        $users = $query->get();
        return view('Admin.users.index', compact('users'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('Admin.users.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'dob' => 'required|date',
            'address' => 'required',
            'created_by' => 'required|exists:employees,id',
            'id_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['id_proof', 'photo']); // Handle files separately
        
        // File Upload Logic
        if ($request->hasFile('id_proof')) {
            $data['id_proof'] = $request->file('id_proof')->store('id_proofs', 'public');
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }
        
        // Auto-generate customer ID: CUST-{RANDOM}-{TIMESTAMP}
        $data['customer_id'] = 'CUST-' . strtoupper(Str::random(4)) . '-' . time();
        
        // Default password
        $data['password'] = Hash::make('123456');

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully with Customer ID: ' . $data['customer_id']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $employees = Employee::where('status', 'active')->get();
        return view('Admin.users.edit', compact('user', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|unique:users,mobile,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'address' => 'required',
            'created_by' => 'required|exists:employees,id',
            'id_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['id_proof', 'photo']); // Handle files separately
        
        // File Upload Logic
        if ($request->hasFile('id_proof')) {
            $data['id_proof'] = $request->file('id_proof')->store('id_proofs', 'public');
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }
        
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
