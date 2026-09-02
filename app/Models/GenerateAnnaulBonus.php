<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerateAnnaulBonus extends Model
{
    use HasFactory;
    protected $table = 'generate_annaul_bonuses';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'performance_id',
        'basice_salary',
        'working_days_per_year',
        'incentive',
        'pa_score',
        'of_incentive_by_pa',
        'achieved_vs_pa',
        'number_months_received',
        'total_annaul_bounus',
        'status',
        'increasement_of_year',
        'approved_by',
        'approved_at',
        'created_by',
        'updated_by',
    ];
}