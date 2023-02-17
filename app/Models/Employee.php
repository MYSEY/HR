<?php

namespace App\Models;

use App\Models\User;
use App\Models\Option;
use App\Helpers\Helper;
use App\Models\Branchs;
use App\Models\Position;
use App\Models\Education;
use App\Models\Department;
use App\Models\Experience;
use Illuminate\Support\Str;
use App\Traits\AddressTrait;
use App\Models\StaffPromoted;
use App\Models\StaffTraining;
use Illuminate\Support\Carbon;
use App\Traits\UploadFiles\UploadFIle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Employee extends Model
{
    // use CrudTrait;
    use UploadFIle;
    use AddressTrait;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'employees';
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
    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
    public function branch()
    {
        return $this->belongsTo(Branchs::class ,'branch_id');
    }
    public function position(){
        return $this->belongsTo(Position::class,'position_id');
    }
    public function educations()
    {
        return $this->hasMany(Education::class, 'employee_id', 'id');
    }
    public function experiences()
    {
        return $this->hasMany(Experience::class, 'employee_id', 'id');
    }
    
    public function staffPromoted()
    {
        return $this->hasMany(StaffPromoted::class, 'employee_id', 'id');
    }
    public function training(){
        return $this->hasMany(StaffTraining::class,'employee_id','id');
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
    public function getBranchNamenKhmerAttribute(){
        return $this->branch_name_kh;
    }
    public function getMediumProfileAttribute()
    {
        return Helper::isUrl($this->profile) ? $this->profile : asset($this->getUploadImage($this->profile, 'medium', 'default_user'));
    }

    public function setProfileAttribute($value)
    {
        if (!empty(request()->profile)) {
            if (Str::startsWith($value, 'data:image')) {
                $this->attributes['profile'] = $this->base64Upload($value);
                $this->deleteFiel($this->getOriginal('profile'));
            } else {
                if (request()->hasFile('profile')) {
                    $this->attributes['profile'] = $this->singleUpload('profile', request());
                    $this->deleteFiel($this->getOriginal('profile'));
                }
            }
        } elseif (Helper::isUrl($value)) {
            $this->attributes['profile'] = $value;
        } else {
            $this->attributes['profile'] = $this->base64Upload($value);
        }
    }

    public function setGuaranteeLetterAttribute($value)
    {
        if (!is_array(request()->guarantee_letter) && Str::startsWith($value, 'data:image')) {
            $this->attributes['guarantee_letter'] = $this->base64Upload($value);
        } else {
            $this->attributes['guarantee_letter'] = $this->singleUpload('guarantee_letter', request(), false);
        }
    }
    public function getGuaranteeLetterOriginalAttribute()
    {
        return asset($this->getUploadImage($this->guarantee_letter, 'original', 'default_user'));
    }

    public function setEmploymentBookAttribute($value)
    {
        if (!is_array(request()->employment_book) && Str::startsWith($value, 'data:image')) {
            $this->attributes['employment_book'] = $this->base64Upload($value);
        } else {
            $this->attributes['employment_book'] = $this->singleUpload('employment_book', request(), false);
        }
    }
    public function getEmploymentBookOriginalAttribute()
    {
        return asset($this->getUploadImage($this->employment_book, 'original', 'default_user'));
    }

    public function getEmployeePositionAttribute(){
        return optional($this->position)->name_khmer;
    }
    public function getEmployeeDepartmentAttribute(){
        return optional($this->department)->name;
    }
    public function getEmployeeGenderAttribute(){
        $data = Option::where('type','gender')->get();
        foreach($data as $item){
            if($this->gender == $item->id){
                $Gender = $item->name_khmer;
            }
        }
        return $Gender;
    }
    public function getEmployeeIdentityTypeAttribute(){
        $data = Option::where('type','identity_type')->get();
        foreach($data as $item){
            if($this->identity_type == $item->id){
                $IdentityType = $item->name_khmer;
            }
        }
        return $IdentityType;
    }
    
    public function getEmployeeBrnachAttribute(){
        return optional($this->branch)->branch_name_kh;
    }
    public function getjoinOfDateAttribute(){
        return Carbon::parse($this->date_of_commencement)->format('d-M-Y');
    }
    //// GET EN ADRESS
    public function getCityEnAttribute()
    {
        return $this->getAddress('city', 'en', $this->current_addtress);
    }
    public function getDistrictEnAttribute()
    {
        return $this->getAddress('district', 'en', $this->current_addtress);
    }
    public function getCommuneEnAttribute()
    {
        return $this->getAddress('commune', 'en', $this->current_addtress);
    }
    public function getVillageEnAttribute()
    {
        return $this->getAddress('village', 'en', $this->current_addtress);
    }
    public function getFullAddressEnAttribute()
    {
        $houseNo = $streetNo = '';
        if (!empty($this->current_house_no)) {
            $houseNo = 'House ' . $this->current_house_no . ',' ?? '';
        }
        if (!empty($this->current_street_no)) {
            $streetNo = 'Street ' . $this->current_street_no . ',' ?? '';
        }
        return $houseNo . $streetNo . $this->getAddress('full', 'en', $this->current_addtress);
    }


    // GET KH ADDRESS
    public function getCityKhAttribute()
    {
        return $this->getAddress('city', 'kh', $this->permanent_addtress);
    }

    public function getDistrictKhAttribute()
    {
        return $this->getAddress('district', 'kh', $this->permanent_addtress);
    }

    public function getCommuneKhAttribute()
    {
        return $this->getAddress('commune', 'kh', $this->permanent_addtress);
    }

    public function getVillageKhAttribute()
    {
        return $this->getAddress('village', 'kh', $this->permanent_addtress);
    }

    public function getFullAddressKhAttribute()
    {
        $houseNo = $streetNo = '';
        if (!empty($this->permanent_house_no)) {
            $houseNo = 'ផ្ទះលេខ ' . $this->permanent_house_no ?? '';
        }
        if (!empty($this->permanent_street_no)) {
            $streetNo = 'ផ្លូវ ' . $this->permanent_street_no ?? '';
        }
        return $houseNo . ' ' .$streetNo .' '. $this->getAddress('full', 'kh', $this->permanent_addtress);
    }
   
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
