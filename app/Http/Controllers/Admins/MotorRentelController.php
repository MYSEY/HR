<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportMotorRentel;
use App\Http\Controllers\Controller;
use App\Models\MotorRentalDetail;
use App\Models\MotorRentel;
use App\Models\User;
use App\Repositories\Admin\MotorRentalRepository;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

// use Excel;

class MotorRentelController extends Controller
{
    private $dataMotorPays;
    public function __construct(MotorRentalRepository $dataMotorPay)
    {
        $this->dataMotorPays = $dataMotorPay;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        
        $data = MotorRentel::with('user')->join('users', 'motor_rentels.employee_id', '=', 'users.id')
            ->select(
                'motor_rentels.*',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.number_employee',
                'users.branch_id',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->orWhere('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
                $query->orWhere('users.employee_name_kh', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($from_date, function ($query, $from_date) {
                $query->where('motor_rentels.created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('motor_rentels.created_at','<=', $to_date);
            })
            ->orderBy('id', 'desc')
            ->get();
       
        $employees = User::whereIn("emp_status", ["Probation", "1", "2", "10"])->get();
        if ($request->research) {
            return response()->json(['data'=>$data]);
        }else {
            return view('motor_rentels.index', compact('data', 'employees'));
        }
    }

    public function indexPay(Request $request)
    {
        $monthly = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        $data = MotorRentalDetail::with('user')
            ->whereMonth('created_at', $monthly)
            ->whereYear('created_at', $currentYear)
            ->orderBy('id', 'desc')
            ->get();
        return view('motor_rentels.pay_motor_rental',  compact('data'));
    }
    public function indexPaySearch(Request $request)
    {
        $request["monthly"] = true;
        $data = $this->dataMotorPays->getDatas($request);
        return response()->json(['data'=>$data]);
    }

    public function detail(Request $request)
    {
        $data = MotorRentalDetail::where("id", $request->id)->first();
        return view('motor_rentels.detail', compact('data'));
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
            $motor = MotorRentel::create($data);
            Toastr::success('Created successfully.', 'Success');
            $getData = MotorRentel::with('user')->where("id", $motor->id)->first();
            return response()->json([
                'success' => $getData,
            ]);
            // return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Created fail.', 'Error');
        }
    }

    public function storePay(Request $request)
    {
        try {
            $motorRentals = MotorRentel::get();
            foreach ($motorRentals as $key => $motor) {
                $data = [
                    'employee_id' => $motor->employee_id,
                    'number_plate' => $motor->number_plate,
                    'gasoline_price_per_liter' => $request->gasoline_price_per_liter,
                    'start_date' => $motor->start_date,
                    'end_date' => $motor->end_date,
                    'product_year' => $motor->product_year,
                    'expired_year' => $motor->expired_year,
                    'shelt_life' => $motor->shelt_life,
                    'total_gasoline' => $motor->total_gasoline,
                    'total_work_day' => $motor->total_work_day,
                    'price_engine_oil' => $motor->price_engine_oil,
                    'price_motor_rentel' => $motor->price_motor_rentel,
                    'taplab_rentel' => $motor->taplab_rentel,
                    'price_taplab_rentel' => $motor->price_taplab_rentel,
                    'tax_rate' => $request->tax_rate,
                    'created_by' => Auth::user()->id
                ];
                MotorRentalDetail::create($data);
            }
            Toastr::success('Created successfully.', 'Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Created fail.', 'Error');
        }
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
        $employee = User::whereIn("emp_status", ["Probation", "1", "2", "10"])->get();
        return response()->json([
            'success' => $data,
            'employee' => $employee,
        ]);
    }

    public function export()
    {
        $dataMotorrentels = MotorRentel::orderBy('id', 'desc')->get();
        $export = new ExportMotorRentel($dataMotorrentels);
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
                    $start_date = Carbon::createFromDate($csv[1])->format('Y-m-d'); // 2023-04-19
                    $end_date = Carbon::createFromDate($csv[2])->format('Y-m-d'); // 2023-04-19
                    $employee = User::where("number_employee", $csv[0])->first();
                    if ($employee) {
                        $arr = [
                            'employee_id'     => $employee->id,
                            'start_date'  => $start_date,
                            'end_date'  => $end_date,
                            'product_year'  => $csv[3],
                            'expired_year'  => $csv[4],
                            'shelt_life'  => $csv[5],
                            'number_plate'  => $csv[6],
                            'total_gasoline'  => $csv[7],
                            'total_work_day'  => $csv[8],
                            'price_engine_oil'  => $csv[9],
                            'price_motor_rentel'  => $csv[10],
                            'taplab_rentel'  => $csv[11],
                            'price_taplab_rentel'  => $csv[12],
                            'created_by'        => $userID,
                            'created_at'       => Carbon::now(),
                        ];
                        DB::table('motor_rentels')->insert($arr);
                    }
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
                // 'gasoline_price_per_liter' => $request->gasoline_price_per_liter,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'product_year' => $request->product_year,
                'expired_year' => $request->expired_year,
                'shelt_life' => $request->shelt_life,
                'total_gasoline' => $request->total_gasoline,
                'total_work_day' => $request->total_work_day,
                'price_engine_oil' => $request->price_engine_oil,
                'price_motor_rentel' => $request->price_motor_rentel,
                'taplab_rentel' => $request->taplab_rentel,
                'price_taplab_rentel' => $request->price_taplab_rentel,
                // 'tax_rate' => $request->tax_rate,
                'updated_by' => Auth::user()->id
            ];
            MotorRentel::where('id', $request->id)->update($dataUpdate);
            Toastr::success('Updated successfully.', 'Success');
            return redirect()->back();
            DB::commit();
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
