<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\permissions;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class SpecialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "special/approve")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $employee = User::whereIn("emp_status", ['Probation','1','2', '10'])
        ->select(
            'id',
            'employee_name_kh',
            'employee_name_en',
            'personal_phone_number',
            'email',
            'line_manager',
            'department_id',
            'branch_id',
        )->get();
        $data = DB::table('users')->whereNot("users.under_approve",null)
        ->leftJoin('users as under2', 'users.under_approve', '=', 'under2.id')
        ->leftJoin('branchs', 'under2.branch_id', '=', 'branchs.id')
        ->leftJoin('departments', 'under2.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'under2.position_id', '=', 'positions.id')
        ->select(
            'under2.id',
            'under2.employee_name_kh',
            'under2.employee_name_en',
            'under2.personal_phone_number',
            'under2.email',
            'under2.line_manager',
            'under2.department_id',
            'under2.branch_id',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
            'departments.name_khmer as department_name_kh',
            'departments.name_english as department_name_en',
            'positions.name_khmer as position_name_kh',
            'positions.name_english as position_name_en',
            'users.under_approve',DB::raw('GROUP_CONCAT(users.employee_name_en) as names')
            )
        ->groupBy('users.under_approve')
        ->get();
        // dd($data);
        return view('special_approves.index',compact(['permission','employee','data']));
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
            DB::beginTransaction();
            Activity::all()->last();
            if (count($request->employee_id) > 0) {
                foreach ($request->employee_id as $key => $emID) {
                    $dataUpdata = User::where("id", $emID)->first();
                    $dataUpdata->under_approve = $request->under_approve;
                    $dataUpdata->save();
                }
            }
            DB::commit();
            Toastr::success('Created successfully.','Success');
            return redirect()->back();
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
    public function edit($id)
    {
        //
    }
    public function employees(Request $request)
    {
        // $roleData = User::where("users.id", $request->id)->with("role")->first();
        // $roleType = optional($roleData->role)->role_type;
        $data = User::whereIn("users.emp_status", ['Probation','1','2', '10'])
        ->where("users.under_approve", $request->id)
        // ->when($roleType, function ($query) use ($roleType, $request) {
        //     if ($roleType == "BOD" || $roleType == "CEO") {
        //         return $query->orWhere("users.line_manager", $request->id);
        //     }
        // })
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->select(
            'users.id',
            'users.employee_name_kh',
            'users.employee_name_en',
            'users.personal_phone_number',
            'users.email',
            'users.line_manager',
            'users.department_id',
            'users.branch_id',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
            'departments.name_khmer as department_name_kh',
            'departments.name_english as department_name_en',
            'positions.name_khmer as position_name_kh',
            'positions.name_english as position_name_en',
        )->get();
        return response()->json(['datas'=>$data]);
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
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            // Update under_approve to NULL where under_approve matches request ID
            User::where("under_approve", $request->id)->update([
                "under_approve" => null
            ]);

            DB::commit(); // Commit transaction

            Toastr::success('Deleted successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on error
            Toastr::error('Delete failed: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
    public function destroyEmploee(Request $request)
    {
        DB::beginTransaction();
        try {
            User::where("id", $request->id)->update([
                "under_approve" => null,
                "line_manager" => null
            ]);

            DB::commit(); // Commit transaction

            Toastr::success('Deleted successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on error
            Toastr::error('Delete failed: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
}
