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
        $employee = User::where('line_manager',Auth::user()->line_manager)->select('id','number_employee','employee_name_kh','employee_name_en')->get();
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
        $title = $request->all();
        dd($title);
        // try {
            // DB::beginTransaction();

            $data = $request->all();
            $data['created_by'] = Auth::id();
            $performance = Performance::create($data);

            if ($request->input('title')) {
                $title = $request->input('title');
                foreach ($title as $item) {
                    $title = Title::create([
                        'employee_id' => $request->employee_id,
                        'title'       => $item['title'] ?? '',
                    ]);
                }
            }
            
            if ($request->input('purpose')) {
                $purpose = $request->input('purpose');
                foreach ($purpose as $item) {
                    $purpose = Purpose::create([
                        'employee_id' => $request->employee_id,
                        'title_id'    => $title->id,
                        'name'        => $item['purpose'] ?? '',
                    ]);
                }
            }
            if ($request->input('keyKpi')) {
                $keyKpi = $request->input('keyKpi');
                foreach ($keyKpi as $item) {
                    PerformanceDetail::create([
                        'performance_id' => $performance->id,
                        'title_id'       => $title->id,
                        'purpose_id'     => $purpose->id,
                        'key_kpi'        => $item['key_kpi'] ?? '',
                        'action_plan'    => $item['action_plan'] ?? '',
                        'goal'           => $item['goal'] ?? '',
                        'weight'         => $item['weight'] ?? '',
                        'created_by'     => Auth::id(),
                    ]);
                }
            }

            // foreach ($request->key_kpi as $key => $item) :
            //     if (!empty($item)) :
            //         PerformanceDetail::create([
            //             'Performance_id'   => $performance->id,
            //             'key_kpi'   => $item,
            //             'action_plan'=> $request->action_plan[$key] ?? '',
            //             'goal'  => $request->goal[$key] ?? '',
            //             'weight'    => $request->weight[$key] ?? '',
            //             'created_by'    => Auth::id(),
            //         ]);
            //     endif;
            // endforeach;

            // $dataTitle = $request->title;

            // if (is_array($dataTitle) && count($dataTitle)) {
            //     foreach ($dataTitle as $titleItem) {
            //         // Create or retrieve a Title record for this employee and title
            //         $title = Title::firstOrCreate([
            //             'employee_id' => $request->employee_id,
            //             'title'       => $titleItem,
            //             'created_by'  => Auth::id()
            //         ]);

            //         // Ensure that purposes align with the current title
            //         if (isset($request->purpose) && is_array($request->purpose)) {
            //             foreach ($request->purpose as $purposeItem) {
            //                 $purpose = Purpose::firstOrCreate([
            //                     'employee_id' => $request->employee_id,
            //                     'title_id'    => $title->id,
            //                     'name'        => $purposeItem,
            //                     'created_by'  => Auth::id(),
            //                 ]);
            //             }
            //         }
            //         // Process KPIs associated with each purpose for the current title
            //         if (isset($request->key_kpi)) {
            //             foreach ($request->key_kpi as $key => $kpiItem) {
            //                 if (!empty($kpiItem)) {
            //                     Performance::firstOrCreate([
            //                         'employee_id'  => $request->employee_id,
            //                         'title_id'     => $title->id,
            //                         'purpose_id'   => $purpose->id,
            //                         'key_kpi'      => $kpiItem,
            //                         'from_date'    => $request->from_date,
            //                         'to_date'      => $request->to_date,
            //                         'action_plan'  => $request->action_plan[$key] ?? '',
            //                         'goal'         => $request->goal[$key] ?? '',
            //                         'weight'       => $request->weight[$key] ?? '',
            //                         'created_by'   => Auth::id(),
            //                     ]);
            //                 }
            //             }
            //         }
            //     }
            // }
            
            
            DB::commit();
            return response()->json(['message' => 'Data saved successfully!']);
            // Toastr::success('Performance created successfully.','Success');
            // return redirect('performance');
        // } catch (\Throwable $exp) {
        //     DB::rollback();
        //     Toastr::error('Performance created fail.','Error');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Performance::with('performanceDetail')->where('employee_id',$id)->get();
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
