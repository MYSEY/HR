<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $table = 'payrolls';
    protected $guarded = ['id'];


    protected $fillable = [
        'employee_id',
        'net_salary',
        'spouse',
        'payment_amount',
        'child_allowance',
        'phone_allowance',
        'monthly_quarterly_bonuses',
        'khmer_new_year_pchum_ben_allowance',
        'annual_incentive_bonus',
        'total_gross_salary',
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
}
