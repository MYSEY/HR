<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialApproveLeaveHistory extends Model
{
    use HasFactory;
     protected $table = 'special_approve_leave_histories';
    protected $guarded = ['id'];

    protected $fillable = [
        'under_approve',
        'employee_id',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
