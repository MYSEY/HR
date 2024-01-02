<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\Option;
use App\Models\Branchs;
use App\Models\Contact;
use App\Models\Position;
use App\Models\Education;
use App\Models\Department;
use App\Models\Experience;
use App\Models\Transferred;
use Illuminate\Http\Request;
use App\Models\ChildrenInfor;
use App\Models\StaffPromoted;
use App\Models\StaffTraining;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChildrenRequest;
use Spatie\Activitylog\Models\Activity;
use App\Http\Requests\EmployeeContactRequest;

class EmployeeProfileController extends Controller
{
    public function employeeProfile(Request $request){
        $data = User::with(['educations','experiences','banks','staffPromoted'])->where('id',$request->id)->first();
        $optionOfStudy = Option::where('type','field_of_study')->get();
        $optionDegree = Option::where('type','degree')->get();
        $relationship = Option::where('type','relationship')->get();
        $optionGender = Option::where('type','gender')->get();
        $EmploymentType = Option::where('type','experience')->get();
        $department = Department::all();
        $position = Position::all();
        $branch = Branchs::all();
        $transferred = Transferred::where('employee_id',$request->id)->get();
        $educations = Education::where('employee_id',$request->id)->get();
        $experiences = Experience::where('employee_id',$request->id)->get();
        $training = StaffTraining::where('employee_id',$request->id)->get();
        $contact = Contact::where('employee_id',$request->id)->get();
        $childrenInfor = ChildrenInfor::where('employee_id',$request->id)->get();
        $empPromoted = StaffPromoted::where('employee_id',$request->id)->orderBy('id', 'DESC')->get();
        $empTranferend = Transferred::where('employee_id',$request->id)->orderBy('id', 'DESC')->get();
        return view('employees.profile',
            compact('data',
            'optionOfStudy',
            'optionDegree',
            'department',
            'position',
            'empPromoted',
            'branch',
            'transferred',
            'training',
            'relationship',
            'contact',
            'educations',
            'experiences',
            'childrenInfor',
            'optionGender',
            'empTranferend',
            'EmploymentType'
        ));
    }
    public function employeeEducation(Request $request){
        try{
            Activity::all()->last();
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
                            'created_by'        => Auth::id(),
                        ]);
                    endif;
                endforeach;
            }
            DB::commit();
            Toastr::success('Update education successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update education fail','Error');
            return redirect()->back();
        }
    }
    public function educationEdit(Request $request){
        $optionOfStudy = Option::where('type','field_of_study')->get();
        $optionDegree = Option::where('type','degree')->get();
        $data = Education::where('id',$request->id)->first();
        return response()->json(['success'=>$data,'optionOfStudy'=>$optionOfStudy,'optionDegree'=>$optionDegree]);
    }
    public function educationUpdate(Request $request){
        try{
            $data = Education::find($request->id);
            $data['employee_id']   = $request->employee_id;
            $data['school']        = $request->school;
            $data['field_of_study']= $request->field_of_study;
            $data['degree']        = $request->degree;
            $data['grade']         = $request->grade;
            $data['start_date']    = $request->start_date;
            $data['end_date']      = $request->end_date;
            $data['updated_by']    = Auth::id();
            $data->save();
            DB::commit();
            Toastr::success('Update Education successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update Education fail','Error');
            return redirect()->back();
        }
    }
    public function educationDelete(Request $request){
        try{
            Education::destroy($request->id);
            Toastr::success('Education deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Education delete fail.','Error');
            return redirect()->back();
        }
    }
    public function changePassword(Request $request) {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:8',
            ],
            'comfirm_password' => 'required|string',
        ]);
        
        $hashedPassword = User::select('employee_name_en','number_employee', 'password','email')->where('number_employee', $request->number_employee)->first();
        if($hashedPassword == null){
            Toastr::error('Wrong current password or new password', 'Error');
            return redirect()->back();
        }
        if ($request->new_password == $request->comfirm_password) {
            if (Hash::check($request->current_password, $hashedPassword->password)) {
                User::where('number_employee', $request->number_employee)->update([
                    'password'  =>  Hash::make($request->new_password)
                ]);
                DB::commit();
                return response()->json(['message' => "password updated successfully!"], 200);
            }else{
                DB::rollBack();
                return response()->json(['message' => "Current password Invalid!"], 404);
            }
        }else{
            DB::rollBack();
            return response()->json(['message' => "New password or comfirm password Invalid!"], 404);
        }
    }

    public function createExperience(Request $request)
    {
        try {
            if (is_array($request->company_name) && count($request->company_name)) {
                foreach ($request->company_name as $key => $item) :
                    if (!empty($item)) :
                        Experience::updateOrCreate([
                            'employee_id'       => $request->employee_id,
                            'employment_type'   => $request->employment_type[$key] ?? '',
                            'company_name'      => $request->company_name[$key] ?? '',
                            'position'          => $request->position[$key] ?? '',
                            'location'          => $request->location[$key] ?? '',
                            'start_date'        => !empty($request->start_date_experience[$key]) ? Carbon::parse($request->start_date_experience[$key])->format('Y-m-d') : '',
                            'end_date'          => !empty($request->end_date_experience[$key]) ? Carbon::parse($request->end_date_experience[$key])->format('Y-m-d') : '',
                            'updated_by'        => Auth::id(),
                        ]);
                    endif;
                endforeach;
            }
            DB::commit();
            Toastr::success('Update experience successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update experience fail','Error');
            return redirect()->back();
        }
    }
    public function editeExperience(Request $request){
        try{
            $EmploymentType = Option::where('type','experience')->get();
            $data = Experience::where('id',$request->id)->first();
            return response()->json(['success'=>$data,'EmploymentType'=>$EmploymentType]);
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back();
        }
    }
    public function updateExperience(Request $request){
        try{
            $data = Experience::find($request->id);
            $data['employee_id']       = $request->employee_id;
            $data['employment_type']   = $request->employment_type;
            $data['company_name']      = $request->company_name;
            $data['position']          = $request->position;
            $data['start_date']        = $request->start_date_experience;
            $data['end_date']          = $request->end_date_experience;
            $data['location']          = $request->location;
            $data['updated_by']        = Auth::id();
            $data->save();
            DB::commit();
            Toastr::success('Update experience successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update experience fail','Error');
            return redirect()->back();
        }
    }
    public function deleteExperience(Request $request){
        try{
            Experience::destroy($request->id);
            Toastr::success('Experience deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Experience delete fail.','Error');
            return redirect()->back();
        }
    }
    public function createPromote(Request $request){
        try{
            StaffPromoted::create([
                'employee_id'   => $request->employee_id,
                'posit_id'      => $request->posit_id,
                'position_promoted_to'      => $request->position_promoted_to,
                'depart_id'     => $request->depart_id,
                'department_promoted_to'     => $request->department_promoted_to,
                'date'          => $request->promote_date,
                'created_by'    => Auth::id(),
            ]);

            DB::commit();
            Toastr::success('Create promoted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create promoted fail','Error');
            return redirect()->back();
        }
    }
    public function editPromote(Request $request){
        try{
            $department = Department::all();
            $position = Position::all();
            $data = StaffPromoted::where('id',$request->id)->first();
            return response()->json(['success'=>$data,'department'=>$department,'position'=>$position]);
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Edit promoted fail','Error');
            return redirect()->back();
        }
    }
    public function updatePromote(Request $request){
        try{
            $data = StaffPromoted::find();
            $data['employee_id']               = $request->employee_id;
            $data['posit_id']                  = $request->posit_id;
            $data['position_promoted_to']      = $request->position_promoted_to;
            $data['depart_id']                 = $request->depart_id;
            $data['department_promoted_to']    = $request->department_promoted_to;
            $data['date']                      = $request->promote_date;
            $data['created_by']                = Auth::id();
            $data->save();
            DB::commit();
            Toastr::success('Update promoted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update promoted fail','Error');
            return redirect()->back();
        }
    }
    public function deletePromote(Request $request){
        try{
            StaffPromoted::destroy($request->id);
            Toastr::success('Promote deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Promote delete fail.','Error');
            return redirect()->back();
        }
    }

    public function createTransferred(Request $request){
        try{
            Transferred::create([
                'employee_id'               => $request->employee_id,
                'branch_id'                 => $request->branch_id,
                'tranferend_branch_name'    => $request->tranferend_branch_name,
                'position_id'               => $request->position_id,
                'tranferend_position_name'  => $request->tranferend_position_name,
                'date'                      => $request->date,
                'descrition'                => $request->descrition,
                'created_by'                => Auth::id(),
            ]);

            DB::commit();
            Toastr::success('Create transferred successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('transferred fail','Error');
            return redirect()->back();
        }
    }
    public function editTransferend(Request $request){
        $branch = Branchs::all();
        $position = Position::all();
        $data = Transferred::where('id',$request->id)->first();
        return response()->json(['success'=>$data,'branch'=>$branch,'position'=>$position]);
    }
    public function updateTransferend(Request $request){
        try{
            $data = Transferred::find($request->id);
            $data['branch_id']                 = $request->branch_id;
            $data['tranferend_branch_name']    = $request->tranferend_branch_name;
            $data['position_id']               = $request->position_id;
            $data['tranferend_position_name']  = $request->tranferend_position_name;
            $data['date']                      = $request->date;
            $data['descrition']                = $request->descrition;
            $data['updated_by']                = Auth::id();
            $data->save();
            DB::commit();
            Toastr::success('Update transferred successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('transferred fail','Error');
            return redirect()->back();
        }
    }
    public function deleteTransferend(Request $request)
    {
        try{
            Transferred::destroy($request->id);
            Toastr::success('Transferred deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Transferred delete fail.','Error');
            return redirect()->back();
        }
    }
    

    public function createTraining(Request $request){
        try{
            StaffTraining::create([
                'employee_id'   => $request->employee_id,
                'title'         => $request->title,
                'start_date'    => $request->start_date,
                'end_date'      => $request->end_date,
                'descrition'    => $request->descrition,
                'created_at'    => Auth::id(),
            ]);

            DB::commit();
            Toastr::success('Created training successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Created training fail','Error');
            return redirect()->back();
        }
    }
    public function editTraining(Request $request){
        $data = StaffTraining::where('id',$request->id)->first();
        return response()->json(['success'=>$data]);
    }
    public function updateTraining(Request $request){
        try{
            $data = StaffTraining::find($request->id);
            $data['employee_id']   = $request->employee_id;
            $data['title']         = $request->title;
            $data['start_date']    = $request->start_date;
            $data['end_date']      = $request->end_date;
            $data['descrition']    = $request->descrition;
            $data['updated_by']    = Auth::id();
            $data->save();
            DB::commit();
            Toastr::success('Update training successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update training fail','Error');
            return redirect()->back();
        }
    }
    public function deleteTraining(Request $request){
        try{
            StaffTraining::destroy($request->id);
            Toastr::success('Training deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Training delete fail.','Error');
            return redirect()->back();
        }
    }
    public function employeeContact(EmployeeContactRequest $request){
        try{
            Contact::create([
                'employee_id'   => $request->employee_id,
                'name'          => $request->name,
                'relationship'  => $request->relationship,
                'phone'         => $request->phone,
                'phone_2'       => $request->phone_2,
                'created_by'    => Auth::id(),
            ]);
            DB::commit();
            Toastr::success('Create contact successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create contact fail','Error');
            return redirect()->back();
        }
    }
    public function editContact(Request $request){
        $relationship = Option::where('type','relationship')->get();
        $data = Contact::where('id',$request->id)->first();
        return response()->json(['success'=>$data,'relationship'=>$relationship]);
    }
    public function updateContact(Request $request){
        try{
            $data = Contact::find($request->id);
            $data['employee_id']   = $request->employee_id;
            $data['name']          = $request->name;
            $data['relationship']  = $request->relationship;
            $data['phone']         = $request->phone;
            $data['phone_2']       = $request->phone_2;
            $data['updated_by']    = Auth::id();
            $data->save();
            DB::commit();
            Toastr::success('Update contact successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update contact fail','Error');
            return redirect()->back();
        }
    }
    public function deleteContact(Request $request){
        try{
            Contact::destroy($request->id);
            Toastr::success('Contact deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Contact delete fail.','Error');
            return redirect()->back();
        }
    }
    public function employeeChildren(ChildrenRequest $request){
        try{
            if (is_array($request->name) && count($request->name)) {
                foreach ($request->name as $key => $item) :
                    if (!empty($item)) :
                        ChildrenInfor::updateOrCreate([
                            'employee_id'       => $request->employee_id,
                            'name'              => $request->name[$key] ?? '',
                            'date_of_birth'     => $request->date_of_birth[$key] ?? '',
                            'sex'               => $request->sex[$key] ?? '',
                            'created_by'        => Auth::id(),
                        ]);
                    endif;
                endforeach;
            }
            DB::commit();
            Toastr::success('Create Children successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create Children fail','Error');
            return redirect()->back();
        }
    }
    public function editChildrenInformation(Request $request){
        $data = ChildrenInfor::where('id',$request->id)->first();
        return response()->json([
            'success'=>$data,
        ]);
    }
    public function childrenUpdate(Request $request){
        try{
            $data = ChildrenInfor::find($request->id);
            $data['employee_id']       = $request->employee_id;
            $data['name']              = $request->name;
            $data['date_of_birth']     = $request->date_of_birth;
            $data['sex']               = $request->sex;
            $data['updated_by']        = Auth::id();
            $data->save();
            DB::commit();
            Toastr::success('Updated Children successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Updated Children fail','Error');
            return redirect()->back();
        }
    }
    public function childrenDelate(Request $request){
        try{
            ChildrenInfor::destroy($request->id);
            Toastr::success('Children deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Children delete fail.','Error');
            return redirect()->back();
        }
    }
}
