<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\MotorAdjustment;
use App\Models\User;
use App\Repositories\Admin\EmployeeRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity as ModelsActivity;

class MotorAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (permissionAccess("m5-s4","is_view")->value != "1") {
            return view('upgrade.access_page');
        }

        $employees = User::whereIn("emp_status", ["Probation", "1", "2", "10"])
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'Employee') {
                if(permissionAccess("m5-s4","is_access")->value == "1"){
                    $query->where("department_id", Auth::user()->department_id);
                    $query->where("branch_id", Auth::user()->branch_id);
                }else{
                    $query->where('id',Auth::user()->id);
                }
            }
            if ($RolePermission == 'HOD') {
                $query->whereIn("department_id", EmployeeRepository::getRoleHOD());
            }
            if ($RolePermission == 'HR') {
                $query->where("branch_id", Auth::user()->branch_id);
            }
            if ($RolePermission == 'BM') {
                $query->where("branch_id", Auth::user()->branch_id);
            }
        })
        ->get();
        $data = MotorAdjustment::leftJoin('users', 'motor_adjustments.employee_id', '=', 'users.id')
        ->select(
            'motor_adjustments.*',
            'users.employee_name_en',
            'users.employee_name_kh',
            'users.number_employee',
            'users.branch_id',
            'users.department_id',
        )
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'Employee') {
                if(permissionAccess("m5-s4","is_access")->value == "1"){
                    $query->where("users..department_id", Auth::user()->department_id);
                    $query->where("users..branch_id", Auth::user()->branch_id);
                }else{
                    $query->where('users..id',Auth::user()->id);
                }
                // $query->where('users.id',Auth::user()->id);
            }
            if ($RolePermission == 'HOD') {
                $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
            }
            if ($RolePermission == 'BM' || $RolePermission == 'HR') {
                $query->where("users.branch_id", Auth::user()->branch_id);
            }
        })
        ->orderBy('id','DESC')->get();
        return view('motor_rentels.adjustment', compact('data', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
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
            ModelsActivity::all()->last();
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            MotorAdjustment::create($data);
            return response()->json([
                'status' => 200,
                'message' => 'The process has been successfully.'
            ]);
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            return response()->json(['message' => $exp->getMessage()], 500);
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
        $employee = User::whereIn("emp_status", ["Probation", "1", "2", "10"])
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'Employee') {
                if(permissionAccess("m5-s4","is_access")->value == "1"){
                    $query->where("department_id", Auth::user()->department_id);
                    $query->where("branch_id", Auth::user()->branch_id);
                }else{
                    $query->where('id',Auth::user()->id);
                }
            }
            if ($RolePermission == 'HOD') {
                $query->whereIn("department_id", EmployeeRepository::getRoleHOD());
            }
            if ($RolePermission == 'HR') {
                $query->where("branch_id", Auth::user()->branch_id);
            }
            if ($RolePermission == 'BM') {
                $query->where("branch_id", Auth::user()->branch_id);
            }
        })
        ->get();
        $data = MotorAdjustment::where('id',$request->id)->first();
        return response()->json([
            'success'=>$data,
            'employee'=>$employee
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
        try {
            $data = MotorAdjustment::find($request->id);
            $data['employee_id']        = $request->employee_id;
            $data['amount_usd']         = $request->amount_usd ? $request->amount_usd : 0;
            $data['amount_table_usd']   = $request->amount_table_usd ? $request->amount_table_usd : 0;
            $data['amount_kh']          = $request->amount_kh ? $request->amount_kh : 0;
            $data['amount_engine_oil']  = $request->amount_engine_oil ? $request->amount_engine_oil : 0;
            $data['adjustment_date']    = $request->adjustment_date;
            $data['adjustment_type']    = $request->adjustment_type;
            $data['description']        = $request->description;
            $data['updated_by']         = Auth::user()->id;
            $data->save();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Update successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Updated fail.', 'Error');
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
        try {
            MotorAdjustment::destroy($request->id);
            Toastr::success('Deleted successfully.', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Delete fail.', 'Error');
            return redirect()->back();
        }
    }
}
