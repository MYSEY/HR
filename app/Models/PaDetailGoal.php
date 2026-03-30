<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaDetailGoal extends Model
{
    use HasFactory;
    protected $table = 'pa_detail_goals';
    protected $guarded = ['id'];
    protected $fillable = [
       'performance_id',
        'title_id',
        'purpose_id',
        'pa_detail_id',
        'from',
        'to',
        'user_id',
        'created_by',
        'updated_by',
    ];
}
