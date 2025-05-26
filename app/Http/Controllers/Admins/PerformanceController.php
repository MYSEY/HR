<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\Title;
use App\Models\Purpose;
use App\Models\Performance;
use Illuminate\Http\Request;
use App\Models\PerformanceDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class PerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Performance::leftJoin('users', 'performances.employee_id', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->select(
            'performances.*',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'departments.name_english as dep_name',
            'positions.name_english as positions_name',
            'branchs.branch_name_en',
            'branchs.branch_name_kh',
        )->groupBy('performances.employee_id');
        // Fetch paginated data
        $data = $query->get();
        return view('performances.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = User::where('emp_status','!=',null)->select('id','number_employee','employee_name_kh','employee_name_en')->get();
        // $employee = User::where('line_manager',Auth::user()->line_manager)->where('emp_status','!=',null)->select('id','number_employee','employee_name_kh','employee_name_en')->get();
        return view('performances.create',compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'purpose' => 'required|string|max:255',
        //     'key_kpi' => 'required|string',
        //     'action_plan' => 'required|string',
        //     'goal' => 'required|string',
        //     'weight' => 'required|numeric|min:0|max:100',
        // ]);
       
        try {
            // DB::beginTransaction();
            $data = $request->all();
            $data['created_by'] = Auth::id();

            // Create main performance record
            $performance = Performance::create($data);
            foreach ($request->data as $titleItem) {
                // Create Title
                $title = Title::create([
                    'performance_id' => $performance->id,
                    'title' => $titleItem['title'],
                ]);

                // Loop through each purpose under this title
                foreach ($titleItem['dataPurpose'] as $purposeItem) {
                    $purpose = Purpose::create([
                        'performance_id' => $performance->id,
                        'title_id'    => $title->id,
                        'name'        => $purposeItem['purpose'],
                    ]);

                    // Loop through each KPI under this purpose
                    foreach ($purposeItem['dataKPi'] as $kpiItem) {
                        PerformanceDetail::create([
                            'performance_id' => $performance->id,
                            'title_id'       => $title->id,
                            'purpose_id'     => $purpose->id,
                            'key_kpi'        => $kpiItem['key_kpi'],
                            'action_plan'    => $kpiItem['action_plan'],
                            'goal'           => $kpiItem['goal'],
                            'weight'         => $kpiItem['weight'],
                            'created_by'     => Auth::id(),
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json(['message' => 'Data saved successfully!']);
            // Toastr::success('Performance created successfully.','Success');
            // return redirect('performance');
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Performance created fail.','Error');
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
        $data = Performance::with(['titles.purposes.performanceDetail'])
        ->leftJoin('users', 'performances.employee_id', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->select(
            'performances.*',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'departments.name_english as dep_name',
            'positions.name_english as positions_name',
            'branchs.branch_name_en',
            'branchs.branch_name_kh',
        )->where('performances.employee_id',$id)->first();
        // dd($data);
        return view('performances.preview',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = User::where('line_manager',Auth::user()->line_manager)->select('id','number_employee','employee_name_kh','employee_name_en')->get();
        return view('performances.edit',compact('employee'));
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
