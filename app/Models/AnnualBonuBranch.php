<?php

namespace App\Models;

use App\Models\Branchs;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnnualBonuBranch extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    protected $table = 'annual_bonu_branches';
    protected $guarded = ['id'];
    protected $fillable = [
        'branch_id',
        'percentage',
        'year',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
    public function branch()
    {
        return $this->belongsTo(Branchs::class, 'branch_id');
    }
}
