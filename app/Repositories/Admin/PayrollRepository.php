<?php

namespace App\Repositories\Admin;

use App\Models\Payroll;
use App\Models\payrollPreview;
use Illuminate\Support\Carbon;
use App\Models\ParyllStaffResign;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use App\Traits\UploadFiles\UploadFIle;

class PayrollRepository extends BaseRepository
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
        return Payroll::class;
    }

    public function getAllPayroll(){
        $Monthly= Carbon::now()->format('m');
        $yearLy = Carbon::now()->format('Y');
        if (Auth::user()->RolePermission == 'Employee') {
            return DB::table('payrolls')
            ->leftJoin('users','payrolls.employee_id','=','users.id')
            ->leftJoin('positions','positions.id','=','users.position_id')
            ->leftJoin('branchs','branchs.id','=','users.branch_id')
            ->leftJoin('departments','departments.id','=','users.department_id')
            ->select(
                'payrolls.*',
                'users.profile',
                'users.number_employee',
                'users.branch_id',
                'users.department_id',
                'users.branch_id',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.date_of_commencement',
                'users.branch_id',
                'positions.name_khmer as position_name_khmer',
                'positions.name_english as position_name_english',
                'branchs.branch_name_kh',
                'branchs.branch_name_en',
                'departments.name_khmer as depart_name_kh',
                'departments.name_english as depart_name_en',
            )->where('payrolls.employee_id',Auth::user()->id)->get();
        } else {
            return DB::table('payrolls')
            ->leftJoin('users','payrolls.employee_id','=','users.id')
            ->leftJoin('positions','positions.id','=','users.position_id')
            ->leftJoin('branchs','branchs.id','=','users.branch_id')
            ->leftJoin('departments','departments.id','=','users.department_id')
            ->select(
                'payrolls.*',
                'users.profile',
                'users.number_employee',
                'users.branch_id',
                'users.department_id',
                'users.branch_id',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.date_of_commencement',
                'users.branch_id',
                'positions.name_khmer as position_name_khmer',
                'positions.name_english as position_name_english',
                'branchs.branch_name_kh',
                'branchs.branch_name_en',
                'departments.name_khmer as depart_name_kh',
                'departments.name_english as depart_name_en',
            )->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if ($RolePermission == 'HOD') {
                    $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
                }
                if ($RolePermission == 'BM') {
                    $query->where("users.branch_id", Auth::user()->branch_id);
                }
            })->whereMonth('payrolls.payment_date','<=',$Monthly)->whereYear('payrolls.payment_date','>=',$yearLy)->get();
        }
    }
    public function getAllPayrollPreview(){
        return payrollPreview::with("users")->orderBy('number_employee','asc')->get();
    }
    public function getAllPayrollStaffResign(){
        return ParyllStaffResign::with("users")->get();
    }
}