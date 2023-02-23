<?php

namespace App\Http\Controllers\Admins;

use App\Models\Employee;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;

class EmployeeProfileController extends Controller
{
    public function employeeProfile(Request $request){
        $data = Employee::with('educations')->where('id',$request->id)->first();
        $optionOfStudy = Option::where('type','field_of_study')->get();
        $optionDegree = Option::where('type','degree')->get();
        return view('employees.profile',compact('data','optionOfStudy','optionDegree'));
    }
    public function employeeEducation(Request $request){
        try {
            // Education::where('employee_id', $request->employee_id)->delete();
            $schools = $request->school;
            if (is_array($schools) && count($schools)) {
                foreach ($schools as $key => $school) :
                    if (!empty($school)) :
                        Education::create([
                            'employee_id'       => $request->employee_id,
                            'school'            => $school ?? '',
                            'field_of_study'    => $request->field_of_study[$key] ?? '',
                            'degree'            => $request->degree[$key] ?? '',
                            'grade'             => $request->grade[$key] ?? '',
                            'start_date'        => !empty($request->start_date[$key]) ? Carbon::parse($request->start_date[$key])->format('Y-m-d') : '',
                            'end_date'          => !empty($request->end_date[$key]) ? Carbon::parse($request->end_date[$key])->format('Y-m-d') : '',
                            'updated_by'        => Auth::id(),
                        ]);
                    endif;
                endforeach;
            }
            return response()->json(['success'=>'Update education successfully.']);
        } catch (\Exception $exp) {
            /*
            * ERROR
            */
        }
    }
}
