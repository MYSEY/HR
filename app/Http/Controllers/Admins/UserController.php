<?php

namespace App\Http\Controllers\Admins;
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
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\UploadFiles\UploadFIle;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
        $branch = Branchs::all();
        $province = Province::all();
        $bank = Bank::all();
        $dataProbation = User::with('role')->with('department')->where('emp_status','Probation')->get();
        $dataFDC = User::with('role')->with('department')->whereIn('emp_status',['1','10'])->get();
        $dataUDC = User::with('role')->with('department')->where('emp_status','2')->get();
        $dataCanContract = User::with('role')->with('department')->where('emp_status','Cancel')->get();
        $dataResign = User::with('role')->with('department')->whereIn('emp_status', ['3','4','5','6','7','8','9'])->get();
        $optionIdentityType = Option::where('type','identity_type')->get();
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
        $from_date = null;
        $to_date = null;
        $from_date = Carbon::now()->format('d');
        $to_date = Carbon::now()->addDays(14)->format('d');
        $month = Carbon::now()->format('m');

        $data =  User::whereIn('emp_status',['1','2','10','Probation'])
        ->whereDay('date_of_birth', '>=', $from_date)
        ->whereDay('date_of_birth', '<=', $to_date)
        ->whereMonth('date_of_birth', $month)
        ->orderBy('date_of_birth', 'desc')->get();
        return view('users.user_list_birthday',compact('data'));
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
            Toastr::success('Create employee successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create employee fail','Error');
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
        $AllEmployee = $spreadsheet->getActiveSheet()->toArray();
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $created = Auth::user()->id;
            $i = 0;
            foreach ($AllEmployee as $item) {
                $i++;
                if ($i != 1) {
                    $date_of_birth = Carbon::createFromDate($item[4])->format('Y-m-d');
                    $date_of_commencement = Carbon::createFromDate($item[5])->format('Y-m-d');
                    $fdc_date = Carbon::createFromDate($item[6])->format('Y-m-d');
                    $issue_date = Carbon::createFromDate($item[27])->format('Y-m-d');
                    $issue_expired_date = Carbon::createFromDate($item[28])->format('Y-m-d');
                    User::create([
                        'number_employee'   => $item[0],
                        'employee_name_kh'   => $item[1],
                        'employee_name_en'   => $item[2],
                        'gender'   => $item[3],
                        'date_of_birth'   => $date_of_birth,
                        'date_of_commencement'   => $date_of_commencement,
                        'fdc_date'   => $fdc_date,
                        'branch_id'   => $item[7],
                        'department_id'   => $item[8],
                        'position_id'   => $item[9],
                        'position_type'   => $item[10],
                        'unit'   => $item[11],
                        'level'   => $item[12],
                        'nationality'   => $item[13],
                        'marital_status'   => $item[14],
                        'basic_salary'   => $item[15],
                        'phone_allowance'   => $item[16],
                        'guarantee_letter'   => 'INVITATION_Ingenico & Hengbao_11 Aug 2023_v3.pdf',
                        'employment_book'   => $item[18],
                        'personal_phone_number'   => $item[19],
                        'company_phone_number'   => $item[20],
                        'agency_phone_number'   => $item[21],
                        'email'   => $item[22],
                        'spouse'   => $item[23],
                        'is_loan'   => $item[24],
                        'identity_type'   => $item[25],
                        'identity_number'   => $item[26],
                        'issue_date'   => $issue_date,
                        'issue_expired_date'   => $issue_expired_date,
                        'password'  => Hash::make($item[29]),
                        'role_id'  => $item[30],
                        'emp_status'  => $item[31],
                        'created_by'  => $created,
                    ]);
                }
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
    public function update(UserUpdated $request)
    {
        try{
            $this->employeeRepo->updatedUsers($request);
            DB::commit();
            Toastr::success('Updated employee successfully.','Success');
            return redirect()->back();
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
                //total day in months
                $endMonth = Carbon::createFromDate($request->start_date)->format('m');
                $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
            
                //find start date employee join date
                $date_of_month = Carbon::createFromDate($request->start_date)->format('Y-m');
                $currentYear = $date_of_month.'-'.$totalDayInMonth;

                //find total working day in month
                $startDate = Carbon::parse($request->start_date);
                $endDate = Carbon::parse($currentYear);

                // new salary and new total days
                $dataSalary = User::where('id',$request->id)->first();
                $totalNewDays = $startDate->diffInDays($endDate) + 1;
                $totalBasicSalary = $dataSalary->basic_salary + $request->total_salary_increase;
                $totalnewSalary = ($totalBasicSalary / $totalDayInMonth) * $totalNewDays;

                //old salary and total old days
                $totalOldDay = $totalDayInMonth - $totalNewDays;
                $totalOldSalary = ($dataSalary->basic_salary / $totalDayInMonth)  * $totalOldDay;
                
                $totalCurrentSalary = $totalnewSalary + $totalOldSalary;
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'fdc_date' => $request->start_date,
                    'fdc_end' => $request->end_dete,
                    'salary_increas' => $request->total_salary_increase,
                    'basic_salary' => $totalBasicSalary,
                    'total_current_salary' => number_format($totalCurrentSalary, 2),
                    'pre_salary' => number_format($dataSalary->basic_salary, 2),
                    'resign_reason' => $request->resign_reason
                ]);
            }else if($request->emp_status == '10'){
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'fdc_date' => $request->start_date,
                    'fdc_end' => $request->end_dete,
                    'resign_reason' => $request->resign_reason
                ]);
            }else if($request->emp_status == 2){
                User::where('id',$request->id)->update([
                    'emp_status' => $request->emp_status,
                    'fdc_date' => $request->start_date,
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
            
            DB::commit();
            return ['message' => 'successfull'];
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }
}
