<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\SalaryRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class SalaryRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = SalaryRequest::with("employee")->get();
        $employees = User::whereIn("emp_status", ['Probation','1','10','2'])->select([
            'id', 
            'employee_name_en',
            'employee_name_kh',
            'number_employee',
            'department_id',
            'position_id',
            'branch_id',
            'gender',
            'date_of_birth',
            'pre_salary',
            'basic_salary',
            'salary_increas',
        ])
        ->get();
        return view('salary_requests.index', compact(['employees','datas']));
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
            $data['status'] = 1;
            $data['created_by'] = Auth::user()->id;
            SalaryRequest::create($data);
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
        $employees = User::whereIn("emp_status", ['Probation','1','10','2'])->select([
            'id', 
            'employee_name_en',
            'employee_name_kh',
            'number_employee',
            'department_id',
            'position_id',
            'branch_id',
            'gender',
            'date_of_birth',
            'pre_salary',
            'basic_salary',
            'salary_increas',
        ])
        ->get();
        $data = SalaryRequest::with("employee")->where('id',$request->id)->first();
        return response()->json(['success'=>$data, 'employees'=>$employees]);
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
            $data = SalaryRequest::find($request->id);
            $data['employee_id'] = $request->employee_id;
            $data['request_date'] = $request->request_date;
            $data['new_basic_salary'] = $request->new_basic_salary;
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
            SalaryRequest::destroy($request->id);
            Toastr::success('Deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Delete fail.','Error');
            return redirect()->back();
        }
    }
}
