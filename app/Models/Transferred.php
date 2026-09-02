<?php

namespace App\Models;

use App\Models\Branchs;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transferred extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    
    protected $table = 'transferreds';
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'branch_id',
        'tranferend_branch_name',
        'position_id',
        'tranferend_position_name',
        'date',
        'descrition',
        'updated_by'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
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

    public function getTransferredBranchAttribute(){
        return optional($this->branch)->tranferend_branch_name;
    }
    public function getTransferredPositionAttribute(){
        return optional($this->position)->name_english;
    }

    public function getTransferEmpAttribute(){
        return optional($this->employee);
    }
    public function getTransterDateAttribute(){
        if ($this->date) {
            return Carbon::parse($this->date)->format('d-M-Y');
        }
    }
}
