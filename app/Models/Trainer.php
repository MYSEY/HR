<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $table = 'trainers';
    protected $guarded = ['id'];
    protected $fillable = [
        'company_name',
        'employee_id',
        'type',
        'name_en',
        'name_kh',
        'number_phone',
        'email',
        'remark',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
     ];

    public function employee(){
        return $this->belongsTo(User::class,'employee_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }

    public function getEmployeeInAttribute(){
        return optional($this->employee);
    }

}
