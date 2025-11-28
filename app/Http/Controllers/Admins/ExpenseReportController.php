<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportExpense;
use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\ExpenseRequest;
use App\Models\FnDetailLocation;
use App\Models\permissions;
use App\Repositories\Admin\ExpenseRepository;
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
        $datas = $this->dataRequests->getDataByLocation($request);
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "fn/expense/report")->first();
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
        $datas = $this->dataRequests->getDataByLocation($request);
        $name_file = "CAMMA-FND-002-Report.xlsx";
        $export = new ExportExpense($datas, $request);
        return Excel::download($export, $name_file);
    }

}
