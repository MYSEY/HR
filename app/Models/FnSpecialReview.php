<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;

class FnSpecialReview extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'fn_special_reviews'; // ប្តូរតាមឈ្មោះ table ពិតរបស់អ្នក
 
    protected $fillable = [
        'department_id',
        'branch_id',
        'position_id',
        'review',
        'from_date',
        'to_date',
        'remark',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
    protected $casts = [
        'position_id' => 'array',   // json <-> array ស្វ័យប្រវត្តិ
        'from_date'   => 'date:Y-m-d',
        'to_date' 
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
 
    public function branch()
    {
        return $this->belongsTo(Branchs::class, 'branch_id');
    }
 
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
 
}
