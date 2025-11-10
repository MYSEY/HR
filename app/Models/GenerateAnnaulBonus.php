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
        'status',
        'annaul_bonus',
        'increasement_of_year',
        'percentage',
        'approved_by',
        'created_by',
        'updated_by',
    ];
}
