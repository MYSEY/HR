<?php

namespace App\Http\Controllers\Admins;
use App\Address;
use App\Models\Role;
use App\Models\User;
use App\Models\Option;
use App\Helpers\Helper;
use App\Models\Branchs;
use App\Models\Position;
use App\Models\Province;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Cast\Object_;
use App\Traits\UploadFiles\UploadFIle;
use App\Repositories\Admin\EmployeeRepository;

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

    public function __construct(EmployeeRepository $employeeRepo)
    {
        $this->employeeRepo = $employeeRepo;
    }
    public function index()
    {
        $data = $this->employeeRepo->getAllUsers();
        $role = Role::all();
        $position = Position::all();
        $department = Department::all();
        $optionStatus = Option::where('type','status')->get();
        $autoEmpId   = $this->generate_EmployeeId(Carbon::today())['number_employee'];
        $optionGender = Option::where('type','gender')->get();
        $branch = Branchs::all();
        $province = Province::all();
        $optionIdentityType = Option::where('type','identity_type')->get();
        return view('users.index',compact('data','role','position','department','optionStatus','autoEmpId','optionGender','branch','optionIdentityType', 'province'));
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
            $this->employeeRepo->createUsers($request);
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
        try{
            $this->employeeRepo->updatedUsers($request);
            DB::commit();
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
