<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeverancePay extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'severance_pays';
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'total_severanec_pay',
        'total_contract_severance_pay',
        'status',
        'payment_date',
        'created_by',
        'updated_by',
    ];
    //RelationShip
    public function users()
    {
        return $this->belongsTo(User::class ,'employee_id');
    }
}
