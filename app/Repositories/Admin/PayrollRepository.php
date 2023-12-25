<?php

namespace App\Repositories\Admin;

use App\Models\Payroll;
use App\Models\payrollPreview;
use Illuminate\Support\Carbon;
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
            return Payroll::with("users")->where('employee_id',Auth::user()->id)->orderBy('id','DESC')->get();
        } else {
           // return Payroll::with('users')->whereMonth('payment_date','<=',$Monthly)->whereYear('payment_date','>=',$yearLy)->get();
            return Payroll::with('users')
            ->join('users', 'payrolls.employee_id', '=', 'users.id')
            ->select(
                'payrolls.*',
                'users.branch_id',
                'users.department_id',
            )
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if ($RolePermission == 'HOD') {
                    $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
                }
                if ($RolePermission == 'BM') {
                    $query->where("users.branch_id", Auth::user()->branch_id);
                }
            })
            ->orderBy('payment_date','DESC')->get();
        }
    }
    public function getAllPayrollPreview(){
        return payrollPreview::with("users")->orderBy('id','DESC')->get();
    }
}