<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Traits\AddressTrait;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\UploadFiles\UploadFIle;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one
// use Backpack\CRUD\app\Models\Traits\CrudTrait; // <------------------------------- this one

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // use CrudTrait; // <----- this
    // use HasRoles; // <------ and this
    use AddressTrait;
    use UploadFIle;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'date_of_birth',
        'phone',
        'email',
        'position_id',
        'department_id',
        'profile',
        'active',
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

    public function getFullNameAttribute(){
        return $this->name.' '.$this->last_name;
    }

    public function getMediumProfileAttribute()
    {
        return Helper::isUrl($this->profile) ? $this->profile : asset($this->getUploadImage($this->profile, 'medium', 'default_user'));
    }

    public function getProfileAttribute($value)
    {
        return Helper::isUrl($value) ? $value : asset($this->getUploadImage($value, 'original', 'default_user'));
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

    //// GET EN ADRESS
    public function getCityEnAttribute()
    {
        return $this->getAddress('city', 'en', $this->address);
    }
    public function getDistrictEnAttribute()
    {
        return $this->getAddress('district', 'en', $this->address);
    }
    public function getCommuneEnAttribute()
    {
        return $this->getAddress('commune', 'en', $this->address);
    }
    public function getVillageEnAttribute()
    {
        return $this->getAddress('village', 'en', $this->address);
    }
    public function getFullAddressEnAttribute()
    {
        $houseNo = $streetNo = '';
        if (!empty($this->house_no)) {
            $houseNo = 'House ' . $this->house_no . ',&nbsp;' ?? '';
        }
        if (!empty($this->street_no)) {
            $streetNo = 'Street ' . $this->street_no . ',&nbsp;' ?? '';
        }
        return $houseNo . $streetNo . $this->getAddress('full', 'en', $this->address);
    }


    // GET KH ADDRESS
    public function getCityKhAttribute()
    {
        return $this->getAddress('city', 'kh', $this->address);
    }

    public function getDistrictKhAttribute()
    {
        return $this->getAddress('district', 'kh', $this->address);
    }

    public function getCommuneKhAttribute()
    {
        return $this->getAddress('commune', 'kh', $this->address);
    }

    public function getVillageKhAttribute()
    {
        return $this->getAddress('village', 'kh', $this->address);
    }

    public function getFullAddressKhAttribute()
    {
        $houseNo = $streetNo = '';
        if (!empty($this->house_no)) {
            $houseNo = 'ផ្ទះលេខ ' . $this->house_no ?? '';
        }
        if (!empty($this->street_no)) {
            $streetNo = 'ផ្លូវ ' . $this->street_no ?? '';
        }
        return $houseNo . ' ' .$streetNo .' '. $this->getAddress('full', 'kh', $this->address);
    }
}
