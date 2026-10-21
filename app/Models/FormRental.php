<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormRental extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'form_rentals';
    protected $guarded = ['id'];

    protected $fillable = [
        'rental_rates_id',
        'type',
        'title',
        'status',
        'created_by',
        'updated_by',
        'deleted_at'
    ];
    public function rentalRates()
    {
        return $this->hasMany(BundledRentalRate::class, 'group_id', 'rental_rates_id');
    }
    public function rentalRate()
    {
        return $this->belongsTo(BundledRentalRate::class, 'rental_rates_id', 'group_id');
    }
    public function fields()
    {
        return $this->hasMany(FormRentalField::class, 'form_rental_id', 'id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->select(
            'id',
            'number_employee',
            'last_name_kh',
            'first_name_kh',
            'last_name_en',
            'first_name_en',
            'employee_name_kh',
            'employee_name_en',
            'email',
            'position_id',
            'branch_id',
            'department_id',
            'gender',
            'date_of_commencement',
            'personal_phone_number',
        );;
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by')->select(
            'id',
            'number_employee',
            'last_name_kh',
            'first_name_kh',
            'last_name_en',
            'first_name_en',
            'employee_name_kh',
            'employee_name_en',
            'email',
            'position_id',
            'branch_id',
            'department_id',
            'gender',
            'date_of_commencement',
            'personal_phone_number',
        );;
    }
}
