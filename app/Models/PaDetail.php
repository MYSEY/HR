<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaDetail extends Model
{
    use HasFactory;
    protected $table = 'pa_details';
    protected $guarded = ['id'];

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
}
