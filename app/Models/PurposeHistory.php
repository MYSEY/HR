<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurposeHistory extends Model
{
    use HasFactory;
    protected $table = 'purpose_histories';
    protected $guarded = ['id'];

    protected $fillable = [
        'performance_histories_id',
        'title_histories_id',
        'name',
        'created_by',
        'updated_by',
    ];
    public function title()
    {
        return $this->belongsTo(TitleHistory::class, 'title_histories_id');
    }

    public function performanceDetail()
    {
        return $this->hasMany(PerformanceDetailHistory::class, 'purpose_histories_id');
    }
}
