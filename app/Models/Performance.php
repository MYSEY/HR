<?php

namespace App\Models;

use App\Models\Title;
use App\Models\Purpose;
use App\Models\PerformanceDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Performance extends Model
{
    use HasFactory;
    protected $table = 'performances';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'from_date',
        'to_date',
        'total_weight',
        'total_score_achieved',
        'total_score',
        'total_score_live_staff',
        'total_score_direct_chairman',
        'overall_results',
        'score_level',
        'status',
        'type',
        'created_by',
        'updated_by',
    ];

    public function titles()
    {
        return $this->hasMany(Title::class, 'performance_id');
    }
}
