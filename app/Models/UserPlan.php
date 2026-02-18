<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'employee_id',
        'start_date',
        'maturity_date',
        'total_paid',
        'total_pending',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(GoldPlan::class, 'plan_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function emiSchedules()
    {
        return $this->hasMany(EmiSchedule::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
