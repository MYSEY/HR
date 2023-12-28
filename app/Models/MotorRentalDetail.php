<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MotorRentalDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'motor_rental_details';
    protected $guarded = ['id'];


    protected $fillable = [
        'employee_id',
        'motor_rental_id',
        'start_date',
        'end_date',
        'product_year',
        'expired_year',
        'shelt_life',
        'number_plate',
        'motorcycle_brand',
        'category',
        'body_number',
        'engine_number',
        'total_gasoline',
        'total_work_day',
        'price_engine_oil',
        'price_motor_rentel',
        'taplab_rentel',
        'price_taplab_rentel',
        'resigned_date',
        'gasoline_price_per_liter',
        'amount_price_motor_rentel',
        'amount_price_engine_oil',
        'amount_price_taplab_rentel',
        'tax_rate',
        'created_by',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
    public function motorrental(){
        return $this->belongsTo(MotorRentel::class,'motor_rental_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class ,'employee_id')
        ->select([
            'id', 
            'employee_name_en',
            'employee_name_kh',
            'number_employee',
            'department_id',
            'position_id',
            'branch_id',
            'gender'])
        ->with('department')->with('position')->with('gender')->with('branch');
    }

    public function getMotorRentalAttribute(){
        $motor = MotorRentel::where("id", $this->motor_rental_id)->first();
        return $motor;
    }

    public function getMotorEmployeeAttribute(){
        $user = User::where("id", $this->employee_id)->first();
        return $user;
    }
}
