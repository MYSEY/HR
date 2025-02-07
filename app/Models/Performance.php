<?php

namespace App\Models;

use App\Models\Title;
use App\Models\Purpose;
use App\Models\PerformanceDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Performance extends Model
{
    use HasFactory;
    protected $table = 'performances';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'from_date',
        'to_date',
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
    public function performanceDetail(){
        return $this->hasMany(PerformanceDetail::class,'performance_id','id');
    }
}
