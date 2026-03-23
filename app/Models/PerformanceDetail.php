<?php

namespace App\Models;

use App\Models\PerformanceGoal;
use App\Models\Purpose;
use App\Models\Title;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceDetail extends Model
{
    use HasFactory;
    protected $table = 'performance_details';
    protected $guarded = ['id'];
    protected $casts = [
        'goal' => 'array',
    ];
    protected $fillable = [
        'performance_id',
        'title_id',
        'purpose_id',
        'key_kpi',
        'action_plan',
        'goal',
        'weight',
        'progress',
        'score_achieved',
        'score',
        'score_live_staff',
        'score_direct_chairman',
        'easy_difficult_factors',
        'comment',
        'goal_type',
        'is_lock',
        'created_by',
        'updated_by',
    ];

    public function title() {
        return $this->belongsTo(Title::class, 'title_id');
    }
    
    public function purpose() {
        return $this->belongsTo(Purpose::class, 'purpose_id');
    }
    public function performanceGoals()
    {
        return $this->hasMany(PerformanceGoal::class, 'performance_detail_id');
    }
}
