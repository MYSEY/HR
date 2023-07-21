<?php

namespace App\Models;

use App\Traits\UploadFiles\UploadFIle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CandidateResume extends Model
{
    use HasFactory;
    use UploadFIle;
    use SoftDeletes;

    protected $table = 'candidate_resumes';
    protected $guarded = ['id'];
    protected $fillable = [
        'number_employee',
        'name_kh',
        'name_en',
        'gender',
        'current_position',
        'companey_name',
        'position_applied',
        'current_address',
        'location_applied',
        'received_date',
        'recruitment_channel',
        'contact_number',
        'status',
        'cv',
        'interviewed_date',
        'committee_interview',
        'interviewed_result',
        'join_date',
        'remark',
        'short_list',
        'joined_interview',
        'contract_date',
        'interviewed_channel',
        'fdc_date',
        'id_card_number',
        'basic_salary',
        'salary_increas',
        'position_type',
        'department_id',
        'date_of_birth',
        'current_province',
        'current_district',
        'current_commune',
        'current_village',
        'current_house_no',
        'current_street_no',
        'permanent_province',
        'permanent_district',
        'permanent_commune',
        'permanent_village',
        'permanent_house_no',
        'permanent_street_no',
        'created_by',
        'updated_by',
    ];
    public function option(){
        return $this->belongsTo(Option::class,'gender');
    }
    public function position(){
        return $this->belongsTo(Position::class,'position_applied');
    }
    public function positiontype(){
        return $this->belongsTo(Option::class,'position_type', 'id');
    }
    public function branch()
    {
        return $this->belongsTo(Branchs::class ,'location_applied');
    }

    //// Current address
    public function currentprovince(){
        return $this->belongsTo(Province::class,'current_province','code');
    }
    public function currentdistrict(){
        return $this->belongsTo(District::class,'current_district','code');
    }
    public function currentcommune(){
        return $this->belongsTo(Conmmunes::class,'current_commune','code');
    }
    public function currentvillage(){
        return $this->belongsTo(Villages::class,'current_village','code');
    }

    //// Permanent address
    public function permanentprovince(){
        return $this->belongsTo(Province::class,'permanent_province','code');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }

    public function setCVAttribute($value)
    {
        if (!is_array(request()->cv) && Str::startsWith($value, 'data:image')) {
            $this->attributes['cv'] = $this->base64Upload($value);
        } else {
            $this->attributes['cv'] = $this->singleUpload('cv', request(), false);
        }
    }

    public function getCandidateGenderAttribute(){
        return optional($this->option)->name_english;
    }
    public function getCandidatePositionAttribute(){
        return optional($this->position)->name_english;
    }
    public function getCandidateBranchAttribute(){
        return optional($this->branch)->branch_name_en;
    }
}
