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
use Spatie\Activitylog\Models\Activity;
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

    public function index(){
        $dataUser = User::all();
        foreach ($dataUser as $item) {
            if ($item->p_status == 0) {
                return view('auth.change_passwrod');
            } else {
                return view('auth.login');
            }   
        }
    }
    // change password
    public function login(Request $request)
    {
        Activity::all()->last();
        $dataShortList = DB::table('candidate_resumes')->select('candidate_resumes.*')
        ->where(DB::raw("(DATE_FORMAT(candidate_resumes.interviewed_date,'%Y-%m-%d'))"), Carbon::now()->format('Y-m-d'))
        ->where('candidate_resumes.status','2')
        ->get()->count();
        $dataContract = CandidateResume::where('contract_date',Carbon::now()->format('Y-m-d'))->where('status','4')->get()->count();

        $dataUserUpComming = User::where('date_of_commencement',Carbon::now()->format('Y-m-d'))->where('emp_status','Upcoming')->get()->count();
        $dataUserProbation = User::where('fdc_date',Carbon::now()->format('Y-m-d'))->where('emp_status','Probation')->get()->count();
        // $dataUserFdc = User::where('fdc_end',Carbon::now()->format('Y-m-d'))->whereIn('emp_status',['1','10'])->get()->count();
        
        $number_employee    = $request->number_employee;
        $password           = $request->password;
        // dd($password);
        if (Auth::attempt(['number_employee' => $number_employee, 'password' => $password])) {
            return redirect('dashboad/admin')->with([
                'dataUpComming' =>  $dataUserUpComming,
                'dataProbation' =>  $dataUserProbation,
                'dataShortList' =>  $dataShortList,
                'dataContract'  =>  $dataContract
            ]);
            Toastr::success('Login successfully.', 'Success');
        } elseif (Auth::attempt(['number_employee' => $number_employee, 'password' => $password])) {
            Toastr::success('Login successfully.', 'Success');
            return redirect('dashboad/employee');
        } else {
            Toastr::error('Wrong Employee ID Or Password', 'Error');
            return redirect('login');
        }
    }

    public function UserChangePassword(Request $request){
        try{
          
            $this->validate($request, [
                'number_employee' => 'required',
                'password' => 'required',
            ]);

            if ($request->new_password && $request->password_confirmation) {
                if ($request->new_password == $request->password_confirmation) {
                    User::where('number_employee', $request->number_employee)->update([
                        'password'  =>  Hash::make($request->new_password),
                        'p_status'  => '1'
                    ]);
                    $change_password = $request->new_password;
                    Toastr::success('password updated successfully', 'Success');
                }else {
                    Toastr::error('new password can not be the old password!', 'Error');
                    return redirect()->back();
                }
            }else{
                $request->validate([
                    'number_employee' => 'required|string|max:255',
                    'password' => 'required|string',
                ]);
            }
            return redirect('dashboad/admin');
            DB::commit();
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Password update fail','Error');
            return redirect()->back();
        } 
    }

    public function logout()
    {
        Activity::all()->last();
        Auth::logout();
        Toastr::success('Logout successfully', 'Success');
        return redirect('login');
    }
}
