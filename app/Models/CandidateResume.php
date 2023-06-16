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
        'created_by',
        'updated_by',
    ];
    public function option(){
        return $this->belongsTo(Option::class,'gender');
    }
    public function position(){
        return $this->belongsTo(Position::class,'position_applied');
    }
    public function branch()
    {
        return $this->belongsTo(Branchs::class ,'location_applied');
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
