<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\Option;
use App\Models\Branchs;
use App\Models\Position;
use App\Models\Education;
use App\Models\Department;
use App\Models\Experience;
use App\Models\Transferred;
use Illuminate\Http\Request;
use App\Models\StaffPromoted;
use App\Models\StaffTraining;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class EmployeeProfileController extends Controller
{
    public function employeeProfile(Request $request){
        $data = User::with(['educations','experiences'])->where('id',$request->id)->first();
        // $empPromoted = StaffPromoted::where('employee_id',$request->id)->get();
        $optionOfStudy = Option::where('type','field_of_study')->get();
        $optionDegree = Option::where('type','degree')->get();
        $department = Department::all();
        $position = Position::all();
        $branch = Branchs::all();
        $transferred = Transferred::all();
        $training = StaffTraining::all();
        $empPromoted = StaffPromoted::where('employee_id',$request->id)
                        ->orderBy('id', 'DESC')
                        ->get();
        return view('employees.profile',compact('data','optionOfStudy','optionDegree','department','position','empPromoted','branch','transferred','training'));
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
        try{
            StaffPromoted::create([
                'employee_id'   => $request->employee_id,
                'posit_id'      => $request->posit_id,
                'position_promoted_to'      => $request->position_promoted_to,
                'depart_id'     => $request->depart_id,
                'department_promoted_to'     => $request->department_promoted_to,
                'date'          => $request->promote_date,
                'updated_by'    => Auth::id(),
            ]);

            DB::commit();
            Toastr::success('Update promoted successfully. :)','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update promoted fail :)','Error');
            return redirect()->back();
        }
    }

    public function updatedTransferred(Request $request){
        try{
            Transferred::create([
                'employee_id'   => $request->employee_id,
                'branch_id'      => $request->branch_id,
                'date'          => $request->date,
                'updated_by'    => Auth::id(),
            ]);

            DB::commit();
            Toastr::success('Update branch successfully. :)','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update branch fail :)','Error');
            return redirect()->back();
        }
    }

    public function updatedTraining(Request $request){
        try{
            StaffTraining::create([
                'employee_id'   => $request->employee_id,
                'title'         => $request->title,
                'start_date'    => $request->start_date,
                'end_date'      => $request->end_date,
                'updated_by'    => Auth::id(),
            ]);

            DB::commit();
            Toastr::success('Update training successfully. :)','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update training fail :)','Error');
            return redirect()->back();
        }
    }
}
