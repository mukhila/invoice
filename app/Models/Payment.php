<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_plan_id',
        'employee_id',
        'amount',
        'payment_mode',
        'payment_date',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userPlan()
    {
        return $this->belongsTo(UserPlan::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
