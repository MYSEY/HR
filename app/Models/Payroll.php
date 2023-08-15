<?php

namespace App\Models;

use App\Models\User;
use App\Models\Bonus;
use App\Models\Seniority;
use App\Models\SeverancePay;
use App\Models\ChildrenInfor;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\NationalSocialSecurityFund;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory;
    protected $table = 'payrolls';
    protected $guarded = ['id'];


    protected $fillable = [
        'employee_id',
        'basic_salary',
        'total_gross_salary',
        'payment_date',
        'children',
        'spouse',
        'total_child_allowance',
        'phone_allowance',
        'total_kny_phcumben',
        'total_pension_fund',
        'total_severance_pay',
        'seniority_payable_tax',
        'base_salary_received_usd',
        'base_salary_received_riel',
        'total_amount_reduced',
        'total_rate',
        'pension_contribution',
        'total_charges_reduced',
        'total_tax_base_riel',
        'total_salary_tax_usd',
        'total_salary_tax_riel',
        'tax_free_seniority_allowance',
        'total_salary',
        'exchange_rate',
        'amount_loan',
        'incentive',
        'adjustment',
        'leaves',
        'created_by',
        'updated_by',
    ];

    //RelationShip
    public function users()
    {
        return $this->belongsTo(User::class ,'employee_id')
        ->select([
            'id', 
            'profile',
            'employee_name_en',
            'employee_name_kh',
            'number_employee',
            'department_id',
            'position_id',
            'branch_id',
            'date_of_commencement'])
        ->with('department')->with('position')->with('branch');
    }
    public function NSSF(){
        return $this->belongsTo(NationalSocialSecurityFund::class ,'employee_id');
    }
    public function chiledren(){
        return $this->belongsTo(ChildrenInfor::class ,'employee_id');
    }
    public function seniority(){
        return $this->belongsTo(Seniority::class ,'employee_id');
    }
    public function severancePay(){
        return $this->belongsTo(SeverancePay::class ,'employee_id');
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
