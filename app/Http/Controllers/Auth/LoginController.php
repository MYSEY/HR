<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\CandidateResume;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }

    // change password
    public function login(Request $request)
    {
        $dataShortList = DB::table('candidate_resumes')->select('candidate_resumes.*')
        ->where(DB::raw("(DATE_FORMAT(candidate_resumes.interviewed_date,'%Y-%m-%d'))"), Carbon::now()->format('Y-m-d'))
        ->where('candidate_resumes.status','2')
        ->get()->count();
        $dataContract = CandidateResume::where('contract_date',Carbon::now()->format('Y-m-d'))->where('status','4')->get()->count();

        $dataUserUpComming = User::where('date_of_commencement',Carbon::now()->format('Y-m-d'))->where('emp_status','Upcoming')->get()->count();
        $dataUserProbation = User::where('fdc_date',Carbon::now()->format('Y-m-d'))->where('emp_status','Probation')->get()->count();
        // $dataUserFdc = User::where('fdc_end',Carbon::now()->format('Y-m-d'))->whereIn('emp_status',['1','10'])->get()->count();
        
        $change_password= "";
        $hashedPassword = User::select('employee_name_en','number_employee', 'password','email')->where('number_employee', $request->number_employee)->first();
        if($hashedPassword == null){
            Toastr::error('Wrong employee ID Or password', 'Error');
            return redirect('login');
        }
        if ($request->new_password && $request->password_confirmation) {
            if (Hash::check($request->current_password, $hashedPassword->password)) {
                if ($request->new_password == $request->password_confirmation) {
                    User::where('number_employee', $request->number_employee)->update([
                        'password'  =>  Hash::make($request->new_password)
                    ]);
                    $change_password = $request->new_password;
                    Toastr::success('password updated successfully', 'Success');
                }else {
                    Toastr::error('new password can not be the old password!', 'Error');
                    return redirect()->back();
                }
            } else {
                Toastr::error('Wrong employee ID Or current password', 'Error');
                return redirect()->back();
            }
        }else{
            $request->validate([
                'number_employee' => 'required|string|max:255',
                'password' => 'required|string',
            ]);
        }
        
        $name    = $hashedPassword->employee_name_en;
        $email    = $hashedPassword->email;
        $number_employee    = $request->number_employee;
        $password = $change_password ? $change_password : $request->password;
        
        $dt         = Carbon::now();
        $todayDate  = $dt->toDayDateTimeString();

        $activityLog = [
            'name'        => $name,
            'email'       => $email,
            'number_employee'       => $number_employee,
            'description' => 'has log in',
            'date_time'   => $todayDate,
        ];
        if (Auth::attempt(['number_employee' => $number_employee, 'password' => $password, 'role_id' => ['1','2']])) {
            DB::table('activity_logs')->insert($activityLog);
            Toastr::success('Login successfully.', 'Success');
            return redirect('dashboad/admin')->with([
                'dataUpComming'=>$dataUserUpComming,
                'dataProbation'=>$dataUserProbation,
                'dataShortList' => $dataShortList,
                'dataContract'  => $dataContract
            ]);
            // return redirect('dashboad/admin');
        } elseif (Auth::attempt(['number_employee' => $number_employee, 'password' => $password, 'role_id' => '3'])) {
            DB::table('activity_logs')->insert($activityLog);
            Toastr::success('Login successfully.', 'Success');
            return redirect('dashboad/employee');
        } else {
            Toastr::error('Wrong employee ID Or password', 'Error');
            return redirect('login');
        }
    }


    public function logout()
    {
        $user = Auth::User();
        Session::put('user', $user);
        $user = Session::get('user');
        
        $name       = $user->name;
        $email      = $user->email;
        $number_employee      = $user->number_employee;
        $dt         = Carbon::now();
        $todayDate  = $dt->toDayDateTimeString();

        $activityLog = [
            'name'        => $name,
            'email'       => $email,
            'number_employee'       => $number_employee,
            'description' => 'has logged out',
            'date_time'   => $todayDate,
        ];
        DB::table('activity_logs')->insert($activityLog);
        Auth::logout();
        Toastr::success('Logout successfully', 'Success');
        return redirect('login');
    }
}
