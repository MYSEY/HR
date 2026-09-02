<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaReference extends Model
{
    use HasFactory;
    protected $table = 'pa_references';
    protected $guarded = ['id'];

    protected $fillable = [
        'performance_id',
        'title_id',
        'purpose_id',
        'detail_id',
        'reference',
        'created_by',
        'updated_by',
    ];
}