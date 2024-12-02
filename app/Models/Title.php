<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;
    protected $table = 'titles';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'title',
        'created_by',
        'updated_by',
    ];
}
