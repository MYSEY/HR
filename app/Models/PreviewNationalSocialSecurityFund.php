<?php

namespace App\Models;

use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreviewNationalSocialSecurityFund extends Model
{
    use HasFactory;

    protected $table = 'preview_national_social_security_funds';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'number_employee',
        'total_pre_tax_salary_usd',
        'total_pre_tax_salary_riel',
        'total_average_wage',
        'total_occupational_risk',
        'total_health_care',
        'pension_contribution_usd',
        'pension_contribution_riel',
        'corporate_contribution',
        'exchange_rate',
        'payment_date',
        'created_by',
        'updated_by',
    ];
    //RelationShip
    public function users()
    {
        return $this->belongsTo(User::class ,'employee_id');
    }
    public function getLastNameAttribute(){
        return (Helper::getLang() == 'en') ? optional($this->users)->last_name_en : optional($this->users)->last_name_kh;
    }
    public function getFirstNameAttribute(){
        return (Helper::getLang() == 'en') ? optional($this->users)->first_name_en : optional($this->users)->first_name_kh;
    }
}
