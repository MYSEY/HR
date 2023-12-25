<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'role_name',
        'role_type',
        'created_by',
        'updated_by',
    ];
    public function useruse()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }


    public function getFullNameCreatedByAttribute(){
        return optional($this->createdBy)->name;
    }
}
