<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmiSchedule extends Model
{
    use HasFactory;

    protected $table = 'emi_schedule';
    public $timestamps = false; // As per migration observation

    protected $fillable = [
        'user_plan_id',
        'emi_month',
        'due_date',
        'emi_amount',
        'paid_amount',
        'status',
    ];

    public function userPlan()
    {
        return $this->belongsTo(UserPlan::class);
    }
}
