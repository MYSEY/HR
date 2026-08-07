<?php

namespace App\Http\Controllers\Admins;

use App\Models\Bank;
use App\Models\Role;
use App\Models\User;
use App\Models\Lavel;
use App\Models\Option;
use App\Models\Branchs;
use App\Models\Contact;
use App\Models\District;
use App\Models\Position;
use App\Models\Province;
use App\Models\Villages;
use App\Models\Conmmunes;
use App\Models\Education;
use App\Models\LeaveType;
use App\Models\Department;
use App\Models\Experience;
use App\Models\Transferred;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Models\ChildrenInfor;
use App\Models\StaffPromoted;
use App\Models\StaffTraining;
use App\Traits\GeneratingCode;
use Illuminate\Support\Carbon;
use App\Exports\ExportEmployee;
use App\Models\LeaveAllocation;
use Illuminate\Http\JsonResponse;
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
use Illuminate\Support\Str;
use App\Models\CandidateResume;

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
        $permission = DB::table('permissions')
            ->where('role_id', Auth::user()->role_id)
            ->where("url", "users")
            ->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $dataResign =[];
        $dataEmployees = [];
        if (in_array(Auth::user()->RolePermission, ['admin','HRAdmin','developer','BOD','CEO'])){
            $dataProbation = User::with('role')->with('department')->with('position')->where('emp_status','Probation')->orderBy('date_of_commencement', 'desc');
            $dataFDC = User::with('role')->with('department')->with('position')->whereIn('emp_status',['1','10']);
            $dataUDC = User::with('role')->with('department')->with('position')->where('emp_status','2');
            $dataResign = User::with('role')->with('department')->with('position')->whereIn('emp_status', ['3','4','5','6','7','8','9'])->orderBy('resign_date', 'desc');
            $dataEmployees = User::whereIn('emp_status', ['Probation','1','2','10',])->orderBy('id', 'DESC')->get();
        }
        if (Auth::user()->RolePermission == 'HR' && $permission->is_access == "1") {
            $dataProbation = User::with('role')->with('department')->with('position')->where('emp_status','Probation')->orderBy('date_of_commencement', 'desc');
            $dataFDC = User::with('role')->with('department')->with('position')->whereIn('emp_status',['1','10']);
            $dataUDC = User::with('role')->with('department')->with('position')->where('emp_status','2');
            $dataResign = User::with('role')->with('department')->with('position')->whereIn('emp_status', ['3','4','5','6','7','8','9'])->orderBy('resign_date', 'desc');
            $dataEmployees = User::whereIn('emp_status', ['Probation','1','2','10',])->orderBy('id', 'DESC')->get();
        }
        if (in_array(Auth::user()->RolePermission, ['HR','DHOD','DBM']) && $permission->is_access != "1"){
            $department_ids = $this->employeeRepo->getRoleHOD();
            $dataProbation = User::with('role')->with('department')->with('position')->where("line_manager", Auth::user()->id)
            ->when(Auth::user()->emp_status, function ($query, $emp_status) {
                if ($emp_status == "Probation") {
                    $query->orWhere("id", Auth::user()->id);
                }
            })->where('emp_status','Probation')->orderBy('date_of_commencement', 'desc');

            $dataFDC = User::with('role')->with('department')->with('position')->whereIn('emp_status',['1','10'])->where("line_manager", Auth::user()->id)->when(Auth::user()->emp_status, function ($query, $emp_status) {
                if ($emp_status == "1" || $emp_status == "10") {
                    $query->orWhere("id", Auth::user()->id);
                }
            })->whereIn('emp_status',['1','10']);

            $dataUDC = User::with('role')->with('department')->with('position')->where("line_manager", Auth::user()->id)->where('emp_status','2')
            ->when(Auth::user()->emp_status, function ($query, $emp_status) {
                if ($emp_status == "2") {
                    $query->orWhere("id", Auth::user()->id);
                }
            });

            $dataResign = User::with('role')->with('department')->with('position')->where("line_manager", Auth::user()->id)
            ->whereIn('emp_status', ['3','4','5','6','7','8','9'])->orderBy('resign_date', 'desc');
        }
        if (Auth::user()->RolePermission == 'HOD') {
            $department_ids = $this->employeeRepo->getRoleHOD();
            $dataProbation = User::with('role')->with('department')->with('position')->whereIn("department_id", $department_ids)->where('emp_status','Probation')->orderBy('date_of_commencement', 'desc');
            $dataFDC = User::with('role')->with('department')->with('position')->whereIn("department_id",  $department_ids)->whereIn('emp_status',['1','10']);
            $dataUDC = User::with('role')->with('department')->with('position')->whereIn("department_id",  $department_ids)->where('emp_status','2');
            $dataResign = User::with('role')->with('department')->with('position')->whereIn("department_id",  $department_ids)->whereIn('emp_status', ['3','4','5','6','7','8','9'])->orderBy('resign_date', 'desc');
        }
        if (Auth::user()->RolePermission == 'BM') {
            $dataProbation = User::with('role')->with('department')->with('position')->where("branch_id", Auth::user()->branch_id)->where('emp_status','Probation')->orderBy('date_of_commencement', 'desc');
            $dataFDC = User::with('role')->with('department')->with('position')->where("branch_id", Auth::user()->branch_id)->whereIn('emp_status',['1','10']);
            $dataUDC = User::with('role')->with('department')->with('position')->where("branch_id", Auth::user()->branch_id)->where('emp_status','2');
            $dataResign = User::with('role')->with('department')->with('position')->where("branch_id", Auth::user()->branch_id)->whereIn('emp_status', ['3','4','5','6','7','8','9'])->orderBy('resign_date', 'desc');
        }

        if(Auth::user()->RolePermission == 'Employee'){
            $dataProbation = User::with('role')->with('department')->with('position')->where('emp_status','Probation')->where('id',Auth::user()->id)->orderBy('date_of_commencement', 'desc');
            $dataFDC = User::with('role')->with('department')->with('position')->whereIn('emp_status',['1','10'])->where('id',Auth::user()->id);
            $dataUDC = User::with('role')->with('department')->with('position')->where('emp_status','2')->where('id',Auth::user()->id);
            $dataResign = User::with('role')->with('department')->with('position')->whereIn('emp_status', ['3','4','5','6','7','8','9'])->where('id',Auth::user()->id);
        }

        // if (Auth::user()->RolePermission != 'Employee') {
            $perPageSettings = [
                'per_page1' => ['data' => $dataProbation, 'result' => null],
                'per_page2' => ['data' => $dataFDC, 'result' => null],
                'per_page3' => ['data' => $dataUDC, 'result' => null],
                'per_page4' => ['data' => $dataResign, 'result' => null],
            ];
        
            foreach ($perPageSettings as $param => &$setting) {
                // Retrieve the 'per_page' parameter and ensure it's numeric
                $perPage = $request->get($param, 10);
            
                // If 'per_page' is not numeric, set it to a default value
                if (!is_numeric($perPage) && $perPage !== 'all') {
                    $perPage = 10;
                }
            
                // Ensure $setting['data'] is a Query Builder before calling paginate()
                if ($setting['data'] instanceof \Illuminate\Database\Eloquent\Builder) {
                    if ($perPage === 'all') {
                        $allData = $setting['data']->get(); // Get all records
                        $setting['result'] = new \Illuminate\Pagination\LengthAwarePaginator(
                            $allData,
                            $allData->count(),
                            $allData->count(),
                            1,
                            ['path' => $request->url(), 'query' => $request->query()]
                        );
                    } else {
                        $setting['result'] = $setting['data']->paginate($perPage);
                    }
                } else {
                    // Handle cases where $setting['data'] is already a Collection (to prevent errors)
                    $setting['result'] = $setting['data'];
                }
            }
            
            $dataProbation = $perPageSettings['per_page1']['result'];
            $dataFDC = $perPageSettings['per_page2']['result'];
            $dataUDC = $perPageSettings['per_page3']['result'];
            $dataResign = $perPageSettings['per_page4']['result'];
        // }
        
        return view('users.index',compact(
            'permission',
            'dataProbation',
            'dataFDC',
            'dataUDC',
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
        )->whereNotIn('roles.role_type',['Employee','admin','developer'])->get()->makeHidden(['salary', 'basic_salary', 'salary_increas', 'phone_allowance','pre_salary']);
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
        $permission = DB::table('permissions')
            ->where('role_id', Auth::user()->role_id)
            ->where("url", "users")
            ->first();
        return view('users.form_edit', compact(
            'permission',
        ));
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
        $data = User::where('id',$request->id)->with('role')->first()->makeHidden(['salary', 'basic_salary', 'salary_increas', 'phone_allowance','pre_salary']);
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
        )->whereNotIn('roles.role_type',['employee','admin','developer'])->get()->makeHidden(['salary', 'basic_salary', 'salary_increas', 'phone_allowance','pre_salary']);
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
        ->with("lineManager")
        ->with("branch")
        ->with("position")
        ->with("gender")
        ->with("positiontype")
        ->with("permanentprovince")
        ->with("permanentdistrict")
        ->with("permanentcommune")
        ->with("permanentvillage")
        ->with("currentprovince")
        ->with("currentdistrict")
        ->with("currentcommune")
        ->with("currentvillage")
        ->with("recruitment")
        ->first();
        $branch = Branchs::where("abbreviations","HQ")
            ->leftJoin('users', 'branchs.direct_manager_id', '=', 'users.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->select(
                'branchs.*',
                'users.number_employee',
                'users.employee_name_kh',
                'users.employee_name_en',
                'users.line_manager',
                'users.department_id',
                'users.branch_id',
                'users.position_id',
                'positions.name_english',
                'positions.name_khmer',
            )
            ->first();
        return response()->json([
            'success'=>$data,
            'branch'=>$branch,
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

    public function updateRole(Request $request){
        try{
            User::where('id',$request->id)->update([
                "role_id"=> $request->role_id,
                'updated_by'    =>  Auth::user()->id,
            ]);
            DB::commit();
            Toastr::success('Updated role successfully.','Success');
            return redirect('users');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update role fail','Error');
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

        function convertNumber($value)
        {
            $int = floor($value);                  // whole number part
            $decimal = $value - $int;             // decimal part only

            if ($decimal >= 0.50) {
                return $int + 1;                  // round up to next integer
            } else {
                return $int + 0.5;                // convert to .5
            }
        }
       
        try {
            $totalUpcomings = 0;
            if ($request->emp_status == '1') {
                $dataSalary = User::where('id',$request->id)->first();
                $leaveRequest = LeaveAllocation::where('employee_id',$dataSalary->id)->first();
                $data_request = [
                    "total_annual_leave" => 0,
                    "total_sick_leave" => 0,
                    "total_special_leave" => 0,
                ];
                if($leaveRequest){
                    $data_request = [
                        "total_annual_leave" => $leaveRequest->total_annual_leave,
                        "total_sick_leave" => $leaveRequest->total_sick_leave,
                        "total_special_leave" => $leaveRequest->total_special_leave,
                    ];
                }
                
                //*** total annual_leave in probation */
                $toJoinDate  = Carbon::parse($dataSalary->date_of_commencement);
                $endJoinDate = Carbon::parse($dataSalary->fdc_date);
                $monthInProbation = $toJoinDate->diffInMonths($endJoinDate);
                $totalDayInProbation = 1.5 * $monthInProbation;
                // dd($totalDayInProbation);
                //** end */

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
                }else if($toDays >= 15 && $toDays <= 20) {
                    $totalDay = 1;
                    $EndMonths = $months - 1;
                }else{
                    $totalDay = 1.5;
                    $EndMonths = $months;
                }

                $leaveType = LeaveType::get();
                foreach ($leaveType as $key => $lt) {
                    $detault_total_day = ($lt->default_day / 12);
                    if($toDays > 20 ){
                        $total_sick_leave = $detault_total_day;
                    }else {
                        $total_sick_leave = 0;
                    }
                    $total_pass = $detault_total_day * $EndMonths;
                    $default_annual_leave = $total_pass + $totalDay + $totalDayInProbation;

                    if ($lt->type == "annual_leave") {
                        $data['default_annual_leave'] = convertNumber($default_annual_leave);
                        $data['total_annual_leave'] = convertNumber($default_annual_leave) - abs($data_request["total_annual_leave"]);
                    }else if($lt->type == "sick_leave") {
                        $totalDayAnnualLeave = $total_pass + $total_sick_leave;
                        $data['default_sick_leave'] = convertNumber($totalDayAnnualLeave);
                        $data['total_sick_leave'] = convertNumber($totalDayAnnualLeave) - abs($data_request["total_sick_leave"]);
                    }else if($lt->type == "special_leave"){
                        $data['default_special_leave'] = $lt->default_day;
                        $data['total_special_leave'] = $lt->default_day - abs($data_request["total_special_leave"]);
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
                        'year_1' => null,
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
            }
            else if($request->emp_status == '10'){
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
                DB::table('users')
                ->where('id', $request->id)
                ->update([
                    'emp_status' => $request->emp_status,
                    'resign_reason' => $request->resign_reason,
                ]);
                $totalUpcomings = User::where('emp_status','Upcoming')->count();
            }else{
                if($request->line_manager){
                    User::where('line_manager',$request->id)->update([
                        "line_manager"=> $request->line_manager
                    ]);
                };
                if ($request->emp_status == "Cancel") {
                    $users = User::where('id',$request->id)->first();
                    GenerateIdEmployee::where("number_employee",$users->number_employee)->delete();
                    CandidateResume::where('number_employee',$users->number_employee)->update([ 'number_employee' => 'CC-'.$users->number_employee]);
                    $users->number_employee = "CC-".$users->number_employee;
                    $users->emp_status = $request->emp_status;
                    $users->resign_date = $request->resign_date;
                    $users->resign_reason = $request->resign_reason;
                    $users->status = 'Unactive';
                    $users->save();
                }else{
                    $users = User::where('id',$request->id)->first();
                    //function find days in end month
                    $endMonth = Carbon::createFromDate($request->resign_date)->format('m');
                    $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
                    //find start date employee join date
                    $date_of_month = Carbon::createFromDate($request->resign_date)->format('Y-m');
                    $currentYear = $date_of_month.'-'.'01';
                    //find total working day in month
                    $startDate = Carbon::parse($request->resign_date);
                    $endDate = Carbon::parse($currentYear);
                    $totalDayStaffResign 		    = $endDate->diffInWeekdays($startDate);
                    
                    if ($totalDayStaffResign == 0) {
                        $totalSalaryStaffResign = $users->basic_salary;
                    } else {
                        $totalSalaryStaffResign = ($users->basic_salary * $totalDayStaffResign) / 22;
                    }
                    if($users->emp_status == "Probation"){
                        // *** Caculate leave day**/
                        if(in_array($request->emp_status, ['3','4','5','6','7','9'])){
                            $leaveRequest = LeaveAllocation::where('employee_id',$users->id)->first();
                            $data_request = [
                                "total_annual_leave" => 0,
                                "total_sick_leave" => 0,
                                "total_special_leave" => 0,
                            ];
                            if($leaveRequest){
                                $data_request = [
                                    "total_annual_leave" => $leaveRequest->total_annual_leave,
                                    "total_sick_leave" => $leaveRequest->total_sick_leave,
                                    "total_special_leave" => $leaveRequest->total_special_leave,
                                ];
                            }

                            $start_date = Carbon::createFromDate($users->date_of_commencement)->format('d-m-Y');
                            $resign_date = Carbon::createFromDate($request->resign_date)->format('d-m-Y');
                            $start_day = Carbon::createFromDate($users->date_of_commencement)->format('d');

                            $end_day = Carbon::createFromDate($request->resign_date)->format('d');
                            $end_month = Carbon::createFromDate($request->resign_date)->format('m-Y');

                            if($start_date >= $resign_date){
                                $end_date = $start_day.'-'.$end_month;
                            }else{
                                $end_date = $end_day.'-'.$end_month;
                            }
                            $join_date = Carbon::createFromDate($users->date_of_commencement);
                            $total_month = $join_date->diffInMonths($end_date);
                            if($total_month == 0){
                                $totalWorkingDay = $join_date->diffInWeekdays($startDate);
                                //*** special case */
                                $total_sick_leave = 0;
                                if ($totalWorkingDay < 15) {
                                    $totalDay = 0;
                                }else if($totalWorkingDay >= 15 && $totalWorkingDay <= 20) {
                                    $totalDay = 1;
                                }else{
                                    $totalDay = 1.5;
                                }

                                if($totalWorkingDay > 20 ){
                                    $total_sick_leave = 1;
                                }else {
                                    $total_sick_leave = 0;
                                }
                                $dataLeaveAllocation['default_annual_leave'] = $totalDay;
                                $dataLeaveAllocation['total_annual_leave'] = $totalDay - abs($data_request["total_annual_leave"]);
                                $dataLeaveAllocation['default_sick_leave'] = $total_sick_leave;
                                $dataLeaveAllocation['total_sick_leave'] = $total_sick_leave - abs($data_request["total_sick_leave"]);
                                $dataLeaveAllocation['default_special_leave'] = 22;
                                $dataLeaveAllocation['total_special_leave'] = 22 - abs($data_request["total_special_leave"]);
                                //*** end */
                            }else{
                                $end_date = $start_day.'-'.$end_month;
                                $joinResign = Carbon::createFromDate($end_date);
                                $totalWorkingDay = $joinResign->diffInWeekdays($startDate);

                                //*** special case */
                                $total_sick_leave = 0;
                                if ($totalWorkingDay < 15) {
                                    $totalDay = 0;
                                }else if($totalWorkingDay >= 15 && $totalWorkingDay <= 20) {
                                    $totalDay = 1;
                                }else{
                                    $totalDay = 1.5;
                                }
                                //*** end */
                                $leaveType = LeaveType::get();
                                foreach ($leaveType as $key => $lt) {
                                    $detault_total_day = ($lt->default_day / 12);
                                    if($totalWorkingDay > 20 ){
                                        $total_sick_leave = $detault_total_day;
                                    }else {
                                        $total_sick_leave = 0;
                                    }
                                    $total_day_inprobation = $detault_total_day * $total_month;
                                    $default_annual_leave = $total_day_inprobation + $totalDay;

                                    if ($lt->type == "annual_leave") {
                                        $dataLeaveAllocation['default_annual_leave'] = convertNumber($default_annual_leave);
                                        $dataLeaveAllocation['total_annual_leave'] = convertNumber($default_annual_leave) - abs($data_request["total_annual_leave"]);
                                    }else if($lt->type == "sick_leave") {
                                        $totalDayAnnualLeave = $total_day_inprobation + $total_sick_leave;
                                        $dataLeaveAllocation['default_sick_leave'] = convertNumber($totalDayAnnualLeave);
                                        $dataLeaveAllocation['total_sick_leave'] = convertNumber($totalDayAnnualLeave) - abs($data_request["total_sick_leave"]);
                                    }else if($lt->type == "special_leave"){
                                        $dataLeaveAllocation['default_special_leave'] = $lt->default_day;
                                        $dataLeaveAllocation['total_special_leave'] = $lt->default_day - abs($data_request["total_special_leave"]);
                                    }else{
                                        $dataLeaveAllocation['default_unpaid_leave'] = 0;
                                        $dataLeaveAllocation['total_unpaid_leave'] = 0;
                                    }
                                }
                            }
                            LeaveAllocation::updateOrCreate(
                                [
                                    'employee_id' => $users->id,
                                ],
                                [
                                    'default_annual_leave' => $dataLeaveAllocation['default_annual_leave'],
                                    'total_annual_leave' => $dataLeaveAllocation['total_annual_leave'],
                                    'default_sick_leave' => $dataLeaveAllocation['default_sick_leave'],
                                    'total_sick_leave' => $dataLeaveAllocation['total_sick_leave'],
                                    'default_special_leave' => $dataLeaveAllocation['default_special_leave'],
                                    'total_special_leave' => $dataLeaveAllocation['total_special_leave'],
                                    'default_unpaid_leave' => 0,
                                    'total_unpaid_leave' => 0,
                                    // 'year_1' => $year_1,
                                    'created_by'    =>  Auth::user()->id,
                                ]
                            );
                        
                        }
                    }
                    
                    // *** end **/
                    User::where('id',$request->id)->update([
                        'emp_status' => $request->emp_status,
                        'resign_date' => $request->resign_date,
                        'pre_salary' => $users->basic_salary,
                        'basic_salary' => $totalSalaryStaffResign,
                        'status' => 'Unactive',
                        'resign_reason' => $request->resign_reason
                    ]);
                }
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
    public function duplicateEmployeeId(Request $request){
        try {
            $duplicate_employee_id = GenerateIdEmployee::where("number_employee",$request->number_employee)->first();
            DB::commit();
            if ($duplicate_employee_id) {
                return ['message' => 'Employee ID already exists', "data"=>1];
            }else{
                return ['message' => 'Employee ID does not exist', "data"=>0];
            }
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }
    public function autocomplet(Request $request) : JsonResponse{
        try{
            $search = $request->search;
            $data = DB::table("users")->select("id","number_employee")->where('number_employee','LIKE',"%$search%")->pluck('number_employee');
            return response()->json($data);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }

    public function str_replace($text)
    {
        $shortlist = Str::lower($text);
        $shortlistSpaces = str_replace(' ', '', $shortlist);
        return $shortlistSpaces;
    }

    public function importUpdateEmployee(Request $request){
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $allSheetNames = $spreadsheet->getSheetNames();
            foreach ($allSheetNames as $sheetName) {
                // $employees =  $spreadsheet->getSheetByName('Employee')->toArray();
                if ($sheetName == "Employee") {
                    $i = 0;
                    $employees =  $spreadsheet->getSheetByName($sheetName)->toArray();
                    foreach ($employees as $item) {
                        $i++;
                        if ($i > 2) {
                            
                            $dataUpdateEmployee = user::where('number_employee',$item[0])->first();
                            $spouse = $this->str_replace($item[9]) == "yes" ? 1 : 0;
                            $type_of_employees_nssf = $this->str_replace($item[15]) == "residents" ? 1 : 2;
                            $spouse_nssf = $this->str_replace($item[16]) == "yes" ? 1 : 2;
                            $status_nssf = $this->str_replace($item[17]) == "working" ? 1 : 2;
                            if ($dataUpdateEmployee) {
                                    /** block Bank Infor */
                                    $dataUpdateEmployee['bank_name']                = $item[1];
                                    $dataUpdateEmployee['account_name']             = $item[2];
                                    $dataUpdateEmployee['account_number']           = $item[3];
                                    /** block Profile */
                                    $dataUpdateEmployee['agency_phone_number']      = $item[4];
                                    /** block Personal Informations */
                                    $dataUpdateEmployee['nationality']              = $item[5];
                                    $dataUpdateEmployee['ethnicity']                = $item[6];
                                    $dataUpdateEmployee['marital_status']           = $item[7];
                                    $dataUpdateEmployee['id_card_number']           = $item[8];
                                    $dataUpdateEmployee['spouse']                   = $spouse;
                                    $dataUpdateEmployee['identity_type']            = $item[10];
                                    $dataUpdateEmployee['identity_number']          = $item[11];
                                    $dataUpdateEmployee['issue_date']               = $item[12] ? Carbon::createFromDate($item[12])->format('Y-m-d') : null;
                                    $dataUpdateEmployee['issue_expired_date']       = $item[13] ? Carbon::createFromDate($item[13])->format('Y-m-d') : null;
                                    
                                    /** block Information NSSF */
                                    $dataUpdateEmployee['id_number_nssf']           = $item[14];
                                    $dataUpdateEmployee['type_of_employees_nssf']   = $type_of_employees_nssf;
                                    $dataUpdateEmployee['spouse_nssf']              = $spouse_nssf;
                                    $dataUpdateEmployee['status_nssf']              = $status_nssf;
        
                                    /** block Current Address */
                                    $dataUpdateEmployee['current_province']         = $item[18];
                                    $dataUpdateEmployee['current_district']         = $item[19];
                                    $dataUpdateEmployee['current_commune']          = $item[20];
                                    $dataUpdateEmployee['current_village']          = $item[21];
                                    $dataUpdateEmployee['current_street_no']        = $item[22];
                                    $dataUpdateEmployee['current_house_no']         = $item[23];
        
                                    /** block Permanent Address */
                                    $dataUpdateEmployee['permanent_province']       = $item[24];
                                    $dataUpdateEmployee['permanent_district']       = $item[25];
                                    $dataUpdateEmployee['permanent_commune']        = $item[26];
                                    $dataUpdateEmployee['permanent_village']        = $item[27];
                                    $dataUpdateEmployee['permanent_street_no']      = $item[28];
                                    $dataUpdateEmployee['permanent_house_no']       = $item[29];
        
                                    /** block account for login to system */
                                    $dataUpdateEmployee['password']              = Hash::make($item[30]);
                                    $dataUpdateEmployee['type']                  = 'uploade';
                                    $dataUpdateEmployee['updated_by']            = Auth::user()->id;
                                    $dataUpdateEmployee['status' ]               = 'Active';
                                    $dataUpdateEmployee['p_status']              = '0';
                                    $dataUpdateEmployee->save();
                            }
                        }
                    }
                }
                // $Children_Informations =  $spreadsheet->getSheetByName('Children_Informations')->toArray();
                if ($sheetName == "Children_Informations") {
                    $i = 0;
                    $Children_Informations = $spreadsheet->getSheetByName($sheetName)->toArray();
                    foreach ($Children_Informations as $item) {
                        $i++;
                        if ($i > 2) {    
                            $dataUpdateEmployee = user::where('number_employee',$item[0])->first();
                            if ($dataUpdateEmployee) {
                                $child = ChildrenInfor::firstOrCreate([
                                    'employee_id'           => $dataUpdateEmployee->id,
                                    'name'                  => $item[1],
                                    'date_of_birth'         => $item[2] ? Carbon::createFromDate($item[2])->format('Y-m-d') : null,
                                    'sex'                   => $item[3],
                                    'created_by'            => Auth::user()->id
                                ]);
                            }
                        }
                    }
                }
                // $Emergency_Contact =  $spreadsheet->getSheetByName('Emergency_Contact')->toArray();
                if ($sheetName == "Emergency_Contact") {
                    $Emergency_Contact = $spreadsheet->getSheetByName($sheetName)->toArray();
                    foreach ($Emergency_Contact as $item) {
                        $i++;
                        if ($i > 2) {    
                            $dataUpdateEmployee = user::where('number_employee',$item[0])->first();
                            if ($dataUpdateEmployee) {
                                $contact = Contact::firstOrCreate([
                                    'employee_id'           => $dataUpdateEmployee->id,
                                    'name'                  => $item[1],
                                    'relationship'          => $item[2],
                                    'phone'                 => $item[3],
                                    'phone_2'               => $item[4],
                                    'updated_by'            => Auth::user()->id
                                ]);
                            }
                        }
                    }
                }
                // $Education_Informations =  $spreadsheet->getSheetByName('Education_Informations')->toArray();
                if ($sheetName == "Education_Informations") {
                    $Education_Informations = $spreadsheet->getSheetByName($sheetName)->toArray();
                    foreach ($Education_Informations as $item) {
                        $i++;
                        if ($i > 2) {    
                            $dataUpdateEmployee = user::where('number_employee',$item[0])->first();
                            if ($dataUpdateEmployee) {
                                $education = Education::firstOrCreate([
                                    'employee_id'           => $dataUpdateEmployee->id,
                                    'school'                => $item[1],
                                    'field_of_study'        => $item[2],
                                    'degree'                => $item[3],
                                    'grade'                 => $item[4],
                                    'start_date'            => $item[5] ? Carbon::createFromDate($item[5])->format('Y-m-d') : null,
                                    'end_date'              => $item[6] ? Carbon::createFromDate($item[6])->format('Y-m-d') : null,
                                    'created_by'            => Auth::user()->id
                                ]);
                            }
                        }
                    }
                }
                // $Experience_Informations =  $spreadsheet->getSheetByName('Experience_Informations')->toArray();
                if ($sheetName == "Experience_Informations") {
                    $Experience_Informations = $spreadsheet->getSheetByName($sheetName)->toArray();

                    foreach ($Experience_Informations as $item) {
                        $i++;
                        if ($i > 2) {    
                            $dataUpdateEmployee = user::where('number_employee',$item[0])->first();
                            if ($dataUpdateEmployee) {
                                $experience = Experience::firstOrCreate([
                                    'employee_id'           => $dataUpdateEmployee->id,
                                    'company_name'          => $item[1],
                                    'employment_type'       => $item[2],
                                    'position'              => $item[3],
                                    'start_date'            => $item[4] ? Carbon::createFromDate($item[4])->format('Y-m-d') : null,
                                    'end_date'              => $item[5] ? Carbon::createFromDate($item[5])->format('Y-m-d') : null,
                                    'location'              => $item[6],
                                    'updated_by'            => Auth::user()->id
                                ]);
                            }
                        }
                    }
                }
                // change password
                if ($sheetName == "Employee_change_password") {
                    $i = 0;
                    $employees_password =  $spreadsheet->getSheetByName($sheetName)->toArray();
                    foreach ($employees_password as $item) {
                        $i++;
                        if ($i > 2) {
                            $dataUpdateEmployee = user::where('number_employee',$item[0])->first();
                            if ($dataUpdateEmployee) {
                                    $dataUpdateEmployee['password']             = Hash::make($item[2]);
                                    $dataUpdateEmployee['p_status']             = 0;
                                    $dataUpdateEmployee['updated_by']           = Auth::user()->id;
                                    $dataUpdateEmployee->save();
                            }
                        }
                    }
                }
                // Update information banks
                if ($sheetName == "Employee_information_banks") {
                    $i = 0;
                    $employees_password =  $spreadsheet->getSheetByName($sheetName)->toArray();
                    foreach ($employees_password as $item) {
                        $i++;
                        if ($i > 2) {
                            $dataUpdateBank = user::where('number_employee',$item[0])->first();
                            if ($dataUpdateBank) {
                                    /** block Bank Infor */
                                    $dataUpdateBank['bank_name']             = $item[2];
                                    $dataUpdateBank['account_name']          = $item[3];
                                    $dataUpdateBank['account_number']        = $item[4];
                                    $dataUpdateBank['updated_by']            = Auth::user()->id;
                                    $dataUpdateBank->save();
                            }
                        }
                    }
                }
                // Update information salary
                if ($sheetName == "Employee_information_salaries") {
                    $i = 0;
                    $employees_salaries =  $spreadsheet->getSheetByName($sheetName)->toArray();
                    foreach ($employees_salaries as $item) {
                        $i++;
                        if ($i > 2) {
                            $dataUpdateSalary = user::where('number_employee',$item[0])->first();
                            if ($dataUpdateSalary) {
                                    /** block Salary */
                                    $dataUpdateSalary['basic_salary']          = ($item[2] ? $item[2] : $dataUpdateSalary->basic_salary);
                                    $dataUpdateSalary['salary_increas']        = ($item[3] ? $item[3] : $dataUpdateSalary->salary_increas);
                                    $dataUpdateSalary['updated_by']            = Auth::user()->id;
                                    $dataUpdateSalary->save();
                            }
                        }
                    }
                }
            }
            return 1;
        } else {
            return 0;
        }
    }

    public function userNotLogged(){
        $data = User::leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->select(
            'users.id',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'users.date_of_commencement',
            'positions.name_khmer as position_name_kh',
            'positions.name_english as position_name_en',
            'departments.name_khmer as depart_name_kh',
            'departments.name_english as depart_name_en',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
        )
        ->where('p_status',0)
        ->whereIn('emp_status',['Probation','1','10','2'])->get();
        return view('user_log.not_logged',compact('data'));
    }
    public function userLogged(){
        $data = User::leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->select(
            'users.id',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'users.updated_at',
            'users.date_of_commencement',
            'positions.name_khmer as position_name_kh',
            'positions.name_english as position_name_en',
            'departments.name_khmer as depart_name_kh',
            'departments.name_english as depart_name_en',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
        )
        ->where('p_status',1)
        ->whereIn('emp_status',['Probation','1','10','2'])->get();
        return view('user_log.logged',compact('data'));
    }
}
