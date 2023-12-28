<?php

namespace App\Models;

use App\Models\User;
use App\Helpers\Helper;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NationalSocialSecurityFund extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'national_social_security_funds';
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
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
