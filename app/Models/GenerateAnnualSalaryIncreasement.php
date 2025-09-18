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
    protected $appends = ['total_salary_request'];

    protected $fillable = [
        'employee_id',
        'performance_id',
        'status',
        'basic_salary',
        'salary_increasement',
        'salary_request_ids',
        'salary_request',
        'increasement_of_year',
        'percentage',
        'approved_by',
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
    public function getTotalSalaryRequestAttribute(){
        $data = SalaryRequest::where('employee_id',$this->employee_id)->where("type", 0)->where("status", 1)->get();
        $totalSalary = 0;
        foreach($data as $item){
            $totalSalary += $item->new_basic_salary;
        }
        return $totalSalary;
    }
}
