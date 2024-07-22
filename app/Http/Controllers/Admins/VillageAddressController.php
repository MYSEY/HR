<?php

namespace App\Http\Controllers\Admins;

use App\Models\Villages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;

class VillageAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('villages')
        ->leftJoin('provinces','villages.province_id','=','provinces.code')
        ->leftJoin('districts','villages.district_id','=','districts.code')
        ->leftJoin('conmmunes','villages.commune_id','=','conmmunes.code')
        ->select(
            'villages.*',
            'provinces.full_name_en as province_name_en',
            'districts.full_name_en as districts_name_en',
            'conmmunes.full_name_en as conmmune_name',
        )->paginate(15);
        return view('villages.index',compact('data'));
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

    public function ImportVillage(Request $request){
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $Village =  $spreadsheet->getSheetByName('Village')->toArray();
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $i = 0;
            $dataArray = [];
            foreach ($Village as $item) {
                $i++;
                if ($i != 1) {
                    Villages::firstOrCreate([
                        'code'=> $item[0],
                        'name_km'=> $item[1],
                        'name_en'=> $item[2],
                        'name_latin'=> $item[2],
                        'phum_name_km'=> 'ភូមិ',
                        'phum_name_latin'=> 'Phum',
                        'phum_name_en'=> 'Village',
                        'full_name_km'=> 'ភូមិ'.$item[1],
                        'full_name_latin'=> 'Phum'.' '.$item[2],
                        'full_name_en'=> $item[2].' '.'Village',
                        'commune_id'=> $item[3],
                        'district_id'=> $item[6],
                        'province_id'=> $item[9],
                        'address_km'=> 'ភូមិ'.$item[1].'ឃុំ'.$item[4].'ស្រុក'.$item[7].'ខេត្ដ'.$item[10],
                        'address_latin'=> 'Phum'.' '.$item[2].', '.'Khum'.' '.$item[5].', '.'srok'.' '.$item[8].', '.'Khaet'.' '.$item[11],
                        'address_en'=> $item[2].' '.'Village'.', '.$item[5].' '.'Commune'.', '.$item[8].' '.'District'.', '.$item[11].' '.'Villages',
                    ]);
                }
            }
            return 1;
        } else {
            return 0;
        }
    }
}
