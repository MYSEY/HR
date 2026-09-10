<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PayrollAdjustment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Requests\AdjustmentRequest;

class PayrollItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (permissionAccess("m4-s6","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        if (request()->ajax()) {
            // Define the base query
            $query = PayrollAdjustment::leftJoin('users', 'payroll_adjustments.employee_id', '=', 'users.id')
            ->select(
                'payroll_adjustments.*',
                'users.employee_name_en',
            )->where('payroll_adjustments.deleted_at', null);
            $query->when($request->employee_name, function ($query, $employee_name) {
                return $query->where('users.employee_name_en', $employee_name);
            })
            ->when($Monthly, function ($query, $Monthly) {
                return $query->whereMonth('payroll_adjustments.adjustment_date', '=',$Monthly); 
            })->when($yearLy, function ($query, $yearLy) {
                return $query->whereYear('payroll_adjustments.adjustment_date', '=',$yearLy); 
            });

            // **Search Handling**
            $searchValue = request()->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('payroll_adjustments.id', 'like', "%{$searchValue}%")
                    ->orWhere('payroll_adjustments.amount', 'like', "%{$searchValue}%")
                    ->orWhere('payroll_adjustments.adjustment_date', 'like', "%{$searchValue}%")
                    ->orWhere('payroll_adjustments.adjustment_type', 'like', "%{$searchValue}%")
                    ->orWhere('payroll_adjustments.description', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%");
                });
            }

            // Fetch paginated data
            $recordsTotal = $query->count();
            $recordsFiltered = $query->count();
            // Apply pagination for the actual data retrieval
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));
            $data = $query->orderBy('id', 'DESC')->offset($start)->limit($limit)->get();
            // Return JSON response
            return response()->json([
                'draw' => intval($request->input('draw')),  // Optional: for client-side tracking
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        $employee = User::where('status','Active')->where('number_employee','!=','000-0000')->where('number_employee','!=','230-0000')->get();
        return view('payroll_item.index',compact('employee'));
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
    public function store(AdjustmentRequest $request)
    {
        try {
            $data = $request->all();
            $data['created_by']    = Auth::user()->id;
            PayrollAdjustment::create($data);
            DB::commit();
            Toastr::success('Adjustments created successfully.','Success');
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Adjustments created fail.','Error');
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
        $employee = User::whereIn('emp_status',['Probation','1','2','10'])->get();
        $adjustment = PayrollAdjustment::find($id);
        if (!$adjustment) {
            return response()->json(['error' => 'Record not found'], 404);
        }
        return response()->json([
            'success'=>$adjustment,
            'employee'=>$employee
        ]);
        return response()->json($adjustment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdjustmentRequest $request)
    {
        try {
            PayrollAdjustment::where('id',$request->id)->update([
                'employee_id'    => $request->employee_id,
                'amount'    => $request->amount,
                'adjustment_date'    => $request->adjustment_date,
                'adjustment_type'    => $request->adjustment_type,
                'description'    => $request->description,
                'updated_by'    => Auth::user()->id,
            ]);
            DB::commit();
            Toastr::success('Adjustments updated successfully.','Success');
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Adjustments updated fail.','Error');
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
            $adjustment = PayrollAdjustment::find($id);
            if (!$adjustment) {
                return response()->json(['mg' => 'error', 'message' => 'Record not found'], 404);
            }
            $adjustment->delete();
            return response()->json(['mg' => 'success']);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }

    public function adjustmentImport(Request $request){
        $file = $request->file;
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $adjustmentFile =  $spreadsheet->getSheetByName('adjustment')->toArray();
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $i = 0;
            $dataArray = [];
            $dataAdjustment = [];
            foreach ($adjustmentFile as $item) {
                $i++;
                if ($i != 1) {
                    $employee = User::where("number_employee", $item[0])->select('id','number_employee')->first();
                    if($employee){
                        PayrollAdjustment::firstOrCreate([
                            'employee_id'   => $employee->id,
                            'amount'    => $item[2] == null ? 0 : $item[2],
                            'adjustment_date'   => Carbon::parse($item[3])->format('Y-m-d'),
                            'adjustment_type'   => $item[4],
                            'description'   => $item[5],
                            'created_by'    => Auth::user()->id,
                        ]);
                    }else{
                        $dataAdjustment[] = [$item[0]];
                    }
                }
            }
            if($dataArray){
                return response()->json(['error'=>$dataArray]);
            }
            return 1;
        } else {
            return 0;
        }
    }
}
