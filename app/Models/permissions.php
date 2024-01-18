<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class permissions extends Model
{
    use HasFactory;
    use LogsActivity;
    
    protected $table = 'permissions';
    protected $guarded = ['id'];

    protected $fillable = [
        'id',
        'name',
        'menu_id',
        'sub_menu_id',
        'icon',
        'url',
        'role_id',
        'parent_id',
        'is_dashboard',
        'is_all',
        'is_active',
        'is_create',
        'is_view',
        'is_update',
        'is_delete',
        'is_cancel',
        'is_accept',
        'is_approve',
        'is_reject',
        'is_print',
        'is_import',
        'is_export',
        'is_access',
        'is_view_report',
        'is_operation',
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
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
}