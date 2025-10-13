<?php

namespace App\Models;

use App\Models\PaPurpose;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaTitle extends Model
{
    use HasFactory;
    protected $table = 'pa_titles';
    protected $guarded = ['id'];

    protected $fillable = [
        'performance_id',
        'title',
        'created_by',
        'updated_by',
    ];

    public function purposes()
    {
        return $this->hasMany(PaPurpose::class, 'title_id');
    }
}
