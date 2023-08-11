<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorRentalDetail extends Model
{
    use HasFactory;

    protected $table = 'motor_rental_details';
    protected $guarded = ['id'];


    protected $fillable = [
        'employee_id',
        'gasoline_price_per_liter',
        'start_date',
        'end_date',
        'product_year',
        'expired_year',
        'shelt_life',
        'number_plate',
        'total_gasoline',
        'total_work_day',
        'price_engine_oil',
        'price_motor_rentel',
        'taplab_rentel',
        'price_taplab_rentel',
        'tax_rate',
        'created_by',
        'updated_by',
    ];


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
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

    public function getMotorEmployeeAttribute(){
        $user = User::where("id", $this->employee_id)->first();
        return $user;
    }
}
