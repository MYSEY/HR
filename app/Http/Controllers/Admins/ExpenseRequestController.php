<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\Department;
use App\Models\ExpenseRequest;
use App\Models\ExpenseRequestHistory;
use App\Models\FnApproval;
use App\Models\FnDetailLocation;
use App\Models\FnLevelReviewer;
use App\Models\FnPaymentTerm;
use App\Models\FnRegularExspense;
use App\Models\FnTaxRate;
use App\Models\GenerateIdExpense;
use App\Models\permissions;
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
        $dataAsign = ExpenseRequest::with(["requestBy", "approveBy", "locationDetails", "departments", "createdBy"])
            ->when(Auth::user()->RolePermission, function ($queryA, $RolePermission) {
                if (in_array($RolePermission, ['BOD', 'CEO', 'HOD','BM','DHOD','DBM'])){
                    $queryA->where(function ($query) {
                        $query->where('approve_by', Auth::user()->id)
                            ->where('status', "pending_approve");
                    });
                }else{
                    $queryA->where(function ($query) {
                        $query->whereNot('created_by', Auth::user()->id)
                            ->whereJsonContains('position_review', Auth::user()->position_id);
                    });
                }
            })
            ->whereNot('created_by', Auth::user()->id)
            ->where('status', '!=', "rejected")
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

    function lovelReview($by_location, $request_type, $type, $amount){
        $positionReview = FnLevelReviewer::where("from_location", $by_location)
        ->where("request_type", $request_type)
        ->where("type",$type)
        ->when($amount, function ($query, $total_amount_usd) {
            $query->where('from_amount', '<', $total_amount_usd);
        })
        ->when($amount, function ($query, $total_amount_usd) {
            $query->where('to_amount','>=', $total_amount_usd);
        })->orderBy('id', 'DESC')->first();
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
            if(Auth::user()->branch->abbreviations == "HQ"){
                $positionReview = self::lovelReview(2, $request->type, 1, $request->ge_total_amount_usd);
            }else{
                $positionReview = self::lovelReview(1, $request->type, 1, $request->ge_total_amount_usd);
            }
            $data = $request->all();
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

            if ($request->expense_type == 1) {
                //** Rrgular Expense **//
                $data['status']             = 'pending_approve';
            }else{
                //** Irrgular Expense **//
                if(!$positionReview){
                    return response()->json([
                        'error'=>'lang.please_to_set_up_lovel_review_request_expense',
                        'status'=>404,
                    ]);
                }
                $data['status']             = 'pending';
                $data['position_review']    = json_encode($positionReview->id_positions);
                $data['review_type']        = $positionReview->type;
            }
           

            $data['request_by']         = Auth::user()->id;
            $data['date_request']       = Carbon::createFromDate()->format('Y-m-d H:i');
            $data['created_by']         = Auth::user()->id;
            GenerateIdExpense::create([
                'tracking_id' => $data['tracking_id'],
                'created_by'  => Auth::user()->id,
            ]);
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
            // $positionReview = self::lovelReview($request->type, 1, $request->ge_total_amount_usd);
            if(Auth::user()->branch->abbreviations == "HQ"){
                $positionReview = self::lovelReview(2, $request->type, 1, $request->ge_total_amount_usd);
            }else{
                $positionReview = self::lovelReview(1, $request->type, 1, $request->ge_total_amount_usd);
            }
            $data = ExpenseRequest::find($request->id);
             // ***  block create history *** //
            if ($data->status == "rejected") {
                $oldId = ExpenseRequestHistory::where("expense_id", $request->id)->count();
                $dataHistory = $data->toArray();
                $dataHistory['expense_id'] = $data->id;
                $dataHistory['tracking_id'] = $data->tracking_id . "@".$oldId;
                unset($dataHistory['id']);
                ExpenseRequestHistory::create($dataHistory);
                $data['status']             = 'pending';
            }
            
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
            if ($request->expense_type == 1) {
                //** Rrgular Expense **//
                $data['status']             = 'pending_approve';
                $data['position_review']    = [];
                $data['review_type']        = null;
            }else{
                //** Irrrgular Expense **//
                if(!$positionReview){
                    return response()->json([
                        'error'=>'lang.please_to_set_up_lovel_review_request_expense',
                        'status'=>404,
                    ]);
                }
                $data['position_review']    = json_encode($positionReview->id_positions);
                $data['review_type']        = $positionReview->type;
            }

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
            // $positionReview = self::lovelReview(2, 1, $request->ge_total_amount_usd);
            if(Auth::user()->branch->abbreviations == "HQ"){
                $positionReview = self::lovelReview(2, 2, 1, $request->ge_total_amount_usd);
            }else{
                $positionReview = self::lovelReview(1, 2, 1, $request->ge_total_amount_usd);
            }
            if(!$positionReview){
                return response()->json([
                    'error'=>'lang.please_to_set_up_lovel_review_request_expense',
                    'status'=>404,
                ]);
            }
            $data = ExpenseRequest::find($request->id);

            // ***  block create history *** //
            if ($data->status == "rejected") {
                $oldId = ExpenseRequestHistory::where("expense_id", $request->id)->count();
                $dataHistory = $data->toArray();
                $dataHistory['expense_id'] = $data->id;
                $dataHistory['tracking_id'] = $data->tracking_id . "@".$oldId;
                unset($dataHistory['id']);
                ExpenseRequestHistory::create($dataHistory);
                $data['status']             = 'pending';
            }
            
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
            $data = ExpenseRequest::find($request->id);
            $oldId = ExpenseRequestHistory::where("expense_id", $request->id)->count();
            $dataHistory = $data->toArray();
            $dataHistory['expense_id'] = $data->id;
            $dataHistory['tracking_id'] = $data->tracking_id . "@".$oldId;
            unset($dataHistory['id']);
            ExpenseRequestHistory::create($dataHistory);
            $type =  $data->review_type + 1;

            if ($data->approve_by == Auth::user()->id) {
                $data['position_review']    = [];
                $data['review_type']        = null;
                $data['status']             = 'approved';
                $data['date_approve']       = ($request->approve_date ? $request->approve_date : Carbon::createFromDate()->format('Y-m-d H:i'));
            }else{
                // $lovelReview  = self::lovelReview($data->type, $type, $data->ge_total_amount_usd);
                if(Auth::user()->branch->abbreviations == "HQ"){
                    $lovelReview = self::lovelReview(2, $data->type, $type, $data->ge_total_amount_usd);
                }else{
                    $lovelReview = self::lovelReview(1, $data->type, $type, $data->ge_total_amount_usd);
                };
                if ($lovelReview) {
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
            $data = ExpenseRequest::find($request->id);
            $oldId = ExpenseRequestHistory::where("expense_id", $request->id)->count();

            $dataHistory = $data->toArray();
            $dataHistory['expense_id'] = $data->id;
            $dataHistory['tracking_id'] = $data->tracking_id . "@".$oldId;
            unset($dataHistory['id']);
            // $lovelReview  = self::lovelReview($data->type, 1, $data->ge_total_amount_usd);
            if(Auth::user()->branch->abbreviations == "HQ"){
                $lovelReview = self::lovelReview(2, $data->type, 1, $data->ge_total_amount_usd);
            }else{
                $lovelReview = self::lovelReview(1, $data->type, 1, $data->ge_total_amount_usd);
            };
            ExpenseRequestHistory::create($dataHistory);
            if ($lovelReview) {
                $data['status']             = 'rejected';
                $data['position_review']    = $lovelReview->id_positions;
                $data['review_type']        = $lovelReview->type;
            }else{
                $data['status']             = 'pending';
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
