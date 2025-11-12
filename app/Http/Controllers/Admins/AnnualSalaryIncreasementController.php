<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\AnnualSalaryIncreasement;
use App\Http\Requests\AnnualSalaryIncreasementRequest;

class AnnualSalaryIncreasementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentYear = now()->year;
        $data = AnnualSalaryIncreasement::whereYear('increasement_year', $currentYear)->get();
        return view('annual_salary_increasement.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('annual_salary_increasement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnualSalaryIncreasementRequest $request)
    {
        try {
            $rankingResults  = $request->input('ranking_work_result', []);
            $totalScores     = $request->input('total_score', []);
            $percentages     = $request->input('percentage', []);
            $increasementYears = $request->input('increasement_year', []);

            $createdBy = Auth::id();

            foreach ($rankingResults as $key => $ranking) {
                AnnualSalaryIncreasement::create([
                    'ranking_work_result' => $ranking,
                    'total_score'         => $totalScores[$key] ?? null,
                    'percentage'          => $percentages[$key] ?? null,
                    'increasement_year'   => $increasementYears[$key] ?? null,
                    'created_by'          => $createdBy,
                ]);
            }

            DB::commit();
            Toastr::success('Annual salary increasement(s) created successfully.', 'Success');
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollBack();
            Toastr::error('Annual salary increasement creation failed.', 'Error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = AnnualSalaryIncreasement::findOrFail($id);
        return response()->json([
            'success'=>$data,
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
        try {
            $data = $request->only(['ranking_work_result', 'total_score', 'percentage','increasement_year']);
            $data['updated_by'] = Auth::user()->id;
            AnnualSalaryIncreasement::where('id', $request->id)->update($data);
            DB::commit(); // commit transaction
            Toastr::success('Annual salary increasement updated successfully.','Success');
            return redirect()->back();
        } catch (\Throwable $exp) {
            Toastr::error('nnual salary increasement created fail.','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            AnnualSalaryIncreasement::destroy($id);
            Toastr::success('Annual salary increasement deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Annual salary increasement delete fail.','Error');
            return redirect()->back();
        }
    }
}
