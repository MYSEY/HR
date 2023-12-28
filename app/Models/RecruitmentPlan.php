<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecruitmentPlan extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'recruitment_plans';
    protected $guarded = ['id'];
    protected $fillable = [
        'position_id',
        'branch_id',
        'plan_date',
        'total_staff',
        'remark',
        'created_by',
        'updated_by'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
    public function position(){
        return $this->belongsTo(Position::class,'position_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branchs::class ,'branch_id');
    }

    // public function getBranchByPlanAttribute(){
    //     return optional($this->branch)->abbreviations;
    // }

}
