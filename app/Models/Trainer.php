<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trainer extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'trainers';
    protected $guarded = ['id'];
    protected $fillable = [
        'company_name',
        'employee_id',
        'type',
        'name_en',
        'name_kh',
        'number_phone',
        'email',
        'remark',
        'status',
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
    public function employee(){
        return $this->belongsTo(User::class,'employee_id')->select(
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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }

    public function getEmployeeInAttribute(){
        return optional($this->employee);
    }

}
