<?php

namespace App\Repositories\Admin;

use App\Models\ExpenseRequest;
use App\Models\FnDetailLocation;
use App\Models\LeaveAllocation;
use App\Models\LeaveRequest;
use App\Models\permissions;
use App\Repositories\BaseRepository;
use App\Traits\UploadFiles\UploadFIle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ExpenseRepository extends BaseRepository
{
    use UploadFIle;
    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return ExpenseRequest::class;
    }

    public function getDataByLocation($request){
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
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "fn/expense/report")->first();
        $datasDetails = FnDetailLocation::with(["expenseRequest", "location", "department"])
        
        ->leftJoin('expense_requests', 'fn_detail_locations.expense_request_id', '=', 'expense_requests.id')
        ->leftJoin('users', 'expense_requests.request_by', '=', 'users.id')
        ->leftJoin('users as approver', 'expense_requests.final_approve_by', '=', 'approver.id')
        ->leftJoin('users as reviewby', 'expense_requests.review_by', '=', 'reviewby.id')
        ->select(
            'fn_detail_locations.*', 
            'expense_requests.*',
            'users.number_employee',
            'users.position_id',
            'users.branch_id as user_branch_id',
            'users.department_id as user_department_id',
            'users.line_manager',
            // reviewby info
            'reviewby.number_employee as reviewby_number_employee',
            'reviewby.employee_name_kh as reviewby_employee_name_kh',
            'reviewby.employee_name_en as reviewby_employee_name_en',

            // approver info
            'approver.number_employee as approver_number_employee',
            'approver.employee_name_kh as approver_employee_name_kh',
            'approver.employee_name_en as approver_employee_name_en',
            'approver.position_id as approver_position_id',
            'approver.branch_id as approver_branch_id',
            'approver.department_id as approver_department_id',
            'approver.line_manager as approver_line_manager'
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
        ->when($request->tracking_id, function ($query, $tracking_id) {
            $query->where('expense_requests.tracking_id', $tracking_id);
        })
        ->when($request_from_date, function ($query, $request_from_date) {
            $query->where('expense_requests.date_request', '>=', $request_from_date);
        })
        ->when($request_to_date, function ($query, $request_to_date) {
            $query->where('expense_requests.date_request', '<=', $request_to_date);
        })
        ->when($approved_from_date, function ($query, $approved_from_date) {
            $query->where('expense_requests.date_approve', '>=', $approved_from_date);
        })
        ->when($approved_to_date, function ($query, $approved_to_date) {
            $query->where('expense_requests.date_approve', '<=', $approved_to_date);
        })
        ->when($request->type, function ($query, $type) {
            if ($type == 3) {
                $query->where('expense_requests.type','=', 0);
            }else{
                $query->where('expense_requests.type','=', $type);
            }
        })
        ->when($request->expense_type, function ($query, $expense_type) {
            $query->where('expense_requests.expense_type', $expense_type);
        })
        ->when($request->location_id, function ($query, $location_id) {
            $query->where('fn_detail_locations.location_id', $location_id);
        })
        ->whereIn('expense_requests.status', ["approved","cancel"])
        ->orderBy('expense_requests.id', 'DESC');

         $perPage = $request->get('per_page', 10);

        if ($perPage === 'all') {
            $datasDetails = $datasDetails->get();
            $datasDetails = new \Illuminate\Pagination\LengthAwarePaginator(
                $datasDetails,
                $datasDetails->count(),
                $datasDetails->count(),
                1,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $datasDetails = $datasDetails->paginate($perPage)->withQueryString();
        }
        return $datasDetails;
    }
}