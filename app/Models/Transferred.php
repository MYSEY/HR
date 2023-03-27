<?php

namespace App\Models;

use App\Models\Branchs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transferred extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'transferreds';
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'branch_id',
        'date',
        'updated_by'
    ];

    public function branch()
    {
        return $this->belongsTo(Branchs::class ,'branch_id');
    }

    public function getBranchNameAttribute(){
        return optional($this->branch)->branch_name_kh;
    }
}
