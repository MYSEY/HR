<?php

namespace App\Models;

use App\Models\Option;
use App\Helpers\Helper;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Education extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'education';
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'school',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
        'grade',
        'description',
        'created_by',
        'updated_by'
    ];


    public function getEdcutionFieldOfStudyAttribute(){
        $data = Option::where('type','field_of_study')->get();
        foreach($data as $item){
            if($this->field_of_study == $item->id){
                $FieldOfStudy = Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer;
            }
        }
        return $FieldOfStudy ?? null;
    }
    public function getEdcutiondegreeAttribute(){
        $data = Option::where('type','degree')->get();
        foreach($data as $item){
            if($this->degree == $item->id){
                $dataDegree = Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer;
            }
        }
        return $dataDegree ?? null;
    }

    public function getEducationStartDateEdnDateAttribute(){
        return Carbon::parse($this->start_date)->format('M-Y') .' - '. Carbon::parse($this->ent_date)->format('M-Y');
    }
}
