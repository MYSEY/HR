<?php

namespace App\Http\Controllers\Admins;
use App\Address;
use App\Models\Role;
use App\Models\User;
use App\Models\Option;
use App\Models\Branchs;
use App\Models\Position;
use App\Models\Department;
use App\Traits\AddressTrait;
use Illuminate\Http\Request;
use App\Traits\GeneratingCode;
use Illuminate\Support\Carbon;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdated;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use App\Traits\UploadFiles\UploadFIle;
use PhpParser\Node\Expr\Cast\Object_;

class UserController extends Controller
{
    use GeneratingCode;
    use AddressTrait;
    use UploadFIle;
    private $employeeRepo;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::with('role')->with('department')->get();
        $role = Role::all();
        $position = Position::all();
        $department = Department::all();
        $optionStatus = Option::where('type','status')->get();
        $autoEmpId   = $this->generate_EmployeeId(Carbon::today())['number_employee'];
        $optionGender = Option::where('type','gender')->get();
        $branch = Branchs::all();
        $optionIdentityType = Option::where('type','identity_type')->get();
        return view('users.index',compact('data','role','position','department','optionStatus','autoEmpId','optionGender','branch','optionIdentityType'));
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
    public function store(UserRequest $request)
    {
        try{
            $data = $request->all();
            $data['current_province']   = $request->current_province;
            $data['current_district']   = $request->current_district;
            $data['current_commune']   = $request->current_commune;
            $data['current_village']   = $request->current_village;
            $data['permanent_province'] = $request->permanent_province;
            $data['permanent_district'] = $request->permanent_district;
            $data['permanent_commune'] = $request->permanent_commune;
            $data['permanent_village'] = $request->permanent_village;
            $data['password']   = Hash::make($request->password);
            User::create($data);
            DB::commit();
            Toastr::success('Employee create successfully :)','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Employee create fail :)','Error');
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
    public function edit(Request $request)
    {
        $_code = '_code';
        $_name_en = '_name_en';
        $address = Address::where($_code,'Like',$request->code."__")->orderBy($_name_en)->pluck($_code,$_name_en);

        $data = User::where('id',$request->id)->with('role')->first();
        $role = Role::all();
        $position = Position::all();
        $department = Department::all();
        $optionGender = Option::where('type','gender')->get();
        $branch = Branchs::all();
        // $address =  Address::where($_code,'Like',$request->code."__")->orderBy($_name_en)->get();
        $optionIdentityType = Option::where('type','identity_type')->get();
        return response()->json([
            'success'=>$data,
            'role'=>$role,
            'position'=>$position,
            'department'=>$department,
            'optionGender'=>$optionGender,
            'branch'=>$branch,
            'optionIdentityType'=>$optionIdentityType,
            'address'=>$address
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdated $request)
    {
        if($request->hasFile('profile')) {
            $image = $request->file('profile');
            $filename = time().'.'.$image->getClientOriginalName();
            $image->move(public_path('uploads/images'), $filename);
        }else{
            $filename = $request->hidden_image;
        }

        if ($request->hasFile('guarantee_letter')) {
            $file = $request->file('guarantee_letter');
            $filenameGuarant = time().'.'.$file->getClientOriginalName();
            $file->move(public_path('uploads/images'), $filenameGuarant);
        }else{
            $filenameGuarant = $request->hidden_file_guarantee;
        }
        if ($request->hasFile('employment_book')) {
            $file = $request->file('employment_book');
            $filenameBook = time().'.'.$file->getClientOriginalName();
            $file->move(public_path('uploads/images'), $filenameBook);
        }else{
            $filenameBook = $request->hidden_file_employment_book;
        }
        try{
            User::where('id',$request->id)->update([
                'number_employee'  => $request->number_employee,
                'employee_name_kh'  => $request->employee_name_kh,
                'employee_name_en'  => $request->employee_name_en,
                'gender'  => $request->gender,
                'role_id'  => $request->role_id,
                'position_id'  => $request->position_id,
                'department_id'  => $request->department_id,
                'date_of_birth'  => $request->date_of_birth,
                'email'  => $request->email,
                'branch_id'  => $request->branch_id,
                'unit'  => $request->unit,
                'level'  => $request->level,
                'date_of_commencement'  => $request->date_of_commencement,
                'number_of_children'  => $request->number_of_children,
                'marital_status'  => $request->marital_status,
                'nationality'  => $request->nationality,
                'personal_phone_number'  => $request->personal_phone_number,
                'company_phone_number'  => $request->company_phone_number,
                'agency_phone_number'  => $request->agency_phone_number,
                'password'  => Hash::make($request->password),
                'remark'  => $request->remark,
                'bank_name'  => $request->bank_name,
                'account_name'  => $request->account_name,
                'account_number'  => $request->account_number,
                'identity_type'  => $request->identity_type,
                'identity_number'  => $request->identity_number,
                'issue_date'  => $request->issue_date,
                'issue_expired_date'  => $request->issue_expired_date,
                'current_house_no'  => $request->current_house_no,
                'current_street_no'  => $request->current_street_no,
                'current_province'   => $request->current_province,
                'current_district'   => $request->current_district,
                'current_commune'   => $request->current_commune,
                'current_village'   => $request->current_village,
                'permanent_province' => $request->permanent_province,
                'permanent_district' => $request->permanent_district,
                'permanent_commune' => $request->permanent_commune,
                'permanent_village' => $request->permanent_village,
                'permanent_house_no'  => $request->permanent_house_no,
                'permanent_street_no'  => $request->permanent_street_no,
                'profile'  => $filename,
                'guarantee_letter'  => $filenameGuarant,
                'employment_book'  => $filenameBook,
            ]);
            Toastr::success('Updated account successfully :)','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User update fail :)','Error');
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
            User::destroy($request->id);
            if ($request->profile) {
                unlink('uploads/images/'.$request->profile);
            }
            Toastr::success('User deleted successfully :)','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User delete fail :)','Error');
            return redirect()->back();
        }
    }

    public function processing(Request $request)
    {
        try {
            if ($request->emp_status == 1) {
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'fdc_date' => $request->start_date,
                    'fdc_end' => $request->end_dete,
                    'resign_reason' => $request->resign_reason
                ]);
            }else if($request->emp_status == 2){
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'fdc_date' => null,
                    'fdc_end' => null,
                    'resign_reason' => $request->resign_reason
                ]);
            }else{
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'resign_date' => $request->resign_date,
                    'resign_reason' => $request->resign_reason,
                    'fdc_date' => null,
                    'fdc_end' => null,
                ]);
            }
            

            DB::commit();
            return response()->json([
                'message' => 'The process has been successfully.'
            ]);
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }
}
