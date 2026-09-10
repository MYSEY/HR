<?php

namespace App\Models;

use App\Models\Purpose;
use App\Models\PerformanceDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Title extends Model
{
    use HasFactory;
    protected $table = 'titles';
    protected $guarded = ['id'];

    protected $fillable = [
        'performance_id',
        'title',
        'created_by',
        'updated_by',
    ];
    public function purposes()
    {
        return $this->hasMany(Purpose::class, 'title_id');
    }

    public function performanceDetail()
    {
        return $this->hasMany(PerformanceDetail::class, 'title_id');
    }
}
