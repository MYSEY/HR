<?php

namespace App\Models;

use App\Models\Title;
use App\Models\Purpose;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Performance extends Model
{
    use HasFactory;
    protected $table = 'performances';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'number_employee',
        'title_id',
        'purpose_id',
        'key_kpi',
        'action_plan',
        'goal',
        'weight',
        'score_achieved',
        'score',
        'from_date',
        'to_date',
        'score_live_staff',
        'score_direct_chairman',
        'easy_difficult_factors',
        'comment',
        'total_weight',
        'total_score_achieved',
        'total_score',
        'total_score_live_staff',
        'total_score_direct_chairman',
        'overall_results',
        'score_level',
        'created_by',
        'updated_by',
    ];

    public function title(){
        return $this->belongsTo(Title::class,'title_id');
    }
    public function purpose(){
        return $this->belongsTo(Purpose::class,'purpose_id');
    }
}
