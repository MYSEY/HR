<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelegateLeave extends Model
{
    use HasFactory;
    
    protected $table = 'delegate_leaves';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'requester_id',
        'delegate_id',
        'number_of_day',
        'start_date',
        'end_date',
    ];

}
