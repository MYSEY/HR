<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;
    protected $table = 'bonuses';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'number_of_working_days',
        'base_salary',
        'base_salary_received',
        'total_allowance',
        'created_by',
        'updated_by',
    ];
}
