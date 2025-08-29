<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GenerateAnnualSalaryIncreasement extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'generate_annual_salary_increasements';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'performance_id',
        'basic_salary',
        'salary_increasement',
        'increasement_of_year',
        'percentage',
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
}
