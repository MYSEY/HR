<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seniority extends Model
{
    use HasFactory;
    protected $table = 'seniorities';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'total_average_salary',
        'total_salary_receive',
        'tax_exemption_salary',
        'taxable_salary',
        'payment_of_month',
        'created_by',
    ];
}
