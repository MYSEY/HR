<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'kh_address';

    public function getFullAddressAttribute()
    {
       return implode(', ',array_reverse(explode('/',$this->_path_en))) ;
    }
}
