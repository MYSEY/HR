<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\Department;
use App\Models\ExpenseRequest;
use App\Models\ExpenseRequestHistory;
use App\Models\FnApproval;
use App\Models\FnDetailLocation;
use App\Models\FNExchangeRate;
use App\Models\FnLevelReviewer;
use App\Models\FnPaymentTerm;
use App\Models\FnRegularExspense;
use App\Models\FnTaxRate;
use App\Models\GenerateIdExpense;
use App\Models\permissions;
use App\Models\User;
use App\Traits\GeneratingCode;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use App\Mail\SendEmail;
use App\Models\LeaveRequest;
use App\Models\mail as ModelsMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class ExpenseRequestController extends Controller
{
    use GeneratingCode;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "expense-request/list")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $datas = ExpenseRequest::with(["requestBy","locationDetails","departments", "createdBy","reviewBy",'approveBy'])->where("request_by", Auth::user()->id)->orderBy('id', 'DESC')->get();
        $user = Auth::user();
        $dataAsign = ExpenseRequest::with(['requestBy', 'locationDetails', 'departments', 'createdBy', 'reviewBy','approveBy'])
            ->where('status', '!=', "rejected")
            ->whereNot('request_by', $user->id)
            ->where(function ($query) use ($user) {
                if ($user->RolePermission != "admin" && $user->RolePermission != "developer") {
                    $query->where(function ($q) use ($user) {
                        $q->where('status', 'pending_approve')
                        ->whereJsonContains('approve_by', (string)$user->id);
                        // ->whereJsonContains('approve_by', $user->id);
                    })
                    ->orWhere(function ($q) use ($user) {
                        if($user->branch->abbreviations == "HQ"){
                            $q->where('status', '!=', 'pending_approve')
                            ->where('location_review', $user->department_id)
                            ->whereJsonContains('position_review', $user->position_id);
                        }else{
                            $q->where('status', '!=', 'pending_approve')
                            ->where('location_review', $user->branch_id)
                            ->whereJsonContains('position_review', (string)$user->position_id);
                            // ->whereJsonContains('position_review', $user->position_id);
                        }
                    });
                }
            })
            ->orderBy('id', 'DESC')
            ->get();
            // dd($dataAsign);
        return view('FN_ExpenseRequests.index',compact(['permission','datas', 'dataAsign']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $FnApproval = FnApproval::with(["location"])
        ->leftJoin('branchs', 'fn_approvals.location_id', '=', 'branchs.id')
        ->select( 'fn_approvals.*', 'branchs.abbreviations')
        ->when(Auth::user()->branch, function ($query, $branch) {
            if($branch->abbreviations != 'HQ'){
                $query->where("branchs.abbreviations", $branch->abbreviations);
                $query->orWhere("branchs.abbreviations", "HQ");
            }
        })
        ->get();


        $locations = Branchs::get();
        $taxWHT = FnTaxRate::where('tax_type', 1)->get();
        $taxeFBT = FnTaxRate::where('tax_type', 2)->get();
        $FnPaymentTerms = FnPaymentTerm::get();
        $FnRegularExspenses = FnRegularExspense::where("status", "1")->where("is_contactual", "1")->get();
        $employees= DB::table('users')
        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
        ->select( 'users.*', 'roles.role_type',)
        ->whereIn('users.emp_status', ['Probation','1','2','10',])
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if($RolePermission == 'Employee'){
                $query->where("users.department_id", Auth::user()->department_id);
                $query->where("users.branch_id", Auth::user()->branch_id);
                $query->whereNot("users.id", Auth::user()->id);
            }
            if (in_array($RolePermission, ['BM','DBM'])){
                $query->where("users.branch_id", Auth::user()->branch_id);
                $query->whereNot("users.id", Auth::user()->id);
            }
            if (in_array($RolePermission, ['HR','HRAdmin','DHOD','HOD'])){
                $query->where("users.department_id", Auth::user()->department_id);
                $query->where("users.branch_id", Auth::user()->branch_id);
                $query->orWhere("users.line_manager", Auth::user()->id);
                $query->whereNot("users.id", Auth::user()->id);
            }
            if (in_array($RolePermission, ['BOD','CEO'])){
                $query->whereNot("users.id", Auth::user()->id);
                $query->whereNot("roles.role_type", "Employee");
            }
            })->get();
        return view('FN_ExpenseRequests.form_request', compact([
            'locations', 
            'FnApproval', 
            'taxWHT', 
            'taxeFBT', 
            'FnPaymentTerms', 
            'FnRegularExspenses',
            'employees'
        ]));
    }

    public function createTax()
    {
        $FnApproval = FnApproval::with(["location"])
        ->leftJoin('branchs', 'fn_approvals.location_id', '=', 'branchs.id')
        ->select( 'fn_approvals.*', 'branchs.abbreviations')
        ->when(Auth::user()->branch, function ($query, $branch) {
            if($branch->abbreviations != 'HQ'){
                $query->where("branchs.abbreviations", $branch->abbreviations);
                $query->orWhere("branchs.abbreviations", "HQ");
            }
        })
        ->get();
        $FnPaymentTerms = FnPaymentTerm::get();
        $locations = Branchs::get();
        $department = Department::get();
        return view('FN_tax_expenses.form_request', compact([
            'locations', 
            'department', 
            'FnApproval', 
            'FnPaymentTerms'
        ]));
    }
    
    public function leaveRequest($condistion, $department_id,$branch_id, $status){
        $request_date = Carbon::createFromDate()->format('Y-m-d');
        if($status === "pending_approve"){
            $dataLeaveRequest = LeaveRequest::
            whereIn("leave_requests.employee_id", $condistion)
            ->whereIn('leave_requests.status', ["approved_hod","approved","pending"])
            ->where('leave_requests.start_date', '<=', $request_date)
            ->where('leave_requests.end_date', '>=', $request_date)
            ->leftJoin('users', 'leave_requests.employee_id', '=', 'users.id')
            ->leftJoin('delegate_leaves', function($join) use ($request_date) {
            $join->on('leave_requests.employee_id', '=', 'delegate_leaves.requester_id')
                ->where('delegate_leaves.start_date', '<=', $request_date)
                ->where('delegate_leaves.end_date', '>=', $request_date);
            })
            ->leftJoin('users as delegate', 'delegate_leaves.delegate_id', '=', 'delegate.id')
            ->select( 
                    "leave_requests.employee_id",
                    "leave_requests.handover_staff_id",
                    "leave_requests.start_date",
                    "leave_requests.start_half_day",
                    "leave_requests.end_date",
                    "leave_requests.approved_by",
                    "leave_requests.status",

                    'users.id',
                    'users.department_id',
                    'users.branch_id',
                    'users.position_id',
                    'users.employee_name_en',
                    'users.employee_name_kh',
                    
                    'delegate.id  as delegate_delegate_id',
                    'delegate.employee_name_en  as delegate_employee_name_en',
                    'delegate.employee_name_kh  as delegate_leaves_employee_name_kh',
            )->get();
             if ($dataLeaveRequest && count($dataLeaveRequest) > 0) {
               $condistion = $condistion ?? [];
                foreach ($dataLeaveRequest as $lr) {
                    if ($lr->delegate_delegate_id) {
                        $condistion = array_values(array_diff($condistion, [(string)$lr->employee_id]));
                        $newPos = $lr->delegate_delegate_id;
                        if (!in_array((string)$newPos, $condistion, true)) { // strict check
                            $condistion[] = (string)$newPos;
                        }
                    }
                }
                // Assign updated array back (make sure all values are strings)
                $condistion = array_map('strval', array_values($condistion));
                return $condistion;
            }
        }else{
            $dataLeaveRequest = LeaveRequest::
            // where("users.branch_id", $branch_id)
            when($branch_id, function ($query, $bran_id) {
                $query->where('users.branch_id', $bran_id);
            })
            ->when($department_id, function ($query, $dep_id) {
                $query->where('users.department_id', $dep_id);
            })
            ->whereIn("users.position_id", $condistion)
            ->whereIn('leave_requests.status', ["approved_hod","approved"])
            ->where('leave_requests.start_date', '<=', $request_date)
            ->where('leave_requests.end_date', '>=', $request_date)
            ->leftJoin('users', 'leave_requests.employee_id', '=', 'users.id')
            ->leftJoin('users as handover', 'leave_requests.handover_staff_id', '=', 'handover.id')
            ->leftJoin('delegate_leaves', function($join) use ($request_date) {
            $join->on('leave_requests.employee_id', '=', 'delegate_leaves.requester_id')
                ->where('delegate_leaves.start_date', '<=', $request_date)
                ->where('delegate_leaves.end_date', '>=', $request_date);
            })
            ->leftJoin('users as delegate', 'delegate_leaves.delegate_id', '=', 'delegate.id')
            ->select( 
                    "leave_requests.employee_id",
                    "leave_requests.handover_staff_id",
                    "leave_requests.start_date",
                    "leave_requests.start_half_day",
                    "leave_requests.end_date",
                    "leave_requests.approved_by",
                    "leave_requests.status",

                    'users.id',
                    'users.department_id',
                    'users.branch_id',
                    'users.position_id',
                    'users.employee_name_en',
                    'users.employee_name_kh',

                    'handover.position_id  as handover_position_id',
                    'handover.employee_name_en  as handover_employee_name_en',
                    'handover.employee_name_kh  as handover_employee_name_kh',
                    
                    'delegate.position_id  as delegate_position_id',
                    'delegate.employee_name_en  as delegate_employee_name_en',
                    'delegate.employee_name_kh  as delegate_leaves_employee_name_kh',
            )->get();
            if ($dataLeaveRequest && count($dataLeaveRequest) > 0) {
                // Work on a local copy of id_condistion
                $condistion = $condistion ?? [];
                foreach ($dataLeaveRequest as $lr) {
                    if ($lr->delegate_position_id) {
                        $condistion = array_values(array_diff($condistion, [$lr->position_id]));
                        $newPos = $lr->delegate_position_id;
                        if (!in_array($newPos, $condistion)) {
                            $condistion[] = $newPos;
                        }
                    }
                }
                // Assign updated array back
                $condistion = array_values($condistion);
                return $condistion;
            }
        }
    }

    function lovelReview($dataLevelView){
        $query = FnLevelReviewer::with(["departmentView", "modelReview"])
            ->when($dataLevelView["by_location"], function ($query, $by_location) use ($dataLevelView) {
                $query->where('from_location', $by_location);
                if ((string) $by_location === "2") {
                    $query->where('model_review', $dataLevelView["model_review"]);
                } else {
                    $query->whereNull("model_review");
                }
            })
            ->when(isset($dataLevelView["request_type"]), function ($query) use ($dataLevelView) {
                $request_type = $dataLevelView["request_type"];
                $query->where('request_type', $request_type);
                if($dataLevelView["reference_type"] == "on" || (string) $request_type === "1"){
                    $query->where('special_fixed_asset', $dataLevelView["special_fixed_asset"]);
                }
                if ((string) $request_type === "0") {
                    $query->where('reference_type', $dataLevelView["reference_type"]);
                }
            })
            ->when($dataLevelView["amount"], function ($query, $amount) {
                $query->where("from_amount", "<", $amount)
                    ->where("to_amount", ">=", $amount);
            });

        // 🔹 Try first with position check
        if ($dataLevelView["position_request"]) {
            $positionReview = (clone $query) // clone again to keep base query clean
                ->whereJsonContains('id_positions', (string) $dataLevelView["position_request"])
                ->orderBy("id", "DESC")
                ->first();

                 // 🔹 If not found, fallback to type
                if (!$positionReview) {
                    $positionReview = (clone $query)
                        ->when($dataLevelView["type"], function ($q, $type) {
                            $q->where('type', $type);
                        })
                        ->orderBy("id", "DESC")
                        ->first();
                }

                return $positionReview;
        }else{
            $positionReview = (clone $query)
                ->when($dataLevelView["type"], function ($q, $type) {
                    $q->where('type', $type);
                })
                ->orderBy("id", "DESC")
                ->first();
            return $positionReview;
        }
    }

    function sendEmail($dataSend, $emailUserRequest){
        $datasSendEmail = [
            'data'              => $dataSend["data"],
            'type'              => "expense",
        ];
        // Mail::mailer('mailer2')->to("thyvan.vuth@camma.com.kh")->queue(new SendEmail($datasSendEmail, true));
        // $condiction = $dataSend["condiction"];
        // if($dataSend["data"]["status"] == "reject" || $dataSend["data"]["status"] == "approve"){
        //     Mail::to($emailUserRequest)->queue(new SendEmail($datasSendEmail, true));
        // }else{
        //     $userALertEmail =  User::whereIn("position_id", $condiction["position_id"])
        //         ->when($condiction["department_id"], function ($query, $department_id) {
        //             $query->where('department_id', $department_id);
        //         })
        //         ->when($condiction["branch_id"], function ($query, $branch_id) {
        //             $query->where('branch_id', $branch_id);
        //         })
        //         ->when($condiction["approve_by"], function ($query, $approve_by) {
        //             $query->whereIn('id', $approve_by);
        //         })
        //         ->when($condiction["request_by"], function ($query, $request_by) {
        //             $query->where('id', $request_by);
        //         })
        //         ->select(
        //             'number_employee',
        //             'department_id',
        //             'email',
        //             'branch_id'
        //         )
        //     ->get();
        //     $data = [];
        //     foreach ($userALertEmail as $user) {
        //         if($user->email != $emailUserRequest){
        //             $data[] = $user->email;
        //             Mail::mailer('mailer2')->to($user->email)->queue(new SendEmail($datasSendEmail, true));
        //         }
        //     }
        // }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $exchange = FNExchangeRate::first();
            $amount = 0;
            $ge_total_cost_riel = 0;
            if ($request->ge_total_cost_riel) {
                $ge_total_cost_riel = ( $request->ge_total_cost_riel / $exchange->amount_riel);
            }
            $amount = ($request->ge_total_cost_usd + $ge_total_cost_riel);
            $dataCheckLevelView = [
                "by_location"=> 2,
                "position_request"=> Auth::user()->position_id,
                "model_review"=> null,
                "request_type"=> $request->type,
                "reference_type"=> $request->expense_type,
                "special_fixed_asset"=> ($request->type != 2 ? $request->special_asset : null),
                "type"=> 1,
                "amount"=> $amount,
            ];
            $dataSendEmail = [
                "condiction" => [
                    "department_id"=> "",
                    "branch_id"=> "",
                    "position_id"=> "",
                    "approve_by"=> "",
                    "request_by"=> "",
                ],
                "data" =>[
                    "title" => "សំណើស្នើសុំចំណាយ",
                    "status" => "pending",
                    "tracking_id" => "",
                    "date" => "",
                    "subject" => "",
                    "review" => 0,
                    "request_by" => "",
                    "reason" => "",
                    "amount_usd" => 0,
                    "amount_kh" => 0,
                ]
            ];
           
            $data = $request->all();
            $leave = [];
            if(Auth::user()->branch->abbreviations == "HQ"){
                $dataCheckLevelView["model_review"] = (int) Auth::user()->department_id;
                $positionReview = self::lovelReview($dataCheckLevelView);
                if($positionReview){
                    // return response()->json(['message' => 'Please contact the finance team to set up a level review.', 'status'=>404]);
                    if(count($positionReview->id_positions) > 0){
                        if (in_array(Auth::user()->position_id, $positionReview->id_positions)) {
                            if($positionReview->verify_print == 1){
                                $data["review_by"]      = Auth::user()->id;
                                $data["date_review"]    = Carbon::createFromDate()->format('Y-m-d H:i');
                            }
                            $dataCheckLevelView["type"] = ($positionReview->type + 1);
                            $dataCheckLevelView["position_request"] = null;
                            $positionReview = self::lovelReview($dataCheckLevelView);
                            // if(!$positionReview){
                            //     return response()->json(['message' => 'Please contact the finance team to set up a level review.', 'status'=>404]);
                            // }
                        } 
                    }
                    if($positionReview){
                        $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->department_id;
                        if (count($positionReview->id_positions) > 0) {
                            // *** Process get leave request **/
                            $leave = self::leaveRequest($positionReview->id_positions, $positionReview->model_review, Auth::user()->branch_id,"pending");
                            if($leave && count($leave) > 0){
                                $positionReview->id_positions = $leave;
                            }
                            //*** end **/
                            $dataSendEmail["condiction"]["position_id"] = $positionReview->id_positions;
                            $dataSendEmail["condiction"]["department_id"] = $data['location_review'];
                        }
                    }
                    
                }
                
            }else{
                $dataCheckLevelView["by_location"] = 1;
                $positionReview = self::lovelReview($dataCheckLevelView);
                if($positionReview){
                    if(count($positionReview->id_positions) > 0){
                        if (in_array(Auth::user()->position_id, $positionReview->id_positions)) {
                            if($positionReview->verify_print == 1){
                                $data["review_by"]      = Auth::user()->id;
                                $data["date_review"]    = Carbon::createFromDate()->format('Y-m-d H:i');
                            }
                            $dataCheckLevelView["type"] = ($positionReview->type + 1);
                            $dataCheckLevelView["position_request"] = null;
                            $positionReview = self::lovelReview($dataCheckLevelView);
                            // if(!$positionReview){
                            //     return response()->json(['message' => 'Please contact the finance team to set up a level review.', 'status'=>404]);
                            // }
                        }   
                    }
                    if($positionReview){
                        $data['location_review']    =  $positionReview->department_review ? $positionReview->department_review : Auth::user()->branch_id;
                        if (count($positionReview->id_positions) > 0) {
                            // *** Process get leave request **/
                            $leave = self::leaveRequest($positionReview->id_positions, $positionReview->model_review, Auth::user()->branch_id,"pending");
                            if($leave && count($leave) > 0){
                                $positionReview->id_positions = $leave;
                            }
                            //*** end **/
                            if($positionReview->department_review){
                                $dataSendEmail["condiction"]["position_id"] = $positionReview->id_positions;
                                $dataSendEmail["condiction"]["department_id"] = $positionReview->department_review;
                            }else{
                                $dataSendEmail["condiction"]["position_id"] = $positionReview->id_positions;
                                $dataSendEmail["condiction"]["branch_id"] = $data['location_review'];
                            }
                        }
                    }
                }
            }
            if ($request->hasFile('fn_invoice')) {
                $autoSerial = $this->generateSerialCode(Carbon::today(),"REF")['serialref'];
                $data['reference'] = $request->fn_reference ? $request->fn_reference . ',' . $autoSerial : $autoSerial;
                $image = $request->file('fn_invoice');
                $filename = $autoSerial.'.'.$image->getClientOriginalName();
                $image->move(public_path('uploads/FnRegularExspenses'), $filename);
                FnRegularExspense::create([
                    'serialref'   => $autoSerial,
                    'file_upload' => $filename,
                    'status'      => 1,
                    'created_by'  => Auth::user()->id,
                ]);
            } else {
                $data['reference'] = $request->fn_reference;
            }

            $data['status']             = 'pending';
            $data['approve_by']         = json_encode(explode(",", $request->approve_by));
            if($positionReview){
                $data['position_review']    = json_encode($positionReview->id_positions);
                $data['verify_print']      = $positionReview->verify_print;
                $data['review_type']        = $positionReview->type;
            }else{
                // *** Process get leave request **/
                $leave = self::leaveRequest([$request->approve_by],"", "","pending_approve");
                if($leave && count($leave) > 0){
                    $data['approve_by'] = $leave;
                }
                // *** end **/
                $data['position_review']    = null;
                $data['review_type']        = null;
                $data['status']             = 'pending_approve';
                $dataSendEmail["condiction"]["approve_by"]= [$request->approve_by];
            }
            
            // *** Process flow send alert email **/
            $dataSendEmail["data"]["date"] = Carbon::createFromDate()->format('Y-m-d H:i');
            $dataSendEmail["data"]["subject"] = $request->subject;
            $dataSendEmail["data"]["amount_usd"] = $request->ge_total_amount_usd;
            $dataSendEmail["data"]["amount_kh"] = $request->ge_total_amount_riel;
            $dataSendEmail["data"]["request_by"] = Auth::user()->employee_name_kh;
            self::sendEmail($dataSendEmail, Auth::user()->email);
            //*** end **/
            
            $data['tracking_id']        = $this->generateExpenseCode(Carbon::today())['tracking_id'];
            $data['payment_term']       = $request->paymentTerms;
            $data['request_by']         = ($request->request_by? $request->request_by: Auth::user()->id);
            $data['date_request']       = Carbon::createFromDate()->format('Y-m-d H:i');
            $data['created_by']         = Auth::user()->id;
            unset($data['fn_invoice']);
            $expense = ExpenseRequest::create($data);
            $locations = [];
            $locationArrays = json_decode($request->locations, true) ?? [];
            foreach ($locationArrays as $location) {
                $locations[] = [
                    'expense_request_id' => $expense->id,
                    'location_id'        => $location["id"],
                    'department_id'      => (isset($location["department_id"]) ? $location["department_id"] : ""),
                    'amount_usd'         => $location["amount_usd"],
                    'amount_riel'        => $location["amount_kh"],
                ];
            }

            if (!empty($locations)) {
                FnDetailLocation::insert($locations);
            }else{
                if (Auth::user()->branch->abbreviations != "HQ"){
                    FnDetailLocation::create([
                        'expense_request_id' => $expense->id,
                        'location_id'        => Auth::user()->branch_id,
                        'amount_usd'         => $request->ge_total_amount_usd,
                        'amount_riel'        => $request->ge_total_amount_riel,
                    ]);
                }
            }
            DB::commit();
            return response()->json(['message' => 'The process has been successfully.', 'status'=>200]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
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
        $FnApproval = FnApproval::with(["location"])
        ->leftJoin('branchs', 'fn_approvals.location_id', '=', 'branchs.id')
        ->select( 'fn_approvals.*', 'branchs.abbreviations')
        ->when(Auth::user()->branch, function ($query, $branch) {
            if($branch->abbreviations != 'HQ'){
                $query->where("branchs.abbreviations", $branch->abbreviations);
                $query->orWhere("branchs.abbreviations", "HQ");
            }
        })
        ->get();
        $locations = Branchs::get();
        $taxWHT = FnTaxRate::where('tax_type', 1)->get();
        $taxeFBT = FnTaxRate::where('tax_type', 2)->get();
        $FnPaymentTerms = FnPaymentTerm::get();
        $FnRegularExspenses = FnRegularExspense::where("status", "1")->where("is_contactual", "1")->get();
        $data = ExpenseRequest::where("expense_requests.id", $request->id)
            ->leftJoin('fn_approvals', 'expense_requests.kind_regard', '=', 'fn_approvals.id')
            ->select(
                'expense_requests.*',
                'fn_approvals.title'
            )
            ->with("locationDetails")->first();
        $employees= DB::table('users')
        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
        ->select( 'users.*', 'roles.role_type',)
        ->whereIn('users.emp_status', ['Probation','1','2','10',])
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if($RolePermission == 'Employee'){
                $query->where("users.department_id", Auth::user()->department_id);
                $query->where("users.branch_id", Auth::user()->branch_id);
                // $query->whereNot("users.id", Auth::user()->id);
            }
            if (in_array($RolePermission, ['BM','DBM'])){
                $query->where("users.branch_id", Auth::user()->branch_id);
                // $query->whereNot("users.id", Auth::user()->id);
            }
            if (in_array($RolePermission, ['HR','HRAdmin','DHOD','HOD'])){
                $query->where("users.department_id", Auth::user()->department_id);
                $query->where("users.branch_id", Auth::user()->branch_id);
                $query->orWhere("users.line_manager", Auth::user()->id);
                // $query->whereNot("users.id", Auth::user()->id);
            }
            if (in_array($RolePermission, ['BOD','CEO'])){
                // $query->whereNot("users.id", Auth::user()->id);
                $query->whereNot("roles.role_type", "Employee");
            }
            })->get();
        return view('FN_ExpenseRequests.form_edit_request', compact([
            'locations', 
            'FnApproval', 
            'taxWHT', 
            'taxeFBT', 
            'FnPaymentTerms', 
            'FnRegularExspenses',
            'data',
            'employees'
        ]));
    }
    public function editTax(Request $request)
    {
        $FnApproval = FnApproval::with(["location"])
        ->leftJoin('branchs', 'fn_approvals.location_id', '=', 'branchs.id')
        ->select( 'fn_approvals.*', 'branchs.abbreviations')
        ->when(Auth::user()->branch, function ($query, $branch) {
            if($branch->abbreviations != 'HQ'){
                $query->where("branchs.abbreviations", $branch->abbreviations);
                $query->orWhere("branchs.abbreviations", "HQ");
            }
        })
        ->get();
        $locations = Branchs::get();
        $department = Department::get();
        $FnPaymentTerms = FnPaymentTerm::get();
        $FnRegularExspenses = FnRegularExspense::where("status", "1")->where("is_contactual", "1")->get();
        $data = ExpenseRequest::where("expense_requests.id", $request->id)
            ->leftJoin('fn_approvals', 'expense_requests.kind_regard', '=', 'fn_approvals.id')
            ->select(
                'expense_requests.*',
                'fn_approvals.title'
            )
            ->with("departments")->first();
        return view('FN_tax_expenses.form_edit_request', compact([
            'locations', 
            'department', 
            'FnApproval',
            'FnPaymentTerms', 
            'FnRegularExspenses',
            'data'
        ]));
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
        DB::beginTransaction();
        try{
            $exchange = FNExchangeRate::first();
            $amount = 0;
            $ge_total_cost_riel = 0;
            if ($request->ge_total_cost_riel) {
                $ge_total_cost_riel = ( $request->ge_total_cost_riel / $exchange->amount_riel);
            }
            $amount = ($request->ge_total_cost_usd + $ge_total_cost_riel);
            $dataCheckLevelView = [
                "by_location"=> 2,
                "model_review"=> null,
                "position_request"=> Auth::user()->position_id,
                "request_type"=> $request->type,
                "reference_type"=> $request->expense_type,
                "special_fixed_asset"=> ($request->type != 2 ? $request->special_asset : null),
                "type"=> 1,
                "amount"=> $amount,
            ];
            $dataSendEmail = [
                "condiction" => [
                    "department_id"=> "",
                    "branch_id"=> "",
                    "position_id"=> "",
                    "approve_by"=> "",
                    "request_by"=> "",
                ],
                "data" =>[
                    "title" => "សំណើស្នើសុំចំណាយ",
                    "status" => "pending",
                    "tracking_id" => "",
                    "date" => "",
                    "subject" => "",
                    "review" => 0,
                    "request_by" => "",
                    "reason" => "",
                    "amount_usd" => 0,
                    "amount_kh" => 0,
                ]
            ];
            $data = ExpenseRequest::find($request->id);
            if(Auth::user()->branch->abbreviations == "HQ"){
                $dataCheckLevelView["model_review"] = (int) Auth::user()->department_id;
                $positionReview = self::lovelReview($dataCheckLevelView);
                if($positionReview){
                    if(count($positionReview->id_positions) > 0){
                        if (in_array(Auth::user()->position_id, $positionReview->id_positions)) {
                            if($positionReview->verify_print == 1){
                                $data["review_by"]      = Auth::user()->id;
                                $data["date_review"]    = Carbon::createFromDate()->format('Y-m-d H:i');
                            }
                            $dataCheckLevelView["type"] = ($positionReview->type + 1);
                            $dataCheckLevelView["position_request"] = null;
                            $positionReview = self::lovelReview($dataCheckLevelView);
                            // if(!$positionReview){
                            //     return response()->json(['message' => 'Please contact the finance team to set up a level review.', 'status'=>404]);
                            // }
                        }   
                    }
                    if($positionReview){
                        $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->department_id;
                        if (count($positionReview->id_positions) > 0) {
                            // *** Process get leave request **/
                            $leave = self::leaveRequest($positionReview->id_positions, $positionReview->model_review, Auth::user()->branch_id, "pending");
                            if($leave && count($leave) > 0){
                                $positionReview->id_positions = $leave;
                            }
                            // *** end **/
                            $dataSendEmail["condiction"]["position_id"] = $positionReview->id_positions;
                            $dataSendEmail["condiction"]["department_id"] = $data['location_review'];
                        }
                    }
                }
            }else{
                $dataCheckLevelView["by_location"] = 1;
                $positionReview = self::lovelReview($dataCheckLevelView);
                if($positionReview){
                    if(count($positionReview->id_positions) > 0){
                        if (in_array(Auth::user()->position_id, $positionReview->id_positions)) {
                            if($positionReview->verify_print == 1){
                                $data["review_by"]      = Auth::user()->id;
                                $data["date_review"]    = Carbon::createFromDate()->format('Y-m-d H:i');
                            }
                            $dataCheckLevelView["type"] = ($positionReview->type + 1);
                            $dataCheckLevelView["position_request"] = null;
                            $positionReview = self::lovelReview($dataCheckLevelView);
                            if(!$positionReview){
                                return response()->json(['message' => 'Please contact the finance team to set up a level review.', 'status'=>404]);
                            }
                        }   
                    }
                    if($positionReview){
                        $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->branch_id;
                        if (count($positionReview->id_positions) > 0) {
                            // *** Process get leave request **/
                            $leave = self::leaveRequest($positionReview->id_positions, $positionReview->model_review, Auth::user()->branch_id, "pending");
                            if($leave && count($leave) > 0){
                                $positionReview->id_positions = $leave;
                            }
                            // *** end **/
                            if($positionReview->department_review){
                                $dataSendEmail["condiction"]["position_id"] = $positionReview->id_positions;
                                $dataSendEmail["condiction"]["department_id"] = $positionReview->department_review;
                            }else{
                                $dataSendEmail["condiction"]["position_id"] = $positionReview->id_positions;
                                $dataSendEmail["condiction"]["branch_id"] = $data['location_review'];
                            }
                        }
                    }
                }
            }
            $oldId = ExpenseRequestHistory::where("expense_id", $request->id)->count();
            $dataHistory = $data->toArray();
            $dataHistory['expense_id'] = $data->id;
            $dataHistory['tracking_id'] = $data->tracking_id . "@".$oldId;
            unset($dataHistory['id']);
            ExpenseRequestHistory::create($dataHistory);
            $data['status']             = 'pending';
            
            // ***  block update reference or add new reference *** //
            if ($request->e_fn_invoice) {
                $dataReference = FnRegularExspense::where("file_upload", $request->e_fn_invoice)->first();
                if ($dataReference && $request->hasFile('fn_invoice')) {
                    $image = $request->file('fn_invoice');
                    $path = public_path('uploads/FnRegularExspenses/' . $dataReference->file_upload);
                    if (file_exists($path)) {
                        unlink($path); // delete the old file
                    }
                    $filename = $dataReference->serialref.'.'.$image->getClientOriginalName();
                    $data['reference'] = $request->fn_reference ? $request->fn_reference . ',' . $dataReference->serialref : $dataReference->serialref;
                    $image->move(public_path('uploads/FnRegularExspenses'), $filename);
                    $dataReference->file_upload = $filename;
                    $dataReference->updated_by = Auth::user()->id;
                    $dataReference->save();
                }else{
                    if (!$request->hasFile('fn_invoice') && !$request->old_file_name) {
                        $path = public_path('uploads/FnRegularExspenses/' . $dataReference->file_upload);
                        if (file_exists($path)) {
                            unlink($path); // delete the old file
                            $expense = FnRegularExspense::find($dataReference->id);
                            if ($expense) {
                                $expense->updated_by = Auth::user()->id; // set the current user who deleted
                                $expense->save(); // save update before delete
                                $expense->delete(); // soft or hard delete depending on model
                            }
                        }
                        $data['reference'] = $request->fn_reference;
                    }else{
                        $data['reference'] = $request->fn_reference ? $request->fn_reference . ',' . $dataReference->serialref : $dataReference->serialref; 
                    }
                }
                 
            }else{
                if ($request->hasFile('fn_invoice')) {
                    $image = $request->file('fn_invoice');
                    $autoSerial = $this->generateSerialCode(Carbon::today(),"REF")['serialref'];
                    $data['reference'] = $request->fn_reference ? $request->fn_reference . ',' . $autoSerial : $autoSerial;
                    $filename = $autoSerial.'.'.$image->getClientOriginalName();
                    $image->move(public_path('uploads/FnRegularExspenses'), $filename);
                    FnRegularExspense::create([
                        'serialref'   => $autoSerial,
                        'file_upload' => $filename,
                        'status'      => 1,
                        'created_by'  => Auth::user()->id,
                    ]);
                }
            }
            // ***  block update locations or add new locations *** //
            if (Auth::user()->branch->abbreviations != "HQ"){
                $detailLocation = FnDetailLocation::where("expense_request_id", $request->id)->first();
                $detailLocation["amount_usd"] = $request->ge_total_amount_usd;
                $detailLocation["amount_riel"] = $request->ge_total_amount_riel;
                $detailLocation->save();
            }else{
                $locations = [];
                $locationArrays = json_decode($request->locations, true) ?? [];
                $totalLocations = FnDetailLocation::where('expense_request_id', $request->id)->count();
                $locationCount = count($locationArrays); // Store the count once
                if ($locationCount > $totalLocations) {
                    foreach ($locationArrays as $location) {
                        $dataLocation = FnDetailLocation::where('expense_request_id', $request->id)
                            ->where('location_id', $location['id'])
                            ->first();
                
                        if ($dataLocation) {
                            // Update existing location
                            $dataLocation->amount_usd = $location['amount_usd'];
                            $dataLocation->amount_riel = $location['amount_kh'];
                            $dataLocation->save();
                        } else {
                            // Prepare for batch insert if not found
                            $locations[] = [
                                'expense_request_id' => $request->id,
                                'location_id'        => $location['id'],
                                'amount_usd'         => $location['amount_usd'],
                                'amount_riel'        => $location['amount_kh'],
                            ];
                        }
                    }
                
                    if (!empty($locations)) {
                        FnDetailLocation::insert($locations);
                    }
                } else{
                    // Get all location IDs that exist in the database but not in the new array for deletion
                    $existingLocations = FnDetailLocation::where('expense_request_id', $request->id)
                        ->whereNotIn('location_id', array_column($locationArrays, 'id'))
                        ->get();
                    foreach ($existingLocations as $existingLocation) {
                        // Delete locations that are no longer present
                        $existingLocation->delete();
                    }
                    // Now proceed with adding new locations or updating existing ones
                    foreach ($locationArrays as $location) {
                        $dataLocation = FnDetailLocation::where('expense_request_id', $request->id)
                            ->where('location_id', $location['id'])
                            ->first();
                
                        if ($dataLocation) {
                            // Update existing location
                            $dataLocation->amount_usd = $location['amount_usd'];
                            $dataLocation->amount_riel = $location['amount_kh'];
                            $dataLocation->save();
                        } else {
                            // Prepare for batch insert
                            $locations[] = [
                                'expense_request_id' => $request->id,
                                'location_id'        => $location['id'],
                                'amount_usd'         => $location['amount_usd'],
                                'amount_riel'        => $location['amount_kh'],
                            ];
                        }
                    }
                
                    if (!empty($locations)) {
                        FnDetailLocation::insert($locations);
                    }
                }
            }
            $data['approve_by']                     = json_encode(explode(",", $request->approve_by));
            if($positionReview){
                $data['position_review']                = json_encode($positionReview->id_positions);
                $data['verify_print']                   = $positionReview->verify_print;
                $data['review_type']                    = $positionReview->type;
            }else{
                // *** Process get leave request **/
                $leave = self::leaveRequest([$request->approve_by],"", "","pending_approve");
                if($leave && count($leave) > 0){
                    $data['approve_by'] = $leave;
                }
                // *** end **/
                $data['position_review']    = null;
                $data['review_type']        = null;
                $data['status']             = 'pending_approve';
                // $dataSendEmail["condiction"]["approve_by"]= [$request->approve_by];
            }
           
            
            // $data["approve_by"]                     = $request->approve_by;
            $data["type"]                           = $request->type;
            $data["expense_type"]                   = $request->expense_type;
            $data["kind_regard"]                    = $request->kind_regard;
            $data["subject"]                        = $request->subject;
            $data["reason_subject"]                 = $request->reason_subject;
            $data["payment_term"]                   = $request->paymentTerms;
            $data["ge_cost_material_usd"]           = $request->ge_cost_material_usd;
            $data["ge_cost_material_riel"]          = $request->ge_cost_material_riel;
            $data["ge_cost_lso_usd"]                = $request->ge_cost_lso_usd;
            $data["ge_cost_lso_riel"]               = $request->ge_cost_lso_riel;
            $data["ge_total_cost_usd"]              = $request->ge_total_cost_usd;
            $data["ge_total_cost_riel"]             = $request->ge_total_cost_riel;
            $data["ge_tax_usd"]                     = $request->ge_tax_usd;
            $data["tax_riel"]                       = $request->tax_riel;
            $data["ge_tax_fringe_benefit_usd"]      = $request->ge_tax_fringe_benefit_usd;
            $data["tax_fringe_benefit_riel"]        = $request->tax_fringe_benefit_riel;
            $data["ge_vat_reverse_charge_usd"]      = $request->ge_vat_reverse_charge_usd;
            $data["vat_reverse_charge_riel"]        = $request->vat_reverse_charge_riel;
            $data["ge_total_amount_usd"]            = $request->ge_total_amount_usd;
            $data["ge_total_amount_riel"]           = $request->ge_total_amount_riel;
            $data["remark"]                         = $request->remark;
            $data["reason"]                         = "";
            $data['updated_by']                     = Auth::user()->id;
            $data->save();
            // *** function send email **/
            $dataSendEmail["data"]["date"] = Carbon::createFromDate()->format('Y-m-d H:i');
            $dataSendEmail["data"]["subject"] = $request->subject;
            $dataSendEmail["data"]["amount_usd"] = $request->ge_total_amount_usd;
            $dataSendEmail["data"]["amount_kh"] = $request->ge_total_amount_riel;
            $dataSendEmail["data"]["request_by"] = Auth::user()->employee_name_kh;
            self::sendEmail($dataSendEmail, Auth::user()->email);
            /// *** end **/
            DB::commit();
            return response()->json(['message' => 'Update successfully.', 'status'=>200]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateTax(Request $request)
    {
        DB::beginTransaction();
        try{
            $exchange = FNExchangeRate::first();
            $amount = 0;
            $ge_total_cost_riel = 0;
            if ($request->ge_total_cost_riel) {
                $ge_total_cost_riel = ( $request->ge_total_cost_riel / $exchange->amount_riel);
            }
            $amount = ($request->ge_total_cost_usd + $ge_total_cost_riel);
            
            $dataCheckLevelView = [
                "by_location"=> 2,
                "model_review"=> null,
                "position_request"=> Auth::user()->position_id,
                "request_type"=> "2",
                "reference_type"=> "1",
                "special_fixed_asset"=> null,
                "type"=> 1,
                "amount"=> $amount,
            ];
            $dataSendEmail = [
                "condiction" => [
                    "department_id"=> "",
                    "branch_id"=> "",
                    "position_id"=> "",
                    "approve_by"=> "",
                    "request_by"=> "",
                ],
                "data" =>[
                    "title" => "សំណើស្នើសុំចំណាយ",
                    "status" => "pending",
                    "tracking_id" => "",
                    "date" => "",
                    "subject" => "",
                    "review" => 0,
                    "request_by" => "",
                    "reason" => "",
                    "amount_usd" => 0,
                    "amount_kh" => 0,
                ]
            ];
            $data = ExpenseRequest::find($request->id);
            if(Auth::user()->branch->abbreviations == "HQ"){
                $dataCheckLevelView["model_review"] = Auth::user()->department_id;
                $positionReview = self::lovelReview($dataCheckLevelView);
                if($positionReview){
                    if(count($positionReview->id_positions) > 0){
                        
                        if (in_array(Auth::user()->position_id, $positionReview->id_positions)) {
                            if($positionReview->verify_print == 1){
                                $data["review_by"]      = Auth::user()->id;
                                $data["date_review"]    = Carbon::createFromDate()->format('Y-m-d H:i');
                            }
                            $dataCheckLevelView["type"] = ($positionReview->type + 1);
                            $dataCheckLevelView["position_request"] = null;
                            $positionReview = self::lovelReview($dataCheckLevelView);
                            // if(!$positionReview){
                            //     return response()->json(['message' => 'Please contact the finance team to set up a level review.', 'status'=>404]);
                            // }
                        }   
                    }
                    if($positionReview){
                        $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->department_id;
                        if (count($positionReview->id_positions) > 0) {
                            // *** Process get leave request **/
                            $leave = self::leaveRequest($positionReview->id_positions, $positionReview->model_review, Auth::user()->branch_id, "pending");
                            if($leave && count($leave) > 0){
                                $positionReview->id_positions = $leave;
                            }
                            // *** end **/
                            $dataSendEmail["condiction"]["position_id"] = $positionReview->id_positions;
                            $dataSendEmail["condiction"]["department_id"] = $data['location_review'];
                        }
                    }
                }
            }else{
                $dataCheckLevelView["by_location"] = 1;
                $positionReview = self::lovelReview($dataCheckLevelView);
                if($positionReview){
                    if(count($positionReview->id_positions) > 0){
                        if (in_array(Auth::user()->position_id, $positionReview->id_positions)) {
                            if($positionReview->verify_print == 1){
                                $data["review_by"]      = Auth::user()->id;
                                $data["date_review"]    = Carbon::createFromDate()->format('Y-m-d H:i');
                            }
                            $dataCheckLevelView["type"] = ($positionReview->type + 1);
                            $dataCheckLevelView["position_request"] = null;
                            $positionReview = self::lovelReview($dataCheckLevelView);
                            // if(!$positionReview){
                            //     return response()->json(['message' => 'Please contact the finance team to set up a level review.', 'status'=>404]);
                            // }
                        }   
                    }
                    if($positionReview){
                        $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->branch_id;
                        if (count($positionReview->id_positions) > 0) {
                            // *** Process get leave request **/
                            $leave = self::leaveRequest($positionReview->id_positions, $positionReview->model_review, Auth::user()->branch_id,"pending");
                            if($leave && count($leave) > 0){
                                $positionReview->id_positions = $leave;
                            }
                            // *** end **/
                            if($positionReview->department_review){
                                $dataSendEmail["condiction"]["position_id"] = $positionReview->id_positions;
                                $dataSendEmail["condiction"]["department_id"] = $positionReview->department_review;
                            }else{
                                $dataSendEmail["condiction"]["position_id"] = $positionReview->id_positions;
                                $dataSendEmail["condiction"]["branch_id"] = $data['location_review'];
                            }
                        }
                    }
                }
            }

            // ***  block create history *** //
            $oldId = ExpenseRequestHistory::where("expense_id", $request->id)->count();
            $dataHistory = $data->toArray();
            $dataHistory['expense_id'] = $data->id;
            $dataHistory['tracking_id'] = $data->tracking_id . "@".$oldId;
            unset($dataHistory['id']);
            ExpenseRequestHistory::create($dataHistory);
            $data['status']             = 'pending';
            
            // ***  block update reference or add new reference *** //
            if ($request->e_fn_invoice) {
                $dataReference = FnRegularExspense::where("file_upload", $request->e_fn_invoice)->first();
                if ($dataReference && $request->hasFile('fn_invoice')) {
                    $image = $request->file('fn_invoice');
                    $path = public_path('uploads/FnRegularExspenses/' . $dataReference->file_upload);
                    if (file_exists($path)) {
                        unlink($path); // delete the old file
                    }
                    $filename = $dataReference->serialref.'.'.$image->getClientOriginalName();
                    $data['reference'] = $request->fn_reference ? $request->fn_reference . ',' . $dataReference->serialref : $dataReference->serialref;
                    $image->move(public_path('uploads/FnRegularExspenses'), $filename);
                    $dataReference->file_upload = $filename;
                    $dataReference->updated_by = Auth::user()->id;
                    $dataReference->save();
                }else{
                    if (!$request->hasFile('fn_invoice') && !$request->old_file_name) {
                        $path = public_path('uploads/FnRegularExspenses/' . $dataReference->file_upload);
                        if (file_exists($path)) {
                            unlink($path); // delete the old file
                            $expense = FnRegularExspense::find($dataReference->id);
                            if ($expense) {
                                $expense->updated_by = Auth::user()->id; // set the current user who deleted
                                $expense->save(); // save update before delete
                                $expense->delete(); // soft or hard delete depending on model
                            }
                        }
                        $data['reference'] = $request->fn_reference; 
                    }
                }
            }else{
                if ($request->hasFile('fn_invoice')) {
                    $image = $request->file('fn_invoice');
                    $autoSerial = $this->generateSerialCode(Carbon::today(),"REF")['serialref'];
                    $data['reference'] = $request->fn_reference ? $request->fn_reference . ',' . $autoSerial : $autoSerial;
                    $filename = $autoSerial.'.'.$image->getClientOriginalName();
                    $image->move(public_path('uploads/FnRegularExspenses'), $filename);
                    FnRegularExspense::create([
                        'serialref'   => $autoSerial,
                        'file_upload' => $filename,
                        'status'      => 1,
                        'created_by'  => Auth::user()->id,
                    ]);
                }
            }
            // ***  block update locations or add new locations *** //
            $locations = [];
            $locationArrays = json_decode($request->locations, true) ?? [];
            $totalLocations = FnDetailLocation::where('expense_request_id', $request->id)->count();
            $locationCount = count($locationArrays); // Store the count once
            
            if ($locationCount > $totalLocations) {
                foreach ($locationArrays as $location) {
                    $dataLocation = FnDetailLocation::where('expense_request_id', $request->id)
                       ->when($location['id'], function ($query, $location_id) {
                            $query->where('location_id', $location_id);
                        })
                        ->when($location['department_id'], function ($query, $department_id) {
                            $query->where('department_id', $department_id);
                        })
                        ->first();
            
                    if ($dataLocation) {
                        // Update existing location
                        $dataLocation->amount_usd = $location['amount_usd'];
                        $dataLocation->amount_riel = $location['amount_kh'];
                        $dataLocation->save();
                    } else {
                        // Prepare for batch insert if not found
                        $locations[] = [
                            'expense_request_id' => $request->id,
                            'location_id'        => $location['id'],
                            'department_id'      => (isset($location["department_id"]) ? $location["department_id"] : ""),
                            'amount_usd'         => $location['amount_usd'],
                            'amount_riel'        => $location['amount_kh'],
                        ];
                    }
                }
            
                if (!empty($locations)) {
                    FnDetailLocation::insert($locations);
                }
            } else{

                $ids          = array_column($locationArrays, 'id');
                $departmentIds = array_column($locationArrays, 'department_id');

                $existingLocations = FnDetailLocation::where('expense_request_id', $request->id)->get();

                foreach ($existingLocations as $existingLocation) {
                    $shouldDelete = false;

                    if (!empty($existingLocation->location_id) && !in_array($existingLocation->location_id, $ids)) {
                        $shouldDelete = true;
                    }

                    if (!empty($existingLocation->department_id) && !in_array($existingLocation->department_id, $departmentIds)) {
                        $shouldDelete = true;
                    }

                    if ($shouldDelete) {
                        $existingLocation->delete();
                    }
                }

                // Now proceed with adding new locations or updating existing ones
                foreach ($locationArrays as $location) {
                    $dataLocation = FnDetailLocation::where('expense_request_id', $request->id)
                        ->when($location['id'], function ($query, $location_id) {
                            $query->where('location_id', $location_id);
                        })
                        ->when($location['department_id'], function ($query, $department_id) {
                            $query->where('department_id', $department_id);
                        })
                        ->first();
            
                    if ($dataLocation) {
                        // Update existing location
                        $dataLocation->amount_usd = $location['amount_usd'];
                        $dataLocation->amount_riel = $location['amount_kh'];
                        $dataLocation->save();
                    } else {
                        // Prepare for batch insert
                        $locations[] = [
                            'expense_request_id' => $request->id,
                            'location_id'        => $location['id'],
                            'department_id'      => (isset($location["department_id"]) ? $location["department_id"] : ""),
                            'amount_usd'         => $location['amount_usd'],
                            'amount_riel'        => $location['amount_kh'],
                        ];
                    }
                }
            
                if (!empty($locations)) {
                    FnDetailLocation::insert($locations);
                }
            }
            $data['approve_by']                     = json_encode(explode(",", $request->approve_by));
            if($positionReview){
                $data['position_review']                = json_encode($positionReview->id_positions);
                $data['verify_print']                   = $positionReview->verify_print;
            }else{
                // *** Process get leave request **/
                $leave = self::leaveRequest([$request->approve_by],"", "","pending_approve");
                if($leave && count($leave) > 0){
                    $data['approve_by'] = $leave;
                }
                // *** end **/
                $data['position_review']    = null;
                $data['review_type']        = null;
                $data['status']             = 'pending_approve';
                // $dataSendEmail["condiction"]["approve_by"]= [$request->approve_by];
            }
            
            // $data['approve_by']                     = json_encode(explode(",", $request->approve_by));
            // $data['position_review']                = json_encode($positionReview->id_positions);
            // $data['verify_print']                   = $positionReview->verify_print;
            $data["kind_regard"]                    = $request->kind_regard;
            $data["subject"]                        = $request->subject;
            $data["reason_subject"]                 = $request->reason_subject;
            $data["payment_term"]                   = $request->paymentTerms;
            $data["ge_cost_material_usd"]           = $request->ge_cost_material_usd;
            $data["ge_cost_material_riel"]          = $request->ge_cost_material_riel;
            $data["ge_cost_lso_usd"]                = $request->ge_cost_lso_usd;
            $data["ge_cost_lso_riel"]               = $request->ge_cost_lso_riel;
            $data["ge_tax_usd"]                     = $request->ge_tax_usd;
            $data["te_tax_income"]                  = $request->te_tax_income;
            $data["ge_total_cost_usd"]              = $request->ge_total_cost_usd;
            $data["ge_total_cost_riel"]             = $request->ge_total_cost_riel;
            $data["ge_vat_reverse_charge_usd"]      = $request->ge_vat_reverse_charge_usd;
            $data["vat_reverse_charge_riel"]        = $request->vat_reverse_charge_riel;
            $data["ge_total_amount_usd"]            = $request->ge_total_amount_usd;
            $data["te_total_tax"]                   = $request->te_total_tax;
            $data["remark"]                         = $request->remark;
            $data["reason"]                         = "";
            $data['updated_by']                     = Auth::user()->id;
            $data->save();
            // *** function send email **/
            $dataSendEmail["data"]["date"] = Carbon::createFromDate()->format('Y-m-d H:i');
            $dataSendEmail["data"]["subject"] = $request->subject;
            $dataSendEmail["data"]["amount_usd"] = $request->ge_total_amount_usd;
            $dataSendEmail["data"]["amount_kh"] = $request->ge_total_amount_riel;
            $dataSendEmail["data"]["request_by"] = Auth::user()->employee_name_kh;
            self::sendEmail($dataSendEmail, Auth::user()->email);
            /// *** end **/
            DB::commit();
            return response()->json(['message' => 'Update successfully.', 'status'=>200]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function processing(Request $request)
    {
        DB::beginTransaction();
        try{
            $data = ExpenseRequest::where("id",$request->id)->with("requestBy")->first();
            $oldId = ExpenseRequestHistory::where("expense_id", $request->id)->count();
            $dataHistory = $data->toArray();
            $dataHistory['expense_id'] = $data->id;
            $dataHistory['tracking_id'] = $data->tracking_id . "@".$oldId;
            unset($dataHistory['id']);
            unset($dataHistory['request_by']);
            if($request->review_type == $data->review_type){
                return response()->json(['message' => 'Already reviewed please to reload page.', 'status'=>400]);
            }
            $type =  $data->review_type + 1;
            $dataSendEmail = [
                "condiction" => [
                    "department_id"=> "",
                    "branch_id"=> "",
                    "position_id"=> "",
                    "approve_by"=> "",
                    "request_by"=> "",
                ],
                "data" =>[
                    "title" => "សំណើស្នើសុំចំណាយត្រូវបានបដិសេធ",
                    "status" => "pending",
                    "tracking_id" => "",
                    "date" => "",
                    "subject" => "",
                    "review" => 0,
                    "request_by" => "",
                    "reason" => "",
                    "amount_usd" => 0,
                    "amount_kh" => 0,
                ]
            ];
            $approveByArray = json_decode($data->approve_by);
            if (in_array(Auth::user()->id, $approveByArray) && $data->status== "pending_approve") {
                $data['position_review']    = [];
                $data['review_type']        = null;
                $data['status']             = 'approved';
                $data['final_approve_by']   = Auth::user()->id;
                $data['date_approve']       = ($request->approve_date ? $request->approve_date : Carbon::createFromDate()->format('Y-m-d H:i'));
                if ($data->requestBy && $data->requestBy->email) {
                    $dataSendEmail["data"]["title"]= "សំណើស្នើសុំចំណាយត្រូវបានអនុម័ត";
                    $dataSendEmail["data"]["tracking_id"]= $data->tracking_id;
                    $dataSendEmail["data"]["status"]= "approve";
                    self::sendEmail($dataSendEmail, $data->requestBy->email);
                }
            }else{
                $exchange = FNExchangeRate::first();
                $amount = 0;
                $ge_total_cost_riel = 0;
                if ($data->ge_total_cost_riel) {
                    $ge_total_cost_riel = ( $data->ge_total_cost_riel / $exchange->amount_riel);
                }
                $amount = ($data->ge_total_cost_usd + $ge_total_cost_riel);
                $dataCheckLevelView = [
                    "by_location"=> 2,
                    "position_request"=> null,
                    "model_review"=> null,
                    "type"=> $type,
                    "request_type"=> $data->type,
                    "reference_type"=> $data->expense_type,
                    "special_fixed_asset"=> ($data->type != 2 ? $data->special_asset : null),
                    "amount"=> $amount,
                ];
                $branch = Branchs::where("id", $data->requestBy->branch_id)->first();   
                if($branch->abbreviations == "HQ"){
                    $dataCheckLevelView["model_review"] = (int) $data->requestBy->department_id;
                    $lovelReview = self::lovelReview($dataCheckLevelView);
                }else{
                    $dataCheckLevelView["by_location"] = 1;
                    $lovelReview = self::lovelReview($dataCheckLevelView);
                }
                if ($lovelReview) {
                    if ($branch->abbreviations != "HQ") {
                        $data['location_review']    = $lovelReview->department_review ? $lovelReview->department_review : $data->requestBy->branch_id;
                        if (count($lovelReview->id_positions) > 0) {
                            if($lovelReview->department_review){
                                $dataSendEmail["condiction"]["position_id"] = $lovelReview->id_positions;
                                $dataSendEmail["condiction"]["department_id"] = $lovelReview->department_review;
                            }else{
                                $dataSendEmail["condiction"]["position_id"] = $lovelReview->id_positions;
                                $dataSendEmail["condiction"]["branch_id"] = $data->requestBy->branch_id;
                            }
                        }
                    }else{
                        $data['location_review']    = $lovelReview->department_review ? $lovelReview->department_review : $data->requestBy->department_id;
                        $dataSendEmail["condiction"]["position_id"] = $lovelReview->id_positions;
                        $dataSendEmail["condiction"]["department_id"] = $data['location_review'];
                    }
                    // *** Process get leave request **/
                    $model_review = '';
                    $branch = '';
                    if($lovelReview->department_review){
                        $model_review = $lovelReview->department_review;
                    }else{
                        $model_review = $lovelReview->model_review;
                        $branch = $data->requestBy->branch_id;
                    }
                    $leave = self::leaveRequest($lovelReview->id_positions, $model_review, $branch,"pending");
                    if($leave && count($leave) > 0){
                        $lovelReview->id_positions = $leave;
                    }
                    // *** end **/
                    $data['status']             = 'pending';
                    $data['position_review']    = json_encode($lovelReview->id_positions);
                    $data['review_type']        = $lovelReview->type;
                    if($data->verify_print == 1){
                        $data["review_by"]      = Auth::user()->id;
                        $data["date_review"]    = Carbon::createFromDate()->format('Y-m-d H:i');
                    }
                    $data['verify_print']        = $lovelReview->verify_print;
                }else{
                    // *** Process get leave request **/
                    $leave = self::leaveRequest(json_decode($data->approve_by),"", "","pending_approve");
                    if($leave && count($leave) > 0){
                        $data['approve_by'] = $leave;
                    }
                    // *** end **/
                    $data['position_review']    = [];
                    $data['review_type']        = null;
                    $data['status']             = 'pending_approve';
                    $dataSendEmail["condiction"]["approve_by"]= $data->approve_by;

                    if($data->verify_print == 1){
                        $data["review_by"]      = Auth::user()->id;
                        $data["date_review"]    = Carbon::createFromDate()->format('Y-m-d H:i');
                    }
                    $data['verify_print']        = null;
                }
                self::sendEmail($dataSendEmail, Auth::user()->email);
            }
            ExpenseRequestHistory::create($dataHistory);
            $data["reason"]                 = $request->remark;
            $data['is_log_action']          = 1;
            $data['updated_by']             = Auth::user()->id;
            $data->save();
            DB::commit();
            return response()->json(['message' => 'Update successfully.', 'status'=>200]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }
    public function reject(Request $request)
    {
        DB::beginTransaction();
        try{
            $data = ExpenseRequest::where("id",$request->id)->with("requestBy")->first();
            $oldId = ExpenseRequestHistory::where("expense_id", $request->id)->count();
            $exchange = FNExchangeRate::first();
            $amount = 0;
            $ge_total_cost_riel = 0;
            if ($request->ge_total_cost_riel) {
                $ge_total_cost_riel = ( $data->ge_total_cost_riel / $exchange->amount_riel);
            }
            $amount = ($data->ge_total_cost_usd + $ge_total_cost_riel);

            $dataSendEmail = [
                "condiction" => [
                    "department_id"=> "",
                    "branch_id"=> "",
                    "position_id"=> "",
                    "approve_by"=> "",
                    "request_by"=> "",
                ],
                "data" =>[
                    "title" => "សំណើស្នើសុំចំណាយត្រូវបានបដិសេធ",
                    "status" => "reject",
                    "tracking_id" => "",
                    "date" => "",
                    "subject" => "",
                    "review" => 0,
                    "request_by" => "",
                    "reason" => "",
                    "amount_usd" => 0,
                    "amount_kh" => 0,
                ]
            ];
            $dataHistory = $data->toArray();
            $dataHistory['expense_id'] = $data->id;
            $dataHistory['tracking_id'] = $data->tracking_id . "@".$oldId;
            unset($dataHistory['id']);
            unset($dataHistory['request_by']);
            $data["review_by"] = null;
            $data["date_review"] = null;
            $dataCheckLevelView = [
                "by_location"=> 2,
                "model_review"=> null,
                "position_request"=> $data->requestBy->position_id,
                "request_type"=> $data->type,
                "reference_type"=> $data->expense_type,
                "special_fixed_asset"=> ($data->type != 2 ? $data->special_asset : null),
                "type"=> 1,
                "amount"=> $amount,
            ];
            $branch = Branchs::where("id", $data->requestBy->branch_id)->first();
            if($branch->abbreviations == "HQ"){

                $dataCheckLevelView["model_review"] = (int) $data->requestBy->department_id;
                $lovelReview = self::lovelReview($dataCheckLevelView);
                if($lovelReview){
                    if(count($lovelReview->id_positions) > 0){
                        if (in_array($data->requestBy->position_id, $lovelReview->id_positions)) {
                            if($lovelReview->verify_print == 1){
                                $data["review_by"]      = $data->request_by;
                                $data["date_review"]    = Carbon::createFromDate()->format('Y-m-d H:i');
                            }
                            $dataCheckLevelView["type"] = ($lovelReview->type + 1);
                            $dataCheckLevelView["position_request"] = null;
                            $lovelReview = self::lovelReview($dataCheckLevelView);
                        } 
                    }
                    if($lovelReview){
                        $data['location_review']    = $lovelReview->department_review ? $lovelReview->department_review : $data->requestBy->department_id;
                    }
                }
            }else{
                $dataCheckLevelView["by_location"] = 1;
                $lovelReview = self::lovelReview($dataCheckLevelView);
                if($lovelReview){
                    if(count($lovelReview->id_positions) > 0){
                        if (in_array($data->requestBy->position_id, $lovelReview->id_positions)) {
                            if($lovelReview->verify_print == 1){
                                $data["review_by"]      = $data->request_by;
                                $data["date_review"]    = Carbon::createFromDate()->format('Y-m-d H:i');
                            }
                            $dataCheckLevelView["type"] = ($lovelReview->type + 1);
                            $dataCheckLevelView["position_request"] = null;
                            $lovelReview = self::lovelReview($dataCheckLevelView);
                        } 
                    }
                    if($lovelReview){
                        $data['location_review']    = $lovelReview->department_review ? $lovelReview->department_review : $data->requestBy->branch_id;
                    }
                    
                }
                
            };

            $dataSendEmail["data"]["date"] = Carbon::createFromDate()->format('Y-m-d H:i');
            $dataSendEmail["data"]["reason"] = $request->remark;
            $dataSendEmail["data"]["review"] = $data->review_type;
            if ($data->requestBy && $data->requestBy->email) {
                self::sendEmail($dataSendEmail, $data->requestBy->email);
            }
           
            ExpenseRequestHistory::create($dataHistory);
            $data['status']             = 'rejected';
            $data['reject_review_type'] = $data->review_type;
           
            if ($lovelReview) {
                // *** Process get leave request **/
                $leave = self::leaveRequest($lovelReview->id_positions, $lovelReview->model_review, $data->requestBy->branch_id,"pending");
                if($leave && count($leave) > 0){
                    $lovelReview->id_positions = $leave;
                }
                // *** end **/

                $data['position_review']    = $lovelReview->id_positions;
                $data['review_type']        = $lovelReview->type;
                $data['verify_print']       = $lovelReview->verify_print;
                // $data['review_type']        = 1;
            }
            $data["reason"]                 = $request->remark;
            $data['is_log_action']          = null;
            $data['updated_by']             = Auth::user()->id;
            $data->save();
            DB::commit();
            return response()->json(['message' => 'Rejected successfully.']);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
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
            $exp = ExpenseRequest::find($request->id);
            if ($exp) {
                $exp->tracking_id     = "D".$exp->tracking_id;
                $exp->save();
                $reference = explode(',', $exp->reference);
                $FnRegularList = FnRegularExspense::whereIn("serialref", $reference)->get();
                foreach ($FnRegularList as $rxp) {
                    if ($rxp->is_contactual != 1) {
                        FnRegularExspense::destroy($rxp->id);
                        $path = public_path('uploads/FnRegularExspenses/' . $rxp->file_upload);
                        if (file_exists($path)) {
                            unlink($path);
                        }
                    }
                }
                ExpenseRequest::destroy($request->id);
            }
            Toastr::success('Deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Delete fail.','Error');
            return redirect()->back();
        }
    }
}
