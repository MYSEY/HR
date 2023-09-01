<?php

namespace App\Models;

use App\Models\Option;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'contacts';
    protected $guarded = ['id'];
    protected $fillable = [
        'employee_id',
        'name',
        'relationship',
        'phone',
        'phone_2',
        'updated_by'
    ];


    public function getEmergencyContactAttribute(){
        $data = Option::where('type','relationship')->get();
        foreach($data as $item){
            if($this->relationship == $item->id){
                $Contact = (Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer);
            }
        }
        return $Contact ?? "";
    }
}
