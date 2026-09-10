<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportExpense;
use App\Exports\ExportExpenseHistories;
use App\Exports\ExportTaxExpenseHistories;
use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\ExpenseRequest;
use App\Models\ExpenseRequestHistory;
use App\Models\FnDetailLocation;
use App\Models\permissions;
use App\Repositories\Admin\ExpenseRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseReportController extends Controller
{
     private $dataRequests;
    public function __construct(ExpenseRepository $request)
    {
        $this->dataRequests = $request;
    }

    public function index(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "fn/expense/report")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $locations = Branchs::get();
        $datas = $this->dataRequests->getDataByLocation($request);
        return view('reports.expense_report',compact(['permission','datas', 'locations']));
    }
    public function filter(Request $request){
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "fn/expense/report")->first();
        $datas = $this->dataRequests->getDataByLocation($request);
        // Check if it's a paginated response
        if ($datas instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            // If it's paginated, return the necessary pagination metadata
            return response()->json([
                'data' => $datas->items(), // Only send the data items
                'permission' => $permission,
                'pagination' => [
                    'current_page' => $datas->currentPage(),
                    'last_page' => $datas->lastPage(),
                    'total' => $datas->total(),
                    'per_page' => $datas->perPage(),
                ],
            ]);
        }

        // If it's not paginated (e.g., 'all' was requested), just return the data
        return response()->json([
            'data' => $datas,
        ]);
    }

    public function reportExport(Request $request)
    {
        $request["export"] = "export";
        $datas = $this->dataRequests->getDataByLocation($request);
        $name_file = "CAMMA-FND-002-Report.xlsx";
        $export = new ExportExpense($datas, $request);
        return Excel::download($export, $name_file);
    }

    public function historiesExport(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "fn/expense/report")->first();
        $request_from_date = null;
        $request_to_date = null;
        $approved_from_date = null;
        $approved_to_date = null;
        if ($request->request_from_date) {
            $request_from_date = Carbon::createFromDate($request->request_from_date)->format('Y-m-d H:i:s');
        }
        if ($request->request_to_date) {
            $request_to_date = Carbon::createFromDate($request->request_to_date.' '.'23:59:59')->format('Y-m-d H:i:s');
        }
        if ($request->approved_from_date) {
            $approved_from_date = Carbon::createFromDate($request->approved_from_date)->format('Y-m-d H:i:s');
        }
        if ($request->approved_to_date) {
            $approved_to_date = Carbon::createFromDate($request->approved_to_date.' '.'23:59:59')->format('Y-m-d H:i:s');
        }
        $datas = ExpenseRequestHistory::where("expense_request_histories.type",$request->type)->with(["requestBy","approveBy","locationDetails","departments", "createdBy"])
        ->leftJoin('users', 'expense_request_histories.request_by', '=', 'users.id')
        ->select(
            'expense_request_histories.*',
            'users.number_employee',
            'users.position_id',
            'users.branch_id',
            'users.department_id',
            'users.line_manager',
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
                if (in_array($user->RolePermission, ['HOD', 'HRAdmin'])  && $user->department->abbreviations !="A&FDpt") {
                    $query->where("users.department_id", Auth::user()->department_id);
                }
                if (in_array($user->RolePermission, ['BM'])) {
                    $query->where("users.department_id", Auth::user()->department_id)
                        ->where("users.branch_id", Auth::user()->branch_id);
                }
                if (in_array($user->RolePermission, ['HR','DHOD', 'DBM'])){
                 // group the OR where
                    $query->where(function ($q) {
                        $q->where("users.line_manager", Auth::user()->id)   // team under me
                        ->orWhere("expense_request_histories.request_by", Auth::user()->id); // my own
                    });
                    // extra filters
                    $query->where("users.branch_id", Auth::user()->branch_id)
                        ->where("users.department_id", Auth::user()->department_id);
                }
                if ($user->RolePermission == "Employee") {
                    $query->where("expense_request_histories.request_by", Auth::user()->id);
                }
            }
        })
        ->when($request->tracking_id, function ($query, $tracking_id) {
            $query->where('expense_request_histories.tracking_id',  'LIKE', '%'.$tracking_id.'%');
        })
        ->when($request_from_date, function ($query, $request_from_date) {
            $query->where('expense_request_histories.date_request', '>=', $request_from_date);
        })
        ->when($request_to_date, function ($query, $request_to_date) {
            $query->where('expense_request_histories.date_request', '<=', $request_to_date);
        })
        ->when($approved_from_date, function ($query, $approved_from_date) {
            $query->where('expense_request_histories.date_approve', '>=', $approved_from_date);
        })
        ->when($approved_to_date, function ($query, $approved_to_date) {
            $query->where('expense_request_histories.date_approve', '<=', $approved_to_date);
        })
        ->when($request->expense_type, function ($query, $expense_type) {
            $query->where('expense_request_histories.expense_type', $expense_type);
        })
        ->when($request->location_id, function ($query, $location_id) {
            $query->where('users.branch_id', $location_id);
        })
        ->orderBy('expense_request_histories.id', 'DESC')->get();
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

}
