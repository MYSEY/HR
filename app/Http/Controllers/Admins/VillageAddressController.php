<?php

namespace App\Http\Controllers\Admins;

use App\Models\Villages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;

class VillageAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // VillagesController.php

    public function index(Request $request)
    {
        // 1. បង្កើន Memory & Execution time ដើម្បីកុំឱ្យ PHP Crash
        ini_set('memory_limit', '512M');
        set_time_limit(60);

        $permission = DB::table('permissions')
            ->where('role_id', Auth::user()->role_id)
            ->where("url", "address/village")
            ->first();

        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }

        if ($request->ajax()) {
            try {
                $draw = intval($request->input('draw'));
                $start = intval($request->input('start', 0));
                $length = intval($request->input('length', 10));
                $searchValue = trim($request->input('search.value'));
                
                $orderColumnIndex = $request->input('order.0.column', 0);
                $orderDir = $request->input('order.0.dir', 'desc');

                $columns = [
                    0 => 'villages.id',
                    1 => 'villages.code',
                    2 => 'villages.phum_name_km',
                    3 => 'villages.phum_name_latin',
                    4 => 'villages.phum_name_en',
                    5 => 'villages.name_km',
                    6 => 'villages.name_latin',
                    7 => 'villages.name_en',
                    8 => 'villages.full_name_km',
                    9 => 'villages.full_name_latin',
                    10 => 'villages.full_name_en',
                    11 => 'conmmunes.full_name_en',
                    12 => 'districts.full_name_en',
                    13 => 'provinces.full_name_en',
                    14 => 'villages.address_km',
                    15 => 'villages.address_latin',
                    16 => 'villages.address_en',
                    17 => 'villages.id'
                ];

                $orderColumn = $columns[$orderColumnIndex] ?? 'villages.id';

                // 2. Base Query
                $query = DB::table('villages')
                    ->leftJoin('provinces', 'villages.province_id', '=', 'provinces.code')
                    ->leftJoin('districts', 'villages.district_id', '=', 'districts.code')
                    ->leftJoin('conmmunes', 'villages.commune_id', '=', 'conmmunes.code');

                $recordsTotal = DB::table('villages')->count('id');

                // 3. Optimize Search Logic (កាត់បន្ថយ Column ដែលមិនចាំបាច់ ដើម្បីស្រាល)
                if (!empty($searchValue)) {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('villages.code', 'LIKE', "{$searchValue}%") // ប្រើ Prefix Match លើ code ដើរលឿនខ្លាំង
                        ->orWhere('villages.phum_name_km', 'LIKE', "%{$searchValue}%")
                        ->orWhere('villages.phum_name_en', 'LIKE', "%{$searchValue}%")
                        ->orWhere('villages.full_name_en', 'LIKE', "%{$searchValue}%")
                        ->orWhere('villages.full_name_km', 'LIKE', "%{$searchValue}%")
                        ->orWhere('conmmunes.full_name_en', 'LIKE', "%{$searchValue}%")
                        ->orWhere('districts.full_name_en', 'LIKE', "%{$searchValue}%")
                        ->orWhere('provinces.full_name_en', 'LIKE', "%{$searchValue}%");
                    });
                }

                // Clone query សម្រាប់ count
                $recordsFiltered = !empty($searchValue) ? (clone $query)->count('villages.id') : $recordsTotal;

                if ($length != -1) {
                    $query->skip($start)->take($length);
                }

                $villages = $query->orderBy($orderColumn, $orderDir)
                    ->select([
                        'villages.id',
                        'villages.code',
                        'villages.phum_name_km',
                        'villages.phum_name_latin',
                        'villages.phum_name_en',
                        'villages.name_km',
                        'villages.name_latin',
                        'villages.name_en',
                        'villages.full_name_km',
                        'villages.full_name_latin',
                        'villages.full_name_en',
                        'villages.address_km',
                        'villages.address_latin',
                        'villages.address_en',
                        'provinces.full_name_en as province_name_en',
                        'districts.full_name_en as districts_name_en',
                        'conmmunes.full_name_en as conmmune_name'
                    ])->get();

                $data = [];
                foreach ($villages as $index => $row) {
                    $actionBtn = '';
                    if ($permission->is_update == "1" || $permission->is_delete == "1") {
                        $actionBtn = '<div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">';
                        if ($permission->is_update == "1") {
                            $actionBtn .= '<a class="dropdown-item update" data-toggle="modal" data-id="' . $row->id . '" data-target="#edit_trainer"><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                        }
                        if ($permission->is_delete == "1") {
                            $actionBtn .= '<a class="dropdown-item delete" href="#" data-toggle="modal" data-id="' . $row->id . '" data-target="#delete_trainer"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                        }
                        $actionBtn .= '</div></div>';
                    }

                    $data[] = [
                        $start + $index + 1,
                        $row->code,
                        $row->phum_name_km,
                        $row->phum_name_latin,
                        $row->phum_name_en,
                        $row->name_km,
                        $row->name_latin,
                        $row->name_en,
                        $row->full_name_km,
                        $row->full_name_latin,
                        $row->full_name_en,
                        $row->conmmune_name,
                        $row->districts_name_en,
                        $row->province_name_en,
                        $row->address_km,
                        $row->address_latin,
                        $row->address_en,
                        $actionBtn
                    ];
                }

                return response()->json([
                    "draw" => $draw,
                    "recordsTotal" => $recordsTotal,
                    "recordsFiltered" => $recordsFiltered,
                    "data" => $data
                ]);

            } catch (\Throwable $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ], 500);
            }
        }

        return view('villages.index', compact('permission'));
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
