<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = DB::table('permissions')
            ->where('role_id', Auth::user()->role_id)
            ->where("url", "trainer/list")
            ->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $data = Trainer::with("employee")
        ->leftJoin('users', 'trainers.employee_id', '=', 'users.id')
        ->select(
            'trainers.*',
            'users.line_manager',
            'users.department_id',
            'users.branch_id',
        )
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) use ($permission) {
            if(in_array($RolePermission, ['HOD', 'BM'])){
                $query->where("users.department_id", Auth::user()->department_id);
                $query->where("users.branch_id", Auth::user()->branch_id);

            }else if(in_array($RolePermission, ['DHOD', 'DBM'])){
                $query->where("users.line_manager", Auth::user()->id);
                $query->orWhere("users.id", Auth::user()->id);

            }else if($RolePermission == "Employee") {
                $query->where("users.id", Auth::user()->id);

            }else if ($RolePermission == 'HR' && $permission->is_access != "1") {
                $query->where("users.line_manager", Auth::user()->id);
                $query->orWhere("users.id", Auth::user()->id);
            }
        })->get();
        $employee = User::whereIn("emp_status", ['1','2', '10'])->orWhereIn("p_status", ['1','2', '10'])->get();

        return view('trainers.index', compact('permission','data', 'employee'));
    }
    public function filter(Request $request)
    {
        try {
            $permission = DB::table('permissions')
            ->where('role_id', Auth::user()->role_id)
            ->where("url", "trainer/list")
            ->first();
            $from_date = null;
            $to_date = null;
            if ($request->from_date) {
                $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d');
            }
            if ($request->to_date) {
                $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s');
            }
            $data = Trainer::leftJoin('users', 'trainers.employee_id', '=', 'users.id')
            ->select(
                'trainers.*', 
                'users.employee_name_kh',
                'users.employee_name_en',
                'users.personal_phone_number',
                'users.email as  user_email',
                'users.remark as user_remark',
                'users.line_manager',
                'users.department_id',
                'users.branch_id',
            )
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) use ($permission) {
                if(in_array($RolePermission, ['HOD', 'BM'])){
                    $query->where("users.department_id", Auth::user()->department_id);
                    $query->where("users.branch_id", Auth::user()->branch_id);
    
                }else if(in_array($RolePermission, ['DHOD', 'DBM'])){
                    $query->where("users.line_manager", Auth::user()->id);
                    $query->orWhere("users.id", Auth::user()->id);
    
                }else if($RolePermission == "Employee") {
                    $query->where("users.id", Auth::user()->id);
    
                }else if ($RolePermission == 'HR' && $permission->is_access != "1") {
                    $query->where("users.line_manager", Auth::user()->id);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                $query->where('trainers.created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('trainers.created_at','<=', $to_date);
            })
            ->when($request->trainer_type, function ($query, $trainer_type) {
                $query->where('trainers.type', $trainer_type);
            })
            ->when($request->company_name, function ($query, $company_name) {
                $query->where('trainers.company_name', 'LIKE', '%'.$company_name.'%');
            })
            ->when($request->trainer_name, function ($query, $trainer_name) {
                $query->where('users.name_en', 'LIKE', '%'.$trainer_name.'%');
                $query->orWhere('users.name_kh', 'LIKE', '%'.$trainer_name.'%');
                $query->orWhere('users.employee_name_en', 'LIKE', '%'.$trainer_name.'%');
                $query->orWhere('users.employee_name_kh', 'LIKE', '%'.$trainer_name.'%');
            })
            ->get();
            
            return response()->json([
                'success'=>$data,
            ]);
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Training created fail.','Error');
        }
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
            Activity::all()->last();
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            Trainer::create($data);
            Toastr::success('Trainer created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Trainer created fail.','Error');
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
        $data = Trainer::where("id", $request->id)->first();
        $employee = User::whereIn("emp_status", ['1','2'])->get();
        return response()->json([
            'trainer'=>$data,
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
        try{
            $data = Trainer::find($request->id);
            $data['type'] = $request->type;
            $data['company_name'] = $request->company_name;
            $data['employee_id'] = $request->employee_id;
            $data['name_en'] = $request->name_en;
            $data['name_kh'] = $request->name_kh;
            $data['email'] = $request->email;
            $data['number_phone'] = $request->number_phone;
            $data['remark'] = $request->remark;
            $data['status'] = $request->status;
            $data['updated_by'] = Auth::user()->id;
            $data->save();
            Toastr::success('Training type Updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Training type Updated fail.','Error');
            return redirect()->back();
        }
    }

    public function processing(Request $request)
    {
        try {
            Trainer::where('id',$request->id)->update([
                'status' => $request->trainer_status,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'The process has been successfully.'
            ]);
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
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
            Trainer::destroy($request->id);
            Toastr::success('Trainer deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Trainer delete fail.','Error');
            return redirect()->back();
        }
    }
}
