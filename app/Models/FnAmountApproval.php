<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FnAmountApproval extends Model
{
    use HasFactory;
    protected $table = 'fn_amount_approvals';
    protected $guarded = ['id'];

    protected $fillable = [
        'fn_approval_id',
        'level_reviewer_id',
        'location',
        'description',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function requestType()
    {
        return $this->belongsTo(FnLevelReviewer::class, 'level_reviewer_id');
    }
}
