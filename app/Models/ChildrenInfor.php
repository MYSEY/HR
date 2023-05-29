<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChildrenInfor extends Model
{
    use HasFactory;

    protected $table = 'children_infors';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'name',
        'sex',
        'date_of_birth',
        'created_by',
    ];

    public function getDateofBirthChildrenAttribute(){
        if ($this->date_of_birth) {
            return Carbon::parse($this->date_of_birth)->format('d-M-Y');
        }
    }

    public function getYearsOfChildrenAttribute(){
        $years = Carbon::now()->diffInYears($this->date_of_birth);
        $month = Carbon::now()->diffInMonths($this->date_of_birth);
        if ($this->date_of_birth) {
            return $years.' '.'Year';
        }
    }
}
