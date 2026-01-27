<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportExpenseHistories;
use App\Exports\ExportTaxExpenseHistories;
use App\Http\Controllers\Controller;
use App\Models\ExpenseRequest;
use App\Models\ExpenseRequestHistory;
use App\Models\permissions;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseAdminController extends Controller
{
    public function index()
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "admin-expense/list")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $datas = ExpenseRequest::with(["requestBy","locationDetails","departments", "createdBy"])
        ->whereNot("expense_requests.status", "cancel")->where("expense_requests.page_show", null)
        ->leftJoin('users', 'expense_requests.request_by', '=', 'users.id')
        ->select(
            'expense_requests.*',
            'users.number_employee',
            'users.position_id',
            'users.branch_id as user_branch_id',
            'users.department_id as user_department_id',
            'users.line_manager as user_line_manager',
        )
        ->when(Auth::user(), function ($query, $user) use ($permission) {
            if ($permission->is_access == 1) {
                if ($user->department->abbreviations =="A&FDpt") {
                    # code...
                }else{
                    if (in_array($user->RolePermission, ['HRAdmin', 'HOD', 'DHOD', 'HR'])) {
                        $query->where("users.department_id", Auth::user()->department_id);
                    }
                    if(in_array($user->RolePermission, ['BM', 'DBM'])){
                        $query->where("users.department_id", Auth::user()->department_id)
                        ->where("users.branch_id", Auth::user()->branch_id);
                    }
                    if($user->RolePermission == 'Employee'  && $user->branch->abbreviations == "HQ"){
                        $query->where("users.department_id", Auth::user()->department_id);
                    }
                    if($user->RolePermission == 'Employee'  && $user->branch->abbreviations != "HQ"){
                        $query->where("users.department_id", Auth::user()->department_id)
                        ->where("users.branch_id", Auth::user()->branch_id);
                    }
                }
            }else{
                if (in_array($user->RolePermission, ['HOD','HRAdmin'])  && $user->department->abbreviations !="A&FDpt") {
                    $query->where("users.department_id", Auth::user()->department_id);
                        // ->where("users.branch_id", Auth::user()->branch_id);
                }
                if (in_array($user->RolePermission, ['BM'])) {
                    $query->where("users.department_id", Auth::user()->department_id)
                        ->where("users.branch_id", Auth::user()->branch_id);
                }
                if (in_array($user->RolePermission, ['HR','DHOD', 'DBM'])){
                 // group the OR where
                    $query->where(function ($q) {
                        $q->where("users.line_manager", Auth::user()->id)   // team under me
                        ->orWhere("expense_requests.request_by", Auth::user()->id); // my own
                    });
                    // extra filters
                    $query->where("users.branch_id", Auth::user()->branch_id)
                        ->where("users.department_id", Auth::user()->department_id);
                }
                if ($user->RolePermission == "Employee") {
                    $query->where("expense_requests.request_by", Auth::user()->id);
                }
            }
        })
        ->orderBy('id', 'DESC')->get();
        return view('FN_ExpenseAdmins.index',compact(['permission','datas']));
    }
    public function histories(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "admin-expense/list")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }

        $datas = ExpenseRequestHistory::where("expense_id", $request->id)->with(["upldatedBy","requestBy","locationDetails","departments", "createdBy"])
        ->orderBy('id', 'DESC')->get();
        return view('FN_ExpenseAdmins.view_histories',compact(['permission','datas']));
    }
    public function historiesExport(Request $request)
    {
        $datas = ExpenseRequestHistory::where("expense_id", $request->id)->where("type",$request->type)->with(["requestBy","approveBy","locationDetails","departments", "createdBy"])
        ->orderBy('id', 'DESC')->get();
        $name_file = "";
        if ($request->type == 2) {
            $name_file = "Tax-Expense-histories.xlsx";
            $export = new ExportTaxExpenseHistories($datas);
        }else{
            $name_file = "General-Expense-histories.xlsx";
            $export = new ExportExpenseHistories($datas);
        }
        
        return Excel::download($export, $name_file);
    }

    public function asign(Request $request)
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

            $data['position_review']    = "[".json_encode($request->position_id)."]";
            $data['updated_by']         = Auth::user()->id;
            $data->save();
            DB::commit();
            return response()->json(['message' => 'Update successfully.', 'status'=>200]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function cancel(Request $request)
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
            $data["status"]                 = "cancel";
            $data["reason"]                 = $request->reason;
            $data['updated_by']             = Auth::user()->id;
            $data->save();
            DB::commit();
            Toastr::success('Cancel successfully.','Success');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Cancel fail.','Error');
            return redirect()->back();
        }
    }

    public function approveds(Request $request){
        try {
            $updated = DB::table('expense_requests')
                ->whereIn('id', $request->ids)
                ->update([
                    'page_show'        => "page_expense_admin"
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

}
