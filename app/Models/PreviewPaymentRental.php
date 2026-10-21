<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviewPaymentRental extends Model
{
    use HasFactory;
    protected $table = 'preview_payment_rentals';
    protected $guarded = ['id'];
    protected $fillable = [
        "employee_id",
        "location_id",
        "motor_rental_id",
        "total_amount_khr",
        "total_amount_usd",
        "total_leave_amount_khr",
        "total_leave_amount_usd",
        "total_tax_fee_khr",
        "total_tax_fee_usd",
        "total_adjust_amount_excl",
        "total_adjust_amount_incl",
        "total_adjust_tax_fee",
        "total_adjust_amount_khr",
        "total_net_amount_khr",
        "total_net_amount_usd",
        "resigned_date",
        "from_date",
        "to_date",
    ];
    public function user()
    {
        return $this->belongsTo(User::class ,'employee_id')
        ->select([
            'id', 
            'employee_name_en',
            'employee_name_kh',
            'number_employee',
            'date_of_commencement',
            'department_id',
            'position_id',
            'branch_id',
            'gender'])
        ->with('department')->with('position')->with('gender')->with('branch');
    }
    public function details()
    {
        return $this->hasMany(PreviewPaymentRentalDetail::class, 'payment_rental_id', 'id')->with("position");
    }
    public function branch(){
        return $this->belongsTo(Branchs::class ,'location_id');
    }
}
