<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FnApproval extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    protected $table = 'fn_approvals';
    protected $guarded = ['id'];

    protected $fillable = [
        'title',
        'employee_id',
        'print_document_id',
        'location_id',
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
    protected function employeeId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
    public function getEmployeeAttribute()
    {
        $employeeIds = is_array($this->employee_id) ? $this->employee_id : json_decode($this->employee_id, true);

        return !empty($employeeIds) ? User::whereIn('id', $employeeIds)->select(
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
        )->get() : collect();
    }
    public function printDocument()
    {
        return $this->belongsTo(User::class, 'print_document_id')->select(
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
        )->with(["department","branch"]);
    }
    public function location()
    {
        return $this->belongsTo(Branchs::class, 'location_id');
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
