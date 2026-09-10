<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function changePassword(){
        if (permissionAccess("m9-s5","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        return view('settins.index');
    }
    public function updatePassword(Request $request){
        try{
            $hashedPassword = User::select('number_employee', 'password')->where('number_employee', $request->number_employee)->first();
            if($hashedPassword == null){
                Toastr::error('Wrong employee ID Or password', 'Error');
                return redirect('login');
            }
            if($hashedPassword->number_employee == $request->number_employee){
                if ($request->password == $request->password_confirmation) {
                    User::where('number_employee', $request->number_employee)->update([
                        'password'  =>  Hash::make($request->password),
                        'p_status'  =>  0
                    ]);
                    Toastr::success('Updated password successfully.','Success');
                }else{
                    Toastr::error('Password Or employee id not match!','Error');
                }
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
}
