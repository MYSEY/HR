<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class PaymentRental extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'payment_rentals';
    protected $guarded = ['id'];


    protected $fillable = [
        "employee_id",
        "location_id",
        "motor_rental_id",
        "total_amount_khr",
        "total_amount_usd",
        "total_leave_amount_khr",
        "total_leave_amount_usd",
        "total_tax_fee_khr",
        "total_tax_fee_usd",
        "total_adjust_amount_excl",
        "total_adjust_amount_incl",
        "total_adjust_tax_fee",
        "total_adjust_amount_khr",
        "total_net_amount_khr",
        "total_net_amount_usd",
        "resigned_date",
        "from_date",
        "to_date",
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
            'date_of_commencement',
            'department_id',
            'position_id',
            'branch_id',
            'gender'])
        ->with('department')->with('position')->with('gender')->with('branch');
    }
    public function details()
    {
        return $this->hasMany(PaymentRentalDetail::class, 'payment_rental_id', 'id')->with("position");
    }
    public function branch(){
        return $this->belongsTo(Branchs::class ,'location_id');
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
