<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportMotorRentel;
use App\Http\Controllers\Controller;
use App\Models\MotorRentel;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

// use Excel;

class MotorRentelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MotorRentel::orderBy('id', 'desc')->get();
        $employees = User::all();
        return view('motor_rentels.index', compact('data', 'employees'));
    }

    public function detail(Request $request)
    {
        $data = MotorRentel::where("id", $request->id)->first();
        // $employees = User::all();
        return view('motor_rentels.detail', compact('data'));
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
        // $product_year = Carbon::createFromDate($request->product_year)->format('Y');
        // $expried_year = Carbon::createFromDate($request->expired_year)->format('Y');
        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            MotorRentel::create($data);
            Toastr::success('Created successfully.', 'Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Created fail.', 'Error');
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
        $data = MotorRentel::where("id", $request->id)->first();
        $employee = User::all();
        return response()->json([
            'success' => $data,
            'employee' => $employee,
        ]);
    }

    public function export()
    {
        $export = new ExportMotorRentel;
        return Excel::download($export, 'MotorRentel.xlsx');
    }

    public function import(Request $request)
    {
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $allDataInSheet = $spreadsheet->getActiveSheet()->toArray();

        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $userID = Auth::user()->id;
            $i = 0;
            $re = 1;
            foreach ($allDataInSheet as $csv) {
                $i++;
                if ($i != 1) {
                    $start_date = Carbon::createFromDate($csv[2])->format('Y-m-d'); // 2023-04-19
                    $end_date = Carbon::createFromDate($csv[3])->format('Y-m-d'); // 2023-04-19
                    $arr = [
                        'employee_id'     => $csv[0],
                        'gasoline_price_per_liter'  => $csv[1],
                        'start_date'  => $start_date,
                        'end_date'  => $end_date,
                        'product_year'  => $csv[4],
                        'expired_year'  => $csv[5],
                        'shelt_life'  => $csv[6],
                        'number_plate'  => $csv[7],
                        'total_gasoline'  => $csv[8],
                        'total_work_day'  => $csv[9],
                        'price_engine_oil'  => $csv[10],
                        'price_motor_rentel'  => $csv[11],
                        'tax_rate'  => $csv[12],
                        'created_by'        => $userID,
                        'created_at'       => Carbon::now(),
                    ];
                    DB::table('motor_rentels')->insert($arr);
                }
            }
            return 1;
        } else {
            return 0;
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
        try {
            $dataUpdate = [
                'employee_id' => $request->employee_id,
                'gasoline_price_per_liter' => $request->gasoline_price_per_liter,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'product_year' => $request->product_year,
                'expired_year' => $request->expired_year,
                'shelt_life' => $request->shelt_life,
                'total_gasoline' => $request->total_gasoline,
                'total_work_day' => $request->total_work_day,
                'price_engine_oil' => $request->price_engine_oil,
                'price_motor_rentel' => $request->price_motor_rentel,
                'tax_rate' => $request->tax_rate,
                'updated_by' => Auth::user()->id
            ];
            MotorRentel::where('id', $request->id)->update($dataUpdate);
            Toastr::success('Updated successfully.', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Updated fail.', 'Error');
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
        try {
            MotorRentel::destroy($request->id);
            Toastr::success('Deleted successfully.', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Delete fail.', 'Error');
            return redirect()->back();
        }
    }
}
