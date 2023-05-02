<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorRentel extends Model
{
    use HasFactory;

    protected $table = 'motor_rentels';
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

    public function getMotorEmployeeAttribute(){
        $user = User::where("number_employee", $this->employee_id)->first();
        return $user;
    }

}
