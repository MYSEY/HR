<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaPurposeHistory extends Model
{
    use HasFactory;
    protected $table = 'pa_purpose_histories';
    protected $guarded = ['id'];

    protected $fillable = [
        'pa_histories_id',
        'title_histories_id',
        'name',
        'created_by',
        'updated_by',
    ];

    public function performanceDetail()
    {
        return $this->hasMany(PaDetailHistory::class, 'purpose_histories_id');
    }
}
