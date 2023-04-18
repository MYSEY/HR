<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffTraining extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'staff_trainings';
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'title',
        'start_date',
        'end_date',
        'descrition',
        'updated_by'
    ];

    public function getTrainingStartDateAttribute(){
        if ($this->start_date) {
            return Carbon::parse($this->start_date)->format('d-M-Y');
        }
    }
    public function getTrainingStartEndDateAttribute(){
        if ($this->end_date) {
            return Carbon::parse($this->end_date)->format('d-M-Y');
        }
    }
}
