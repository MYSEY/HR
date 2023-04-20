<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

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
        $change_password= "";
        $hashedPassword = User::select('employee_name_en','number_employee', 'password','email')->where('number_employee', $request->number_employee)->first();
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
        if (Auth::attempt(['number_employee' => $number_employee, 'password' => $password, 'status' => 'Active'])) {
            DB::table('activity_logs')->insert($activityLog);
            Toastr::success('Login successfully.', 'Success');
            return redirect('dashboad/admin');
        } elseif (Auth::attempt(['number_employee' => $number_employee, 'password' => $password, 'status' => null])) {
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
