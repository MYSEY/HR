<?php

namespace App\Models;

use App\Models\Option;
use App\Helpers\Helper;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experience extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'experiences';
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'title',
        'employment_type',
        'company_name',
        'position',
        'start_date',
        'end_date',
        'location',
        'description',
        'updated_by'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
    public function getEmpEmploymentTypeAttribute(){
        $data = Option::where('type','experience')->get();
        foreach($data as $item){
            if($this->employment_type == $item->id){
                $Emploype = Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer;
            }
        }
        return $Emploype ?? "";
    }

    public function getExperienceStartDateEdnDateAttribute(){
        return Carbon::parse($this->start_date)->format('M-Y') .' - '. Carbon::parse($this->end_date)->format('M-Y');
    }
}
