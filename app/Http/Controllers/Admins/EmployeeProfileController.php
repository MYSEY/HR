<?php

namespace App\Http\Controllers\Admins;

use App\Models\Option;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Education;
use App\Models\Department;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Models\StaffPromoted;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class EmployeeProfileController extends Controller
{
    public function employeeProfile(Request $request){
        $data = User::with(['educations','experiences'])->where('id',$request->id)->first();
        $optionOfStudy = Option::where('type','field_of_study')->get();
        $optionDegree = Option::where('type','degree')->get();
        $department = Department::all();
        $position = Position::all();
        return view('employees.profile',compact('data','optionOfStudy','optionDegree','department','position'));
    }
    public function employeeEducation(Request $request){
        try{
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
            DB::commit();
            Toastr::success('Update education successfully. :)','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update education fail :)','Error');
            return redirect()->back();
        }
    }

    public function updateOrCreateExperience(Request $request)
    {
        try {
            $titles = $request->title;
            if (is_array($titles) && count($titles)) {
                foreach ($titles as $key => $title) :
                    if (!empty($title)) :
                        Experience::updateOrCreate([
                            'employee_id'       => $request->employee_id,
                            'title'             => $title ?? '',
                            'employment_type'   => $request->employment_type[$key] ?? '',
                            'company_name'      => $request->company_name[$key] ?? '',
                            'position'          => $request->position[$key] ?? '',
                            'location'          => $request->location[$key] ?? '',
                            'description'       => $request->description[$key] ?? '',
                            'start_date'        => !empty($request->start_date_experience[$key]) ? Carbon::parse($request->start_date_experience[$key])->format('Y-m-d') : '',
                            'end_date'          => !empty($request->end_date_experience[$key]) ? Carbon::parse($request->end_date_experience[$key])->format('Y-m-d') : '',
                            'updated_by'        => Auth::id(),
                        ]);
                    endif;
                endforeach;
            }
            DB::commit();
            Toastr::success('Update experience successfully. :)','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update experience fail :)','Error');
            return redirect()->back();
        }
    }
    public function updateOrCreatePromote(Request $request){
        DB::beginTransaction();
        try{
            StaffPromoted::create([
                'employee_id'   => $request->employee_id,
                'posit_id'      => $request->posit_id,
                'depart_id'     => $request->depart_id,
                'date'          => $request->promote_date,
                'updated_by'    => Auth::id(),
            ]);
            DB::commit();
            return response()->json(['success'=>'Update experience successfully.']);
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Add new employee fail :)','Error');
            return redirect()->back();
        }
    }
}
