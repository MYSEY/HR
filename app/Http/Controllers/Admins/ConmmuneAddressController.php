<?php

namespace App\Http\Controllers\Admins;

use App\Models\Conmmunes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ConmmuneAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('conmmunes')->paginate(15);
        return view('conmmune.index',compact('data'));
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
    public function ImportCommune(Request $request){
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $Commune =  $spreadsheet->getSheetByName('Commune')->toArray();
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $i = 0;
            $dataArray = [];
            foreach ($Commune as $item) {
                $i++;
                if ($i != 1) {
                    Conmmunes::firstOrCreate([
                        'code'=> $item[0],
                        'name_km'=> $item[1],
                        'name_en'=> $item[2],
                        'name_latin'=> $item[2],
                        'khum_name_km'=> 'ឃុំ',
                        'khum_name_latin'=> 'Khum',
                        'khum_name_en'=> 'Commune',
                        'full_name_km'=> 'ឃុំ'.''.$item[1],
                        'full_name_latin'=> 'Khum'.' '.$item[2],
                        'full_name_en'=> $item[2].' '.'Commune',
                        'district_id'=> $item[3],
                        'province_id'=> $item[6],
                        'address_km'=> 'ឃុំ'.$item[1].'ស្រុក'.$item[4].'ខេត្ដ'.$item[7],
                        'address_latin'=> 'Khum'.' '.$item[2].', '.'Srok'.' '.$item[5].' '.'Khaet'.' '.$item[8],
                        'address_en'=> $item[2].' '.'Commune'.', '.$item[5].' '.'District'.', '.$item[8].' '.'Conmmunes',
                    ]);
                }
            }
            return 1;
        } else {
            return 0;
        }
    }
}
