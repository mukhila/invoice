<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyGoldRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate_date',
        'rate_per_gram',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }
}
