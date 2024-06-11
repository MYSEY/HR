<?php

namespace App\Repositories\Admin;

use App\Models\MotorRentalDetail;
use App\Models\MotorRentel;
use App\Models\SeverancePay;
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
                    $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
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


    public function getDataSeverancePay($request){

        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }

        $severancePay = SeverancePay::
        leftJoin('users', 'severance_pays.employee_id', '=', 'users.id')
        ->leftJoin('options','options.id','=','users.gender')
        ->leftJoin('positions','positions.id','=','users.position_id')
        ->leftJoin('branchs','branchs.id','=','users.branch_id')
        ->select(
            'severance_pays.*',
            'severance_pays.type as severan_type',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'users.branch_id',
            'users.department_id',
            'options.name_khmer',
            'options.name_english',
            'options.type',
            'positions.name_khmer as positionNameKhmer',
            'positions.name_english as positionNameEnglish',
            'branchs.branch_name_kh as branck_kh',
            'branchs.branch_name_en as branck_en',
        )
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'Employee') {
                $query->where("users.id", Auth::user()->id);
            }
            if ($RolePermission == 'HOD') {
                $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
            }
            if ($RolePermission == 'BM') {
                $query->where("users.branch_id", Auth::user()->branch_id);
            }
        })
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
        })
        ->when($request->branch_id, function ($query, $branch_id) {
            $query->where('users.branch_id', $branch_id);
        })
        ->when($Monthly, function ($query, $Monthly) {
            $query->whereMonth('payment_date', $Monthly);
        })
        ->when($yearLy, function ($query, $yearLy) {
            $query->whereYear('payment_date', $yearLy);
        });
        $severancePay_1 = (clone $severancePay)->with("users")->with("gruse_salary_1")->where('severance_pays.type', 'FDC-1')->get();
        $severancePay_2 = (clone $severancePay)->with("users")->with("gruse_salary_2")->where('severance_pays.type', 'FDC-2')->get();
        $nssf = $severancePay_1->merge($severancePay_2);
        return $nssf;
    }
}