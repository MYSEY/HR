<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelegateLeave extends Model
{
    use HasFactory;
    
    protected $table = 'delegate_leaves';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'requester_id',
        'delegate_id',
        'number_of_day',
        'start_date',
        'end_date',
    ];
    public function userRequest()
    { 
        return $this->belongsTo(User::class,'requester_id')
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
        ->with(['department','position','gender','branch','role']);
    }
    public function userDelegeted()
    { 
        return $this->belongsTo(User::class,'delegate_id')
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

}
