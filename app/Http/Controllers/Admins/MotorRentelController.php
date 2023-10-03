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
        $data = MotorRentalDetail::with('motorrental')->with('user')
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
            $data['status'] = 1;
            $data['created_by'] = Auth::user()->id;
            $motor = MotorRentel::create($data);
            Toastr::success('Created successfully.', 'Success');
            $getData = MotorRentel::with('user')->where("id", $motor->id)->first();
            if ($request->status_print) {
                return response()->json([
                    'success' => $getData,
                ]);
            }else{
                return redirect()->back();
            }
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Created fail.', 'Error');
        }
    }

    public function storePay(Request $request)
    {
        try {

            $month = Carbon::now()->month;
            $year = Carbon::now()->year;
            // Get the first day of the month
            $first_day_of_month = Carbon::create($year, $month, 1)->startOfMonth();
            $last_day_of_month = Carbon::now()->lastOfMonth()->format('Y-m-d');

            // count current last day of the month
            $totalLastDayofMonth = Carbon::now()->daysInMonth;
            $motorRentals = MotorRentel::get();
            foreach ($motorRentals as $key => $motor) {
                // logic pay by start date
                $currentMonth1 = Carbon::create($motor->start_date)->format('Y-m');
                $currentMonth2 = Carbon::create($year,$month)->format('Y-m');
                if ($motor->status == 1 && $currentMonth1 == $currentMonth2) {
                    $target_start_date = Carbon::create($motor->start_date);
                    $last_day = Carbon::create($last_day_of_month);
                    $payStartDate = $last_day->diffInDays($target_start_date)+1;
                    $amountMotorPriceInDay = $motor->price_motor_rentel / $totalLastDayofMonth;
                    $amountEngineOilInDay = $motor->price_engine_oil / $totalLastDayofMonth;
                    $amountTaplabRentelInDay = $motor->price_taplab_rentel / $totalLastDayofMonth;
                    $amount_price_motor_rentel = $amountMotorPriceInDay * $payStartDate;
                    $amount_price_engine_oil = $amountEngineOilInDay * $payStartDate;
                    $amount_price_taplab_rentel = $amountTaplabRentelInDay * $payStartDate;
                    $data = [
                        'employee_id' => $motor->employee_id,
                        'motor_rental_id' => $motor->id,
                        'start_date' => $motor->start_date,
                        'end_date' => $motor->end_date,
                        'product_year' => $motor->product_year,
                        'expired_year' => $motor->expired_year,
                        'shelt_life' => $motor->shelt_life,
                        'number_plate' => $motor->number_plate,
                        'motorcycle_brand' => $motor->motorcycle_brand,
                        'category' => $motor->category,
                        'body_number' => $motor->body_number,
                        'engine_number' => $motor->engine_number,
                        'total_gasoline' => $motor->total_gasoline,
                        'total_work_day' => $motor->total_work_day,
                        'price_engine_oil' => $motor->price_engine_oil,
                        'price_motor_rentel' => $motor->price_motor_rentel,
                        'taplab_rentel' => $motor->taplab_rentel,
                        'price_taplab_rentel' => $motor->price_taplab_rentel,
                        'resigned_date' => $motor->resigned_date,
                        'gasoline_price_per_liter' => $request->gasoline_price_per_liter,
                        'amount_price_motor_rentel'=> $amount_price_motor_rentel,
                        'amount_price_engine_oil' => $amount_price_engine_oil,
                        'amount_price_taplab_rentel' => $amount_price_taplab_rentel,
                        'tax_rate' => $request->tax_rate,
                        'created_by' => Auth::user()->id
                    ];
                    MotorRentalDetail::create($data);
                }
                // Logic pay resigned date
                $resignedMonth1 = Carbon::create($motor->resigned_date)->format('Y-m');
                $resignedMonth2 = Carbon::create($year,$month)->format('Y-m');
                if ($motor->status == 0 &&  $resignedMonth1 == $resignedMonth2) {
                    $target_date = Carbon::create($first_day_of_month);
                    $today = Carbon::create($motor->resigned_date);
                    $number_of_days = $today->diffInDays($target_date)+1;
                    $resignedAmountMotorPriceInDay = $motor->price_motor_rentel / $totalLastDayofMonth;
                    $resignedAmountEngineOilInDay = $motor->price_engine_oil / $totalLastDayofMonth;
                    $resignedAmountTaplabRentelInDay = $motor->price_taplab_rentel / $totalLastDayofMonth;
                    $resignedAmount_price_motor_rentel = $resignedAmountMotorPriceInDay * $number_of_days;
                    $resignedAmount_price_engine_oil = $resignedAmountEngineOilInDay * $number_of_days;
                    $resignedAmount_price_taplab_rentel = $resignedAmountTaplabRentelInDay * $number_of_days;
                    $data = [
                        'employee_id' => $motor->employee_id,
                        'motor_rental_id' => $motor->id,
                        'start_date' => $motor->start_date,
                        'end_date' => $motor->end_date,
                        'product_year' => $motor->product_year,
                        'expired_year' => $motor->expired_year,
                        'shelt_life' => $motor->shelt_life,
                        'number_plate' => $motor->number_plate,
                        'motorcycle_brand' => $motor->motorcycle_brand,
                        'category' => $motor->category,
                        'body_number' => $motor->body_number,
                        'engine_number' => $motor->engine_number,
                        'total_gasoline' => $motor->total_gasoline,
                        'total_work_day' => $motor->total_work_day,
                        'price_engine_oil' => $motor->price_engine_oil,
                        'price_motor_rentel' => $motor->price_motor_rentel,
                        'taplab_rentel' => $motor->taplab_rentel,
                        'price_taplab_rentel' => $motor->price_taplab_rentel,
                        'resigned_date' => $motor->resigned_date,
                        'gasoline_price_per_liter' => $request->gasoline_price_per_liter,
                        'amount_price_motor_rentel'=> $resignedAmount_price_motor_rentel,
                        'amount_price_engine_oil' => $resignedAmount_price_engine_oil,
                        'amount_price_taplab_rentel' => $resignedAmount_price_taplab_rentel,
                        'tax_rate' => $request->tax_rate,
                        'created_by' => Auth::user()->id
                    ];
                    MotorRentalDetail::create($data);
                }
                //Logic pay old motor start_date < current month
                if ($motor->status == 1 && $currentMonth1 < $currentMonth2) {
                    $data = [
                        'employee_id' => $motor->employee_id,
                        'motor_rental_id' => $motor->id,
                        'start_date' => $motor->start_date,
                        'end_date' => $motor->end_date,
                        'product_year' => $motor->product_year,
                        'expired_year' => $motor->expired_year,
                        'shelt_life' => $motor->shelt_life,
                        'number_plate' => $motor->number_plate,
                        'motorcycle_brand' => $motor->motorcycle_brand,
                        'category' => $motor->category,
                        'body_number' => $motor->body_number,
                        'engine_number' => $motor->engine_number,
                        'total_gasoline' => $motor->total_gasoline,
                        'total_work_day' => $motor->total_work_day,
                        'price_engine_oil' => $motor->price_engine_oil,
                        'price_motor_rentel' => $motor->price_motor_rentel,
                        'taplab_rentel' => $motor->taplab_rentel,
                        'price_taplab_rentel' => $motor->price_taplab_rentel,
                        'resigned_date' => $motor->resigned_date,
                        'gasoline_price_per_liter' => $request->gasoline_price_per_liter,
                        'amount_price_motor_rentel'=> $motor->price_motor_rentel,
                        'amount_price_engine_oil' => $motor->price_engine_oil,
                        'amount_price_taplab_rentel' => $motor->price_taplab_rentel,
                        'tax_rate' => $request->tax_rate,
                        'created_by' => Auth::user()->id
                    ];
                    MotorRentalDetail::create($data);
                }
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
                    $employee = User::where("number_employee", $csv[0])->first();
                    $start_date = Carbon::createFromDate($csv[1])->format('Y-m-d'); // 2023-04-19
                    $end_date = Carbon::createFromDate($csv[2])->format('Y-m-d'); // 2023-04-19
                    if ($employee) {
                        $arr = [
                            'employee_id'     => $employee->id,
                            'start_date'  => $start_date,
                            'end_date'  => $end_date,
                            'product_year'  => $csv[3],
                            'expired_year'  => $csv[4],
                            'shelt_life'  => $csv[5],
                            'number_plate'  => $csv[6],
                            'motorcycle_brand'=> $csv[7],
                            'category'=> $csv[8],
                            'body_number'=> $csv[9],
                            'engine_number'=> $csv[10],
                            'total_gasoline'  => $csv[11],
                            'total_work_day'  => $csv[12],
                            'price_engine_oil'  => $csv[13],
                            'price_motor_rentel'  => $csv[14],
                            'taplab_rentel'  => $csv[15],
                            'price_taplab_rentel'  => $csv[16],
                            'status' => 1,
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
                'number_plate' => $request->number_plate,
                'motorcycle_brand' => $request->motorcycle_brand,
                'category' => $request->category,
                'body_number' => $request->body_number,
                'engine_number' => $request->engine_number,
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
                'updated_by' => Auth::user()->id
            ];
            MotorRentel::where('id', $request->id)->update($dataUpdate);
            Toastr::success('Updated successfully.', 'Success');
            $getData = MotorRentel::with('user')->where("id", $request->id)->first();
            if ($request->status_print) {
                return response()->json([
                    'success' => $getData,
                ]);
            }else{
                return redirect()->back();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Updated fail.', 'Error');
            return redirect()->back();
        }
    }

    public function processing(Request $request) {
        try {
            MotorRentel::where('id',$request->id)->update([
                'status' => $request->status,
                'resigned_date' => $request->resigned_date,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'The process has been successfully.'
            ]);
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
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
