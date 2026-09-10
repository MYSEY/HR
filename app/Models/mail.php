<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'mails';
    protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'email',
        'department_id',
        'branch_id',
        'subject',
        'message',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }

    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }
    public function branch(){
        return $this->belongsTo(Branchs::class,'branch_id');
    }
}
