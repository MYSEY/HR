<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Address;
class AddressController extends Controller
{
    public function index(Request $request)
    { 
        $_code = '_code';
        $_name_en = '_name_en';
        if(session()->get('locale') == 'kh'){
            return Address::where($_code,'Like',$request->code."__")
            ->orderBy($_name_en)
            ->pluck($_code,'_name_kh');  
        }else{
            return Address::where($_code,'Like',$request->code."__")
            ->orderBy($_name_en)
            ->pluck($_code,$_name_en);     
        }
    }
}
