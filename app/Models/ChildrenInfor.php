<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Option;
use App\Helpers\Helper;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChildrenInfor extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'children_infors';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'name',
        'sex',
        'date_of_birth',
        'created_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
    public function getDateofBirthChildrenAttribute(){
        if ($this->date_of_birth) {
            return Carbon::parse($this->date_of_birth)->format('d-M-Y');
        }
    }

    public function getYearsOfChildrenAttribute(){
        $years = Carbon::now()->diffInYears($this->date_of_birth);
        $month = Carbon::now()->diffInMonths($this->date_of_birth);
        if ($this->date_of_birth) {
            $yearLang = Helper::getLang() == 'en' ? 'Year' : 'ឆ្នាំ';
            return $years.' '.$yearLang;
        }
    }

    public function getChildrenGenderAttribute(){
        $data = Option::where('type','gender')->get();
        foreach($data as $item){
            if($this->sex == $item->id){
                $Gender =  Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer;
            }
        }
        return $Gender ?? "";
    }
}
