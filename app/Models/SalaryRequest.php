<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SalaryRequest extends Model
{
    use HasFactory;
    protected $table = 'salary_requests';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'request_date',
        'new_basic_salary',
        'status',
        'type',
        'description',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id')->select([
            'id', 
            'employee_name_en',
            'employee_name_kh',
            'number_employee',
            'department_id',
            'position_id',
            'branch_id',
            'gender',
            'date_of_birth',
            'pre_salary',
            'basic_salary',
            'salary_increas',
        ])->with(["department","position","branch"]);
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
