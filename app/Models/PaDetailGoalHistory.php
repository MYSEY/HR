<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaDetailGoalHistory extends Model
{
    use HasFactory;
    protected $table = 'pa_detail_goal_histories';
    protected $guarded = ['id'];
    protected $fillable = [
        'pa_histories_id',
        'title_histories_id',
        'purpose_histories_id',
        'pa_detail_histories_id',
        'from',
        'to',
        'user_id',
        'created_by',
        'updated_by',
    ];
}
