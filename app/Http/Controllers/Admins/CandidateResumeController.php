<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\CandidateResume;
use App\Models\Department;
use App\Models\Option;
use App\Models\Position;
use App\Models\User;
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
        $position = Position::all();
        $branch = Branchs::all();
        $gender = Option::where('type','gender')->get();
        $data = CandidateResume::where("status", "1")->get();
        return view('recruitments.candidate_resumes.candidate_resume', compact(["position", "branch", "gender", "data" ]));
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
            Toastr::success('Candidate resume created successfully.','Success');
            return redirect()->back();
            DB::commit();
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
        $data = CandidateResume::where("id", $request->id)->first();
        $gender = Option::where('type','gender')->get();
        return response()->json([
            'success'=>$data,
            'gender'=>$gender,
            'position'=>$position,
            'branch'=>$branch,
        ]);
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
                        'updated_by' => Auth::user()->id,
                    ];
                }else{
                    $dataUpdate = [
                        'status' => $request->status,
                        'short_list' => $request->short_list,
                        'interviewed_date' => null,
                        'interviewed_channel' => null,
                        'committee_interview' => null,
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
                        'updated_by' => Auth::user()->id,
                    ];
                }else{
                    $dataUpdate = [
                        'status' => $request->status,
                        'joined_interview' => $request->joined_interview,
                        'interviewed_result' =>null,
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
            CandidateResume::where('id',$request->id)->update($dataUpdate);
            if ($request->status == "4") {
                $dataCandidate = CandidateResume::where("id", $request->id)->first();
                $newDateTime = Carbon::parse($dataCandidate->join_date)->addMonths(3);
                $dataEmployee = [
                    'number_employee' => $this->generate_EmployeeId(Carbon::today())['number_employee'],
                    'employee_name_kh' => $dataCandidate->name_kh,
                    'employee_name_en' => $dataCandidate->name_en,
                    'password' => Hash::make("camma@newstaff@12"),
                    'personal_phone_number' => $dataCandidate->contact_number,
                    'position_id' => $dataCandidate->position_applied,
                    'branch_id' => $dataCandidate->location_applied,
                    'gender' => $dataCandidate->gender,
                    'date_of_commencement' => $dataCandidate->join_date,
                    'fdc_date' => $newDateTime,
                    'emp_status' => "Probation",
                    'basic_salary' => 0,
                ];
                User::create($dataEmployee);
            }
            DB::commit();
            return ['message' => 'successfull'];
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }
}
