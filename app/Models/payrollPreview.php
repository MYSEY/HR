<?php

namespace App\Models;

use App\Models\Bonus;
use App\Models\Seniority;
use App\Models\SeverancePay;
use App\Models\ChildrenInfor;
use App\Models\GrossSalaryPay;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\NationalSocialSecurityFund;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class payrollPreview extends Model
{
    use HasFactory;

    protected $table = 'payroll_previews';
    protected $guarded = ['id'];


    protected $fillable = [
        'employee_id',
        'number_employee',
        'basic_salary',
        'total_gross_salary',
        'payment_date',
        'children',
        'spouse',
        'total_child_allowance',
        'phone_allowance',
        'monthly_quarterly_bonuses',
        'total_kny_phcumben',
        'annual_incentive_bonus',
        'seniority_pay_included_tax',
        'total_gross',
        'total_pension_fund',
        'base_salary_received_usd',
        'base_salary_received_riel',
        'total_amount_reduced',
        'total_rate',
        'pension_contribution',
        'total_charges_reduced',
        'total_tax_base_riel',
        'total_salary_tax_usd',
        'total_salary_tax_riel',
        'seniority_pay_excluded_tax',
        'seniority_backford',
        'total_severance_pay',
        'loan_amount',
        'total_amount_car',
        'total_salary',
        'exchange_rate',
        'adjustment',
        'leaves',
        'created_by',
        'updated_by',
    ];

    //RelationShip
    public function users()
    {
        return $this->belongsTo(User::class ,'employee_id')->with("gender")->with('department')->with('position')->with("positiontype")->with('branch')->with("totalChild")->with('bank');
    }
    public function NSSF(){
        return $this->belongsTo(NationalSocialSecurityFund::class ,'employee_id','id');
    }
    public function GrossSalaryPay(){
        return $this->belongsTo(GrossSalaryPay::class ,'employee_id','id');
    }
    public function chiledren(){
        return $this->belongsTo(ChildrenInfor::class ,'employee_id','id');
    }
    public function seniority(){
        return $this->belongsTo(Seniority::class ,'employee_id','id');
    }
    public function severancePay(){
        return $this->belongsTo(SeverancePay::class ,'employee_id','id');
    }
    public function Bonus(){
        return $this->belongsTo(Bonus::class ,'employee_id','id');
    }

    public function getCreatedAttribute(){
        if ($this->created_at) {
            return Carbon::parse($this->created_at)->format('d-M-Y');
        }
    }
    public function getPayrollPaymentDateAttribute(){
        if ($this->payment_date) {
            return Carbon::parse($this->payment_date)->format('d-M-Y');
        }
    }
}
