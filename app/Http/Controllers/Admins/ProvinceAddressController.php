<?php

namespace App\Http\Controllers\Admins;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\permissions;
use Illuminate\Support\Facades\Auth;

class ProvinceAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "address/province")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $data = DB::table('provinces')->get();
        return view('provinces.index',compact('data','permission'));
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
    public function ImportProvince(Request $request){
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $Province =  $spreadsheet->getSheetByName('Province')->toArray();
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $i = 0;
            $dataArray = [];
            foreach ($Province as $item) {
                $i++;
                if ($i != 1) {
                    Province::firstOrCreate([
                        'code'=> $item[0],
                        'name_km'=> $item[1],
                        'name_en'=> $item[2],
                        'name_latin'=> $item[2],
                        'khaet_name_km'=> 'ខេត្ត',
                        'khaet_name_latin'=> 'Khaet',
                        'khaet_name_en'=> 'Province',
                        'full_name_km'=> 'ខេត្ត'.''.$item[1],
                        'full_name_latin'=> 'Khaet'.' '.$item[2],
                        'full_name_en'=> $item[2].' '.'Province',
                        'address_km'=> 'ខេត្ដ'.$item[1],
                        'address_latin'=> 'Khaet'.' '.$item[2],
                        'address_en'=> $item[2].' '.'Province',
                    ]);
                }
            }
            return 1;
        } else {
            return 0;
        }
    }
}
