<?php

namespace App\Models;

use App\Models\User;
use App\Helpers\Helper;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeverancePay extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'severance_pays';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'number_employee',
        'total_severanec_pay',
        'total_contract_severance_pay',
        'status',
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
