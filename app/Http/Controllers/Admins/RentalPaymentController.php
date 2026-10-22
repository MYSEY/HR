<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Branchs;
use App\Models\MotorRentel;
use App\Models\TaxRentalRate;
use App\Models\PreviewPaymentRental;
use App\Models\PreviewPaymentRentalDetail;
use App\Models\PaymentRental;
use App\Models\PaymentRentalDetail;
use App\Models\LeaveDetail;
use App\Models\MotorAdjustment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Admin\EmployeeRepository;
use App\Models\permissions;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use App\Repositories\Admin\PaymentRentalRepository;
use App\Exports\ExportMotorRentel;
use App\Models\BundledRentalRate;
use App\Models\Transferred;
use Maatwebsite\Excel\Facades\Excel;

class RentalPaymentController extends Controller
{
    private $dataMotor;
    public function __construct(PaymentRentalRepository $dataMotors)
    {
        $this->dataMotor = $dataMotors;
    }

    static function getDatas($request){
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        $query = PreviewPaymentRental::with(['branch','user','details'])->leftJoin('users', 'preview_payment_rentals.employee_id', '=', 'users.id')
        ->select(
            'preview_payment_rentals.*',
            'users.employee_name_en',
            'users.employee_name_kh',
            'users.number_employee',
            'users.branch_id',
            'users.department_id',
            'users.resign_date',
        )
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if (in_array($RolePermission, ['Employee', 'DHOD', 'DBM'])) {
                if(permissionAccess("m5-s1","is_access")->value == "1" || permissionAccess("m7-s12","is_access")->value == "1"){
                    $query->where("users.department_id", Auth::user()->department_id);
                    if($RolePermission == "DBM"){
                        $query->where("users.branch_id", Auth::user()->branch_id);
                    }
                }else{
                    $query->where('users.id',Auth::user()->id);
                }
            }
            if ($RolePermission == 'HOD') {
                $query->where("users.department_id", Auth::user()->department_id);
            }
            if ($RolePermission == 'BM') {
                $query->where("users.branch_id", Auth::user()->branch_id);
            }
            if ($RolePermission == 'HR') {
                 if(permissionAccess("m5-s1","is_access")->value == "1"){
                    // $query->where("users.department_id", Auth::user()->department_id);
                    // $query->where("users.branch_id", Auth::user()->branch_id);
                }else{
                    $query->where('users.id',Auth::user()->id);
                }
            }
        })
        ->when($request->branch_id, function ($query, $branch_id) {
            return $query->where('users.branch_id', $branch_id);
        })
        ->when($request->year_month, function ($query, $yearMonth) {
            $startDate = Carbon::parse($yearMonth)->startOfMonth();
            $endDate   = Carbon::parse($yearMonth)->endOfMonth();
            $query->whereBetween('preview_payment_rentals.created_at', [$startDate, $endDate]);
        })
        ->when($from_date, function ($query, $from_date) {
            $query->where('preview_payment_rentals.created_at', '>=', $from_date);
        })
        ->when($to_date, function ($query, $to_date) {
            $query->where('preview_payment_rentals.created_at','<=', $to_date);
        });

        return $query;
    }

    public function indexGenerate(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "rental-pay/generate")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        
        if ($request->ajax()) {
            $query = self::getDatas($request);
               
            $searchValue = $request->input('search.value');

            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {

                    // 🔹 Search main table
                    $q->where('preview_payment_rentals.id', 'like', "%{$searchValue}%");
                    // ->orWhere('preview_payment_rentals.created_at', 'like', "%{$searchValue}%");

                    // 🔹 Search employee
                    $q->orWhereHas('user', function ($q2) use ($searchValue) {
                        $q2->where('number_employee', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_kh', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_en', 'like', "%{$searchValue}%");
                    });
                });
            }
            $recordsTotal = (clone $query)->count();
            $recordsFiltered = $query->count();

            // Pagination
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));

            // 🔥 HANDLE "ALL"
            if ($limit == -1) {
                $data = $query->get(); // get all rows
            } else {
                $data = $query->orderBy('id', 'DESC')->offset($start)->limit($limit)->get();
            }
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        $TaxRental = TaxRentalRate::first();
        $locations = Branchs::get();
        return view('motor_rentels.review',  compact("permission",'TaxRental','locations'));
    }

    public function index(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "rental-pay")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        if ($request->ajax()) {
            $query = $this->dataMotor->getDatas($request);
            $searchValue = $request->input('search.value');

            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {

                    // 🔹 Search main table
                    $q->where('payment_rentals.id', 'like', "%{$searchValue}%")
                    ->orWhere('payment_rentals.from_date', 'like', "%{$searchValue}%");

                    // 🔹 Search employee
                    $q->orWhereHas('user', function ($q2) use ($searchValue) {
                        $q2->where('number_employee', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_kh', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_en', 'like', "%{$searchValue}%");
                    });
                });
            }
            $recordsTotal = (clone $query)->count();
            $recordsFiltered = $query->count();

            // Pagination
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));

            // 🔥 HANDLE "ALL"
            if ($limit == -1) {
                $data = $query->get(); // get all rows
            } else {
                $data = $query->orderBy('id', 'DESC')->offset($start)->limit($limit)->get();
            }
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        $locations = Branchs::get();
        return view('motor_rentels.payment_rental', compact("locations","permission"));
    }
    public function generate(Request $request)
    {
        DB::beginTransaction();
        try {
            // =========================================================================
            // 1. រៀបចំ TAX RATE & FILTER DATE RANGE
            // =========================================================================
            $taxRate = TaxRentalRate::first();
            TaxRentalRate::updateOrCreate(
                [
                    'id' => $taxRate ? $taxRate->id : null,
                ],
                [
                    'tax_rate'   => $request->tax_rate,
                    'created_by' => $taxRate ? $taxRate->created_by : Auth::id(),
                    'updated_by' => Auth::id(),
                ]
            );

            $filterFromDate = Carbon::parse($request->from_date)->startOfDay();
            $filterToDate   = Carbon::parse($request->to_date)->endOfDay();

            // 1.1 សម្អាត Table ផ្លាស់ប្តូរបណ្តោះអាសន្ន (Preview Tables)
            PreviewPaymentRentalDetail::query()->delete();
            PreviewPaymentRental::query()->delete();

            // =========================================================================
            // 2. ទាញយក SETTINGS (LEAVE LIMIT & TRANSFER CUTOFF DAY)
            // =========================================================================
            // ចំនួនថ្ងៃច្បាប់ដែលអនុញ្ញាត (ឧ. 1 ថ្ងៃ)
            $leaveSetting = BundledRentalRate::where('type', 'leave')
                ->latest('id')
                ->value('leave_day');
            $leave_day = (float) ($leaveSetting ?? 1); 

            // កាលបរិច្ឆេទ Cutoff សម្រាប់ទូទាត់ប្រាក់ Transfer Staff (ឧ. ថ្ងៃទី 15)
            $transfer_day_15 = BundledRentalRate::where('type', 'staff_transfer')
                ->latest('id')
                ->value('transfer_day');

            // =========================================================================
            // 3. ទាញយកបញ្ជី MOTOR RENTALS ដែល ACTIVE/ELIGIBLE តាម FILTER
            // =========================================================================
            $motorRentals = MotorRentel::where('status', $request->status)->with("user")
                ->where(function ($q) use ($filterFromDate) {
                    // បុគ្គលិកដែល Resigned ត្រូវតែ Resigned ក្រោយ ឬចំថ្ងៃ Filter From Date
                    $q->where('resigned_date', '>=', $filterFromDate->format('Y-m-d'))
                    ->orWhereNull('resigned_date');
                })
                ->get()
                ->filter(function ($item) use ($filterToDate) {
                    $rentalForms = $item->form_rental_with_price;
                    if (empty($rentalForms) || !is_array($rentalForms)) {
                        return false;
                    }
                    foreach ($rentalForms as $form) {
                        $startDateStr = $form['start_date'] ?? null;
                        if ($startDateStr) {
                            try {
                                $formStartDate = Carbon::hasFormat($startDateStr, 'd-m-Y') 
                                    ? Carbon::createFromFormat('d-m-Y', $startDateStr)->startOfDay()
                                    : Carbon::parse($startDateStr)->startOfDay();

                                // រៀបចំតែ Form ណាដែលបានចាប់ផ្តើមមុន ឬចំថ្ងៃ Filter To Date
                                if ($formStartDate->lte($filterToDate)) {
                                    return true;
                                }
                            } catch (\Exception $e) {
                                continue;
                            }
                        }
                    }
                    return false;
                });

            // Loop តាម Motor Rental នីមួយៗ
            foreach ($motorRentals as $motor) {

                $rentalForms = $motor->form_rental_with_price;

                // --- Condition 3.1: ពិនិត្យ Resigned Date របស់បុគ្គលិក ---
                $resignedDate = null;
                if (!empty($motor->resigned_date)) {
                    try {
                        $resignedDate = Carbon::hasFormat($motor->resigned_date, 'd-m-Y')
                            ? Carbon::createFromFormat('d-m-Y', $motor->resigned_date)->startOfDay()
                            : Carbon::parse($motor->resigned_date)->startOfDay();
                    } catch (\Exception $e) {
                        $resignedDate = null;
                    }
                }

                // បើបុគ្គលិកឈប់ធ្វើការ (status=0) ហើយថ្ងៃឈប់ធ្វើការតូចជាង From Date ត្រូវ Skip
                if ($motor->status == 0 && $resignedDate && $resignedDate->lt($filterFromDate)) {
                    continue;
                }

                // --- Condition 3.2: ស្វែងរក Terminate Date របស់ Form Motorcycle (បើមាន) ដើម្បីកំណត់ថ្ងៃបញ្ចប់រាប់ Leave ---
                $motorcycleLeaveEndDate = $filterToDate->copy();
                if (!empty($rentalForms) && is_array($rentalForms)) {
                    foreach ($rentalForms as $form) {
                        $formType     = strtolower($form['type'] ?? '');
                        $terminateStr = $form['terminate_date'] ?? null;

                        if ($formType === 'motorcycle' && !empty($terminateStr)) {
                            try {
                                $tDate = Carbon::hasFormat($terminateStr, 'd-m-Y')
                                    ? Carbon::createFromFormat('d-m-Y', $terminateStr)->endOfDay()
                                    : Carbon::parse($terminateStr)->endOfDay();

                                if ($tDate->between($filterFromDate, $filterToDate)) {
                                    $motorcycleLeaveEndDate = $tDate;
                                    break;
                                }
                            } catch (\Exception $e) {
                                // Keep default filterToDate
                            }
                        }
                    }
                }

                // --- Condition 3.3: គណនា Total Leave សរុបក្នុងខែនេះ (កាត់ត្រឹម motorcycleLeaveEndDate) ---
                $total_month_leave = LeaveDetail::where("employee_id", $motor->employee_id)
                    ->where(function ($query) {
                        $query->whereNull('status')
                            ->orWhereNotIn('status', ['pending_cancel', 'cancel']);
                    })
                    ->whereBetween('date', [$filterFromDate->format('Y-m-d'), $motorcycleLeaveEndDate->format('Y-m-d')])
                    ->sum('number_of_day') ?? 0;

                // --- Condition 3.4: ពិនិត្យមើលការផ្លាស់ប្តូរទីតាំង (Staff Transferred) ---
                $transferred = Transferred::where("employee_id", $motor->employee_id)
                    ->whereBetween('date', [$filterFromDate->format('Y-m-d'), $filterToDate->format('Y-m-d')])
                    ->latest("date")->first();

                // រៀបចំ Structure Data សម្រាប់ Main Record (PreviewPaymentRental)
                $data = [
                    "employee_id"               => $motor->employee_id,
                    "location_id"               => optional($motor->user)->branch_id,
                    "motor_rental_id"           => $motor->id,
                    "form_rental"               => $motor->form_rental,
                    "from_date"                 => $request->from_date,
                    "to_date"                   => $request->to_date,
                    "resigned_date"             => $motor->resigned_date,
                    "total_amount_khr"          => 0,
                    "total_tax_fee_khr"         => 0,
                    "total_net_amount_khr"      => 0,
                    "total_amount_usd"          => 0,
                    "total_tax_fee_usd"         => 0,
                    "total_net_amount_usd"      => 0,
                    "total_adjust_amount_khr"   => 0,
                    "total_adjust_amount_excl"  => 0,
                    "total_adjust_amount_incl"  => 0,
                    "total_adjust_tax_fee"      => 0,
                    "total_leave_amount_usd"    => 0,
                ];

                $dataDetails = [];
                $taxRateVal  = (float) ($request->tax_rate ?? 0);

                if (!empty($rentalForms) && is_array($rentalForms)) {
                    foreach ($rentalForms as $form) {
                        $type         = strtolower($form['type'] ?? '');
                        $startDateStr = $form['start_date'] ?? null;
                        $terminateStr = $form['terminate_date'] ?? null;

                        $oldPrice     = (float) ($form['price'] ?? 0);
                        $newPrice     = isset($form['new_price']) && $form['new_price'] !== null ? (float)$form['new_price'] : $oldPrice;
                        $promotedStr  = $form['promoted_date'] ?? null;

                        // --- Condition: ប្តូរ Location តាមថ្ងៃ Cutoff (ថ្ងៃទី 15) ប្រសិនបើមាន Transfer ---
                        if ($transferred && isset($form['new_price']) && (float)$form['new_price'] > 0) {
                            $transferDate = Carbon::parse($transferred->date)->startOfDay();
                            $toDate       = Carbon::parse($request->to_date);
                            $day          = min((int) $transfer_day_15, $toDate->daysInMonth);
                            $cutoff       = Carbon::create($toDate->year, $toDate->month, $day)->startOfDay();

                            // ធំជាងថ្ងៃទី ១៥ (gt) => សាខាចាស់ 
                            // តូចជាង ឬស្មើ ថ្ងៃទី ១៥ (lte) => សាខាថ្មី
                            if ($transferDate->gt($cutoff)) {
                                // សាខាចាស់៖ បើ branch_id ជា ID យកប្រើភ្លាម បើជា Text ត្រូវ Query 
                                if (is_numeric($transferred->branch_id)) {
                                    $data["location_id"] = $transferred->branch_id;
                                } else {
                                    $location_old = Branchs::where("branch_name_en", $transferred->branch_id)
                                        ->orWhere("branch_name_kh", $transferred->branch_id)
                                        ->first();
                                    if ($location_old) {
                                        $data["location_id"] = $location_old->id;
                                    }
                                }
                            } else {
                                // សាខាថ្មី (តូចជាង ឬស្មើថ្ងៃទី ១៥)
                                $location_new = Branchs::where("branch_name_en", $transferred->tranferend_branch_name)
                                    ->orWhere("branch_name_kh", $transferred->tranferend_branch_name)
                                    ->first();

                                if ($location_new) {
                                    $data["location_id"] = $location_new->id;
                                }
                            }
                        }

                        // =========================================================================
                        // 4. CHECK CONDITIONS: TERMINATE DATE & PROMOTED DATE (PERIOD SPLITTING)
                        // =========================================================================
                        
                        // --- Condition 4.1: Parse Terminate Date ---
                        $formTerminateDate = null;
                        if (!empty($terminateStr)) {
                            try {
                                $formTerminateDate = Carbon::hasFormat($terminateStr, 'd-m-Y')
                                    ? Carbon::createFromFormat('d-m-Y', $terminateStr)->startOfDay()
                                    : Carbon::parse($terminateStr)->startOfDay();
                            } catch (\Exception $e) {
                                $formTerminateDate = null;
                            }
                        }

                        // ប្រសិនបើ Form ត្រូវ Terminate មុនថ្ងៃចាប់ផ្តើម Filter (pFrom) ត្រូវ Skip Form នេះចោល
                        if ($formTerminateDate && $formTerminateDate->lt($filterFromDate)) {
                            continue;
                        }

                        // --- Condition 4.2: Parse Promoted Date ---
                        $promotedDate = null;
                        if (!empty($promotedStr)) {
                            try {
                                $pDate = Carbon::hasFormat($promotedStr, 'd-m-Y')
                                    ? Carbon::createFromFormat('d-m-Y', $promotedStr)->startOfDay()
                                    : Carbon::parse($promotedStr)->startOfDay();

                                if ($pDate->between($filterFromDate, $filterToDate)) {
                                    $promotedDate = $pDate;
                                }
                            } catch (\Exception $e) {
                                $promotedDate = null;
                            }
                        }

                        // --- Condition 4.3: បំបែក Periods តាម Position (ចាស់/ថ្មី) និង កាត់ត្រឹម Terminate Date ---
                        $periods = [];
                        if ($promotedDate) {
                            // [Period 1]: Position ចាស់ (ពី FromDate ដល់ មុន 1 ថ្ងៃនៃ Promoted Date)
                            $oldToDate = $promotedDate->copy()->subDay()->endOfDay();
                            
                            // បើមាន Terminate Date ក្នុង Position ចាស់ ត្រូវកាត់ត្រឹម Terminate Date នោះ
                            if ($formTerminateDate && $formTerminateDate->lt($oldToDate)) {
                                $oldToDate = $formTerminateDate->copy()->endOfDay();
                            }

                            if ($filterFromDate->lte($oldToDate)) {
                                $periods[] = [
                                    'type'     => 'old_position',
                                    'from'     => $filterFromDate->copy(),
                                    'to'       => $oldToDate,
                                    'price'    => $oldPrice,
                                    'position' => $form['promoted_from_position_id'] ?? null,
                                ];
                            }

                            // [Period 2]: Position ថ្មី (ពី Promoted Date ដល់ Filter ToDate ឬ Terminate Date)
                            $newToDate = $filterToDate->copy();
                            if ($formTerminateDate && $formTerminateDate->lte($filterToDate)) {
                                $newToDate = $formTerminateDate->copy()->endOfDay();
                            }

                            // បើ Terminate ក្រោយ/ចំថ្ងៃ Promoted ទើបមាន Period ថ្មីនេះ
                            if ($promotedDate->lte($newToDate)) {
                                $periods[] = [
                                    'type'     => 'new_position',
                                    'from'     => $promotedDate,
                                    'to'       => $newToDate,
                                    'price'    => $newPrice,
                                    'position' => $form['promoted_to_position_id'] ?? null,
                                ];
                            }
                        } else {
                            // [Normal Period]: គ្មាន Promotion (គណនាត្រឹម Filter ToDate ឬ Terminate Date)
                            $normalToDate = $filterToDate->copy();
                            if ($formTerminateDate && $formTerminateDate->lte($filterToDate)) {
                                $normalToDate = $formTerminateDate->copy()->endOfDay();
                            }

                            if ($filterFromDate->lte($normalToDate)) {
                                $periods[] = [
                                    'type'     => 'normal',
                                    'from'     => $filterFromDate->copy(),
                                    'to'       => $normalToDate,
                                    'price'    => $oldPrice,
                                    'position' => optional($motor->user)->position_id,
                                ];
                            }
                        }

                        // =========================================================================
                        // 5. CALCULATE RENTAL, LEAVE & ADJUSTMENT FOR EACH PERIOD
                        // =========================================================================
                        foreach ($periods as $period) {

                            $pFrom        = $period['from'];
                            $pTo          = $period['to'];
                            $currentPrice = $period['price'];

                            if (in_array($motor->status, [0, 1]) && !empty($startDateStr)) {

                                // --- Condition 5.1: គណនា Leave Days ជាក់ស្តែងក្នុង Period នីមួយៗ ---
                                $period_leave_days = LeaveDetail::where("employee_id", $motor->employee_id)
                                    ->where(function ($query) {
                                        $query->whereNull('status')
                                            ->orWhereNotIn('status', ['pending_cancel', 'cancel']);
                                    })
                                    ->whereBetween('date', [$pFrom->format('Y-m-d'), $pTo->format('Y-m-d')])
                                    ->sum('number_of_day') ?? 0;

                                // --- Condition 5.2: គណនា Motor Adjustments ក្នុង Period នីមួយៗ ---
                                $adjustments = MotorAdjustment::where("employee_id", $motor->employee_id)
                                    ->where("type", $type)
                                    ->whereBetween('adjustment_date', [$pFrom->format('Y-m-d'), $pTo->format('Y-m-d')])
                                    ->get();

                                $amount_adj_excl_usd = 0;
                                $amount_adj_incl_usd = 0;
                                $amount_adj_khr      = 0;

                                if ($adjustments->count() > 0) {
                                    foreach ($adjustments as $adj) {
                                        $amtUsd = (float) ($adj->amount_usd ?? 0);
                                        $amtKh  = (float) ($adj->amount_kh ?? 0);

                                        if ($adj->adjustment_type === "include_tax") {
                                            $amount_adj_incl_usd += $amtUsd;
                                        } else {
                                            $amount_adj_excl_usd += $amtUsd;
                                        }
                                        $amount_adj_khr += $amtKh;
                                    }
                                }

                                // --- Condition 5.3: ស្វែងរក Actual Start និង Actual End Date ក្នុង Period នេះ ---
                                try {
                                    $formStartDate = Carbon::hasFormat($startDateStr, 'd-m-Y')
                                        ? Carbon::createFromFormat('d-m-Y', $startDateStr)->startOfDay()
                                        : Carbon::parse($startDateStr)->startOfDay();
                                } catch (\Exception $e) {
                                    continue;
                                }

                                if ($formStartDate->gt($pTo)) continue;

                                $actualStart = $formStartDate->gt($pFrom) ? $formStartDate : $pFrom;

                                // ប្រៀបធៀបរកថ្ងៃបញ្ចប់ដែលមកដល់មុនគេបំផុត (Period End, Form Terminate, Resigned Date)
                                $potentialEnds = collect([$pTo]);
                                if ($formTerminateDate && $formTerminateDate->lte($pTo)) {
                                    $potentialEnds->push($formTerminateDate);
                                }
                                if ($motor->status == 0 && $resignedDate && $resignedDate->lte($pTo)) {
                                    $potentialEnds->push($resignedDate);
                                }

                                $actualEnd = $potentialEnds->min();

                                if ($actualStart->gt($actualEnd)) {
                                    continue;
                                }

                                // --- Condition 5.4: គណនា Working Days និង Total Month Days ---
                                $totalWorkingDays = Helper::countWorkingDays($actualStart->format('Y-m-d'), $actualEnd->format('Y-m-d'));
                                $totalPeriodDays  = Helper::countWorkingDays($filterFromDate->format('Y-m-d'), $filterToDate->format('Y-m-d'));

                                $calculatedAmount = 0;
                                $leave_amount     = 0;

                                // --- Condition 5.5: គណនា Leave Deduction (កាត់លុយច្បាប់ លុះត្រាតែ Total Month Leave > leave_day) ---
                                if ($type === 'motorcycle' && $totalPeriodDays > 0 && (float) $total_month_leave > $leave_day && $period_leave_days > 0) {
                                    $amountPerDay = $currentPrice / $totalPeriodDays;
                                    $leave_amount = $amountPerDay * $period_leave_days;
                                }

                                // --- Condition 5.6: គណនា Calculated Amount តាមថ្ងៃធ្វើការ - ប្រាក់ច្បាប់ ---
                                if ($totalPeriodDays > 0 && $totalWorkingDays > 0) {
                                    $amountPerDay     = $currentPrice / $totalPeriodDays;
                                    $calculatedAmount = ($amountPerDay * $totalWorkingDays) - $leave_amount;
                                }

                                $calculatedAmount = max(0, $calculatedAmount);

                                // --- Condition 5.7: គណនា Tax, Net Amount & Adjustments ---
                                $amount       = round($calculatedAmount, 4);
                                $taxFee       = round($amount * ($taxRateVal / 100), 4);
                                $rentalNetUsd = round($amount - $taxFee, 4);

                                $amount_adj_fee = round($amount_adj_incl_usd * ($taxRateVal / 100), 4);
                                $adjInclNet     = round($amount_adj_incl_usd - $amount_adj_fee, 4);

                                $formNetAmount = round($rentalNetUsd + $amount_adj_excl_usd + $adjInclNet, 4);
                                $currency      = strtoupper($form["currency"] ?? 'USD');

                                // បូកសរុបចូល Main Record Data
                                if ($currency === "USD") {
                                    $data["total_amount_usd"]     += $amount;
                                    $data["total_tax_fee_usd"]    += $taxFee;
                                    $data["total_net_amount_usd"] += $formNetAmount;
                                } else if ($currency === "KHR") {
                                    $data["total_amount_khr"]     += $amount;
                                    $data["total_tax_fee_khr"]    += $taxFee;
                                    $data["total_net_amount_khr"] += $formNetAmount;
                                }

                                $data["total_adjust_amount_khr"]  += $amount_adj_khr;
                                $data["total_adjust_amount_excl"] += $amount_adj_excl_usd;
                                $data["total_adjust_amount_incl"] += $amount_adj_incl_usd;
                                $data["total_adjust_tax_fee"]     += $amount_adj_fee;
                                $data["total_leave_amount_usd"]   += $leave_amount;

                                // រៀបចំ Detail Record Array
                                $dataDetails[] = [
                                    "fields"             => is_array($form["fields"] ?? null) ? json_encode($form["fields"]) : ($form["fields"] ?? null),
                                    "type"               => $type,
                                    "position_id"        => $period['position'] ?? null, // Position ចាស់ ឬ ថ្មី
                                    "terminate_date"     => $form["terminate_date"] ?? null,
                                    "status"             => $form["status"] ?? null,
                                    "currency"           => $currency,
                                    "price"              => $currentPrice,
                                    "total_work_day"     => $totalWorkingDays,
                                    "tax_rate"           => $taxRateVal,
                                    "amount"             => $amount,
                                    "amount_excl_tax"    => $rentalNetUsd,
                                    "tax_fee"            => $taxFee,
                                    "leave_amount"       => $leave_amount,
                                    "total_leave_days"   => $period_leave_days, // ចំនួនថ្ងៃច្បាប់ក្នុង Period នេះ
                                    "adjust_amount_excl" => $amount_adj_excl_usd,
                                    "adjust_amount_incl" => $amount_adj_incl_usd,
                                    "adjust_tax_fee"     => $amount_adj_fee,
                                    "adjust_amount_khr"  => $amount_adj_khr,
                                    "net_amount"         => $formNetAmount,
                                ];
                            }
                        } // End foreach $periods
                    } // End foreach $rentalForms
                }

                // =========================================================================
                // 6. SAVE DATA TO PREVIEW TABLES
                // =========================================================================
                $previewPay = PreviewPaymentRental::create($data);
                if (!empty($dataDetails)) {
                    $now = now();
                    foreach ($dataDetails as &$detail) {
                        $detail["payment_rental_id"] = $previewPay->id;
                        $detail["created_at"]        = $now;
                        $detail["updated_at"]        = $now;
                    }
                    unset($detail);
                    PreviewPaymentRentalDetail::insert($dataDetails);
                }
            } // End foreach $motorRentals

            DB::commit();
            Toastr::success('Created successfully.', 'Success');
            return redirect()->back();

        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Created fail: ' . $exp->getMessage(), 'Error');
            return redirect()->back();
        }
    }
    public function payApproved(Request $request)
    {
        DB::beginTransaction();
        try {
            $ids = array_filter(explode(",", $request->id));
            
            $previewPays = PreviewPaymentRental::with(['user', 'details'])->whereIn('id', $ids)->get();

            if ($previewPays->isNotEmpty()) {
                $now = now();

                $dataReturn   = []; // Array សម្រាប់ទុក Duplicate Data
                $processedIds = []; // Array សម្រាប់ទុក IDs ណាដែល Process រួចរាល់ ដើម្បី Delete

                foreach ($previewPays as $preview) {

                    // Parse created_at ទៅជា Carbon Object
                    $createdAt = \Carbon\Carbon::parse($preview->created_at);

                    // Check Duplicate ដោយផ្អែកលើ status = 0, motor_rental_id, Month និង Year
                    $dataApprove = PaymentRental::with("user")
                        // where("status", "0")
                        ->where("motor_rental_id", $preview->motor_rental_id)
                        ->whereMonth("created_at", $createdAt->month) 
                        ->whereYear("created_at", $createdAt->year)
                        ->first();

                    // ករណីមាន Duplicate Record ស្រាប់
                    if ($dataApprove) {
                        $dataReturn[] = [
                            'preview_id'            => $preview->id,
                            'total_net_amount_usd'  => $preview->total_net_amount_usd,
                            'employee_id'           => $preview->employee_id,
                            'motor_rental_id'       => $preview->motor_rental_id,
                            'user'                  => $preview->user,
                            'message'               => 'ទិន្នន័យនេះត្រូវបាន Approve ក្នុងខែ/ឆ្នាំនេះរួចរាល់ហើយ'
                        ]; 
                        continue; // រំលង មិនលុប និងមិន Insert ចូល PaymentRental ទេ
                    }

                    // 1. បម្លែង Preview Main Record ទៅជា Array
                    $mainData = $preview->toArray();
                    
                    // លុប keys មិនចាំបាច់ចេញ
                    unset($mainData['id'], $mainData['created_at'], $mainData['updated_at'], $mainData['user'], $mainData['details']);

                    $mainData['created_by'] = Auth::id();
                    $mainData['created_at'] = $now;
                    $mainData['updated_at'] = $now; 

                    // Update ទិន្នន័យទៅក្នុង Table motor_rentels
                    if (!empty($preview->motor_rental_id)) {
                        MotorRentel::where('id', $preview->motor_rental_id)->update([
                            'current_position' => optional($preview->user)->position_id,
                            'payment_status'   => 'Current',
                            'updated_by'       => Auth::id(),
                            'updated_at'       => $now,
                        ]);
                    }

                    // 2. បង្កើត PaymentRental Record ថ្មី
                    $newPaymentRental = PaymentRental::create($mainData);
                    $previewDetails   = PreviewPaymentRentalDetail::where('payment_rental_id', $preview->id)->get();

                    if ($previewDetails->isNotEmpty()) {
                        $detailsToInsert = [];

                        foreach ($previewDetails as $detail) {
                            $detailData = $detail->toArray();

                            unset($detailData['id'], $detailData['created_at'], $detailData['updated_at']);

                            $detailData['payment_rental_id'] = $newPaymentRental->id;
                            $detailData['created_at']        = $now;
                            $detailData['updated_at']        = $now;

                            $detailsToInsert[] = $detailData;
                        }
                        PaymentRentalDetail::insert($detailsToInsert);
                    }

                    // កត់ត្រា ID ដែលបាន Process ជោគជ័យ ដើម្បីលុបចេញពី Preview Table
                    $processedIds[] = $preview->id;
                }

                // 3. លុបតែ Records ណាដែលបាន Approve ជោគជ័យ (មិនលុប Duplicate ទេ)
                if (!empty($processedIds)) {
                    PreviewPaymentRentalDetail::whereIn('payment_rental_id', $processedIds)->delete();
                    PreviewPaymentRental::whereIn('id', $processedIds)->delete();
                }

                DB::commit();

                // ប្រសិនបើមាន Duplicate ទិន្នន័យ
                if (!empty($dataReturn)) {
                    return response()->json([
                        'status'      => 207, // Multi-Status (មានជោគជ័យខ្លះ និង Duplicate ខ្លះ)
                        'message'     => 'មានទិន្នន័យមួយចំនួនត្រូវបាន Approve រួចហើយ!',
                        'duplicates'  => $dataReturn,
                        'approved_ids'=> $processedIds
                    ], 200);
                }

                return response()->json([
                    'status'  => 200,
                    'message' => 'Approved successfully.'
                ], 200);

            } else {
                DB::rollback();
                return response()->json([
                    'status'  => 404,
                    'message' => 'Approved fail: No data found.'
                ], 404);
            }

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status'  => 500,
                'message' => 'Approved fail: ' . $e->getMessage()
            ], 500);
        }
    }
    public function replaceApprove(Request $request)
    {
        DB::beginTransaction();
        try {
            $previewId = $request->preview_id;
            $preview   = PreviewPaymentRental::with('details')->find($previewId);

            if (!$preview) {
                return response()->json(['status' => 404, 'message' => 'Preview record not found.']);
            }

            $createdAt = \Carbon\Carbon::parse($preview->created_at);

            // 1. ស្វែងរក និង លុប PaymentRental Record ចាស់ (រួមទាំង Detail) ក្នុងខែ/ឆ្នាំនេះ
            $oldPayment = PaymentRental::
                // where("status", "0")
                where("motor_rental_id", $preview->motor_rental_id)
                ->whereMonth("created_at", $createdAt->month)
                ->whereYear("created_at", $createdAt->year)
                ->first();

            if ($oldPayment) {
                PaymentRentalDetail::where('payment_rental_id', $oldPayment->id)->delete();
                $oldPayment->delete();
            }

            // 2. បង្កើត PaymentRental Record ថ្មីជំនួស
            $now      = now();
            $mainData = $preview->toArray();
            unset($mainData['id'], $mainData['created_at'], $mainData['updated_at'], $mainData['user'], $mainData['details']);

            $mainData['created_by'] = Auth::id();
            $mainData['created_at'] = $now;
            $mainData['updated_at'] = $now;

            $newPaymentRental = PaymentRental::create($mainData);

            // 3. បញ្ចូល details ថ្មី
            $previewDetails = PreviewPaymentRentalDetail::where('payment_rental_id', $preview->id)->get();
            if ($previewDetails->isNotEmpty()) {
                $detailsToInsert = [];
                foreach ($previewDetails as $detail) {
                    $detailData = $detail->toArray();
                    unset($detailData['id'], $detailData['created_at'], $detailData['updated_at']);
                    $detailData['payment_rental_id'] = $newPaymentRental->id;
                    $detailData['created_at']        = $now;
                    $detailData['updated_at']        = $now;
                    $detailsToInsert[]               = $detailData;
                }
                PaymentRentalDetail::insert($detailsToInsert);
            }

            // 4. លុប Preview Record ចេញ
            PreviewPaymentRentalDetail::where('payment_rental_id', $preview->id)->delete();
            $preview->delete();

            DB::commit();

            return response()->json([
                'status'  => 200,
                'message' => 'Replaced and approved successfully.'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status'  => 500,
                'message' => 'Replace failed: ' . $e->getMessage()
            ], 500);
        }
    }
    public function deletePay(Request $request)
    {
        try {
            $ids = array_filter(explode(",", $request->id));
            PreviewPaymentRentalDetail::whereIn('payment_rental_id', $ids)->delete();
            PreviewPaymentRental::whereIn('id', $ids)->delete();
            Toastr::success('Deleted successfully.', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Delete fail.', 'Error');
            return redirect()->back();
        }
    }

    public function previewExport(Request $request){
        $data = self::getDatas($request)->orderBy('id', 'desc')->get();
        $date = $request->get('date') ?? date('Y-m-d');
        return Excel::download(new ExportMotorRentel($data, $date), "MotorRental-".$date.'.xlsx');
    }
    public function export(Request $request){
        $data = $this->dataMotor->getDatas($request)->orderBy('id', 'desc')->get();
        $date = $request->get('date') ?? date('Y-m-d');
        return Excel::download(new ExportMotorRentel($data, $date), "MotorRental-".$date.'.xlsx');
    }
}
