<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\CandidateResume;
use App\Models\Conmmunes;
use App\Models\Department;
use App\Models\District;
use App\Models\GenerateIdEmployee;
use App\Models\Option;
use App\Models\Position;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use App\Models\Villages;
use App\Traits\GeneratingCode;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CandidateResumeController extends Controller
{
    use GeneratingCode;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        
        $role = Role::all();
        $autoEmpId   = $this->generate_EmployeeId(Carbon::today())['number_employee'];
        $department = Department::all();
        $position = Position::all();
        $branch = Branchs::all();
        $gender = Option::where('type','gender')->get();
        $optionPositionType = Option::where('type','position_type')->get();
        $optionLoan = Option::where('type','loan')->get();
        $data = CandidateResume::where("status", "1")->get();
        $dataShortList = CandidateResume::where("short_list", "1")->where('status','2')->count();
        $dataNon = CandidateResume::where("short_list", "2")->count();
        $dataResult = CandidateResume::where("status",'3')->count();
        $dataProcessing = CandidateResume::where("status",'4')->count();
        $dataCancel = CandidateResume::where("status",'Cancel')->count();
        $province = Province::all();
        return view('recruitments.candidate_resumes.candidate_resume', 
            compact([
                "position", 
                "branch", 
                "gender", 
                "data", 
                "autoEmpId", 
                "role", 
                "department", 
                "optionPositionType", 
                "optionLoan", 
                "province",
                "dataShortList",
                "dataNon",
                "dataResult",
                'dataProcessing',
                'dataCancel'
            ]));
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
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            $data['status'] = "1";
            CandidateResume::create($data);
            DB::commit();
            Toastr::success('Candidate resume created successfully.','Success');
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Candidate resume created fail.','Error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $datas = CandidateResume::where("status", $request->status)->with("branch")->with("position")->with("option")->get();
        return response()->json(['datas'=>$datas]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $position = Position::all();
        $branch = Branchs::all();
        $gender = Option::where('type','gender')->get();
        if ($request->status =='4') {
            $autoEmpId   = $this->generate_EmployeeId(Carbon::today())['number_employee'];
            $optionPositionType = Option::where('type','position_type')->get();
            $department = Department::all();
            $data = CandidateResume::where("id", $request->id)
            ->with("branch")->with("position")->with("option")
            ->with("positiontype")
            ->with("permanentprovince")
            ->with("currentprovince")
            ->with("currentdistrict")
            ->with("currentcommune")
            ->with("currentvillage")
            ->first();
            $province = Province::all();
            $district = District::whereIn('province_id',[$data->current_province, $data->permanent_province])->get();
            $conmmunes = Conmmunes::whereIn('district_id',[$data->current_district,$data->permanent_district])->get();
            $villages = Villages::whereIn('commune_id',[$data->current_commune,$data->permanent_commune])->get();
            return response()->json([
                'autoEmpId'=>$autoEmpId,
                'success'=>$data,
                'gender'=>$gender,
                'position'=>$position,
                'branch'=>$branch,
                'optionPositionType' => $optionPositionType,
                'department' => $department,
                'province' => $province,
                'district' => $district,
                'conmmunes' => $conmmunes,
                'villages' => $villages,
            ]);
        }else{
            $data = CandidateResume::where("id", $request->id)
            ->with("branch")->with("position")->with("option")->first();
            return response()->json([
                'success'=>$data,
                'gender'=>$gender,
                'position'=>$position,
                'branch'=>$branch,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                $filenameGuarant = time().'.'.$file->getClientOriginalName();
                $file->move(public_path('uploads/images'), $filenameGuarant);
            }else{
                $filenameGuarant = $request->hidden_cv;
            }
            $dataUpdate = [
                'name_kh' => $request->name_kh,
                'name_en' => $request->name_en,
                'gender' => $request->gender,
                'current_position' => $request->current_position,
                'companey_name' => $request->companey_name,
                'position_applied' => $request->position_applied,
                'current_address' => $request->current_address,
                'location_applied' => $request->location_applied,
                'received_date' => $request->received_date,
                'recruitment_channel' => $request->recruitment_channel,
                'contact_number' => $request->contact_number,
                'status' => $request->status,
                'cv' => $filenameGuarant,
                'updated_by' => Auth::user()->id 
            ];
            CandidateResume::where('id',$request->id)->update($dataUpdate);
            Toastr::success('Candidate resume updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Candidate resume update fail.','Error');
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
            CandidateResume::destroy($request->id);
            Toastr::success('Candidate resume deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Candidate resume delete fail.','Error');
            return redirect()->back();
        }
    }
    public function processing(Request $request)
    {
        try {
            $dataUpdate = [];
            if ($request->status == "1") {
                $dataUpdate = [
                    'status' => $request->status,
                    'short_list' => null,
                    'interviewed_date' => null,
                    'interviewed_channel' => null,
                    'committee_interview' => null,
                    'contract_date' => null,
                    'join_date' => nuLL,
                    'joined_interview' => null,
                    'interviewed_result' => null,
                    'updated_by' => Auth::user()->id,
                ];
            }
            if ($request->status == "2") {
                if ($request->short_list == 1) {
                    $dataUpdate = [
                        'status' => $request->status,
                        'short_list' => $request->short_list,
                        'interviewed_date' => $request->interviewed_date,
                        'interviewed_channel' => $request->interviewed_channel,
                        'committee_interview' => $request->committee_interview,
                        'remark' => $request->remark,
                        'updated_by' => Auth::user()->id,
                    ];
                }else{
                    $dataUpdate = [
                        'status' => $request->status,
                        'short_list' => $request->short_list,
                        'interviewed_date' => null,
                        'interviewed_channel' => null,
                        'committee_interview' => null,
                        'remark' => $request->remark,
                        'updated_by' => Auth::user()->id,
                    ];
                }
            }
            if ($request->status == "3") {
                if ($request->joined_interview == "1") {
                    $dataUpdate = [
                        'status' => $request->status,
                        'joined_interview' => $request->joined_interview,
                        'interviewed_result' => $request->interviewed_result,
                        'remark' =>$request->remark,
                        'updated_by' => Auth::user()->id,
                    ];
                }else if($request->joined_interview == "3"){
                    $dataUpdate = [
                        'status' => 2,
                        'joined_interview' => $request->joined_interview,
                        'interviewed_result' =>null,
                        'interviewed_date' =>$request->interviewed_date,
                        'remark' =>$request->remark,
                        'updated_by' => Auth::user()->id,
                    ];
                }else {
                    $dataUpdate = [
                        'status' => $request->status,
                        'joined_interview' => $request->joined_interview,
                        'interviewed_result' =>null,
                        'remark' =>$request->remark,
                        'updated_by' => Auth::user()->id,
                    ]; 
                }
            } 
            if ($request->status == "4") {
                $dataUpdate = [
                    'status' => $request->status,
                    'contract_date' => $request->contract_date,
                    'join_date' => $request->join_date,
                    'updated_by' => Auth::user()->id,
                ];
            }
            if ($request->status == "Cancel") {
                $dataUpdate = [
                    'status' => $request->status,
                    'updated_by' => Auth::user()->id,
                ];
            }
            CandidateResume::where('id',$request->id)->update($dataUpdate);
            DB::commit();
            return ['message' => 'successfull'];
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }
    public function createemp(Request $request)
    {
        try {
            if ($request->status == "Upcoming") {
                $candidate = CandidateResume::where("id", $request->id) ->first();
                $emp_data = [
                    'number_employee' => $candidate->number_employee,
                    'employee_name_kh' => $candidate->name_kh,
                    'employee_name_en' => $candidate->name_en,
                    'gender' => $candidate->gender,
                    'position_id' => $candidate->position_applied,
                    'branch_id' => $candidate->location_applied,
                    'personal_phone_number' => $candidate->contact_number,
                    'id_card_number' => $candidate->id_card_number,
                    'basic_salary' => $candidate->basic_salary,
                    'salary_increas' => $candidate->salary_increas,
                    'position_type' => $candidate->position_type,
                    'department_id' => $candidate->department_id,
                    'date_of_commencement' => $candidate->join_date,
                    'fdc_date' => $candidate->fdc_date,
                    'date_of_birth' => $candidate->date_of_birth,
                    'current_province' => $candidate->current_province,
                    'current_district' => $candidate->current_district,
                    'current_commune' => $candidate->current_commune,
                    'current_village' => $candidate->current_village,
                    'current_house_no' => $candidate->current_house_no,
                    'current_street_no' => $candidate->current_street_no,
                    'permanent_province' => $candidate->permanent_province,
                    'permanent_district' => $candidate->permanent_district,
                    'permanent_commune' => $candidate->permanent_commune,
                    'permanent_village' => $candidate->permanent_village,
                    'permanent_house_no' => $candidate->permanent_house_no,
                    'permanent_street_no' => $candidate->permanent_street_no,
                    'emp_status' => $request->status,
                    'remark' => $request->remark,
                    'spouse' => 0,
                    'is_loan' => 0,
                    'password' => Hash::make("Camma@123"),
                    'created_by' => Auth::user()->id,
                ];
                $userData = User::create($emp_data);
                CandidateResume::where('id',$candidate->id)->update([ 'status' => 5]);
                DB::commit();
                return ['message' => 'successfull'];
            }else{
                $generateID = GenerateIdEmployee::where("number_employee",$request->number_employee )->first();
                if (!$generateID) {
                    GenerateIdEmployee::create([
                        'candidate_resumes_id'   => $request->candidate_id,
                        'number_employee'   => $request->number_employee,
                        'created_by' => Auth::user()->id,
                    ]);
                };
                $newDateTime = Carbon::parse($request->date_of_commencement)->addMonths(3);
                CandidateResume::where('id',$request->candidate_id)->update([
                    "number_employee" =>$request->number_employee,
                    'name_kh' => $request->employee_name_kh,
                    'name_en' => $request->employee_name_en,
                    'gender' => $request->gender,
                    'position_applied' => $request->position_id,
                    'location_applied' => $request->branch_id,
                    'contact_number' => $request->personal_phone_number,
                    'id_card_number' =>$request->id_card_number,
                    'basic_salary' => $request->basic_salary,
                    'salary_increas' => $request->salary_increas,
                    'position_type' => $request->position_type,
                    'department_id' =>$request->department_id,
                    'join_date' => $request->date_of_commencement,
                    'fdc_date' => $newDateTime,
                    'date_of_birth' => $request->date_of_birth,
                    'current_province' =>$request->current_province,
                    'current_district' => $request->current_district,
                    'current_commune' => $request->current_commune,
                    'current_village' => $request->current_village,
                    'current_house_no' => $request->current_house_no,
                    'current_street_no' => $request->current_street_no,
                    'permanent_province' => $request->permanent_province,
                    'permanent_district' => $request->permanent_district,
                    'permanent_commune' => $request->permanent_commune,
                    'permanent_village' => $request->permanent_village,
                    'permanent_house_no' => $request->permanent_house_no,
                    'permanent_street_no' => $request->permanent_street_no,
                    'status' => 4,
                ]);
                $datas = CandidateResume::where("id", $request->candidate_id)
                    ->with("branch")->with("position")->with("option")
                    ->with("positiontype")
                    ->with("permanentprovince")
                    ->with("currentprovince")
                    ->with("currentdistrict")
                    ->with("currentcommune")
                    ->with("currentvillage")
                    ->first();
                return response()->json(['dataEmployee'=>$datas]);
            }
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }
}
