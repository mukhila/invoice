<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->paginate(20);
        return view('Admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('Admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees',
            'mobile' => 'required|unique:employees',
            'password' => 'required|min:6',
            'role' => 'required',
            'status' => 'required',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        
        Employee::create($data);

        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('Admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,' . $id,
            'mobile' => 'required|unique:employees,mobile,' . $id,
            'role' => 'required',
            'status' => 'required',
        ]);

        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully');
    }
}
