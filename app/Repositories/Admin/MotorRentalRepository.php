<?php

namespace App\Repositories\Admin;

use App\Models\MotorRentalDetail;
use App\Models\MotorRentel;
use App\Repositories\BaseRepository;
use App\Traits\UploadFiles\UploadFIle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MotorRentalRepository extends BaseRepository
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
        return MotorRentel::class;
    }

    public function getDatas($request){
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        $monthly = null;
        $currentYear = null;
        if ($request->monthly == true) {
            $monthly =  Carbon::createFromDate(Carbon::now())->format('m');
            $currentYear =  Carbon::createFromDate(Carbon::now())->format('Y');
        }
        $data = MotorRentalDetail::with('user')
            ->leftJoin('users', 'motor_rental_details.employee_id', '=', 'users.id')
            ->select(
                'motor_rental_details.*',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.number_employee',
                'users.branch_id',
                'users.department_id',
            )
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if ($RolePermission == 'Employee') {
                    $query->where('users.id',Auth::user()->id);
                }
                if ($RolePermission == 'HOD') {
                    $query->where("users.department_id", Auth::user()->department_id);
                }
                if ($RolePermission == 'BM') {
                    $query->where("users.branch_id", Auth::user()->branch_id);
                }
            })
            ->when($monthly, function ($query, $monthly) {
                $query->whereMonth('motor_rental_details.created_at', $monthly);
            })
            ->when($currentYear, function ($query, $currentYear) {
                $query->whereYear('motor_rental_details.created_at', $currentYear);
            })
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
                $query->orWhere('users.employee_name_kh', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($request->employee_name_kh, function ($query, $employee_name_kh) {
                $query->where('users.employee_name_kh', 'LIKE', '%'.$employee_name_kh.'%');
            })
            ->when($request->branch_id, function ($query, $branch) {
                $query->where('users.branch_id', $branch);
            })
            ->when($request->department_id, function ($query, $department_id) {
                $query->where('users.department_id', $department_id);
            })
            ->when($from_date, function ($query, $from_date) {
                $query->where('motor_rental_details.created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('motor_rental_details.created_at','<=', $to_date);
            })
            ->orderBy('id', 'desc')
            ->get();
        return $data;
    }
}