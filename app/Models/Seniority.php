<?php

namespace App\Models;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seniority extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'seniorities';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'number_employee',
        'total_average_salary',
        'total_salary_receive',
        'tax_exemption_salary',
        'taxable_salary',
        'payment_of_month',
        'payment_date',
        'created_by',
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
}
