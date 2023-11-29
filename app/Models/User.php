<?php

namespace App\Models;

use App\Models\Bank;
use App\Models\Role;
use App\Models\Option;
use App\Helpers\Helper;
use App\Models\Branchs;
use App\Models\District;
use App\Models\Position;
use App\Models\Province;
use App\Models\Villages;
use App\Models\Conmmunes;
use App\Models\Education;
use App\Models\Department;
use App\Models\Experience;
use App\Models\Transferred;
use Illuminate\Support\Str;
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


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number_employee',
        'last_name_kh',
        'first_name_kh',
        'last_name_en',
        'first_name_en',
        'employee_name_kh',
        'employee_name_en',
        'email',
        'pre_salary',
        'basic_salary',
        'salary_increas',
        'total_current_salary',
        'total_severancey_pay',
        'phone_allowance',
        'password',
        'phone',
        'role_id',
        'position_id',
        'position_type',
        'department_id',
        'branch_id',
        'profile',
        'unit',
        'level',
        'gender',
        'date_of_birth',
        'id_card_number',
        'id_number_nssf',
        'nationality',
        'ethnicity',
        'date_of_commencement',
        'guarantee_letter',
        'employment_book',
        'identity_type',
        'identity_number',
        'issue_date',
        'issue_expired_date',
        'type_of_employees_nssf',
        'spouse_nssf',
        'status_nssf',
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
        'company_phone_number',
        'personal_phone_number',
        'agency_phone_number',
        'marital_status',
        'fdc_date',
        'fdc_end',
        'severance_pay_date',
        'udc_end_date',
        'resign_date',
        'resign_reason',
        'remark',
        'spouse',
        'bank_name',
        'account_name',
        'account_number',
        'users_permission',
        'status',
        'emp_status',
        'p_status',
        'is_loan',
        'type',
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
    public function positiontype(){
        return $this->belongsTo(Option::class,'position_type', 'id');
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
    public function bank()
    {
        return $this->belongsTo(Bank::class ,'bank_name');
    }
    public function resignStatus(){
        return $this->belongsTo(Option::class,'resign_reason', 'id');
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
        return $this->belongsTo(Option::class,'gender','id');
    }
    public function employeeGender(){
        return $this->belongsTo(Option::class,'gender','id');
    }
    // total child
    public function totalChild(){
        return $this->hasMany(ChildrenInfor::class,'employee_id','id');
    }

    public function banks(){
        return $this->belongsTo(Bank::class,'bank_name','id');
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
        return optional($this->role)->role_type;
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

    public function getEmployeeNameAttribute(){
        return Helper::getLang() == 'en' ? $this->employee_name_en : $this->employee_name_kh;
    }
    public function getEmployeePositionAttribute(){
        return (Helper::getLang() == 'en') ? optional($this->position)->name_english : optional($this->position)->name_khmer;
    }
    public function getEmployeeDepartmentAttribute(){
        return (Helper::getLang() == 'en') ? optional($this->department)->name_english : optional($this->department)->name_khmer;
    }
    public function getEmployeeGenderAttribute(){
        $data = Option::where('type','gender')->get();
        foreach($data as $item){
            if($this->gender == $item->id){
                $Gender = Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer;
            }
        }
        return $Gender ?? "";
    }
    public function getEmployeeIdentityTypeAttribute(){
        $data = Option::where('type','identity_type')->get();
        foreach($data as $item){
            if($this->identity_type == $item->id){
                $IdentityType = Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer;
            }
        }
        return $IdentityType ?? "";
    }
    public function getEmployeePositionTypeAttribute(){
        $data = Option::where('type','position_type')->get();
        foreach($data as $item){
            if($this->position_type == $item->id){
                $positionType = Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer;
            }
        }
        return $positionType ?? "";
    }
    public function getEmployeeResignReasonAttribute(){
        $data = Option::where('type','emp_status')->get();
        foreach($data as $item){
            if($this->resign_reason == $item->id){
                $resignReason = $item->name_english;
            }
        }
        return $resignReason ?? "";
    }
    public function getEmployeeMaritalStatusAttribute(){
        $data = Option::where('type','marital_status')->get();
        foreach($data as $item){
            if($this->marital_status == $item->id){
                $maritalStatus = Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer;
            }
        }
        return $maritalStatus ?? "";
    }
    public function getEmployeeNationalityAttribute(){
        $data = Option::where('type','nationality')->get();
        foreach($data as $item){
            if($this->nationality == $item->id){
                $nationality = Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer;
            }
        }
        return $nationality ?? "";
    }
    public function getTypeNssfAttribute(){
        $data = Option::where('type','type_nssf')->get();
        foreach($data as $item){
            if($this->type_of_employees_nssf == $item->id){
                $type_nssf = Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer;
            }
        }
        return $type_nssf ?? "";
    }
    
    public function getEmployeeBranchAttribute(){
        return (Helper::getLang() == 'en') ? optional($this->branch)->branch_name_en : optional($this->branch)->branch_name_kh;
    }
    public function getEmployeeBranchAbbreviationsAttribute(){
        return optional($this->branch)->abbreviations;
    }
    public function getBranchAddressAttribute(){
        return (Helper::getLang() == 'en') ? optional($this->branch)->address : optional($this->branch)->address_kh;

    }
    public function getjoinOfDateAttribute(){
        if ($this->date_of_commencement) {
            return Carbon::parse($this->date_of_commencement)->format('d-M-Y');
        }
    }
    public function getPassDateAttribute(){
        if ($this->fdc_date) {
            return Carbon::parse($this->fdc_date)->format('d-M-Y');
        }
    }
    public function getFDCStartDateAttribute(){
        if ($this->fdc_date) {
            return Carbon::parse($this->fdc_date)->format('d-M-Y');
        }
    }
    public function getUDCStartDateAttribute(){
        if ($this->udc_end_date) {
            return Carbon::parse($this->udc_end_date)->format('d-M-Y');
        }
    }
    public function getFDCEndDateAttribute(){
        if ($this->fdc_end) {
            return Carbon::parse($this->fdc_end)->format('d-M-Y');
        }
    }
    public function getDayOfGetSeverancePayAttribute(){
        if ($this->fdc_end) {
            return Carbon::createFromDate($this->fdc_end)->format('d-M-Y');
        }
    }
    public function getResignDatesAttribute(){
        if ($this->resign_date) {
            return Carbon::parse($this->resign_date)->format('d-M-Y');
        }
    }
    public function getDOBAttribute(){
        if ($this->date_of_birth) {
            return Carbon::parse($this->date_of_birth)->format('d-M-Y');
        }
    }

    // total child
    public function getTotalChildAttribute(){
       $totalChild = ChildrenInfor::where('employee_id',$this->id)->count();
        return $totalChild;
    }

    //// GET Current address EN
    public function getFullCurrentAddressAttribute()
    {
        $houseNo = $streetNo = $provice_name = $district_name = $conmmunes_name = $villages_name = '';
        $house = Helper::getLang() == 'en' ? 'House ' : 'ផ្ទះលេខ';
        $street = Helper::getLang() == 'en' ? 'Street ' : 'ផ្លូវ';
        if (!empty($this->current_house_no)) {
            $houseNo = $house .' '. $this->current_house_no . ' , ' ?? '';
        }
        if (!empty($this->current_street_no)) {
            $streetNo = $street . ' ' . $this->current_street_no . ' ,' ?? '';
        }
        $province = Province::all();
        foreach($province as $item){
            if($this->current_province == $item->code){
                $provice_name = Helper::getLang() == 'en' ? $item->address_en : $item->address_km;
            }
        }
        $district = District::where('province_id',$this->current_province)->get();
        foreach($district as $item){
            if($this->current_district == $item->code){
                $district_name = Helper::getLang() == 'en' ? $item->full_name_en : $item->full_name_km;
            }
        }
        $Conmmunes = Conmmunes::where('district_id',$this->current_district)->get();
        foreach($Conmmunes as $item){
            if($this->current_commune == $item->code){
                $conmmunes_name = Helper::getLang() == 'en' ? $item->full_name_en : $item->full_name_km;
            }
        }
        $villages = Villages::all();
        foreach($villages as $item){
            if($this->current_village == $item->code){
                $villages_name = Helper::getLang() == 'en' ? $item->full_name_en : $item->full_name_km;
            }
        }
        return $houseNo . $streetNo .$villages_name.', '.$conmmunes_name.', '.$district_name.', '.$provice_name;
    }

    public function getSeniorityYearsOfEmployeeAttribute(){
        $date_of_commencement = Carbon::createFromDate($this->date_of_commencement);
        $current_date = Carbon::createFromDate();
        $result = $date_of_commencement->gte($current_date);
        $seniority = "0 years, 0 months, 0 days";
        if (!$result) {
            $seniority = Carbon::createFromDate($this->date_of_commencement)->diff(Carbon::now())->format('%y years, %m months, %d days');
        }
        if ($this->date_of_commencement) {
            return $seniority;
        }
    }
    //// GET Permanent address
    public function getFullPermanentAddressAttribute()
    {
        $houseNo = $streetNo = $provice_name = $district_name = $conmmunes_name = $villages_name = '';
        $house = Helper::getLang() == 'en' ? 'House ' : 'ផ្ទះលេខ';
        $street = Helper::getLang() == 'en' ? 'Street ' : 'ផ្លូវ';
        if (!empty($this->permanent_house_no)) {
            $houseNo = $house .' ' . $this->permanent_house_no . ',' ?? '';
        }
        if (!empty($this->permanent_street_no)) {
            $streetNo = $street. ' ' . $this->permanent_street_no . ',' ?? '';
        }
        $province = Province::all();
        foreach($province as $item){
            if($this->permanent_province == $item->code){
                $provice_name = $item->address_en;
            }
        }
        $district = District::where('province_id',$this->permanent_province)->get();
        foreach($district as $item){
            if($this->permanent_district == $item->code){
                $district_name = $item->full_name_en;
            }
        }
        $Conmmunes = Conmmunes::where('district_id',$this->permanent_district)->get();
        foreach($Conmmunes as $item){
            if($this->permanent_commune == $item->code){
                $conmmunes_name = $item->full_name_en;
            }
        }
        $villages = Villages::all();
        foreach($villages as $item){
            if($this->permanent_village == $item->code){
                $villages_name = $item->full_name_en;
            }
        }
        return $houseNo . $streetNo .$villages_name.', '.$conmmunes_name.', '.$district_name.', '.$provice_name;
    }
}
