<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\Position;
use App\Models\RecruitmentPlan;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecruitmentPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = RecruitmentPlan::with('position')->with('branch')
        ->orderBy('id', 'desc')
        ->get();
        $positions = Position::all();
        $branchs = Branchs::all();
        return view('recruitments.plans.recruitment_plan', compact('data', 'positions', 'branchs'));
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
        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            RecruitmentPlan::create($data);
            Toastr::success('Recruitment plan created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Recruitment plan created fail.','Error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // $branchs = Branchs::
        // when($request->branch_id, function ($query, $branch_id) {
        //     $query->where('id', $branch_id);
        // })
        // ->get();
        $data = RecruitmentPlan::with('position')->with('branch')
        -> when($request->branch_id, function ($query, $branch_id) {
            $query->where('branch_id', $branch_id);
        })
        ->when($request->position_id, function ($query, $position_id) {
            $query->where('position_id', $position_id);
        })
        ->orderBy('plan_date', 'desc')
        // ->orderBy('id', 'desc')
        ->get();
        return response()->json([
            'success'=>$data,
            // 'branchs'=>$branchs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = RecruitmentPlan::where("id", $request->id)->first();
        $positions = Position::all();
        $branchs = Branchs::all();

        return response()->json([
            'success'=>$data,
            'positions'=>$positions,
            'branchs'=>$branchs,
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
            RecruitmentPlan::where('id',$request->id)->update([
                'position_id' => $request->position_id,
                'branch_id' => $request->branch_id,
                'plan_date' => $request->plan_date,
                'total_staff' => $request->total_staff,
                'remark' => $request->remark,
                'updated_by' => Auth::user()->id 
            ]);
            Toastr::success('Recruitment plan updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Recruitment plan updated fail.','Error');
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
            RecruitmentPlan::destroy($request->id);
            Toastr::success('Recruitment plan deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Recruitment plan delete fail.','Error');
            return redirect()->back();
        }
    }
}
