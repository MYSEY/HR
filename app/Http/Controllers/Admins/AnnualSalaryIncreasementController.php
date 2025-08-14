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
        $data = AnnualSalaryIncreasement::all();
        return view('annual_salary_increasement.index',compact('data'));
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
    public function store(AnnualSalaryIncreasementRequest $request)
    {
        try {
            $data = $request->all();
            $data['created_by']    = Auth::user()->id;
            AnnualSalaryIncreasement::create($data);
            Toastr::success('Annual salary increasement created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            Toastr::error('nnual salary increasement created fail.','Error');
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
            $data = $request->only(['ranking_work_result', 'total_score', 'percentage']);
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
