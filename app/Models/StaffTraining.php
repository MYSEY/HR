<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffTraining extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'staff_trainings';
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'title',
        'start_date',
        'end_date',
        'updated_by'
    ];
}
