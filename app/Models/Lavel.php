<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lavel extends Model
{
    use HasFactory;
    protected $table = 'lavels';
    protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'name',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
