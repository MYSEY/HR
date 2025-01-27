<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\User;
use App\Models\MotorRentel;
use Illuminate\Http\Request;
use App\Models\MotorRentalDetail;
use App\Exports\ExportMotorRentel;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Holiday;
use App\Models\LeaveRequest;
use App\Models\MotorAdjustment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Spatie\Activitylog\Models\Activity;
use App\Repositories\Admin\EmployeeRepository;
use App\Repositories\Admin\MotorRentalRepository;

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
        if (permissionAccess("m5-s1","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        $data = MotorRentel::with('user')->leftJoin('users', 'motor_rentels.employee_id', '=', 'users.id')
            ->select(
                'motor_rentels.*',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.number_employee',
                'users.branch_id',
                'users.department_id',
                'users.resign_date',
            )
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if ($RolePermission == 'Employee') {
                    $query->where('users.id',Auth::user()->id);
                }
                if ($RolePermission == 'HOD') {
                    $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
                }
                if ($RolePermission == 'BM' || $RolePermission == 'HR') {
                    $query->where("users.branch_id", Auth::user()->branch_id);
                }
            })
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
                // $query->orWhere('users.employee_name_kh', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($from_date, function ($query, $from_date) {
                $query->where('motor_rentels.created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('motor_rentels.created_at','<=', $to_date);
            })
            ->orderBy('id', 'desc')
            ->get();

        $employees = User::whereIn("emp_status", ["Probation", "1", "2", "10"])
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if ($RolePermission == 'Employee') {
                    $query->where('id',Auth::user()->id);
                }
                if ($RolePermission == 'HOD') {
                    $query->whereIn("department_id", EmployeeRepository::getRoleHOD());
                }
                if ($RolePermission == 'HR') {
                    $query->where("branch_id", Auth::user()->branch_id);
                }
                if ($RolePermission == 'BM') {
                    $query->where("branch_id", Auth::user()->branch_id);
                }
            })
            ->get();
        if ($request->research) {
            return response()->json(['data'=>$data]);
        }else {
            return view('motor_rentels.index', compact('data', 'employees'));
        }
    }

    public function indexReviewPay(Request $request)
    {
        if (permissionAccess("m5-s3","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $monthly = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        $data = MotorRentalDetail::with('motorrental')->with('user')
            ->leftJoin('users', 'motor_rental_details.employee_id', '=', 'users.id')
            ->select(
                'motor_rental_details.*',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.number_employee',
                'users.branch_id',
                'users.department_id',
            )
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if ($RolePermission == 'Employee') {
                    $query->where('users.id',Auth::user()->id);
                }
                if ($RolePermission == 'HOD') {
                    $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
                }
                if ($RolePermission == 'BM' || $RolePermission == 'HR') {
                    $query->where("users.branch_id", Auth::user()->branch_id);
                }
            })
            ->where("motor_rental_details.status", null)
            ->whereMonth('motor_rental_details.created_at', $monthly)
            ->whereYear('motor_rental_details.created_at', $currentYear)
            ->orderBy('id', 'desc')
            ->get();
        return view('motor_rentels.review',  compact('data'));
    }

    public function indexPay(Request $request)
    {
        if (permissionAccess("m5-s2","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $monthly = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        $data = MotorRentalDetail::with('motorrental')->with('user')
            ->leftJoin('users', 'motor_rental_details.employee_id', '=', 'users.id')
            ->select(
                'motor_rental_details.*',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.number_employee',
                'users.branch_id',
                'users.department_id',
            )
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if ($RolePermission == 'Employee') {
                    $query->where('users.id',Auth::user()->id);
                }
                if ($RolePermission == 'HOD') {
                    $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
                }
                if ($RolePermission == 'BM' || $RolePermission == 'HR') {
                    $query->where("users.branch_id", Auth::user()->branch_id);
                }
            })
            ->where("motor_rental_details.status", "approve")
            ->whereMonth('motor_rental_details.created_at', $monthly)
            ->whereYear('motor_rental_details.created_at', $currentYear)
            ->orderBy('id', 'desc')
            ->get();
        return view('motor_rentels.pay_motor_rental',  compact('data'));
    }

    public function payApproved(Request $request){
        try{
            $dataPay = MotorRentalDetail::whereIn('id',explode(",",$request->id))->update(['status' => 'approve']);
            if ($dataPay) {
                Toastr::success('Approved successfully.','Success');
            } else {
                Toastr::error('Approved fail','Error');
            }
            return redirect()->back();
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Approved fail','Error');
            return redirect()->back();
        }
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
            Activity::all()->last();
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
        DB::beginTransaction();
        try {

            $month = Carbon::now()->month;
            $year = Carbon::now()->year;

            MotorRentalDetail::where('status',null)->delete();

            // **** Logic Public Holiday
            $holidays = Holiday::where('from', '<=', $request->to_date)
            ->where('to', '>=', $request->from_date)
            ->get();

            $totaHolidays = 0;
            if (count($holidays) > 0){
                foreach ($holidays as $key => $hl) {
                    $totaHolidays += Helper::countWorkingDays($hl->from, $hl->to);
                }
            }
            // **** end

            // count current last day of the month
            $motorRentals = MotorRentel::leftJoin('users', 'motor_rentels.employee_id', '=', 'users.id')
                            ->select(
                                'motor_rentels.*',
                                'users.employee_name_en',
                                'users.employee_name_kh',
                                'users.number_employee',
                                'users.branch_id',
                                'users.department_id',
                            )
                            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                                if ($RolePermission == 'Employee') {
                                    $query->where('users.id',Auth::user()->id);
                                }
                                if ($RolePermission == 'HOD') {
                                    $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
                                }
                                if ($RolePermission == 'BM' || $RolePermission == 'HR') {
                                    $query->where("users.branch_id", Auth::user()->branch_id);
                                }
                            })
                            ->where('start_date', '<=', $request->to_date)
                            ->where(function ($query) use ($request) {
                                $query->where('motor_rentels.resigned_date', '>=', $request->from_date)
                                      ->orWhereNull('motor_rentels.resigned_date');
                            })
                            ->get();
            
            foreach ($motorRentals as $key => $motor) {

                // **** Logic count total request leave
                $dataLeaveRequest = LeaveRequest::where('employee_id', $motor->employee_id)
                ->whereIn('status', ["approved_hod", "approved_hod", "approved"])
                ->where('start_date', '<=', $request->to_date)
                ->where('end_date', '>=', $request->from_date)
                ->get();
                $totalLeave = 0;
                if (count($dataLeaveRequest) > 0){
                    foreach ($dataLeaveRequest as $key => $lr) {
                        $totalLeave += $lr->number_of_day;
                    }
                }
                // **** end
            

                $totalWorkDay = (Helper::countWorkingDays($request->from_date, $request->to_date) - $totaHolidays - $totalLeave);
                // **** price motor by year
                $ageMotorrentel = Helper::calculateAgeMotor($motor->product_year);
                $priceMotorRentel = 0;
                if ($ageMotorrentel >= 0 && $ageMotorrentel <= 5) {
                    $priceMotorRentel = 30;
                } elseif ($ageMotorrentel > 5 && $ageMotorrentel <= 7) {
                    $priceMotorRentel = 25;
                } elseif ($ageMotorrentel > 7 && $ageMotorrentel <= 10) {
                    $priceMotorRentel = 20;
                }

                // **** logic pay adjustment by month and year
                $adjust_amount_exclude = 0;
                $adjust_amount_tabple_exclude = 0;
                $adjust_amount_include = 0;
                $adjust_amount_tabple_include = 0;
                $adjust_amount_kh = 0;
                $adjust_amount_engine_oil = 0;
                $adjusts = MotorAdjustment::where('employee_id',$motor->employee_id)
                ->whereMonth('adjustment_date', $month)
                ->whereYear('adjustment_date', $year)
                ->first();
                if ($adjusts) {
                    $adjust_amount_kh =  $adjusts->amount_kh;
                    $adjust_amount_engine_oil = $adjusts->amount_engine_oil;
                    if ($adjusts->adjustment_type == "include_taxe") {
                        $adjust_amount_include =  $adjusts->amount_usd;
                        $adjust_amount_tabple_include = $adjusts->amount_table_usd;
                    }else{
                        $adjust_amount_exclude = $adjusts->amount_usd;
                        $adjust_amount_tabple_exclude = $adjusts->amount_table_usd;
                    }
                }

                // **** login pay by start date on tablet
                $amount_price_taplab_rentel = $motor->price_taplab_rentel;
                if ($motor->status == 1 && ($motor->start_date_taplab >= $request->from_date && $motor->start_date_taplab <= $request->to_date)) {
                    if ($motor->start_date_taplab == $request->from_date) {
                       $amount_price_taplab_rentel = $motor->price_taplab_rentel;
                    }else{
                        $totalWorkingStartTablet = Helper::countWorkingDays($motor->start_date_taplab, $request->to_date);
                        $totalDay = Helper::countWorkingDays($request->from_date, $request->to_date);
                        $amountTaplabRentelInDayStartTablet = ($motor->price_taplab_rentel / $totalDay);
                        $amount_price_taplab_rentel = ($amountTaplabRentelInDayStartTablet * $totalWorkingStartTablet);
                    }
                }

                // **** login pay by start date on motor
                $amount_price_motor_rentel = $priceMotorRentel;
                $amount_price_engine_oil = $motor->price_engine_oil;
                
                if ($motor->status == 1 && ($motor->start_date >= $request->from_date && $motor->start_date <= $request->to_date)) {

                    // **** Logic Public Holiday
                    $holidays = Holiday::where('from', '<=', $request->to_date)
                    ->where('to', '>=', $motor->start_date)
                    ->get();

                    $totaHolidayStart = 0;
                    if (count($holidays) > 0){
                        foreach ($holidays as $key => $hl) {
                            $totaHolidayStart += Helper::countWorkingDays($hl->from, $hl->to);
                        }
                    }
                    // **** end

                    if ($motor->start_date == $request->from_date) {
                        $amount_price_motor_rentel = $priceMotorRentel;
                        $amount_price_engine_oil = $motor->price_engine_oil;
                        $totalWorkDay = (Helper::countWorkingDays($request->from_date, $request->to_date) - $totaHolidayStart - $totalLeave);
                    }else{

                        $totalWorkingStart = Helper::countWorkingDays($motor->start_date, $request->to_date);
                        $totalDay = Helper::countWorkingDays($request->from_date, $request->to_date);
                        $amountMotorPriceInDayStart = $priceMotorRentel / $totalDay;
                        $totalWorkDay = ($totalWorkingStart - $totaHolidayStart - $totalLeave);
                        $amountEngineOilInDayStart = ($motor->price_engine_oil / $totalDay);
                        $amount_price_motor_rentel = ($amountMotorPriceInDayStart * $totalWorkingStart);
                        $amount_price_engine_oil = ($amountEngineOilInDayStart * $totalWorkingStart);
                    }
                }

                // **** Logic pay resigned date
                if ($motor->status == 0 && ($motor->resigned_date >= $request->from_date && $motor->resigned_date <= $request->to_date)) {
                    
                    // **** Logic Public Holiday
                    $holidays = Holiday::where('from', '<=', $motor->resigned_date)
                    ->where('to', '>=', $request->from_date)
                    ->get();

                    $totaHolidaysResign = 0;
                    if (count($holidays) > 0){
                        foreach ($holidays as $key => $hl) {
                            $totaHolidaysResign += Helper::countWorkingDays($hl->from, $hl->to);
                        }
                    }
                    // **** end

                    if ($motor->resigned_date == $request->to_date) {
                        $amount_price_motor_rentel = $priceMotorRentel;
                        $amount_price_engine_oil = $motor->price_engine_oil;
                        $amount_price_taplab_rentel = $motor->price_taplab_rentel;
                        $totalDay = Helper::countWorkingDays($request->from_date, $request->to_date);
                        $totalWorkDay = ($totalDay - $totaHolidaysResign - $totalLeave);
                    }else{
                        $totalWorkingResign = Helper::countWorkingDays($request->from_date, $motor->resigned_date);
                        $totalDay = Helper::countWorkingDays($request->from_date, $request->to_date);
                        $totalWorkDay = ($totalWorkingResign - $totaHolidaysResign - $totalLeave);
                        
                        $amountMotorPriceInDayResign = $priceMotorRentel / $totalDay;
                        $amountEngineOilInDayResign = $motor->price_engine_oil / $totalDay;
                        $amount_price_motor_rentel = ($amountMotorPriceInDayResign * $totalWorkingResign);
                        $amount_price_engine_oil = ($amountEngineOilInDayResign * $totalWorkingResign);

                        $amountTaplabRentelInDayResign = $motor->price_taplab_rentel / $totalDay;
                        $amount_price_taplab_rentel = ($amountTaplabRentelInDayResign * $totalWorkingResign);
                    }
                }
                $data = [
                    'employee_id' => $motor->employee_id,
                    'motor_rental_id' => $motor->id,
                    'start_date' => $motor->start_date,
                    'end_date' => $motor->end_date,
                    'product_year' => $motor->product_year,
                    'expired_year' => $motor->expired_year,
                    'motor_color' => $motor->motor_color,
                    'shelt_life' => $ageMotorrentel,
                    'number_plate' => $motor->number_plate,
                    'motorcycle_brand' => $motor->motorcycle_brand,
                    'category' => $motor->category,
                    'body_number' => $motor->body_number,
                    'engine_number' => $motor->engine_number,
                    'total_gasoline' => $motor->total_gasoline,
                    'total_work_day' => $totalWorkDay,
                    'price_engine_oil' => $motor->price_engine_oil,
                    'price_motor_rentel' => ($motor->is_motor_fee !=1 ? $priceMotorRentel: 0),
                    'taplab_rentel' => $motor->taplab_rentel,
                    'taplab_imei' => $motor->taplab_imei,
                    'start_date_taplab' => $motor->start_date_taplab,
                    'price_taplab_rentel' => $motor->price_taplab_rentel,
                    'resigned_date' => $motor->resigned_date,
                    'gasoline_price_per_liter' => $request->gasoline_price_per_liter,
                    'amount_price_motor_rentel'=> ($motor->is_motor_fee !=1 ? $amount_price_motor_rentel : 0),
                    'amount_price_engine_oil' => $amount_price_engine_oil,
                    'amount_price_taplab_rentel' => $amount_price_taplab_rentel,
                    'adjust_amount_exclude'         => $adjust_amount_exclude,
                    'adjust_amount_tabple_exclude'  => $adjust_amount_tabple_exclude,   
                    'adjust_amount_include'         => $adjust_amount_include,
                    'adjust_amount_tabple_include'  => $adjust_amount_tabple_include,
                    'adjust_amount_kh'              => $adjust_amount_kh,
                    'adjust_amount_engine_oil'      => $adjust_amount_engine_oil,
                    'from_date'                     => $request->from_date,
                    'to_date'                       => $request->to_date,
                    'tax_rate' => $request->tax_rate,
                    'created_by' => Auth::user()->id
                ];
                MotorRentalDetail::create($data);
            }
            DB::commit();
            Toastr::success('Created successfully.', 'Success');
            return redirect()->back();
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
                    $start_date_taplab = $csv[18] ? Carbon::createFromDate($csv[18])->format('Y-m-d') : null; // 2023-04-19
                    if ($employee) {
                        $arr = [
                            'employee_id'           => $employee->id,
                            'start_date'            => $start_date,
                            'end_date'              => $end_date,
                            'product_year'          => $csv[3],
                            'expired_year'          => $csv[4],
                            'shelt_life'            => $csv[5],
                            'number_plate'          => $csv[6],
                            'motorcycle_brand'      => $csv[7],
                            'category'              => $csv[8],
                            'body_number'           => $csv[9],
                            'engine_number'         => $csv[10],
                            'motor_color'           => $csv[11],
                            'total_gasoline'        => $csv[12],
                            'total_work_day'        => $csv[13],
                            'price_engine_oil'      => $csv[14],
                            'price_motor_rentel'    => $csv[15],
                            'taplab_rentel'         => $csv[16],
                            'taplab_imei'           => $csv[17],
                            'start_date_taplab'     => $start_date_taplab,
                            'price_taplab_rentel'   => $csv[19],
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
            $data = MotorRentel::find($request->id);
            $data['employee_id']        = $request->employee_id;
            $data['number_plate']       = $request->number_plate;
            $data['motorcycle_brand']   = $request->motorcycle_brand;
            $data['category']           = $request->category;
            $data['body_number']        = $request->body_number;
            $data['engine_number']      = $request->engine_number;
            $data['start_date']         = $request->start_date;
            $data['end_date']           = $request->end_date;
            $data['product_year']       = $request->product_year;
            $data['expired_year']       = $request->expired_year;
            $data['shelt_life']         = $request->shelt_life;
            $data['total_gasoline']     = $request->total_gasoline;
            $data['total_work_day']     = $request->total_work_day;
            $data['price_engine_oil']   = $request->price_engine_oil;
            $data['is_motor_fee']   = $request->is_motor_fee;
            $data['price_motor_rentel'] = $request->price_motor_rentel;
            $data['taplab_rentel']      = $request->taplab_rentel;
            $data['price_taplab_rentel'] = $request->price_taplab_rentel;
            $data['motor_color']         = $request->motor_color;
            $data['taplab_imei']        = $request->taplab_imei;
            $data['start_date_taplab']  = $request->start_date_taplab;
            $data['updated_by']         = Auth::user()->id;
            $data->save();
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
    public function deletePay(Request $request)
    {
        try {
            MotorRentalDetail::whereIn('id',explode(",",$request->id))->delete();
            Toastr::success('Deleted successfully.', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Delete fail.', 'Error');
            return redirect()->back();
        }
    }
}
