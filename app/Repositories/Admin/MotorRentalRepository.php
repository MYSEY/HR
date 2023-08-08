<?php

namespace App\Repositories\Admin;

use App\Models\MotorRentel;
use App\Repositories\BaseRepository;
use App\Traits\UploadFiles\UploadFIle;
use Carbon\Carbon;

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
        $data = MotorRentel::with('user')->join('users', 'motor_rentels.employee_id', '=', 'users.id')
            ->select(
                'motor_rentels.*',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.number_employee',
                'users.branch_id',
                'users.department_id',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->orWhere('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
                $query->orWhere('users.employee_name_kh', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($request->branch_id, function ($query, $branch) {
                $query->where('users.branch_id', $branch);
            })
            ->when($request->department_id, function ($query, $department_id) {
                $query->where('users.department_id', $department_id);
            })
            ->when($from_date, function ($query, $from_date) {
                $query->where('motor_rentels.created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('motor_rentels.created_at','<=', $to_date);
            })
            ->orderBy('id', 'desc')
            ->get();
        return $data;
    }
}