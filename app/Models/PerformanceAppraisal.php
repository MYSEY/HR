<?php

namespace App\Models;

use App\Models\PaTitle;
use App\Models\PaDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerformanceAppraisal extends Model
{
    use HasFactory;
    protected $table = 'performance_appraisals';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'from_date',
        'to_date',
        'total_weight',
        'total_score',
        'total_score_live_staff',
        'total_score_direct_chairman',
        'status',
        'type',
        'approved_by',
        'approved_date',
        'remark',
        'review_employee_id',
        'location_review',
        'position_review',
        'review_date',
        'approve_by',
        'approve_date',
        'reject_date',
        'reason',
        'strength',
        'points_change_develop_employee',
        'desires',
        'created_by',
        'updated_by',
    ];
    public function users()
    {
        return $this->belongsTo(User::class ,'employee_id');
    }
    public function titles()
    {
        return $this->hasMany(PaTitle::class, 'performance_id');
    }
    public function purpose()
    {
        return $this->belongsTo(PaPurpose::class, 'purpose_id');
    }
    public function performanceDetail()
    {
        return $this->hasMany(PaDetail::class,'performance_id')->with("reference");
    }
}
