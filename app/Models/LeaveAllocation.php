<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveAllocation extends Model
{
    use HasFactory;

    protected $table = 'leave_allocations';
    protected $guarded = ['id'];

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
            'gender',
            'date_of_birth',
            'date_of_commencement',
            'id_card_number',
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
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }



    public function getEmployeeNameAttribute(){
        return Helper::getLang() == 'en' ? optional($this->employee)->employee_name_en : optional($this->employee)->employee_name_kh;
    }
}