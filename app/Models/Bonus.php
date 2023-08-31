<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bonus extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    //RelationShip
    public function users()
    {
        return $this->belongsTo(User::class ,'employee_id');
    }
}
