<?php

namespace App\Models;

use App\Models\User;
use App\Models\Bonus;
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
        'role_id',
        'basic_salary',
        'payment_amount',
        'total_gross_salary',
        'payment_date',
        'children',
        'spouse',
        'total_child_allowance',
        'phone_allowance',
        'monthly_quarterly_bonuses',
        'annual_incentive_bonus',
        'base_salary_received_usd',
        'base_salary_received_riel',
        'total_amount_reduced',
        'total_rate',
        'seniority_allowance_tax',
        'pension_contribution',
        'total_charges_reduced',
        'total_tax_base_riel',
        'total_salary_tax_usd',
        'total_salary_tax_riel',
        'total_tax_seniority',
        'total_salary',
        'created_by',
        'updated_by',
    ];

    //RelationShip
    public function users()
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
            'date_of_commencement'])
        ->with('department')->with('position')->with('branch');
    }

    public function bunus(){
        return $this->belongsTo(Bonus::class ,'employee_id');
    }
    public function NSSF(){
        return $this->belongsTo(NationalSocialSecurityFund::class ,'employee_id');
    }

    public function getCreatedAttribute(){
        if ($this->created_at) {
            return Carbon::parse($this->created_at)->format('d-M-Y');
        }
    }
    public function getPayrollDateAttribute(){
        if ($this->payment_date) {
            return Carbon::parse($this->payment_date)->format('d-M-Y');
        }
    }
}
