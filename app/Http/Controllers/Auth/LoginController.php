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
use Illuminate\Validation\ValidationException;

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
        return view('auth.login');

        // $dataUser = User::all();
        // foreach ($dataUser as $item) {
        //     if ($item->p_status == 0) {
        //         return view('auth.change_passwrod');
        //     } else {
        //         return view('auth.login');
        //     }   
        // }
    }
    // change password
    public function login(Request $request)
    {
        $user = User::where("number_employee",$request->number_employee)->first();
        if ($user) {
            if($user->status == "Active"){
                if ($user->p_status == 0) {
                    if (!Hash::check($request->password, $user->password)) {
                        return response()->json([
                            'message' => "Wrong employee ID or password",
                            'status'=>"error"
                        ]);
                    }else{
                        return response()->json([
                            'message' => "Login successfully",
                            'status'=>"success",
                            'role' => null
                        ]);
                    }
                }else{
                    Activity::all()->last();
                    $number_employee    = $request->number_employee;
                    $password           = $request->password;
                    if (Auth::attempt(['number_employee' => $number_employee, 'password' => $password])) {
                        if (Auth::user()->status == 'Active') {
                            return response()->json([
                                'message' => "Login successfully",
                                'status'=>"success",
                                'role' => Auth::user()->RolePermission
                            ]);
                            // if (Auth::user()->RolePermission == "Employee") {
                            //     return redirect('dashboad/employee');
                            // }else{
                            //     return redirect('dashboad/admin')->with([
                            //         'dataUpComming' =>  $dataUserUpComming,
                            //         'dataProbation' =>  $dataUserProbation,
                            //         'dataShortList' =>  $dataShortList,
                            //         'dataContract'  =>  $dataContract
                            //     ]);
                            // }
                            // Toastr::success('Login successfully.', 'Success');
                        } else {
                            // User status is not active
                            Auth::logout();
                            return response()->json([
                                'message' => "Your account is not active. Please contact support",
                                'status'=>"error"
                            ]);
                            // Toastr::error('Your account is not active. Please contact support.', 'Error');
                            // return redirect('login');
                        }
                    }else {
                        return response()->json([
                            'message' => "Wrong Employee ID Or Password",
                            'status'=>"error"
                        ]);
                        // Toastr::error('Wrong Employee ID Or Password', 'Error');
                        // return redirect('login');
                    }
                }
            }else{
                return response()->json([
                    'message' => "Your account is not active. Please contact support",
                    'status'=>"error"
                ]);
                // Toastr::error('Your account is not active. Please contact support.', 'Error');
                // return redirect('login');
            }
        }else {
            return response()->json([
                'message' => "Wrong employee ID or password. Please contact support",
                'status'=>"error"
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate(
                [
                    'number_employee' => 'required',
                    'confirm_password' => 'required',
                    'new_password' => 'required|min:8',
                ],
                [
                    'new_password.required' => 'The new password field is required.',
                    'new_password.min' => 'The new password must be at least :min characters.',
                ]
            );
            if ($request->confirm_password != $request->new_password) {
                return response()->json([
                    'message' => "New password is invalid with password confirmation!",
                    'status'=>"error"
                ]);
            }else{
                $user = User::where("number_employee",$request->number_employee)->first();
                $user->password = Hash::make($request->new_password);
                $user->p_status = 1;
                $user->save();
                if (Auth::attempt(['number_employee' => $request->number_employee, 'password' => $request->new_password])) {
                    return response()->json([
                        'role' => Auth::user()->RolePermission
                    ]);
                    // Toastr::success('Login successfully.', 'Success');
                }
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()]);
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
