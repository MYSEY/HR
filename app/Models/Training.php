<?php

namespace App\Models;

use App\Models\TrainingType;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Training extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'trainings';
    protected $guarded = ['id'];

    protected $fillable = [
       'training_type',
       'course_name',
       'trainer_id',
       'employee_id',
       'cost_price',
       'discount',
       'start_date',
       'end_date',
       'duration_month',
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
    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function trainerId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    } 
    protected function employeeId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    } 
    public function trainingDetailStaffs()
    {
        return $this->hasMany(TrainingDetailStaff::class, 'training_id', 'id');
    }
    public function trainingDetailTrainer()
    {
        return $this->hasMany(TrainingDetailTrainer::class, 'training_id', 'id')->with("trainer");
    }

    public function isStaff()
    {
        $data = TrainingDetailStaff::where('training_id', $this->id) // Use $this->id instead of 'id'
            ->leftJoin('users', 'training_detail_staff.employee_id', '=', 'users.id')
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if (in_array($RolePermission, ['HOD', 'BM'])) {
                    $query->where("users.department_id", Auth::user()->department_id)
                        ->where("users.branch_id", Auth::user()->branch_id);
                } elseif (in_array($RolePermission, ['DHOD', 'DBM'])) {
                    $query->where("training_detail_staff.employee_id", Auth::user()->id);
                    $query->orWhere("users.line_manager", Auth::user()->id);
                } elseif ($RolePermission == "Employee") {
                    $query->where("users.id", Auth::user()->id);
                } elseif ($RolePermission == 'HR' && permissionAccess("m6-s2","is_access")->value != 1) {
                    $query->where("training_detail_staff.employee_id", Auth::user()->id);
                    $query->orWhere("users.line_manager", Auth::user()->id);
                }
            })->exists();

        return $data;
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
