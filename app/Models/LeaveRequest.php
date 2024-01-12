<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'leave_requests';
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'start_date',
        'start_half_day',
        'end_date',
        'end_half_day',
        'approved_date',
        'approved_by',
        'status',
        'number_of_day',
        'total_annual_leave',
        'total_sick_leave',
        'total_special_leave',
        'total_unpaid_leave',
        'remark',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
    public function employee(){
        return $this->belongsTo(User::class,'employee_id');
    }
    public function leaveType(){
        return $this->belongsTo(LeaveType::class,'leave_type_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
}
