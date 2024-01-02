<?php

namespace App\Http\Controllers\Admins;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class HolidayController extends Controller
{
    public function index(){
        $data = Holiday::all();
        return view('holidays.index',compact('data'));
    }

    public function store(Request $request){
        try{
            Activity::all()->last();
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            $data['type']       = 'bonus';
            Holiday::create($data);
            DB::commit();
            Toastr::success('created holiday successfully','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('created holiday fail','Error');
            return redirect()->back();
        }
    }
    public function edit(Request $request)
    {
        $data = Holiday::where('id',$request->id)->first();
        return response()->json([
            'success'=>$data,
        ]);
    }

    public function update(Request $request){
        try{
            $data = Holiday::find($request->id);
            $data['title_en']          = $request->title_en;
            $data['title_kh']          = $request->title_kh;
            $data['amount_percent']    = $request->amount_percent;
            $data['period_month']      = $request->period_month;
            $data['from']              = $request->from;
            $data['to']                = $request->to;
            $data['type']              = 'bonus';
            $data['updated_by']        = Auth::user()->id;
            $data->save();
            DB::commit();
            Toastr::success('Updated holiday successfully','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Updated holiday fail','Error');
            return redirect()->back();
        }
    }
}
