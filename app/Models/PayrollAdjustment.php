<?php

namespace App\Models;

use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PayrollAdjustment extends Model
{
    use HasFactory;
    protected $table = 'payroll_adjustments';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'amount',
        'adjustment_date',
        'description',
        'created_by',
    ];

    public function users()
    {
        return $this->belongsTo(User::class ,'employee_id');
    }



    public function getEmployeeNameAttribute(){
        return (Helper::getLang() == 'en') ? optional($this->users)->employee_name_en : optional($this->users)->employee_name_kh;
    }
}
