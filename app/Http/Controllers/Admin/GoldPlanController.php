<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoldPlan;
use Illuminate\Http\Request;

class GoldPlanController extends Controller
{
    public function index()
    {
        $goldPlans = GoldPlan::latest()->paginate(20);
        return view('Admin.gold_plans.index', compact('goldPlans'));
    }

    public function create()
    {
        return view('Admin.gold_plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_name' => 'required',
            'duration_months' => 'required|integer|min:1',
            'monthly_emi' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'bonus_amount' => 'nullable|numeric|min:0',
            'status' => 'required',
        ]);

        $data = $request->all();
        // Ensure bonus_amount defaults to 0 if not provided
        $data['bonus_amount'] = $request->input('bonus_amount', 0);

        GoldPlan::create($data);

        return redirect()->route('admin.gold-plans.index')->with('success', 'Gold Plan created successfully');
    }

    public function edit($id)
    {
        $goldPlan = GoldPlan::findOrFail($id);
        return view('Admin.gold_plans.edit', compact('goldPlan'));
    }

    public function update(Request $request, $id)
    {
        $goldPlan = GoldPlan::findOrFail($id);
        
        $request->validate([
            'plan_name' => 'required',
            'duration_months' => 'required|integer|min:1',
            'monthly_emi' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'bonus_amount' => 'nullable|numeric|min:0',
            'status' => 'required',
        ]);

        $data = $request->all();
        $data['bonus_amount'] = $request->input('bonus_amount', 0);

        $goldPlan->update($data);

        return redirect()->route('admin.gold-plans.index')->with('success', 'Gold Plan updated successfully');
    }

    public function destroy($id)
    {
        $goldPlan = GoldPlan::findOrFail($id);
        $goldPlan->delete();
        return redirect()->route('admin.gold-plans.index')->with('success', 'Gold Plan deleted successfully');
    }
}
