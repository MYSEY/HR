<?php

namespace App\Http\Controllers\Admins;

use App\Models\Bank;
use App\Models\Role;
use App\Models\User;
use App\Models\Lavel;
use App\Models\Option;
use App\Models\Branchs;
use App\Models\District;
use App\Models\Position;
use App\Models\Province;
use App\Models\Villages;
use App\Models\Conmmunes;
use App\Models\LeaveType;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Traits\GeneratingCode;
use Illuminate\Support\Carbon;
use App\Exports\ExportEmployee;
use App\Models\LeaveAllocation;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdated;
use App\Models\GenerateIdEmployee;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\EmployeeStatusHistory;
use App\Traits\UploadFiles\UploadFIle;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Spatie\Activitylog\Models\Activity;
use App\Repositories\Admin\EmployeeRepository;

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
        // $data = $this->employeeRepo->getAllUsers($request);
        // dd($data);
        $dataResign =[];
        $dataEmployees = [];
        if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'HR' || Auth::user()->RolePermission == 'developer' || Auth::user()->RolePermission == 'BOD' || Auth::user()->RolePermission == 'CEO') {
            $dataProbation = User::with('role')->with('department')->with('position')->where('emp_status','Probation')->get();
            $dataFDC = User::with('role')->with('department')->with('position')->whereIn('emp_status',['1','10'])->get();
            $dataUDC = User::with('role')->with('department')->with('position')->where('emp_status','2')->get();
            $dataCanContract = User::with('role')->with('department')->with('position')->where('emp_status','Cancel')->get();
            $dataResign = User::with('role')->with('department')->with('position')->whereIn('emp_status', ['3','4','5','6','7','8','9'])->get();
            $dataEmployees = User::whereIn('emp_status', ['Probation','1','2','10',])->get();
        }
        if (Auth::user()->RolePermission == 'HOD') {
            $department_ids = $this->employeeRepo->getRoleHOD();
            $dataProbation = User::with('role')->with('department')->with('position')
                ->whereIn("department_id", $department_ids)
                ->where('emp_status','Probation')->get();
            $dataFDC = User::with('role')->with('department')->with('position')
                ->whereIn("department_id",  $department_ids)
                ->whereIn('emp_status',['1','10'])->get();
            $dataUDC = User::with('role')->with('department')->with('position')
                ->whereIn("department_id",  $department_ids)
                ->where('emp_status','2')->get();
            $dataCanContract = User::with('role')->with('department')->with('position')
                ->whereIn("department_id",  $department_ids)
                ->where('emp_status','Cancel')->get();
            $dataResign = User::with('role')->with('department')->with('position')
                ->whereIn("department_id",  $department_ids)
                ->whereIn('emp_status', ['3','4','5','6','7','8','9'])->get();
        }
        if (Auth::user()->RolePermission == 'BM') {
            $dataProbation = User::with('role')->with('department')->with('position')
                ->where("branch_id", Auth::user()->branch_id)
                ->where('emp_status','Probation')->get();
            $dataFDC = User::with('role')->with('department')->with('position')
                ->where("branch_id", Auth::user()->branch_id)
                ->whereIn('emp_status',['1','10'])->get();
            $dataUDC = User::with('role')->with('department')->with('position')
                ->where("branch_id", Auth::user()->branch_id)
                ->where('emp_status','2')->get();
            $dataCanContract = User::with('role')->with('department')->with('position')
                ->where("branch_id", Auth::user()->branch_id)
                ->where('emp_status','Cancel')->get();
            $dataResign = User::with('role')->with('department')->with('position')
                ->where("branch_id", Auth::user()->branch_id)
                ->whereIn('emp_status', ['3','4','5','6','7','8','9'])->get();
        }
        if(Auth::user()->RolePermission == 'Employee'){
            $dataProbation = User::with('role')->with('department')->with('position')->where('id',Auth::user()->id)
                ->where('emp_status','Probation')->get();
            $dataFDC = User::with('role')->with('department')->with('position')->where('id',Auth::user()->id)
                ->whereIn('emp_status',['1','10'])->get();
            $dataUDC = User::with('role')->with('department')->with('position')->where('id',Auth::user()->id)
                ->where('emp_status','2')->get();
            $dataCanContract = User::where('id',Auth::user()->id)->where('emp_status','Cancel')->with('department')->with('position')->get();
            $dataResign = User::where('id',Auth::user()->id)->whereIn('emp_status', ['3','4','5','6','7','8','9'])->with('department')->with('position')->get();
        }
        return view('users.index',compact(
            // 'data',
            'dataProbation',
            'dataFDC',
            'dataUDC',
            'dataCanContract',
            'dataResign',
            'dataEmployees',
        ));
    }

    public function formCreate() {
        $role = Role::whereNotIn("role_type",['admin', 'developer'])->get();
        $position = Position::all();
        $department = Department::all();
        $optionStatus = Option::where('type','status')->get();
        $autoEmpId   = $this->generate_EmployeeId(Carbon::today())['number_employee'];
        $optionGender = Option::where('type','gender')->get();
        $optionPositionType = Option::where('type','position_type')->get();
        $optionLoan = Option::where('type','loan')->get();
        $optionSpouse = Option::where('type','is_spouse')->get();
        $optionIdentityType = Option::where('type','identity_type')->get();
        $maritalStatus = Option::where('type','marital_status')->get();
        $nationality = Option::where('type','nationality')->get();
        $branch = Branchs::all();
        $province = Province::all();
        $bank = Bank::all();
        $lavel = Lavel::all();
        $lineManager = User::join('roles', 'users.role_id', '=', 'roles.id')
        ->select(
            'users.*',
            'roles.role_type',
        )->whereNotIn('roles.role_type',['Employee','admin','developer'])->get();
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
            'maritalStatus',
            'nationality',
            'lavel',
            'lineManager',
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
        $month = Carbon::now()->format('m');
        $monthAdd = Carbon::now()->addDays(14)->format('m');
        $data = User::whereIn('emp_status',['1','2','10','Probation'])
        ->whereRaw('MONTH(date_of_birth) IN ('.$month.','.$monthAdd.')')->get();
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
            Activity::all()->last();
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
        // try{
        //     $this->employeeRepo->createUsers($request);
        //     DB::commit();
        //     Toastr::success('Create employee successfully.','Success');
        //     return redirect()->back();
        // }catch(\Exception $e){
        //     DB::rollback();
        //     Toastr::error('Create employee fail','Error');
        //     return redirect()->back();
        // }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $role = Role::whereNotIn("role_type",['admin', 'developer'])->get();
        $data = User::where('id',$request->id)->with('role')->first();
        $position = Position::all();
        $department = Department::all();
        $optionGender = Option::where('type','gender')->get();
        $branch = Branchs::all();
        $optionIdentityType = Option::where('type','identity_type')->get();
        $optionPositionType = Option::where('type','position_type')->get();
        $optionLoan = Option::where('type','loan')->get();
        $optionSpouse = Option::where('type','is_spouse')->get();
        $maritalStatus = Option::where('type','marital_status')->get();
        $nationality = Option::where('type','nationality')->get();
        $bank = Bank::all();
        $lavel = Lavel::all();
        $lineManager = User::join('roles', 'users.role_id', '=', 'roles.id')
        ->select(
            'users.*',
            'roles.role_type',
        )->whereNotIn('roles.role_type',['employee','admin','developer'])->get();
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
            'optionSpouse'=>$optionSpouse,
            'maritalStatus'=>$maritalStatus,
            'nationality'=>$nationality,
            'lavel'=>$lavel,
            'lineManager'=>$lineManager,
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
                        $emp = User::firstOrCreate([
                            'number_employee'       => $item[0],
                            'employee_name_kh'      => $fullNameKH,
                            'employee_name_en'      => $fullNameEN,
                            'last_name_kh'          => $item[1],
                            'first_name_kh'         => $item[2],
                            'last_name_en'          => $item[3],
                            'first_name_en'         => $item[4],
                            'id_card_number'        => $item[5],
                            'gender'                => $item[6],
                            'date_of_birth'         => $item[7] ? Carbon::createFromDate($item[7])->format('Y-m-d') : null,
                            'emp_status'            => $item[8],
                            'role_id'               => $item[9],
                            'date_of_commencement'  => $item[10] ? Carbon::createFromDate($item[10])->format('Y-m-d') : null,
                            'fdc_date'              => $item[11] ? Carbon::createFromDate($item[11])->format('Y-m-d'): null,
                            'fdc_end'               => $item[12] ? Carbon::createFromDate($item[12])->format('Y-m-d'): null,
                            'udc_end_date'          => $item[13] ? Carbon::createFromDate($item[13])->format('Y-m-d'): null,
                            'resign_date'           => $item[14] ? Carbon::createFromDate($item[14])->format('Y-m-d'): null,
                            'resign_reason'         => $item[15],
                            'branch_id'             => $item[16],
                            'department_id'         => $item[17],
                            'position_id'           => $item[18],
                            'unit'                  => $item[19],
                            'level'                 => $item[20],
                            'marital_status'        => $item[21],
                            'basic_salary'          => $item[22],
                            'phone_allowance'       => $item[23],
                            'personal_phone_number' => $item[24],
                            'company_phone_number'  => $item[25],
                            'agency_phone_number'   => $item[26],
                            'email'                 => $item[27],
                            'spouse'                => $item[28],
                            'is_loan'               => $item[29],
                            'identity_type'         => $item[30],
                            'identity_number'       => $item[31],
                            'issue_date'            => $item[32] ? Carbon::createFromDate($item[32])->format('Y-m-d') : null,
                            'issue_expired_date'    => $item[33] ? Carbon::createFromDate($item[32])->format('Y-m-d') : null,
                            'password'              => Hash::make($item[34]),
                            'type'                  => 'uploade',
                            'created_by'            => Auth::user()->id,
                            'status'                => 'Active',
                        ]);
                        if($emp){
                            GenerateIdEmployee::firstOrCreate([
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
        $line_manager = User::where("line_manager", '=', $request->line_manager_id)->count();
        $dataEmployee = [];
        if ($line_manager > 0 ) {
            $dataEmployee =  User::whereIn("emp_status", ["Probation", "1", "2", "10"])->get();
        }
        return response()->json([
            'options' => $options,
            'dataEmployee'=> $dataEmployee
        ]);
    }

    public function processing(Request $request)
    {
        try {
            $totalUpcomings = 0;
            if ($request->emp_status == '1') {
                $dataSalary = User::where('id',$request->id)->first();
                $leaveRequest = LeaveAllocation::where('employee_id',$dataSalary->id)->first();
                $totalRequestLeave = 0;
                if ($leaveRequest) {
                    $totalRequestLeave = $leaveRequest->total_annual_leave;
                }
                
                $toJoinDate  = Carbon::parse($dataSalary->date_of_commencement);
                $yearLy = Carbon::now()->format('Y');
                $toJoinDateYear = Carbon::createFromDate($toJoinDate)->format('Y');
                $startFormYear = Carbon::parse($yearLy."-01-01");
                
                $endJoinDate = Carbon::parse($dataSalary->fdc_date);
                $monthInProbation = $startFormYear->diffInMonths($endJoinDate);
                $totalDayInProbation = $monthInProbation * 1.5;
                $year_1 = 0;
                if ($yearLy != $toJoinDateYear) {
                    $endDate = $toJoinDateYear."-12-31";
                    $monthBefor = $toJoinDate->diffInMonths($endDate);
                    $year_1 = $monthBefor * 1.5;
                }
                
                // dd($totalDayInProbation);
                //total day in monthsd
                $start_date = Carbon::createFromDate($request->start_date);
                $endMonth = Carbon::createFromDate($request->start_date)->endOfMonth();
                $end_date = Date::createFromDate($endMonth);
                $commencementDate   = Carbon::parse($start_date);
                $resumptionDate     = Carbon::parse($end_date);
                $toDays 		    = $resumptionDate->diffInWeekdays($commencementDate) + 1;
                
                $toDate = Carbon::parse($request->start_date);
                $yearLy = Carbon::now()->format('Y');
                $fromDate = $yearLy."-12-31";
                $months = $toDate->diffInMonths($fromDate);
                if ($toDays < 15) {
                    $totalDay = 0;
                    $EndMonths = $months - 1;
                } elseif($toDays >= 15 && $toDays <= 20) {
                    $totalDay = 1;
                    $EndMonths = $months - 1;
                }else{
                    $totalDay = 1.5;
                    $EndMonths = $months;
                }
                
                $leaveType = LeaveType::get();
                // $total_day = 0;
                foreach ($leaveType as $key => $lt) {
                    if ($lt->type == "annual_leave") {
                        $totalDayAnnualLeave = (($lt->default_day / 12) * $EndMonths + $totalDay + $totalDayInProbation);
                        $data['default_annual_leave'] = $totalDayAnnualLeave;
                        $data['total_annual_leave'] = $totalDayAnnualLeave - abs($totalRequestLeave);
                    }else if($lt->type == "sick_leave") {
                        $totalDaySickLeave = (($lt->default_day / 12) * $EndMonths + $totalDay);
                        $data['default_sick_leave'] = $totalDaySickLeave;
                        $data['total_sick_leave'] = $totalDaySickLeave;
                    }else if($lt->type == "special_leave"){
                        $totalDaySpecialLeave = (($lt->default_day / 12) * $EndMonths + $totalDay);
                        $data['default_special_leave'] = $totalDaySpecialLeave;
                        $data['total_special_leave'] = $totalDaySpecialLeave;
                    }else{
                        $data['default_unpaid_leave'] = 0;
                        $data['total_unpaid_leave'] = 0;
                    }
                }
                
                LeaveAllocation::updateOrCreate(
                    [
                        'employee_id' => $dataSalary->id,
                    ],
                    [
                        'default_annual_leave' => $data['default_annual_leave'],
                        'total_annual_leave' => $data['total_annual_leave'],
                        'default_sick_leave' => $data['default_sick_leave'],
                        'total_sick_leave' => $data['total_sick_leave'],
                        'default_special_leave' => $data['default_special_leave'],
                        'total_special_leave' => $data['total_special_leave'],
                        'default_unpaid_leave' => 0,
                        'total_unpaid_leave' => 0,
                        'year_1' => $year_1,
                        'created_by'    =>  Auth::user()->id,
                    ]
                );

                //function update users
                $totalBasicSalary = $dataSalary->basic_salary + $request->total_salary_increase;
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'fdc_date' => $request->start_date,
                    'fdc_end' => $request->end_dete,
                    'udc_end_date' => $request->start_date,
                    'salary_increas' => $request->total_salary_increase,
                    'basic_salary' => $totalBasicSalary,
                    'pre_salary' => $dataSalary->basic_salary,
                    'resign_reason' => $request->resign_reason
                ]);
            }else if($request->emp_status == '10'){
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'fdc_date' => $request->start_date,
                    'fdc_end' => $request->end_dete,
                    'udc_end_date' => $request->start_date,
                    'resign_reason' => $request->resign_reason
                ]);
            }else if($request->emp_status == 2){
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'fdc_date' => $request->start_date,
                    'udc_end_date' => $request->start_date,
                    'resign_reason' => $request->resign_reason
                ]);
            }else if($request->emp_status == "Probation"){
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'resign_reason' => $request->resign_reason
                ]);
                $totalUpcomings = User::where('emp_status','Upcoming')->count();
            }else{
                if($request->line_manager){
                    User::where('line_manager',$request->id)->update([
                        "line_manager"=> $request->line_manager
                    ]);
                };

                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'resign_date' => $request->resign_date,
                    'status' => 'Unactive',
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
            return ['message' => 'successfull', "totalUpcomings"=>$totalUpcomings];
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

    public function lineManagere(Request $request) {
        $line_manager = User::where("line_manager", '=', $request->line_manager_id)->count();
        $dataEmployee = [];
        if ($line_manager > 0 ) {
            $dataEmployee =  User::whereIn("emp_status", ["Probation", "1", "2", "10"])->get();
        }
        return response()->json([
            'datas' => $dataEmployee
        ]);
    }
    public function updateLineManager(Request $request){
        try {
            User::whereIn('id',$request->employee_ids)->update([
                "line_manager"=> $request->line_manager
            ]);
            DB::commit();
            Toastr::success('Update line manager successfull.','Success');
            return redirect()->back();
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }
}
