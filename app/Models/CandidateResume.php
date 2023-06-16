<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateResume extends Model
{
    use HasFactory;

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

    public function getCandidatePositionAttribute(){
        return optional($this->position)->name_english;
    }
    public function getCandidateBranchAttribute(){
        return optional($this->branch)->branch_name_en;
    }
}
