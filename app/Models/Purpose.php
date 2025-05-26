<?php

namespace App\Models;

use App\Models\Title;
use App\Models\PerformanceDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purpose extends Model
{
    use HasFactory;
    protected $table = 'purposes';
    protected $guarded = ['id'];

    protected $fillable = [
        'performance_id',
        'title_id',
        'name',
        'created_by',
        'updated_by',
    ];
    public function title()
    {
        return $this->belongsTo(Title::class, 'title_id');
    }

    public function performanceDetail()
    {
        return $this->hasMany(PerformanceDetail::class, 'purpose_id');
    }
}
