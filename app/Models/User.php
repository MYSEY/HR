<?php

namespace App\Models;

use App\Models\Role;
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
use Laravel\Sanctum\HasApiTokens;
use App\Traits\UploadFiles\UploadFIle;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one
// use Backpack\CRUD\app\Models\Traits\CrudTrait; // <------------------------------- this one

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use UploadFIle;
    use SoftDeletes;
    use AddressTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number_employee',
        'employee_name_kh',
        'employee_name_en',
        'email',
        'password',
        'phone',
        'email',
        'role_id',
        'position_id',
        'department_id',
        'branch_id',
        'profile',
        'unit',
        'level',
        'gender',
        'date_of_birth',
        'nationality',
        'date_of_commencement',
        'guarantee_letter',
        'employment_book',
        'identity_type',
        'identity_number',
        'issue_date',
        'issue_expired_date',
        'current_addtress',
        'current_house_no',
        'current_street_no',
        'permanent_addtress',
        'permanent_house_no',
        'permanent_street_no',
        'company_phone_number',
        'personal_phone_number',
        'agency_phone_number',
        'marital_status',
        'pass_date',
        'expired_date',
        'fixed_dura_con_type',
        'fdc_date',
        'fdc_end',
        'resign_date',
        'resign_reason',
        'remark',
        'number_of_children',
        'bank_name',
        'account_name',
        'account_number',
        'users_permission',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(self::class, 'created_by');
    }
    public function position(){
        return $this->belongsTo(Position::class,'position_id');
    }
    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }

    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
    public function branch()
    {
        return $this->belongsTo(Branchs::class ,'branch_id');
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
    public function gender(){
        return $this->hasMany(Option::class,'gender','id');
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

    public function getRolePermissionAttribute(){
        return optional($this->role)->name;
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
        return optional($this->department)->name_khmer;
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
        return $this->getAddress('city', 'en', $this->permanent_addtress);
    }

    public function getDistrictKhAttribute()
    {
        return $this->getAddress('district', 'en', $this->permanent_addtress);
    }

    public function getCommuneKhAttribute()
    {
        return $this->getAddress('commune', 'en', $this->permanent_addtress);
    }

    public function getVillageKhAttribute()
    {
        return $this->getAddress('village', 'en', $this->permanent_addtress);
    }

    public function getFullPermanentAddressAttribute()
    {
        $houseNo = $streetNo = '';
        if (!empty($this->permanent_house_no)) {
            $houseNo = 'House ' . $this->permanent_house_no ?? '';
        }
        if (!empty($this->permanent_street_no)) {
            $streetNo = 'Street ' . $this->permanent_street_no ?? '';
        }
        return $houseNo . ' ' .$streetNo .' '. $this->getAddress('full', 'en', $this->permanent_addtress);
    }
}
