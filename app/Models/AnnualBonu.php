<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnnualBonu extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    protected $table = 'annual_bonus';
    protected $guarded = ['id'];
    protected $fillable = [
        'criteria',
        'discription',
        'total_score',
        'percentage',
        'increasement_year',
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
}
