<?php

namespace App\Http\Controllers\Admins;

use App\Models\District;
use App\Models\Province;
use App\Models\Villages;
use App\Models\Conmmunes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        $province = Province::all();
        return view('users.index',compact('province'));
    }

    public function showDistrict(Request $request)
    {
        $district = District::where('province_id',$request->province_id)
                        ->get();
        return response()->json(['data'=>$district]);
    }
    public function showCommune(Request $request)
    {
        $communes = Conmmunes::where('district_id',$request->district_id)
                        ->get();
        return response()->json(['data'=>$communes]);
    }
    public function showVillage(Request $request)
    {
        $villages = Villages::where('commune_id',$request->commune_id)
                        ->get();
        return response()->json(['data'=>$villages]);
    }
}
