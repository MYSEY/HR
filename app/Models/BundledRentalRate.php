<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BundledRentalRate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bundled_rental_rates';
    protected $guarded = ['id'];

    protected $fillable = [
        'group_id',
        'name',
        'type',
        'position_id',
        'from',
        'to',
        'currency',
        'amount',
        'transfer_day',
        'leave_day',
        'created_by',
        'updated_by',
        'deleted_at'
    ];
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
}
