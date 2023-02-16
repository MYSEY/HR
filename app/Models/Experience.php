<?php

namespace App\Models;

use App\Models\Option;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experience extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'experiences';
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'title',
        'employment_type',
        'company_name',
        'start_date',
        'end_date',
        'location',
        'description',
        'updated_by'
    ];

    public function getEmpEmploymentTypeAttribute(){
        $data = Option::where('type','experience')->get();
        foreach($data as $item){
            if($this->employment_type == $item->id){
                $Emploype = $item->name_khmer;
            }
        }
        return $Emploype;
    }

    public function getExperienceStartDateEdnDateAttribute(){
        return Carbon::parse($this->start_date)->format('M-Y') .' - '. Carbon::parse($this->end_date)->format('M-Y');
    }
}
