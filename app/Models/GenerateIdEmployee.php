<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerateIdEmployee extends Model
{
    use HasFactory;
    protected $table = 'generate_id_employees';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'number_employee',
        'candidate_resumes_id',
        'created_by',
        'updated_by',
    ];
}
