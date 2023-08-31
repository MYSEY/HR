<?php

namespace App\Models;

use App\Models\User;
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
        'total_average_salary',
        'total_salary_receive',
        'tax_exemption_salary',
        'taxable_salary',
        'payment_of_month',
        'created_by',
    ];

    //RelationShip
    public function users()
    {
        return $this->belongsTo(User::class ,'employee_id');
    }
}
