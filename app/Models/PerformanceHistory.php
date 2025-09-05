<?php

namespace App\Models;
use App\Models\TitleHistory;
use App\Models\PerformanceDetailHistory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceHistory extends Model
{
    use HasFactory;
    protected $table = 'performance_histories';
    protected $guarded = ['id'];

    protected $fillable = [
        'performance_id',
        'employee_id',
        'from_date',
        'to_date',
        'total_weight',
        'total_score',
        'total_score_live_staff',
        'total_score_direct_chairman',
        'score_level',
        'status',
        'type',
        'approved_by',
        'approved_date',
        'remark',
        'noted',
        'review_employee_id',
        'location_review',
        'position_review',
        'review_date',
        'approve_by',
        'approve_date',
        'reject_date',
        'reason',
        'created_by',
        'updated_by',
    ];

    public function titles()
    {
        return $this->hasMany(TitleHistory::class, 'performance_histories_id');
    }

    public function PerformanceDetails()
    {
        return $this->hasMany(PerformanceDetailHistory::class,'performance_histories_id');
    }
    public function RevieweEmployee()
    {
        return $this->hasMany(User::class,'review_employee_id')->select(
            'id',
            'number_employee',
            'last_name_kh',
            'first_name_kh',
            'last_name_en',
            'first_name_en',
            'employee_name_kh',
            'employee_name_en',
            'email',
            'position_id',
            'branch_id',
            'department_id',
            'gender',
            'date_of_commencement',
            'personal_phone_number',
        );
    }
}
