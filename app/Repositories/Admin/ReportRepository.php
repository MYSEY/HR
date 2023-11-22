<?php

namespace App\Repositories\Admin;

use App\Models\FringeBenefit;
use App\Models\Payroll;
use App\Repositories\BaseRepository;
use App\Traits\UploadFiles\UploadFIle;
use Carbon\Carbon;

class ReportRepository extends BaseRepository
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

    public function getEFilingSalary($request){
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $payroll = Payroll::with("users")
            ->join('users', 'payrolls.employee_id', '=', 'users.id')
            ->select(
                'payrolls.*',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.position_id',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
                $query->orWhere('employee_name_kh', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($request->position_id, function ($query, $position_id) {
                $query->where('users.position_id', $position_id);
            })
            ->when($Monthly, function ($query, $Monthly) {
                $query->whereMonth('payment_date', $Monthly);
            })
            ->when($yearLy, function ($query, $yearLy) {
                $query->whereYear('payment_date', $yearLy);
            })->orderBy('id', 'DESC')->get();
            $dataPayrolls = [];
            foreach ($payroll as $key => $item) {
                $monthly = Carbon::createFromDate($item->payment_date)->format('m');
                $currentYear = Carbon::createFromDate($item->payment_date)->format('Y');
                $fringe = FringeBenefit::where("employee_id", $item->employee_id)->whereMonth('paid_date', $monthly)->whereYear('paid_date', $currentYear)->get();
                $total_fringe_usd = 0;
                $total_fringe_riel = 0;
                foreach ($fringe as $key => $fri) {
                    $total_fringe_usd +=$fri->amount_usd;
                    $total_fringe_riel +=$fri->amount_riel;
                };
                $fringe_usd = ($total_fringe_usd/2);
                $dataPayrolls[] = [
                    "total_benefits"=>($total_fringe_riel/2) + (round($fringe_usd,2) * $item->exchange_rate),
                    "users"=>$item->users,
                    "base_salary_received_usd"=>$item->base_salary_received_usd,
                    "base_salary_received_riel"=>$item->base_salary_received_riel,
                    "non_taxable_salary"=>($item->seniority_pay_excluded_tax + $item->seniority_backford + $item->total_severance_pay),
                    "exchange_rate"=>$item->exchange_rate,
                    "payment_date"=>$item->payment_date,
                    "total_gross"=>$item->total_gross,
                ];
            };
        return $dataPayrolls;
    }
    public function getFringeBenefits($request) {
        $data = Payroll::where('payment_date', Payroll::max('payment_date'))->orderBy('payment_date','desc')->get();
        $datas = [];
        if (count($data) > 0 ) {
            foreach ($data as $key => $item) {
                $monthly = Carbon::createFromDate($item->payment_date)->format('m');
                $currentYear = Carbon::createFromDate($item->payment_date)->format('Y');
                $fringe = FringeBenefit::with("employee")->where("employee_id", $item->employee_id)->whereMonth('paid_date', $monthly)->whereYear('paid_date', $currentYear)
                ->join('users', 'fringe_benefits.employee_id', '=', 'users.id')
                ->select(
                    'fringe_benefits.*',
                    'users.number_employee',
                    'users.employee_name_en',
                    'users.employee_name_kh',
                    'users.position_id',
                )
                ->when($request->employee_id, function ($query, $employee_id) {
                    $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
                })
                ->when($request->employee_name_en, function ($query, $employee_name_en) {
                    $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name_en.'%');
                })
                ->when($request->employee_name_kh, function ($query, $employee_name_kh) {
                    $query->where('users.employee_name_kh', 'LIKE', '%'.$employee_name_kh.'%');
                })
                ->when($request->position_id, function ($query, $position_id) {
                    $query->where('users.position_id', $position_id);
                })->get();
                if (count($fringe) > 0) {
                    foreach ($fringe as $key => $fri) {
                        $amount_riel = (($fri->amount_usd ? $fri->amount_usd : 0) * $item->exchange_rate) + ($fri->amount_riel ? $fri->amount_riel : 0);
                        $tax_deduction_usd = $fri->amount_usd ? $fri->amount_usd / 2 : 0;
                        $amount_usd = ($fri->amount_usd ? $fri->amount_usd / 2: 0);
                        $tax_deduction_riel = ($fri->amount_riel ? $fri->amount_riel/2: 0) + (round($amount_usd,2) * $item->exchange_rate);
                        $withholding_tax_rate_usd = $tax_deduction_usd ? ($tax_deduction_usd * 20) / 100 : 0;
                        $withholding_tax_rate_riel = $withholding_tax_rate_usd ? (round($withholding_tax_rate_usd,2) * $item->exchange_rate) : ($tax_deduction_riel ? ($tax_deduction_riel * 20 / 100): 0);
                        $earnings_after_tax_usd = round($tax_deduction_usd,2) - round($withholding_tax_rate_usd,2);
                        $earnings_after_tax_riel = $tax_deduction_riel - $withholding_tax_rate_riel;
                        $datas[] = [
                            "exchange_rate"=>$item->exchange_rate,
                            "employee"=>$fri->employee,
                            "amount_usd"=>$fri->amount_usd ? $fri->amount_usd: "",
                            "amount_riel"=>$amount_riel,
                            "tax_deduction_usd"=> $tax_deduction_usd ? round($tax_deduction_usd,2) : "",
                            "tax_deduction_riel"=> $tax_deduction_riel,
                            "withholding_tax_rate_usd"=> $withholding_tax_rate_usd ? round($withholding_tax_rate_usd,2) : "",
                            "withholding_tax_rate_riel"=> $withholding_tax_rate_riel,
                            "earnings_after_tax_usd"=> $earnings_after_tax_usd ? round($earnings_after_tax_usd,2) : "",
                            "earnings_after_tax_riel"=> $earnings_after_tax_riel ? $earnings_after_tax_riel : "",
                        ];
                    }
                }
            }
        }
        return $datas;
    }
}