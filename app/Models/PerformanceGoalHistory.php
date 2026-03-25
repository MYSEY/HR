<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceGoalHistory extends Model
{
    use HasFactory;
    protected $table = 'performance_goal_histories';
    protected $guarded = ['id'];
    protected $fillable = [
        'performance_histories_id',
        'title_histories_id',
        'purpose_histories_id',
        'key_kpi',
        'performance_detail_histories_id',
        'from',
        'to',
        'user_id',
        'created_by',
        'updated_by',
    ];

    public function performanceDetail()
    {
        return $this->belongsTo(PerformanceDetailHistory::class, 'performance_detail_histories_id');
    }
}
