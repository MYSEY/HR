<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeverancePay extends Model
{
    use HasFactory;

    protected $table = 'severance_pays';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'total_severanec_pay',
        'total_contract_severance_pay',
        'status',
        'created_by',
        'updated_by',
    ];

}
