<?php

namespace App\Models;

use App\Models\Role;
use App\Helpers\Helper;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Support\Str;
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
        'name',
        'email',
        'password',
        'phone',
        'email',
        'role_id',
        'position_id',
        'department_id',
        'profile',
        'active',
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



    public function getEmployeePositionAttribute(){
        return optional($this->position)->name_khmer;
    }
    public function getEmployeeDepartmentAttribute(){
        return optional($this->department)->name;
    }
    public function getRolePermissionAttribute(){
        return optional($this->role)->name;
    }
}
