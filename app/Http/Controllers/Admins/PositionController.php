<?php

namespace App\Http\Controllers\Admins;

use App\Models\Option;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PositionRequest;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Spatie\Activitylog\Models\Activity;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (permissionAccess("m9-s2","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $data = Position::all();
        $positionType = Option::where('type','position_type')->get();
        $positionRange = Option::where('type','position_range')->get();
        return view('positions.index',compact('data','positionType','positionRange'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PositionRequest $request)
    {
        try {
            Activity::all()->last();
            $data = $request->all();
            $data['created_by']    = Auth::user()->id;
            Position::create($data);
            Toastr::success('Position created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Position created fail.','Error');
        }
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
    public function edit(Request $request)
    {
        $data = Position::where('id',$request->id)->first();
        $positionType = Option::where('type','position_type')->get();
        $positionRange = Option::where('type','position_range')->get();
        return response()->json([
            'success'=>$data,
            'positionType'  => $positionType,
            'positionRange' => $positionRange
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            $data = Position::find($request->id);
            $data['name_khmer']  = $request->name_khmer;
            $data['name_english']  = $request->name_english;
            $data['position_type']  = $request->position_type;
            $data['position_range']  = $request->position_range;
            $data['updated_by']    = Auth::user()->id;
            $data->save(); 
            Toastr::success('Position Updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Position Updated fail.','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            Position::destroy($request->id);
            Toastr::success('Position deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Position delete fail.','Error');
            return redirect()->back();
        }
    }
    public function ImpotPosition(Request $request){
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $AllPosition = $spreadsheet->getActiveSheet()->toArray();
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $i = 0;
            $dataArray = [];
            foreach ($AllPosition as $item) {
                $i++;
                if ($i != 1) {
                    Position::firstOrCreate([
                        'name_english'   => $item[0],
                        'name_khmer'   => $item[1],
                        'position_range'   => $item[2],
                        'position_type'   => $item[3],
                        'position_type_number'   => $item[4],
                        'created_by'    => Auth::user()->id,
                    ]);
                }
            }
            if($dataArray){
                return response()->json(['error'=>$dataArray]);
            }
            return 1;
        } else {
            return 0;
        }
    }
}
