<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\ExpenseRequest;
use App\Models\permissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseAdminController extends Controller
{
    public function index()
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "admin-expense/list")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }

        $datas = ExpenseRequest::with(["requestBy","approveBy","locationDetails","departments", "createdBy"])
        ->whereNot("status", "approved")->orderBy('id', 'DESC')->get();
        return view('FN_ExpenseAdmins.index',compact(['permission','datas']));
    }
}
