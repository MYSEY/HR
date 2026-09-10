<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TrainingDetailTrainer extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    
    protected $table = 'training_detail_trainers';
    protected $guarded = ['id'];

    protected $fillable = [
       'training_id',
       'trainer_id',
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
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id')->with("employee");
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
}
