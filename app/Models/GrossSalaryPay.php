<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrossSalaryPay extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'gross_salary_pays';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'number_employee',
        'basic_salary',
        'total_gross_salary',
        'total_fdc1',
        'type_fdc1',
        'total_fdc2',
        'type_fdc2',
        'type_udc',
        'total_seniority',
        'payment_date',
        'created_by',
        'updated_by',
    ];
    public function users()
    {
        return $this->belongsTo(User::class ,'employee_id')->with("gender")->with('department')->with('position')->with("positiontype")->with('branch')->with("totalChild")->with('bank');
    }
    public function getPayrollPaymentDateAttribute(){
        if ($this->payment_date) {
            return Carbon::parse($this->payment_date)->format('d-M-Y');
        }
    }
}
