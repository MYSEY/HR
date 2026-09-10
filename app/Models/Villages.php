<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Villages extends Model
{
    use HasFactory;
    protected $table = 'villages';
    protected $guarded = ['id'];
    protected $fillable = [
        'code',
        'phum_name_km',
        'phum_name_latin',
        'phum_name_en',
        'name_km',
        'name_latin',
        'name_en',
        'full_name_km',
        'full_name_latin',
        'full_name_en',
        'commune_id',
        'district_id',
        'province_id',
        'address_km',
        'address_latin',
        'address_en',
    ];
}
