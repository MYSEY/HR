<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorAdjustment extends Model
{
    use HasFactory;
    protected $table = 'motor_adjustments';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'amount_usd',
        'amount_kh',
        'amount_engine_oil',
        'adjustment_date',
        'adjustment_type',
        'tax_rate',
        'description',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function users()
    {
        return $this->belongsTo(User::class ,'employee_id');
    }

    public function getEmployeeNameAttribute(){
        return (Helper::getLang() == 'en') ? optional($this->users)->employee_name_en : optional($this->users)->employee_name_kh;
    }
}
