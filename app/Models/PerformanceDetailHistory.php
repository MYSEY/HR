<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceDetailHistory extends Model
{
    use HasFactory;
    protected $table = 'performance_detail_histories';
    protected $guarded = ['id'];

    protected $fillable = [
        'performance_histories_id',
        'title_histories_id',
        'purpose_histories_id',
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
        return $this->belongsTo(TitleHistory::class, 'title_histories_id');
    }
    
    public function purpose() {
        return $this->belongsTo(PurposeHistory::class, 'purpose_histories_id');
    }
}
