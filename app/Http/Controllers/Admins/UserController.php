<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportEmployee;
use App\Models\Bank;
use App\Models\Role;
use App\Models\User;
use App\Models\Option;
use App\Models\Branchs;
use App\Models\District;
use App\Models\Position;
use App\Models\Province;
use App\Models\Villages;
use App\Models\Conmmunes;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Traits\GeneratingCode;
use Illuminate\Support\Carbon;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdated;
use App\Models\GenerateIdEmployee;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\EmployeeStatusHistory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\UploadFiles\UploadFIle;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Repositories\Admin\EmployeeRepository;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    use GeneratingCode;
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
    public function index(Request $request)
    {
        $data = $this->employeeRepo->getAllUsers($request);
        $role = Role::all();
        $position = Position::all();
        $department = Department::all();
        $optionStatus = Option::where('type','status')->get();
        $autoEmpId   = $this->generate_EmployeeId(Carbon::today())['number_employee'];
        $optionGender = Option::where('type','gender')->get();
        $optionPositionType = Option::where('type','position_type')->get();
        $optionLoan = Option::where('type','loan')->get();
        $optionSpouse = Option::where('type','is_spouse')->get();
        $optionIdentityType = Option::where('type','identity_type')->get();
        $branch = Branchs::all();
        $province = Province::all();
        $bank = Bank::all();
        if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer') {
            $dataProbation = User::with('role')->with('department')->where('emp_status','Probation')->get();
            $dataFDC = User::with('role')->with('department')->whereIn('emp_status',['1','10'])->get();
            $dataUDC = User::with('role')->with('department')->where('emp_status','2')->get();
            $dataCanContract = User::with('role')->with('department')->where('emp_status','Cancel')->get();
            $dataResign = User::with('role')->with('department')->whereIn('emp_status', ['3','4','5','6','7','8','9'])->get();
        }else{
            $dataProbation = User::where('role_id',Auth::user()->role_id)
            ->where('branch_id',Auth::user()->branch_id)
            ->where('position_id',Auth::user()->position_id)
            ->where('department_id',Auth::user()->department_id)
            ->where('branch_id',Auth::user()->branch_id)
            ->where('emp_status','Probation')->get();
            $dataFDC = User::where('role_id',Auth::user()->role_id)
            ->where('branch_id',Auth::user()->branch_id)
            ->where('position_id',Auth::user()->position_id)
            ->where('department_id',Auth::user()->department_id)
            ->where('branch_id',Auth::user()->branch_id)
            ->whereIn('emp_status',['1','10'])->get();
            $dataUDC = User::where('role_id',Auth::user()->role_id)
            ->where('branch_id',Auth::user()->branch_id)
            ->where('position_id',Auth::user()->position_id)
            ->where('department_id',Auth::user()->department_id)
            ->where('branch_id',Auth::user()->branch_id)
            ->where('emp_status','2')->get();
            $dataCanContract = User::where('role_id',Auth::user()->role_id)->where('emp_status','Cancel')->with('department')->get();
            $dataResign = User::where('role_id',Auth::user()->role_id)->whereIn('emp_status', ['3','4','5','6','7','8','9'])->with('department')->get();
        }
       
        return view('users.index',compact('data',
                                            'role',
                                            'position',
                                            'department',
                                            'optionStatus',
                                            'autoEmpId',
                                            'optionGender',
                                            'branch',
                                            'optionIdentityType', 
                                            'province',
                                            'bank',
                                            'optionPositionType',
                                            'optionLoan',
                                            'optionSpouse',
                                            'dataProbation',
                                            'dataFDC',
                                            'dataUDC',
                                            'dataCanContract',
                                            'dataResign'
                                        ));
    }

    public function formCreate() {
        $role = Role::all();
        $position = Position::all();
        $department = Department::all();
        $optionStatus = Option::where('type','status')->get();
        $autoEmpId   = $this->generate_EmployeeId(Carbon::today())['number_employee'];
        $optionGender = Option::where('type','gender')->get();
        $optionPositionType = Option::where('type','position_type')->get();
        $optionLoan = Option::where('type','loan')->get();
        $optionSpouse = Option::where('type','is_spouse')->get();
        $optionIdentityType = Option::where('type','identity_type')->get();
        $branch = Branchs::all();
        $province = Province::all();
        $bank = Bank::all();
        return view('users.form_create',compact(
                                            'role',
                                            'position',
                                            'department',
                                            'optionStatus',
                                            'autoEmpId',
                                            'optionGender',
                                            'branch',
                                            'optionIdentityType', 
                                            'province',
                                            'bank',
                                            'optionPositionType',
                                            'optionLoan',
                                            'optionSpouse',
                                        ));
    }
    public function formEdit() {
        return view('users.form_edit');
    }

    public function filter(Request $request){
        try{
            $data = $this->employeeRepo->getAllUsers($request);
            return response()->json([
                'data'=>$data,
            ]);
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update employee fail','Error');
            return redirect()->back();
        }
    }
    public function showDetailBirthday (Request $request){
        $from_date = Carbon::now()->format('d');
        $to_date = Carbon::now()->addDays(14)->format('d');
        $month = Carbon::now()->format('m');
        $monthAdd = Carbon::now()->addDays(14)->format('m');
        $data =  User::whereIn('emp_status',['1','2','10','Probation'])
        ->whereDay('date_of_birth', '>=', $from_date)
        ->whereMonth('date_of_birth', $month)
        ->orWhereMonth('date_of_birth', $monthAdd)
        ->whereDay('date_of_birth', '<=', $to_date)
        ->orderBy('date_of_birth', 'desc')->get();
        return view('users.user_list_birthday',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try{
            $this->employeeRepo->createUsers($request);
            DB::commit();
            Toastr::success('Create employee successfully.','Success');
            return redirect('users');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create employee fail','Error');
            return redirect()->back();
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
        try{
            $this->employeeRepo->createUsers($request);
            DB::commit();
            Toastr::success('Create employee successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create employee fail','Error');
            return redirect()->back();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = User::where('id',$request->id)->with('role')->first();
        $role = Role::all();
        $position = Position::all();
        $department = Department::all();
        $optionGender = Option::where('type','gender')->get();
        $branch = Branchs::all();
        $optionIdentityType = Option::where('type','identity_type')->get();
        $optionPositionType = Option::where('type','position_type')->get();
        $optionLoan = Option::where('type','loan')->get();
        $optionSpouse = Option::where('type','is_spouse')->get();
        $bank = Bank::all();
        $province = Province::all();
        $district = District::where('province_id',$data->current_province)->orWhere("province_id",$data->permanent_province )->get();
        $conmmunes = Conmmunes::where('district_id',$data->current_district)->orWhere('district_id',$data->permanent_district)->get();
        $villages = Villages::where('commune_id',$data->current_commune)->orWhere('commune_id',$data->permanent_commune)->get();
        return response()->json([
            'success'=>$data,
            'role'=>$role,
            'position'=>$position,
            'department'=>$department,
            'optionGender'=>$optionGender,
            'branch'=>$branch,
            'optionIdentityType'=>$optionIdentityType,
            'bank'=>$bank,
            'province'=>$province,
            'district'=>$district,
            'conmmunes'=>$conmmunes,
            'villages'=>$villages,
            'optionPositionType'=>$optionPositionType,
            'optionLoan'=>$optionLoan,
            'optionSpouse'=>$optionSpouse
        ]);
    }

    public function print(Request $request)
    {
        $data = User::where("id", $request->id)
        ->with("branch")
        ->with("position")
        ->with("gender")
        ->with("positiontype")
        ->with("permanentprovince")
        ->with("currentprovince")
        ->with("currentdistrict")
        ->with("currentcommune")
        ->with("currentvillage")
        ->first();
        return response()->json([
            'success'=>$data,
        ]);
    }

    public function employImport(Request $request){
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $AllEmployee =  $spreadsheet->getSheetByName('Employee')->toArray();
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $i = 0;
            $dataArray = [];
            foreach ($AllEmployee as $item) {
                $i++;
                if ($i != 1) {
                    $employeeID = GenerateIdEmployee::where('number_employee',$item[0])->get();
                    if (count($employeeID) > 0) {
                        $dataArray[]= $employeeID;
                    }else{
                        $fullNameKH = $item[1].' '.$item[2];
                        $fullNameEN = $item[3].' '.$item[4];
                        $emp = User::create([
                            'number_employee'       => $item[0],
                            'employee_name_kh'      => $fullNameKH,
                            'employee_name_en'      => $fullNameEN,
                            'last_name_kh'          => $item[1],
                            'first_name_kh'         => $item[2],
                            'last_name_en'          => $item[3],
                            'first_name_en'         => $item[4],
                            'gender'                => $item[5],
                            'date_of_birth'         => $item[6] ? Carbon::createFromDate($item[6])->format('Y-m-d') : null,
                            'emp_status'            => $item[7],
                            'role_id'               => $item[8],
                            'date_of_commencement'  => $item[9] ? Carbon::createFromDate($item[9])->format('Y-m-d') : null,
                            'fdc_date'              => $item[10] ? Carbon::createFromDate($item[10])->format('Y-m-d'): null,
                            'fdc_end'               => $item[11] ? Carbon::createFromDate($item[11])->format('Y-m-d'): null,
                            'resign_date'           => $item[12] ? Carbon::createFromDate($item[12])->format('Y-m-d'): null,
                            'resign_reason'         => $item[13],
                            'branch_id'             => $item[14],
                            'department_id'         => $item[15],
                            'position_id'           => $item[16],
                            'position_type'         => $item[17],
                            'unit'                  => $item[18],
                            'level'                 => $item[19],
                            'nationality'           => $item[20],
                            'marital_status'        => $item[21],
                            'basic_salary'          => $item[22],
                            'phone_allowance'       => $item[23],
                            'guarantee_letter'      => 'INVITATION_Ingenico & Hengbao_11 Aug 2023_v3.pdf',
                            'employment_book'       => $item[25],
                            'personal_phone_number' => $item[26],
                            'company_phone_number'  => $item[27],
                            'agency_phone_number'   => $item[28],
                            'email'                 => $item[29],
                            'spouse'                => $item[30],
                            'is_loan'               => $item[31],
                            'identity_type'         => $item[32],
                            'identity_number'       => $item[33],
                            'issue_date'            => $item[34] ? Carbon::createFromDate($item[34])->format('Y-m-d') : null,
                            'issue_expired_date'    => $item[35] ? Carbon::createFromDate($item[35])->format('Y-m-d') : null,
                            'password'              => Hash::make($item[36]),
                            'type'                  => 'uploade',
                            'created_by'            => Auth::user()->id,
                        ]);
                        if($emp){
                            GenerateIdEmployee::create([
                                'employee_id'       => $emp->id,
                                'number_employee'   => $emp->number_employee,
                                'created_by'        => Auth::user()->id,
                            ]);
                        }
                    }
                }
            }
            if($dataArray){
                return response()->json(['error'=>$dataArray]);
            }
            return 1;
        } else {
            return 0;
        }
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
            $this->employeeRepo->updatedUsers($request);
            DB::commit();
            Toastr::success('Updated employee successfully.','Success');
            return redirect('users');
            // return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update employee fail','Error');
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
            GenerateIdEmployee::where('employee_id',$request->id)->delete();
            if ($request->profile) {
                unlink('uploads/images/'.$request->profile);
            }
            Toastr::success('User deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User delete fail','Error');
            return redirect()->back();
        }
    }

    public function reasonOption(Request $request){
        $options = Option::where("type", "emp_status")->get();
        return response()->json([
            'options' => $options
        ]);
    }

    public function processing(Request $request)
    {
        try {
            if ($request->emp_status == '1') {
                $dataSalary = User::where('id',$request->id)->first();
                $totalBasicSalary = $dataSalary->basic_salary + $request->total_salary_increase;
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'fdc_date' => $request->start_date,
                    'fdc_end' => $request->end_dete,
                    'severance_pay_date' => $request->end_dete,
                    'salary_increas' => $request->total_salary_increase,
                    'basic_salary' => $totalBasicSalary,
                    // 'total_current_salary' => $totalCurrentSalary,
                    // 'total_severancey_pay' => $totalnewSalary,
                    'pre_salary' => $dataSalary->basic_salary,
                    'resign_reason' => $request->resign_reason
                ]);
            }else if($request->emp_status == '10'){
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'fdc_date' => $request->start_date,
                    'fdc_end' => $request->end_dete,
                    'severance_pay_date' => $request->end_dete,
                    'resign_reason' => $request->resign_reason
                ]);
            }else if($request->emp_status == 2){
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'fdc_date' => $request->start_date,
                    'severance_pay_date' => $request->end_dete,
                    'udc_end_date' => $request->start_date,
                    'resign_reason' => $request->resign_reason
                ]);
            }else if($request->emp_status == "Probation"){
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'resign_reason' => $request->resign_reason
                ]);
            }else{
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'resign_date' => $request->resign_date,
                    'resign_reason' => $request->resign_reason
                ]);
            }
            EmployeeStatusHistory::create([
                'employee_id'   =>  $request->id,
                'status'        =>  $request->emp_status,
                'status_date'   =>  $request->start_date,
                'created_by'    =>  Auth::user()->id,
            ]);
            DB::commit();
            return ['message' => 'successfull'];
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }

    public function export(Request $request){
        $data = $this->employeeRepo->getAllUsers($request);
        $export = new ExportEmployee($data);
        return Excel::download($export, 'Employee.xlsx');
    }
}
