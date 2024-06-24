<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seniority extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    //RelationShip
    public function users()
    {
        return $this->belongsTo(User::class ,'employee_id')->with("gender")->with("branch")->with("department")
        ->select(
            'id',
            'number_employee',
            'last_name_kh',
            'first_name_kh',
            'last_name_en',
            'first_name_en',
            'employee_name_kh',
            'employee_name_en',
            'email',
            'gender',
            'branch_id',
            'department_id',
            'position_id',
            'date_of_commencement',
        );
    }

    public function gross_seniority_1()
    {
        $nextYear =  Carbon::now()->format('Y');
        $currentYear_month1 = Carbon::createFromDate($nextYear.'-01-01')->format('Y-m-d');
        $currentMonth6 = Carbon::createFromDate($nextYear.'-06-30')->format('Y-m-d');

        return $this->hasMany(GrossSalaryPay::class, 'employee_id', 'employee_id')->where("type_udc","UDC")
        ->when($currentYear_month1 ,function ($query, $month1) {
            $query->where('payment_date', '>=',$month1);
        })
        ->when($currentMonth6 ,function ($query, $month6) {
            $query->where('payment_date', '<=',$month6);
        })->orderBy('payment_date', 'asc');
    }
    public function gross_seniority_2()
    {
        $nextYear =  Carbon::now()->format('Y');
        $currentYear_month7 = Carbon::createFromDate($nextYear.'-07-01')->format('Y-m-d');
        $currentMonth12 = Carbon::createFromDate($nextYear.'-12-30')->format('Y-m-d');
        return $this->hasMany(GrossSalaryPay::class, 'employee_id', 'employee_id')->where("type_udc","UDC")
        ->when($currentYear_month7 ,function ($query, $month7) {
            $query->where('payment_date', '>=',$month7);
        })
        ->when($currentMonth12 ,function ($query, $month12) {
            $query->where('payment_date', '<=',$month12);
        })->orderBy('payment_date', 'asc');
    }
}
