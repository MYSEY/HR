<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveAllocationHistory extends Model
{
    use HasFactory;
    protected $table = 'leave_allocation_histories';
    protected $guarded = ['id'];
}
