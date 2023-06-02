<?php

namespace App\Http\Controllers\Admins;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    public function index(){
        $data = Holiday::all();
        return view('holidays.index',compact('data'));
    }

    public function store(Request $request){
        try{
            $data = $request->all();
            $data['created_by']         = Auth::user()->id;
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
            Holiday::where('id',$request->id)->update([
                'title' => $request->title,
                'amount_percent'    => $request->amount_percent,
                'period_month'      => $request->period_month,
                'from'              => $request->from,
                'to'                => $request->to,
                'updated_by'        => Auth::user()->id
            ]);
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
