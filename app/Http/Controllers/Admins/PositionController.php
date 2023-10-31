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

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            Position::where('id',$request->id)->update([
                'name_khmer'  => $request->name_khmer,
                'name_english'  => $request->name_english,
                'position_type'  => $request->position_type,
                'position_range'  => $request->position_range,
                'updated_by'    => Auth::user()->id 
            ]);
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
}
