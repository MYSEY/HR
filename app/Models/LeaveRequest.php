<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
        'request_to',
        'line_manager_id',
        'handover_staff_id',
        'next_approver',
        'approved_by',
        'status',
        'number_of_day',
        'total_annual_leave',
        'total_sick_leave',
        'total_special_leave',
        'total_unpaid_leave',
        'total_long_sick_leave',
        'reason',
        'remark',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
    
    public function employee(){
        return $this->belongsTo(User::class,'employee_id')
        ->select([
            'id', 
            'employee_name_en',
            'employee_name_kh',
            'number_employee',
            'department_id',
            'position_id',
            'branch_id',
            'line_manager',
            'gender',
            'date_of_birth',
            'current_province',
            'current_district',
            'current_commune',
            'current_village',
            'current_house_no',
            'current_street_no',
        ])
        ->with('department')
        ->with('position')
        ->with('gender')
        ->with('branch');
    }
    public function handover(){
        return $this->belongsTo(User::class,'handover_staff_id')
        ->select([
            'id', 
            'employee_name_en',
            'employee_name_kh',
            'number_employee',
            'department_id',
            'position_id',
            'branch_id',
            'gender',
            'date_of_birth',
        ])
        ->with('department')
        ->with('position')
        ->with('gender')
        ->with('branch');
    }
    public function getDelegatedAttribute(){
        $data = DelegateLeave::where("requester_id", $this->employee_id)->where("start_date",$this->start_date)->where("end_date",$this->end_date)->with("userDelegeted")->first();
        $delegated = "";
        if ($data) {
            $delegated =  Helper::getLang() == 'en' ? $data->userDelegeted->employee_name_en : $data->userDelegeted->employee_name_kh;
        }
        return $delegated;
    }
    public function leaveType(){
        return $this->belongsTo(LeaveType::class,'leave_type_id');
    }
    
    public function getStatusApprveAttribute(){
        $status = explode(',',$this->status);
        $datas = [];
        foreach($status as $key=>$item){
            $datas[$item] = $item;
        }
        return $datas;
    }
    public function approve(){
        return $this->belongsTo(User::class,'next_approver')
        ->select([
            'id', 
            'employee_name_en',
            'employee_name_kh',
            'number_employee',
        ]);
    }
    public function getApproveAttribute(){
        $approved_by = explode(',',$this->next_approver);
        $approve_name = '';
        $emolyees = User::whereIn("id", $approved_by)
        ->select([
            'id', 
            'employee_name_en',
            'employee_name_kh',
            'number_employee',
        ])->get();
        if ($emolyees) {
            foreach($emolyees as $key=>$item){
                $approve_name .= Helper::getLang() == 'en' ? nl2br("".$item->employee_name_en): nl2br("".$item->employee_name_kh);
            }
        }
        
        return $approve_name;
    }
    public function LeaveAllocation()
    { 
        return $this->belongsTo(LeaveAllocation::class, 'employee_id', 'employee_id');
    }
    public function createdBy()
    { 
        return $this->belongsTo(User::class, 'created_by')->select(
            'id',
            'number_employee',
            'last_name_kh',
            'first_name_kh',
            'last_name_en',
            'first_name_en',
            'employee_name_kh',
            'employee_name_en',
            'email',
            'created_by'
        );
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
}
