<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\FnAmountApproval;
use App\Models\FnApproval;
use App\Models\FnLevelReviewer;
use App\Models\permissions;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class FnApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "fn/approval")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $datas = FnApproval::with(["location"])->get();
        $employees = User::whereIn("emp_status", ['Probation','1','10','2'])->get();
        $locations = Branchs::get();
        return view('FN_Approvals.index',compact(['datas','permission', 'employees', 'locations']));
    }

    public function view(Request $request)
    {
        $datas = FnAmountApproval::where('fn_approval_id', $request->id)->get();
        $FnApproval = FnApproval::with('location')->findOrFail($request->id);
        $locationAbbr = optional($FnApproval->location)->abbreviations;
        $location_id = $locationAbbr !== 'HQ' ? 1 : 2;
        $amounts = FnLevelReviewer::where('from_location', $location_id)
            ->when($FnApproval->employee[0], function ($query, $employee) {
                $query->where("model_review", $employee->department_id)
                    ->orWhere("branch_id", null);
            })
            ->groupBy('group_id')
            ->get();
        if ($amounts->isEmpty()) {
            $amounts = FnLevelReviewer::where('from_location', $location_id)
                ->whereNull('branch_id')
                ->groupBy('group_id')
                ->get();
        }
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "fn/approval")->first();
        return view('FN_Approvals.amount_setup',compact(['permission','FnApproval','datas','amounts']));
    }

    public function getTitle(Request $request) 
    {
        $request->validate([
            'title' => 'required|string',
        ]);
        $data = FnApproval::with("printDocument")
            ->where('title', $request->title)
            ->first();
        $name = $data && $data->printDocument ? $data->printDocument->employee_name_kh : "";

        return response()->json([
            'name' => $name,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $data['created_by']         = Auth::user()->id;
            FnAmountApproval::create($data);
            Toastr::success('Created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage(), 'status' => 500], 500);
        }
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
            Activity::all()->last();
            $data = $request->all();
            // $data['employee_id']    = json_encode($request->employee_id);
            $data['created_by'] = Auth::user()->id;
            FnApproval::create($data);
            Toastr::success('Created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Created fail.','Error');
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
        $data = FnApproval::where('id',$request->id)->first();
        $employees = User::whereIn("emp_status", ['Probation','1','10','2'])->get();
        $locations = Branchs::get();
        return response()->json([
            'success'=>$data, 
            'employees'=>$employees, 
            'locations'=>$locations
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
            $data = FnApproval::where("id",$request->id)->first();
            $data['title'] = $request->title;
            // $data['employee_id']    = json_encode($request->employee_id);
            $data['employee_id'] = $request->employee_id;
            $data['print_document_id'] = $request->print_document_id;
            $data['location_id'] = $request->location_id;
            $data['description'] = $request->description;
            $data['updated_by'] = Auth::user()->id;
            $data->save();
            Toastr::success('Updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Updated fail.','Error');
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
            FnApproval::destroy($request->id);
            Toastr::success('Deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Delete fail.','Error');
            return redirect()->back();
        }
    }

      public function deleteAmount(Request $request)
    {
        try{
            FnAmountApproval::destroy($request->id);
            Toastr::success('Deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Delete fail.','Error');
            return redirect()->back();
        }
    }
    
}
