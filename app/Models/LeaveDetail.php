<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveDetail extends Model
{
    use HasFactory;
    protected $table = 'leave_details';
    protected $guarded = ['id'];

    protected $fillable = [
        'leave_request_id',
        'employee_id',
        'status',
        'date',
        'number_of_day'
    ];
}
