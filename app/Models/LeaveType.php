<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;
    protected $table = 'leave_types';
    protected $guarded = ['id'];

    protected $fillable = [
        'id',
        'name',
        'default_day',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
