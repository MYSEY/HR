<?php

namespace App\Models;

use App\Models\Branchs;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transferred extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'transferreds';
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'branch_id',
        'position_id',
        'date',
        'descrition',
        'updated_by'
    ];

    public function branch()
    {
        return $this->belongsTo(Branchs::class ,'branch_id');
    }
    public function position()
    {
        return $this->belongsTo(Position::class ,'position_id');
    }
    public function employee()
    {
        return $this->belongsTo(User::class ,'employee_id')->with("branch")->with("position");
    }

    public function getBranchNameAttribute(){
        return optional($this->branch)->branch_name_kh;
    }
    public function getTransterDateAttribute(){
        if ($this->date) {
            return Carbon::parse($this->date)->format('d-M-Y');
        }
    }
}
