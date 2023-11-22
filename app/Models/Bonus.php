<?php

namespace App\Models;

use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bonus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bonuses';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'number_employee',
        'number_of_working_days',
        'base_salary',
        'base_salary_received',
        'total_allowance',
        'payment_date',
        'created_by',
        'updated_by',
    ];

    //RelationShip
    public function users()
    {
        return $this->belongsTo(User::class ,'employee_id');
    }
    public function getLastNameAttribute(){
        return (Helper::getLang() == 'en') ? optional($this->users)->last_name_en : optional($this->users)->last_name_kh;
    }
    public function getFirstNameAttribute(){
        return (Helper::getLang() == 'en') ? optional($this->users)->first_name_en : optional($this->users)->first_name_kh;
    }
}
