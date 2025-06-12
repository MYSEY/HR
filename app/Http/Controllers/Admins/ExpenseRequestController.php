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
        $datas = ExpenseRequest::with(["requestBy","approveBy","locationDetails","departments", "createdBy"])->where("created_by", Auth::user()->id)->orderBy('id', 'DESC')->get();
        $user = Auth::user();
        $dataAsign = ExpenseRequest::with(['requestBy', 'approveBy', 'locationDetails', 'departments', 'createdBy'])
            ->where('status', '!=', "rejected")
            ->whereNot('created_by', $user->id)
            ->where(function ($query) use ($user) {
                $query->where(function ($q) use ($user) {
                    $q->where('status', 'pending_approve')
                    ->where('approve_by', $user->id);
                })->orWhere(function ($q) use ($user) {
                    if($user->branch->abbreviations == "HQ"){
                        $q->where('status', '!=', 'pending_approve')
                        ->where('location_review', $user->department_id)
                        ->whereJsonContains('position_review', $user->position_id);
                    }else{
                        $q->where('status', '!=', 'pending_approve')
                        ->where('location_review', $user->branch_id)
                        ->whereJsonContains('position_review', $user->position_id);
                    }
                });
            })
            ->orderBy('id', 'DESC')
            ->get();
        return view('FN_ExpenseRequests.index',compact(['permission','datas', 'dataAsign']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $FnApproval = FnApproval::with(["employee","location"])->get();
        $locations = Branchs::get();
        $taxWHT = FnTaxRate::where('tax_type', 1)->get();
        $taxeFBT = FnTaxRate::where('tax_type', 2)->get();
        $FnPaymentTerms = FnPaymentTerm::get();
        $FnRegularExspenses = FnRegularExspense::where("status", "1")->where("is_contactual", "1")->get();
        return view('FN_ExpenseRequests.form_request', compact([
            'locations', 
            'FnApproval', 
            'taxWHT', 
            'taxeFBT', 
            'FnPaymentTerms', 
            'FnRegularExspenses'
        ]));
    }

    public function createTax()
    {
        $FnApproval = FnApproval::with(["employee","location"])->get();
        $locations = Department::get();
        $FnPaymentTerms = FnPaymentTerm::get();
        return view('FN_tax_expenses.form_request', compact([
            'locations', 
            'FnApproval', 
            'FnPaymentTerms'
        ]));
    }

    function lovelReview($dataLevelView){

        $baseQuery = FnLevelReviewer::query()
        ->where("from_location", $dataLevelView["by_location"])
        ->where("type", $dataLevelView["type"]);

        // Apply request_type & reference_type
        if (isset($dataLevelView["request_type"])) {
            $baseQuery->where("request_type", $dataLevelView["request_type"]);

            if (!in_array($dataLevelView["request_type"], [1, 2])) {
                $baseQuery->where("reference_type", $dataLevelView["reference_type"]);
            }
        }

        // Apply amount range
        if (isset($dataLevelView["amount"])) {
            $amount = $dataLevelView["amount"];
            $baseQuery->where("from_amount", "<", $amount)
                    ->where("to_amount", ">=", $amount);
        }

        // Clone and try with department_review
        $queryWithDept = clone $baseQuery;
        if (!empty($dataLevelView["department_review"])) {
            $queryWithDept->where("department_review", $dataLevelView["department_review"]);
        } else {
            $queryWithDept->whereNull("department_review");
        }

        $positionReview = $queryWithDept->orderBy("id", "DESC")->first();

        // Fallback: if we tried with dept and found nothing, try null department_review
        if (!$positionReview && !empty($dataLevelView["department_review"])) {
            $positionReview = $baseQuery
                ->whereNull("department_review")
                ->orderBy("id", "DESC")
                ->first();
        }

        return $positionReview;
    }

    function processReview($dataLevelView){
        $baseQuery = FnLevelReviewer::where("from_location", $dataLevelView["by_location"])
        ->where("type", $dataLevelView["type"]);

        // Shared condition: request_type
        if (isset($dataLevelView["request_type"])) {
            $baseQuery->where("request_type", $dataLevelView["request_type"]);

            if (!in_array($dataLevelView["request_type"], [1, 2])) {
                $baseQuery->where("reference_type", $dataLevelView["reference_type"]);
            }
        }

        // Shared condition: amount range
        if (isset($dataLevelView["amount"])) {
            $amount = $dataLevelView["amount"];
            $baseQuery->where("from_amount", "<", $amount)
                    ->where("to_amount", ">=", $amount);
        }

        // First try: with department_review
        $queryWithDept = clone $baseQuery;
        if (!empty($dataLevelView["department_review"])) {
            $queryWithDept->where("department_review", $dataLevelView["department_review"]);
        }

        $positionReview = $queryWithDept->orderBy("id", "DESC")->first();

        // Fallback: without department_review
        if (!$positionReview) {
            $positionReview = $baseQuery->orderBy("id", "DESC")->first();
        }

        return $positionReview;
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
                "department_review"=> "",
                "request_type"=> $request->type,
                "reference_type"=> $request->expense_type,
                "type"=> 1,
                "amount"=> $amount,
            ];
            $data = $request->all();
            if(Auth::user()->branch->abbreviations == "HQ"){
                $dataCheckLevelView["department_review"] = Auth::user()->department_id;
                $positionReview = self::lovelReview($dataCheckLevelView);
                $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->department_id;
            }else{
                $dataCheckLevelView["by_location"] = 1;
                $positionReview = self::lovelReview($dataCheckLevelView);
                $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->branch_id;
            }
            if ($request->hasFile('fn_invoice')) {
                $autoSerial = $this->generateSerialCode(Carbon::today())['serialref'];
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
            $data['tracking_id']        = $this->generateExpenseCode(Carbon::today())['tracking_id'];
            $data['payment_term']       = $request->paymentTerms;

            // if ($request->expense_type == 1) {
                //** Rrgular Expense **//
            //     $data['status']             = 'pending_approve';
            // }else{
                //** Irrgular Expense **//
                // if(!$positionReview){
                //     return response()->json([
                //         'error'=>'lang.please_to_set_up_lovel_review_request_expense',
                //         'status'=>404,
                //     ]);
                // }
                $data['status']             = 'pending';
                // if (Auth::user()->branch->abbreviations != "HQ") {
                //     $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->branch_id;
                // }else{
                //     $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->department_id;
                // }

                $data['position_review']    = json_encode($positionReview->id_positions);
                $data['review_type']        = $positionReview->type;
            // }   

            $data['request_by']         = Auth::user()->id;
            $data['date_request']       = Carbon::createFromDate()->format('Y-m-d H:i');
            $data['created_by']         = Auth::user()->id;
            // GenerateIdExpense::create([
            //     'tracking_id' => $data['tracking_id'],
            //     'created_by'  => Auth::user()->id,
            // ]);
            unset($data['fn_invoice']);
            $expense = ExpenseRequest::create($data);
            $locations = [];
            $locationArrays = json_decode($request->locations, true) ?? [];
            foreach ($locationArrays as $location) {
                $locations[] = [
                    'expense_request_id' => $expense->id,
                    'location_id'        => $location["id"],
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
        $FnApproval = FnApproval::with(["employee","location"])->get();
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
        return view('FN_ExpenseRequests.form_edit_request', compact([
            'locations', 
            'FnApproval', 
            'taxWHT', 
            'taxeFBT', 
            'FnPaymentTerms', 
            'FnRegularExspenses',
            'data'
        ]));
    }
    public function editTax(Request $request)
    {
        $FnApproval = FnApproval::with(["employee","location"])->get();
        $locations = Department::get();
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
                "department_review"=> "",
                "request_type"=> $request->type,
                "reference_type"=> $request->expense_type,
                "type"=> 1,
                "amount"=> $amount,
            ];
            $data = ExpenseRequest::find($request->id);
            if(Auth::user()->branch->abbreviations == "HQ"){
                $dataCheckLevelView["department_review"] = Auth::user()->department_id;
                $positionReview = self::lovelReview($dataCheckLevelView);
                $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->department_id;
            }else{
                $dataCheckLevelView["by_location"] = 1;
                $positionReview = self::lovelReview($dataCheckLevelView);
                $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->branch_id;
            }
             // ***  block create history *** //
            // if ($data->status == "rejected") {
                $oldId = ExpenseRequestHistory::where("expense_id", $request->id)->count();
                $dataHistory = $data->toArray();
                $dataHistory['expense_id'] = $data->id;
                $dataHistory['tracking_id'] = $data->tracking_id . "@".$oldId;
                unset($dataHistory['id']);
                ExpenseRequestHistory::create($dataHistory);
                $data['status']             = 'pending';
            // }
            
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
                    $autoSerial = $this->generateSerialCode(Carbon::today())['serialref'];
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
           //** Rrgular Expense **//
            // if ($request->expense_type == 1) {
                // $data['status']             = 'pending';
            //     $data['position_review']    = [];
            //     $data['review_type']        = null;
            // }else{
                //** Irrrgular Expense **//
                // if(!$positionReview){
                //     return response()->json([
                //         'error'=>'lang.please_to_set_up_lovel_review_request_expense',
                //         'status'=>404,
                //     ]);
                // }
                // if (Auth::user()->branch->abbreviations != "HQ") {
                //     $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->branch_id;
                // }else{
                //     $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->department_id;
                // }
                $data['position_review']    = json_encode($positionReview->id_positions);
                $data['review_type']        = $positionReview->type;
            // }

            $data["approve_by"]                     = $request->approve_by;
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
                "department_review"=> "",
                "request_type"=> 2,
                "reference_type"=> 1,
                "type"=> 1,
                "amount"=> $amount,
            ];
            $data = ExpenseRequest::find($request->id);
            if(Auth::user()->branch->abbreviations == "HQ"){
                $dataCheckLevelView["department_review"] = Auth::user()->department_id;
                $positionReview = self::lovelReview($dataCheckLevelView);
                $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->department_id;
            }else{
                $dataCheckLevelView["by_location"] = 1;
                $positionReview = self::lovelReview($dataCheckLevelView);
                $data['location_review']    = $positionReview->department_review ? $positionReview->department_review : Auth::user()->branch_id;
            }
            if(!$positionReview){
                return response()->json([
                    'error'=>'lang.please_to_set_up_lovel_review_request_expense',
                    'status'=>404,
                ]);
            }

            // ***  block create history *** //
            // if ($data->status == "rejected") {
                $oldId = ExpenseRequestHistory::where("expense_id", $request->id)->count();
                $dataHistory = $data->toArray();
                $dataHistory['expense_id'] = $data->id;
                $dataHistory['tracking_id'] = $data->tracking_id . "@".$oldId;
                unset($dataHistory['id']);
                ExpenseRequestHistory::create($dataHistory);
                $data['status']             = 'pending';
            // }
            
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
                    $autoSerial = $this->generateSerialCode(Carbon::today())['serialref'];
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
            // $data['location_review']                = ($positionReview->department_review ? $positionReview->department_review : Auth::user()->department_id);
            $data["approve_by"]                     = $request->approve_by;
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
            $data['position_review']                = json_encode($positionReview->id_positions);
            $data['updated_by']                     = Auth::user()->id;
            $data->save();
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
            ExpenseRequestHistory::create($dataHistory);
            $type =  $data->review_type + 1;
            if ($data->approve_by == Auth::user()->id) {
                $data['position_review']    = [];
                $data['review_type']        = null;
                $data['status']             = 'approved';
                $data['date_approve']       = ($request->approve_date ? $request->approve_date : Carbon::createFromDate()->format('Y-m-d H:i'));
            }else{
                $exchange = FNExchangeRate::first();
                $amount = 0;
                $ge_total_cost_riel = 0;
                if ($request->ge_total_cost_riel) {
                    $ge_total_cost_riel = ( $data->ge_total_cost_riel / $exchange->amount_riel);
                }
                $amount = ($data->ge_total_cost_usd + $ge_total_cost_riel);
                $dataCheckLevelView = [
                    "by_location"=> 2,
                    "department_review"=> "",
                    "request_type"=> $data->type,
                    "reference_type"=> $data->expense_type,
                    "type"=> $type,
                    "amount"=> $amount,
                ];

                $branch = Branchs::where("id", $data->requestBy->branch_id)->first();
                
                if($branch->abbreviations == "HQ"){
                    $dataCheckLevelView["department_review"] = $data->requestBy->department_id;
                    $lovelReview = self::processReview($dataCheckLevelView);
                }else{
                    $dataCheckLevelView["by_location"] = 1;
                    $lovelReview = self::processReview($dataCheckLevelView);
                };
                if ($lovelReview) {
                    if ($branch->abbreviations != "HQ") {
                        $data['location_review']    = $lovelReview->department_review ? $lovelReview->department_review : $data->requestBy->branch_id;
                    }else{
                        $data['location_review']    = $lovelReview->department_review ? $lovelReview->department_review : $data->requestBy->department_id;
                    }
                    $data['status']             = 'pending';
                    $data['position_review']    = $lovelReview->id_positions;
                    $data['review_type']        = $lovelReview->type;
                }else{
                    $data['position_review']    = [];
                    $data['review_type']        = null;
                    $data['status']             = 'pending_approve';
                }
            }
           
            $data["reason"]                 = $request->remark;
            $data['updated_by']             = Auth::user()->id;
            $data->save();
            DB::commit();
            return response()->json(['message' => 'Update successfully.']);
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

            $dataHistory = $data->toArray();
            $dataHistory['expense_id'] = $data->id;
            $dataHistory['tracking_id'] = $data->tracking_id . "@".$oldId;
            unset($dataHistory['id']);
            unset($dataHistory['request_by']);
            $dataCheckLevelView = [
                "by_location"=> 2,
                "department_review"=> "",
                "request_type"=> $data->type,
                "reference_type"=> $data->expense_type,
                "type"=> 1,
                "amount"=> $amount,
            ];
            $branch = Branchs::where("id", $data->requestBy->branch_id)->first();
            if($branch->abbreviations == "HQ"){
                $dataCheckLevelView["department_review"] = $data->requestBy->department_id;
                $lovelReview = self::lovelReview($dataCheckLevelView);
                $data['location_review']    = $lovelReview->department_review ? $lovelReview->department_review : $data->requestBy->department_id;
            }else{
                $dataCheckLevelView["by_location"] = 1;
                $lovelReview = self::lovelReview($dataCheckLevelView);
                $data['location_review']    = $lovelReview->department_review ? $lovelReview->department_review : $data->requestBy->branch_id;
            };
            ExpenseRequestHistory::create($dataHistory);
            $data['status']             = 'rejected';
            if ($lovelReview) {
                $data['position_review']    = $lovelReview->id_positions;
                $data['review_type']        = 1;
            }
            $data["reason"]                 = $request->remark;
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
