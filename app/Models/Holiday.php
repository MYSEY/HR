<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
// use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Holiday extends Model
{
    // use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'holidays';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

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
        $from = Carbon::parse($this->from)->format('d');
        $to = Carbon::parse($this->to)->format('d-M-Y');
        return $from.' , '.$to;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
