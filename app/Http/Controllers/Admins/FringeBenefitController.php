<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\FringeBenefit;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class FringeBenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = User::whereIn("emp_status", ["Probation", "1", "2", "10"])->get();
        $data = FringeBenefit::with('employee')->get();
        return view('fringe_benefits.index', compact('data','employees'));
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
            FringeBenefit::create($data);
            Toastr::success('Fringe Benefit created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Fringe Benefit created fail.','Error');
        }
    }

    public function import(Request $request){
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $allDataInSheet = $spreadsheet->getActiveSheet()->toArray();
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $userID = Auth::user()->id;
            $i = 0;
            $re = 1;
            $dataArray = [];
            foreach ($allDataInSheet as $csv) {
                $i++;
                if ($i != 1) {
                    $employee = User::where('number_employee',$csv[0])->first();
                    $request_date = Carbon::createFromFormat('d/m/Y', $csv[3])->format('Y-m-d');
                    $paid_date = Carbon::createFromFormat('d/m/Y', $csv[4])->format('Y-m-d');
                    if (!$employee) {
                        $dataArray[] = $csv;
                    }else{
                        $arr = [
                            'employee_id'           => $employee->id,
                            'amount_usd'            => $csv[1],
                            'amount_riel'           => $csv[2],
                            'request_date'          => $request_date,
                            'paid_date'             => $paid_date,
                            'remark'                => $csv[5],
                            'updated_by'            => $userID,
                            'created_at'            => Carbon::now(),
                        ];
                        DB::table('fringe_benefits')->insert($arr);
                    }
                }
            }
            return 1;
        } else {
            return 0;
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
    public function edit(Request $request)
    {
        $employees = User::whereIn("emp_status", ["Probation", "1", "2", "10"])->get();
        $data = FringeBenefit::where('id',$request->id)->first();
        return response()->json(['success'=>$data, 'employees'=>$employees]);
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
            FringeBenefit::where('id',$request->id)->update([
                'employee_id' => $request->employee_id,
                'amount_usd' => $request->amount_usd,
                'amount_riel' => $request->amount_riel,
                'request_date' => $request->request_date,
                'paid_date' => $request->tax_date,
                'remark' => $request->remark,
                'updated_by' => Auth::user()->id 
            ]);
            Toastr::success('Exchange rate successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Exchange rate fail.','Error');
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
            FringeBenefit::destroy($request->id);
            Toastr::success('Fringe Benefit deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Fringe Benefit delete fail.','Error');
            return redirect()->back();
        }
    }
}
