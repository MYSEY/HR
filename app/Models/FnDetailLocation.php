<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FnDetailLocation extends Model
{
    use HasFactory;
    protected $table = 'fn_detail_locations';
    protected $guarded = ['id'];

    protected $fillable = [
        'expense_request_id',
        'location_id',
        'department_id',
        'amount_usd',
        'amount_riel',
        
    ];
    
    public function expenseRequest()
    {
        return $this->belongsTo(ExpenseRequest::class, 'expense_request_id')->with(["requestBy","locationDetails","departments", "createdBy"]);
    }
    public function location()
    {
        return $this->belongsTo(Branchs::class, 'location_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function getLocationAttribute()
    {
        $branch = Branchs::where('id',$this->location_id)->first();
        return $branch;
    }
}
