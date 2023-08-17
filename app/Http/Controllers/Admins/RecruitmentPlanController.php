<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportRecruitmentPlan;
use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\Position;
use App\Models\RecruitmentPlan;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
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
            $currentday = Carbon::createFromDate()->format('d');
            foreach ($request->plan_date as $key => $plan_date) {
                $data = [
                    "position_id" => $request->position_id,
                    "branch_id" => $request->branch_id,
                    "plan_date" => $plan_date.'-'.$currentday,
                    "total_staff" => $request->total_staff[$key],
                    "remark" =>  $request->remark,
                    "created_by" => Auth::user()->id,
                ];
                RecruitmentPlan::create($data);
            }
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
        try {
            $by_year = null;
            if ($request->filter_year) {
            $by_year = $request->filter_year;
            }else {
                $by_year = Carbon::createFromDate()->format('Y');
            }
            $data = RecruitmentPlan::with('position')->with('branch')
            ->when($request->branch_id, function ($query, $branch_id) {
                $query->where('branch_id', $branch_id);
            })
            ->when($request->position_id, function ($query, $position_id) {
                $query->where('position_id', $position_id);
            })
            ->when($by_year, function ($query, $filter_year) {
                $query->whereYear('plan_date', $filter_year);
            })
            ->orderBy('plan_date', 'desc')
            ->get();
            return response()->json([
                'success'=>$data,
            ]);
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Recruitment plan fail.','Error');
        }
    }

    public function detail()
    {
        return view('recruitments.plans.recruitment_plan_detail');
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
            $currentday = Carbon::createFromDate()->format('d');
            $plan_date = $request->plan_date.'-'.$currentday;
            $dataPlan = RecruitmentPlan::where("id", $request->id)->first();
            $dataPlan->position_id = $request->position_id;
            $dataPlan->branch_id = $request->branch_id;
            $dataPlan->plan_date = $plan_date;
            $dataPlan->total_staff = $request->total_staff;
            $dataPlan->remark = $request->remark;
            $dataPlan->updated_by = Auth::user()->id;
            $dataPlan->save();
            Toastr::success('Recruitment plan updated successfully.','Success');
            return response()->json([
                'success'=>$dataPlan,
            ]);
            // return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Recruitment plan updated fail.','Error');
            return redirect()->back();
        }
    }

    public function export(Request $request)
    {
        $export = new ExportRecruitmentPlan($request);
        return Excel::download($export, 'RecruitmentPlan.xlsx');
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
