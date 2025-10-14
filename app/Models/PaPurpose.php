<?php

namespace App\Models;

use App\Models\PaDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaPurpose extends Model
{
    use HasFactory;
    protected $table = 'pa_purposes';
    protected $guarded = ['id'];

    protected $fillable = [
        'performance_id',
        'title_id',
        'name',
        'created_by',
        'updated_by',
    ];

    public function performanceDetail()
    {
        return $this->hasMany(PaDetail::class, 'purpose_id');
    }
}