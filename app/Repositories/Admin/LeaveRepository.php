<?php

namespace App\Repositories\Admin;

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
        return LeaveRequest::class;
    }

    public function getDatas($request){
        $from_date = null;
        $to_date = null;
        if ($request->start_date || $request->end_date) {
            $from_date = Carbon::createFromDate($request->start_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->end_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        $currentYear = null;
        if ($request->monthly == true) {
            $currentYear =  Carbon::createFromDate(Carbon::now())->format('Y');
        }
        $data = LeaveRequest::with("employee")->with("leaveType")
        ->leftJoin('users', 'leave_requests.employee_id', '=', 'users.id')
        ->select(
            'leave_requests.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'users.profile',
        )
        ->whereIn("leave_requests.status", ["approved","rejected","cancel"])
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
        })
        ->when($request->status, function ($query, $status) {
            $query->where('leave_requests.status', $status);
        })
        ->when($from_date, function ($query, $from_date) {
            $query->where('leave_requests.start_date', '>=', $from_date);
        })
        ->when($to_date, function ($query, $to_date) {
            $query->where('leave_requests.end_date', '<=', $to_date);
        })->orderBy('id', 'DESC')->get();
        return $data;
    }
}