<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentPlan extends Model
{
    use HasFactory;
    protected $table = 'recruitment_plans';
    protected $guarded = ['id'];
    protected $fillable = [
        'position_id',
        'branch_id',
        'plan_year',
        'total_staff',
        'description',
        'created_by',
        'updated_by'
    ];

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
