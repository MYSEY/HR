<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRentalDetail extends Model
{
    use HasFactory;
    protected $table = 'payment_rental_details';
    protected $guarded = ['id'];
    protected $fillable = [
        "payment_rental_id",
        "position_id",
        "fields",
        "type",
        "currency",
        "price",
        "terminate_date",
        "status",
        "total_leave_days'",
        "total_work_day",
        "tax_rate",
        "amount",
        "amount_excl_tax",
        'leave_amount',
        "tax_fee",
        "adjust_amount_excl",
        "adjust_amount_incl",
        "adjust_tax_fee",
        "adjust_amount_khr",
        "net_amount",
    ];
    public function position(){
        return $this->belongsTo(Position::class,'position_id');
    }
}
