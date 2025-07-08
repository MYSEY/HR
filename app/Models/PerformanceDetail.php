<?php

namespace App\Models;

use App\Models\Title;
use App\Models\Purpose;
use App\Models\Performance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerformanceDetail extends Model
{
    use HasFactory;
    protected $table = 'performance_details';
    protected $guarded = ['id'];

    protected $fillable = [
        'performance_id',
        'title_id',
        'purpose_id',
        'key_kpi',
        'action_plan',
        'goal',
        'weight',
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
}
