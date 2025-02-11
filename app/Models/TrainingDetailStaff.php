<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class TrainingDetailStaff extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'training_detail_staff';
    protected $guarded = ['id'];

    protected $fillable = [
       'training_id',
       'employee_id',
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
        return $this->belongsTo(User::class, 'employee_id','id')->with(['position', 'department', 'gender','branch'])->select(
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
        );
    }
    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id')->withCount("trainingDetailStaffs")->with("trainingDetailTrainer");
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
