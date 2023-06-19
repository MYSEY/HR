<?php

namespace App\Http\Controllers\Admins;
use DateTime;
use DatePeriod;
use App\Address;
use DateInterval;
use App\Models\Bank;
use App\Models\Role;
use App\Models\User;
use App\Models\Option;
use App\Helpers\Helper;
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
use PhpParser\Node\Expr\Cast\Object_;
use App\Traits\UploadFiles\UploadFIle;
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
        $branch = Branchs::all();
        $province = Province::all();
        $bank = Bank::all();
        $optionIdentityType = Option::where('type','identity_type')->get();
        return view('users.index',compact('data','role','position','department','optionStatus','autoEmpId','optionGender','branch','optionIdentityType', 'province','bank'));
    }

    public function showDetailBirthday (Request $request){
        $from_date = null;
        $to_date = null;
        $from_date = Carbon::now()->format('d');
        $to_date = Carbon::now()->addDays(14)->format('d');
        $month = Carbon::now()->format('m');

        $data =  User::whereIn('emp_status',['1','2','Probation'])
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
         
        //total day in months
        $currentYear = Carbon::createFromDate($request->date_of_commencement)->format('Y-m');
        $begin = new DateTime($currentYear.'-'.'01');
        
        //total day in months
        $endMonth = Carbon::createFromDate($request->date_of_commencement)->format('m');
        $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
        $end = new DateTime($currentYear.'-'.$totalDayInMonth);

        $end = $end->modify('+1 day');
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);

        $holidays = [];
        foreach ($daterange as $date) {
            $sunday = date('w', strtotime($date->format("Y-m-d")));
            if ($sunday == 0) {
                $holidays[] = $date->format("Y-m-d");
            } else {
                echo'';
            }
        }
        // dd($holidays);
        $startDate = Carbon::parse($request->date_of_commencement);
        $endDate = Carbon::parse($currentYear.'-'.$totalDayInMonth);
        // dd($endDate);
        $days = $startDate->diffInDaysFiltered(function (Carbon $date) use ($holidays) {
            return $date->isWeekday() && !in_array($date, $holidays);
        }, $endDate);

        $totalSalary = $days * ($request->basic_salary / 22);
        dd($totalSalary);
        try{
            $this->employeeRepo->createUsers($request);
            DB::commit();
            Toastr::success('Employee create successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Employee create fail','Error');
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
            Toastr::success('Updated employee successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User update fail','Error');
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
                    'fdc_date' => $request->start_date,
                    'fdc_end' => $request->end_date,
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
