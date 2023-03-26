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
    public function permanentAddress(Request $request)
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


    public function villages(){
        return response()->file(public_path('country/villages.json'));
    }
    public function communes(){
        return response()->file(public_path('country/communes.json'));
    }
    public function district(){
        return response()->file(public_path('country/district.json'));
    }
    public function provinces(){
        return response()->file(public_path('country/provinces.json'));
    }
}
