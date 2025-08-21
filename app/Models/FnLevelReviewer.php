<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FnLevelReviewer extends Model
{
    use HasFactory;
    protected $table = 'fn_level_reviewers';
    protected $guarded = ['id'];
    protected $appends = ['position_review'];

    protected $fillable = [
        'group_id',
        'from_amount',
        'to_amount',
        'request_type',
        'reference_type',
        'type',
        'from_location',
        'model_review',
        'department_review',
        'id_positions',
        'verify_print',
        'description',
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
    protected function idPositions(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
    public function getPositionReviewAttribute()
    {
        $positionIds = is_array($this->id_positions) ? $this->id_positions : json_decode($this->id_positions, true);

        return !empty($positionIds) ? Position::whereIn('id', $positionIds)->get() : collect();
    }
    public function modelReview()
    {
        return $this->belongsTo(Department::class, 'model_review');
    }
    public function departmentView()
    {
        return $this->belongsTo(Department::class, 'department_review');
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
