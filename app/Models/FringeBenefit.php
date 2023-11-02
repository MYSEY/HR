<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FringeBenefit extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'fringe_benefits';
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'amount_usd',
        'amount_riel',
        'request_date',
        'paid_date',
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
            'gender',
            'date_of_commencement',
        ])->with('employeeGender')->with('position')->with('branch');
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
