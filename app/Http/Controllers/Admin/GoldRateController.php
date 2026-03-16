<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyGoldRate;
use Illuminate\Http\Request;

class GoldRateController extends Controller
{
    public function index()
    {
        $goldRates = DailyGoldRate::with('creator')->orderBy('rate_date', 'desc')->paginate(20);
        return view('Admin.gold_rates.index', compact('goldRates'));
    }

    public function create()
    {
        return view('Admin.gold_rates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rate_date' => 'required|date|unique:daily_gold_rates,rate_date',
            'rate_per_gram' => 'required|numeric|min:0',
        ]);

        DailyGoldRate::create([
            'rate_date' => $request->rate_date,
            'rate_per_gram' => $request->rate_per_gram,
            'created_by' => session('admin_id'),
        ]);

        return redirect()->route('admin.gold-rates.index')->with('success', 'Gold Rate added successfully');
    }

    public function edit($id)
    {
        $goldRate = DailyGoldRate::findOrFail($id);
        return view('Admin.gold_rates.edit', compact('goldRate'));
    }

    public function update(Request $request, $id)
    {
        $goldRate = DailyGoldRate::findOrFail($id);

        $request->validate([
            'rate_date' => 'required|date|unique:daily_gold_rates,rate_date,' . $id,
            'rate_per_gram' => 'required|numeric|min:0',
        ]);

        $goldRate->update([
            'rate_date' => $request->rate_date,
            'rate_per_gram' => $request->rate_per_gram,
            // 'created_by' => session('admin_id'), // Optional: Update if we want to track who updated it. Usually creation is tracked.
        ]);

        return redirect()->route('admin.gold-rates.index')->with('success', 'Gold Rate updated successfully');
    }

    public function destroy($id)
    {
        $goldRate = DailyGoldRate::findOrFail($id);
        $goldRate->delete();
        return redirect()->route('admin.gold-rates.index')->with('success', 'Gold Rate deleted successfully');
    }
}
