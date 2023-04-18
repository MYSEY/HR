<?php

namespace App\Models;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffPromoted extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'staff_promoteds';
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'posit_id',
        'position_promoted_to',
        'depart_id',
        'department_promoted_to',
        'date',
        'created_by',
        'updated_by'
    ];

    public function position(){
        return $this->belongsTo(Position::class,'posit_id');
    }
    public function department(){
        return $this->belongsTo(Department::class,'depart_id');
    }

    public function getPostionPromotedAttribute(){
        return optional($this->position)->name_khmer;
    }
    public function getDepartmentPromotedAttribute(){
        return optional($this->department)->name_khmer;
    }
    public function getPormotDateAttribute(){
        if ($this->date) {
            return Carbon::parse($this->date)->format('d-M-Y');
        }
    }
}
