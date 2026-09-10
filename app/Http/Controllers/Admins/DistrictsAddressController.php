<?php

namespace App\Http\Controllers\Admins;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\permissions;
use Illuminate\Support\Facades\Auth;

class DistrictsAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "address/district")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $data = DB::table('districts')
        ->leftJoin('provinces','districts.province_id','=','provinces.id')
        ->select(
            'districts.*',
            'provinces.full_name_km as province_name_km',
            'provinces.full_name_en as province_name_en',
        )->get();
        return view('district.index',compact('data','permission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ImportDistrict(Request $request){
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $Districts =  $spreadsheet->getSheetByName('Districts')->toArray();
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $i = 0;
            $dataArray = [];
            foreach ($Districts as $item) {
                $i++;
                if ($i != 1) {
                    District::firstOrCreate([
                        'code'=> $item[0],
                        'name_km'=> $item[1],
                        'name_en'=> $item[2],
                        'name_latin'=> $item[2],
                        'province_id'=> $item[3],
                        'srok_name_km'=> 'ស្រុក',
                        'srok_name_latin'=> 'Srok',
                        'srok_name_en'=> 'District',
                        'full_name_km'=> 'ស្រុក'.''.$item[1],
                        'full_name_latin'=> 'Srok'.' '.$item[2],
                        'full_name_en'=> $item[2].' '.'District',
                        'address_km'=> 'ស្រុក'.$item[1].'ខេត្ដ'.$item[4],
                        'address_latin'=> 'Srok'.' '.$item[2].','.'Khaet'.' '.$item[5],
                        'address_en'=> $item[2].' '.'District'.','.$item[5].' '.'Province',
                    ]);
                }
            }
            return 1;
        } else {
            return 0;
        }
    }
}
