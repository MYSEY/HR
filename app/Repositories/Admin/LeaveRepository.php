<?php

namespace App\Repositories\Admin;

use App\Models\LeaveAllocation;
use App\Models\LeaveRequest;
use App\Repositories\BaseRepository;
use App\Traits\UploadFiles\UploadFIle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LeaveRepository extends BaseRepository
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
        return LeaveAllocation::class;
    }

    public function getDatas($request){
        $currentYear = null;
        if ($request->monthly == true) {
            $currentYear =  Carbon::createFromDate(Carbon::now())->format('Y');
        }
        $employeeData = LeaveRequest::leftJoin('users', 'leave_requests.employee_id', '=', 'users.id')
        ->select(
            'leave_requests.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
        )
        ->where("leave_requests.status", "approved")
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
        })
        ->when($request->department_id, function ($query, $department) {
            $query->where('users.department_id', $department);
        })
        ->when($request->branch_id, function ($query, $branch) {
            $query->where('users.branch_id', $branch);
        })->get();
        $employee_ids = [];
        foreach ($employeeData as $key => $value) {
           $employee_ids [] = $value->employee_id;
        }
        $LeaveAllocation = LeaveAllocation::with("employee")->whereIn("employee_id", $employee_ids)->orderBy('id', 'DESC')->get();
        return $LeaveAllocation;
    }
}