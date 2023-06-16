<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\CandidateResume;
use App\Models\Department;
use App\Models\Position;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CandidateResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $position = Position::all();
        $branch = Branchs::all();
        $department = Department::all();
        $data = CandidateResume::where("status", "1")->get();
        return view('recruitments.candidate_resumes.candidate_resume', compact(["position", "branch", "department", "data" ]));
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
        $datas = CandidateResume::where("status", $request->status)->with("branch")->with("position")->get();
        return response()->json(['datas'=>$datas]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
            
            DB::commit();
            return ['message' => 'successfull'];
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }
}
