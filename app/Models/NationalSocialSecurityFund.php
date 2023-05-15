<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NationalSocialSecurityFund extends Model
{
    use HasFactory;

    protected $table = 'national_social_security_funds';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'total_pre_tax_salary_usd',
        'total_pre_tax_salary_riel',
        'total_average_wage',
        'total_occupational_risk',
        'total_health_care',
        'pension_contribution_usd',
        'pension_contribution_riel',
        'corporate_contribution',
        'created_by',
        'updated_by',
    ];
}
