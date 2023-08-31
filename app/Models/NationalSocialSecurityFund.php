<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NationalSocialSecurityFund extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    //RelationShip
    public function users()
    {
        return $this->belongsTo(User::class ,'employee_id');
    }
}
