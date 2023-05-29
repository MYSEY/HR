<?php

namespace App\Repositories\Admin;

use App\Models\Payroll;
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
        if (Auth::user()->RolePermission == 'Administrator') {
            return Payroll::with('users')->whereMonth('payment_date', '=', Carbon::now())->get();
        } else {
            return Payroll::where('employee_id',Auth::user()->id)->where('role_id',Auth::user()->role_id)->whereMonth('payment_date', '=', Carbon::now())->get()->get();
        }
    }
}