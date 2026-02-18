<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_name',
        'duration_months',
        'monthly_emi',
        'total_amount',
        'bonus_amount',
        'status',
    ];
}
