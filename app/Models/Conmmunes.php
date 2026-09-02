<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conmmunes extends Model
{
    use HasFactory;
    protected $table = 'conmmunes';
    protected $guarded = ['id'];
    protected $fillable = [
        'code',
        'khum_name_km',
        'khum_name_latin',
        'khum_name_en',
        'name_km',
        'name_latin',
        'name_en',
        'full_name_km',
        'full_name_latin',
        'full_name_en',
        'district_id',
        'province_id',
        'address_km',
        'address_latin',
        'address_en',
    ];
}
