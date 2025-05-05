<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\ExpenseRequest;
use App\Models\permissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseReportController extends Controller
{
    public function index()
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "fn/expense/report")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $datas = ExpenseRequest::with(["requestBy","approveBy","locationDetails","departments", "createdBy"])->where('status', "approved")->orderBy('id', 'DESC')->get();
        return view('reports.expense_report',compact(['permission','datas']));
    }

}
