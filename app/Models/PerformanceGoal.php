<?php

namespace App\Models;

use App\Models\PerformanceDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceGoal extends Model
{
    use HasFactory;
     protected $table = 'performance_goals';
    protected $guarded = ['id'];
    protected $fillable = [
        'performance_id',
        'title_id',
        'purpose_id',
        'key_kpi',
        'performance_detail_id',
        'from',
        'to',
        'user_id',
        'created_by',
        'updated_by',
    ];

    public function performanceDetail()
    {
        return $this->belongsTo(PerformanceDetail::class, 'performance_detail_id');
    }
}