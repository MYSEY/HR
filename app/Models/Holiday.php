<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Holiday extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'holidays';
    protected $guarded = ['id'];

    protected $fillable = [
        'title_kh',
        'title_en',
        'amount_percent',
        'period_month',
        'from',
        'to',
        'type',
        'created_by',
        'updated_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getFullNameAttribute(){
        return $this->name.' '.$this->last_name;
    }

    public function getPeriodPaymentAttribute(){
        if ($this->period_month) {
            return Carbon::parse($this->period_month)->format('d-M-Y');
        }
    }
    public function getDateFromAttribute(){
        if ($this->from) {
            return Carbon::parse($this->from)->format('d-M-Y');
        }
    }
    public function getDateToAttribute(){
        if ($this->to) {
            return Carbon::parse($this->to)->format('d-M-Y');
        }
    }
    public function getDaysAttribute(){
        $to = Carbon::parse($this->to);
        $from = Carbon::parse($this->from);

        $diff_in_days = $to->diffInDays($from);
        return $diff_in_days;
    }
    public function getDayAttribute(){
        $startDate = Carbon::parse($this->from);
        if($this->to == null){
            $endDate = Carbon::parse($this->from);
            $end_day = Carbon::createFromDate($this->from)->format('d');
            $end_month = Carbon::createFromDate($this->from)->format('M'); 
        }else{
            $endDate = Carbon::parse($this->to);
            $end_day = Carbon::createFromDate($this->to)->format('d');
            $end_month = Carbon::createFromDate($this->to)->format('M'); 
        }

        $diffInDays = $startDate->diffInDays($endDate);
        $day = Carbon::createFromDate($this->from)->format('d'); 
        
        $holidays = null;
        $int = (int)$day;
        if ($diffInDays > 1) {
            for ($i=0; $i < $diffInDays; $i++) { 
                if ($int > 9) {
                    $holidays .= $int + $i.',';
                }else{
                    $holidays .= '0'.$int + $i.',';
                }
            }
            return $end_month.' '.$holidays.$end_day;
        }else{
            return $end_month.' '.'0'.$int;
        }
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
