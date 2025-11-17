<?php

namespace App\Http\Controllers\Admins;

use App\Models\Branchs;
use Illuminate\Http\Request;
use App\Models\AnnualBonuBranch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class ConfigeAnnualBonuByBranchCongroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AnnualBonuBranch::with('branch')->get();
        $branches = Branchs::all();
        return view('annual_bonu_by_brach.index',compact('data','branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branchs::all();
        return view('annual_bonu_by_brach.create',compact('branches'));
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
            $branch  = $request->input('branch_id', []);
            $percentages     = $request->input('percentage', []);
            $increasementYears = $request->input('year', []);
            $createdBy = Auth::id();

            foreach ($branch as $key => $ranking) {
                AnnualBonuBranch::create([
                    'branch_id' => $ranking,
                    'percentage'    => $percentages[$key] ?? null,
                    'year'  => $increasementYears[$key] ?? null,
                    'created_by'    => $createdBy,
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
        $data = AnnualBonuBranch::findOrFail($id);
        $branches = Branchs::all();
        return response()->json([
            'success'=>$data,
            'branches'=>$branches,

        ]);
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
}
