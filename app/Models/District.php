<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = 'districts';
    protected $guarded = ['id'];
    protected $fillable = [
        'code',
        'name_km',
        'name_en',
        'name_latin',
        'province_id',
        'srok_name_km',
        'srok_name_latin',
        'srok_name_en',
        'full_name_km',
        'full_name_latin',
        'full_name_en',
        'address_km',
        'address_latin',
        'address_en',
    ];
}
