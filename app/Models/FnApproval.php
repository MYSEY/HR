<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;

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
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id')->select(
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
