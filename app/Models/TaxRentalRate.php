<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRentalRate extends Model
{
    use HasFactory;
    protected $table = 'tax_rental_rates';
    protected $guarded = ['id'];

    protected $fillable = [
        'tax_rate',
        'tax_type',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
