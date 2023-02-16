<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\Branchs;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Traits\GeneratingCode;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\UploadFiles\UploadFIle;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    use GeneratingCode;
    use UploadFIle;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::all();
        return view('employees.index',compact('data'));
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
        $data['code']   = $this->generate_EmployeeId(Carbon::today())['number_employee'];
        return view('employees.create',compact('data','department','position','branch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $guarantee_letter = $this->singleUpload('guarantee_letter',$request,false);
        $employment_book = $this->singleUpload('employment_book',$request,false);
        $profile = $this->singleUpload('profile',$request,false);
        try {
            $data = $request->all();
            $data['guarantee_letter']   = $guarantee_letter;
            $data['employment_book']    = $employment_book;
            $data['profile']            = $profile;
            $data['created_by']         = Auth::user()->id;
            Employee::create($data);
            return redirect()->route('employee.index')->with('status','Employee created successfully!');
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollBack();
        }
    }

    public function putSession($request)
    {
        foreach ($this->fields() as $field) {
            Session::put($field, $request->{$field});
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
    public function destroy($id)
    {
        //
    }
}
