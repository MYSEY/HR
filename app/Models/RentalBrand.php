<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentalBrand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'rental_brands';
    protected $guarded = ['id'];

    protected $fillable = [
        'brand_name',
        'type',
        'description',
        'created_by',
        'updated_by',
        'deleted_at'
    ];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
}
