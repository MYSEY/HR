<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaTitleHistory extends Model
{
    use HasFactory;
    protected $table = 'pa_title_histories';
    protected $guarded = ['id'];

    protected $fillable = [
        'pa_histories_id',
        'title',
        'created_by',
        'updated_by',
    ];

    public function purposes()
    {
        return $this->hasMany(PaPurposeHistory::class, 'title_histories_id');
    }
}
