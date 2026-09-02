<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Option;
use App\Models\Branchs;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Traits\GeneratingCode;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EmployeeRequest;
use App\Traits\UploadFiles\UploadFIle;
use Spatie\Activitylog\Models\Activity;
use App\Repositories\Admin\EmployeeRepository;

class EmployeeController extends Controller
{
    use GeneratingCode;
    use UploadFIle;
    private $employeeRepo;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::all();
        $department = Department::all();
        $position = Position::all();
        $branch = Branchs::all();
        $role = Role::all();
        $optionIdentityType = Option::where('type','identity_type')->get();
        $optionGender = Option::where('type','gender')->get();
        $autoEmpId   = $this->generate_EmployeeId(Carbon::today())['number_employee'];
        return view('employees.index',compact('data','department','position','branch','optionIdentityType','optionGender','autoEmpId','role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = Department::all();
        $position = Position::all();
        $branch = Branchs::all();
        $optionIdentityType = Option::where('type','identity_type')->get();
        $optionGender = Option::where('type','gender')->get();
        $data['code']   = $this->generate_EmployeeId(Carbon::today())['number_employee'];
        return view('employees.create',compact('data','department','position','branch','optionIdentityType','optionGender'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        try{
            Activity::all()->last();
            $data = $request->all();
            $data['current_addtress']   = $request->current_addre_village ? : $request->current_addre_commune ? : $request->current_addre_distric ? : $request->current_addre_city;
            $data['permanent_addtress'] = $request->permanet_addre_village ? : $request->permanet_addre_commune ? : $request->permanet_addre_distric ? : $request->permanet_addre_city;
            $data['created_by']         = Auth::user()->id;
            $data['role_id']            = Auth::user()->role_id;
            Employee::create($data);
            DB::commit();
            Toastr::success('Employee created successfully :)','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Employee created fail :)','Error');
            return redirect()->back();
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
        Employee::where('id',$request->id)->delete();
        return response()->json(['status'=>true]);
    }
}
