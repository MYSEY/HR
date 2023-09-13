<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeStatusHistory extends Model
{
    use HasFactory;
    protected $table = 'employee_status_histories';
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'status',
        'status_date',
        'created_by',
        'updated_by',
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
