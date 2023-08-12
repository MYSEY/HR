<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrossSalaryPay extends Model
{
    use HasFactory;
    protected $table = 'gross_salary_pays';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'basic_salary',
        'total_gross_salary',
        'total_salary_severance',
        'payment_date',
        'created_by',
        'updated_by',
    ];
}
