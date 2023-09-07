<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MotorRentel extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        'tax_rate',
        'status',
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
            'gender',
            'date_of_birth',
            'id_card_number',
            'current_province',
            'current_district',
            'current_commune',
            'current_village',
            'current_house_no',
            'current_street_no',
        ])
        ->with('department')
        ->with('position')
        ->with('gender')
        ->with('branch')
        ->with('currentprovince')
        ->with('currentdistrict')
        ->with('currentcommune')
        ->with('currentvillage');
    }

    public function getMotorEmployeeAttribute(){
        $user = User::where("id", $this->employee_id)->first();
        return $user;
    }

}
