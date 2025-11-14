<?php

namespace App\Repositories\Admin;

use App\Helpers\Helper;
use App\Models\FringeBenefit;
use App\Models\GenerateAnnualSalaryIncreasement;
use App\Models\Payroll;
use App\Models\Performance;
use App\Models\PerformanceAppraisal;
use App\Models\permissions;
use App\Models\TrainingDetailStaff;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Traits\UploadFiles\UploadFIle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $startOfLastMonth = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }else{
            $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        }
        $payroll = Payroll::with("users")
            ->join('users', 'payrolls.employee_id', '=', 'users.id')
            ->select(
                'payrolls.*',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.position_id',
                'users.branch_id',
                'users.department_id',
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
                $query->orWhere('employee_name_kh', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($request->position_id, function ($query, $position_id) {
                $query->where('users.position_id', $position_id);
            })
            ->when($startOfLastMonth, function ($query, $startOfLastMonth) {
                $query->whereBetween('payment_date', [Helper::startOfLastendOfLastMonth()->startOfLastMonth, Helper::startOfLastendOfLastMonth()->endOfLastMonth]);
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
                    'users.branch_id',
                    'users.department_id',
                    'users.line_manager',
                )
                ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                    if ($RolePermission == 'Employee') {
                        $query->where("users.id", Auth::user()->id);
                    }
                    if ($RolePermission == 'HOD') {
                        if (permissionAccess("m7-s8", "is_view_salary_staff")->value == 1) {
                            $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
                        }else{
                            $query->where("users.id", Auth::user()->id);
                        }
                    }
                    if (in_array($RolePermission, ['HR', 'DHOD', 'DBM'])) {
                        $query->where("users.id", Auth::user()->id);
                        if (optional(permissionAccess("m7-s8", "is_view_salary_staff"))->value == 1) {
                            $query->orWhere(function ($q) {
                                $q->where("users.line_manager", Auth::user()->id);
                            });
                        }
                    }
                    if ($RolePermission == 'BM') {
                        if (permissionAccess("m7-s8", "is_view_salary_staff")->value == 1) {
                            $query->where("users.branch_id", Auth::user()->branch_id);
                        }else{
                            $query->where("users.id", Auth::user()->id);
                        }
                    }
                })
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
                        $withholding_tax_rate_riel = $tax_deduction_riel ? ($tax_deduction_riel * 20 / 100): 0;
                       
                        // $withholding_tax_rate_riel = $withholding_tax_rate_usd ? (round($withholding_tax_rate_usd,2) * $item->exchange_rate) : ($tax_deduction_riel ? ($tax_deduction_riel * 20 / 100): 0);
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

    public function getTrainingReport($request){
        $start_date = null;
        $end_date = null;
        if ($request->start_date) {
            $start_date = Carbon::createFromDate($request->start_date)->format('Y-m-d H:i:s');
        }
        if ($request->end_date) {
            $end_date = Carbon::createFromDate($request->end_date)->format('Y-m-d H:i:s');
        }
        // $perPage = $request->get('per_page', 10); // Default is 10
        $dataTrainings = TrainingDetailStaff::with(["training","employee"])
        ->leftJoin('users', 'training_detail_staff.employee_id', '=', 'users.id')
        ->leftJoin('trainings', 'training_detail_staff.training_id', '=', 'trainings.id')
        ->select(
            'training_detail_staff.*',
            'users.department_id',
            'users.branch_id',
            'users.line_manager',
            'trainings.training_type',
            'trainings.course_name',
            'trainings.cost_price',
            'trainings.discount',
            'trainings.start_date',
            'trainings.end_date',
            'trainings.duration_month',
            'trainings.remark',
            'trainings.status'
        )
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if (in_array($RolePermission, ['HOD', 'BM'])) {
                $query->where("users.department_id", Auth::user()->department_id)
                    ->where("users.branch_id", Auth::user()->branch_id);
            } elseif (in_array($RolePermission, ['DHOD', 'DBM'])) {
                $query->where("training_detail_staff.employee_id", Auth::user()->id);
                $query->orWhere("users.line_manager", Auth::user()->id);
            } elseif ($RolePermission == "Employee") {
                $query->where("users.id", Auth::user()->id);
            } elseif ($RolePermission == 'HR' && permissionAccess("m6-s3","is_access")->value != 1) {
                $query->where("training_detail_staff.employee_id", Auth::user()->id);
                $query->orWhere("users.line_manager", Auth::user()->id);
            }
        })
        ->when($request->traing_type, function ($query, $traing_type) {
            $query->where('trainings.training_type', $traing_type);
        })
        ->when($request->course_name, function ($query, $course_name) {
            $query->where('trainings.course_name', $course_name);
        })
        ->when($start_date, function ($query, $start_date) {
            $query->where('trainings.start_date', '>=', $start_date);
        })
        ->when($end_date, function ($query, $end_date) {
            $query->where('trainings.end_date','<=', $end_date);
        })
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
            $query->orWhere('users.employee_name_kh', 'LIKE', '%'.$employee_name.'%');
        })->orderBy('trainings.id', 'desc');
        $perPage = $request->get('per_page', 10);

        if ($perPage === 'all') {
            $dataTrainings = $dataTrainings->get();
            $dataTrainings = new \Illuminate\Pagination\LengthAwarePaginator(
                $dataTrainings,
                $dataTrainings->count(),
                $dataTrainings->count(),
                1,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $dataTrainings = $dataTrainings->paginate($perPage)->withQueryString();
        }

        return $dataTrainings;
    }

    public function getAnnualSalaryIncreasementReport($request){
      
        // Base query with joins
        $query = GenerateAnnualSalaryIncreasement::leftJoin('users', 'generate_annual_salary_increasements.employee_id', '=', 'users.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
            ->leftJoin('performances', 'generate_annual_salary_increasements.performance_id', '=', 'performances.id')
            ->leftJoin('users as users_approve', 'generate_annual_salary_increasements.approved_by', '=', 'users_approve.id')
            ->select(
                'generate_annual_salary_increasements.*',
                'users.number_employee',
                'users.employee_name_kh',
                'users.employee_name_en',
                'users.date_of_commencement',
                'departments.name_english as dep_name',
                'departments.name_khmer as dep_name_kh',
                'positions.name_english as positions_name',
                'positions.name_khmer as positions_name_kh',
                'branchs.branch_name_kh',
                'branchs.branch_name_en',
                'performances.total_score',
                'performances.total_score_live_staff',
                'performances.total_score_direct_chairman',
                'users_approve.employee_name_kh as approve_employee_name_kh',
                'users_approve.employee_name_en as approve_employee_name_en',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                return $query->where('users.number_employee', $employee_id);
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                return $query->where('users.employee_name_en', $employee_name);
            })
            ->when($request->branch_id, function ($query, $branch_id) {
                return $query->where('users.branch_id', $branch_id);
            })
            ->when($request->department_id, function ($query, $department_id) {
                return $query->where('users.department_id', $department_id);
            });
    
        // Search filter
        $searchValue = request()->input('search.value');
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('users.employee_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('users.number_employee', 'like', "%{$searchValue}%")
                    ->orWhere('positions.name_english', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('departments.name_english', 'like', "%{$searchValue}%");
            });
        }
        return $query;
    }
    public function getKpiReport($request, $permission){
        $query = Performance::leftJoin('users', 'performances.employee_id', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->leftJoin('users as reviewEmployee', 'performances.review_employee_id', '=', 'reviewEmployee.id')
        ->leftJoin('users as userApprove', 'performances.approved_by', '=', 'userApprove.id')
         ->leftJoin('options', 'users.gender', '=', 'options.id')
        ->select(
            'performances.*',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'users.department_id',
            'users.branch_id',
            'users.line_manager',
            'users.gender',
            'users.date_of_commencement',
            'options.name_khmer as gender_name_khmer',
            'options.name_english as gender_name_english',

            'departments.name_english as dep_name',
            'departments.name_khmer as dep_name_khmer',
            
            'positions.name_english as positions_name',
            'positions.name_khmer as positions_name_khmer',

            'branchs.branch_name_en',
            'branchs.branch_name_kh',

            'reviewEmployee.number_employee as review_employee_number_employee',
            'reviewEmployee.employee_name_kh as review_employee_name_kh',
            'reviewEmployee.employee_name_en as review_employee_name_en',

            'userApprove.number_employee as approve_number_employee',
            'userApprove.employee_name_kh as approve_employee_name_kh',
            'userApprove.employee_name_en as approve_employee_name_en',
        )
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) use ($permission) {

            // HR Role: can only see their own data or subordinates if access denied
            if ($RolePermission == 'HR' && $permission->is_access != "1") {
                $query->where(function ($q) {
                    $q->where("performances.employee_id", Auth::user()->id)
                    ->orWhere("users.line_manager", Auth::user()->id);
                });
            }

            // HOD or BM: can see same department and branch
            if (in_array($RolePermission, ['HOD', 'BM'])) {
                $query->where("users.department_id", Auth::user()->department_id)
                    ->where("users.branch_id", Auth::user()->branch_id);
            }

            // DHOD or DBM: can see their own and those they manage
            if (in_array($RolePermission, ['DHOD', 'DBM'])) {
                $query->where(function ($q) {
                    $q->where("performances.employee_id", Auth::user()->id)
                    ->orWhere("users.line_manager", Auth::user()->id);
                });
            }

            // Employee: can see only their own
            if ($RolePermission == "Employee") {
                $query->where("performances.employee_id", Auth::user()->id);
            }

        })
        // 🔍 Search filters
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('users.number_employee', $employee_id);
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
        })
        ->when($request->branch_id, function ($query, $branch_id) {
            $query->where('users.branch_id', $branch_id);
        })
        ->when($request->department_id, function ($query, $department_id) {
            $query->where('users.department_id', $department_id);
        });

        // Search filter
        $searchValue = request()->input('search.value');
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('performances.id', 'like', "%{$searchValue}%")
                ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%")
                ->orWhere('positions.name_english', 'like', "%{$searchValue}%")
                ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%")
                ->orWhere('departments.name_english', 'like', "%{$searchValue}%");
            });
        }
        return $query;
    }
    public function getPAReport($request, $permission){
        $query = PerformanceAppraisal::leftJoin('users', 'performance_appraisals.employee_id', '=', 'users.id')
        ->leftJoin('options', 'users.gender', '=', 'options.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->select(
            'performance_appraisals.*',
            'users.position_id',
            'users.department_id',
            'users.branch_id',
            'users.line_manager',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'users.date_of_commencement',
            'options.name_khmer as gender_name_khmer',
            'options.name_english as gender_name_english',
            'departments.name_english as dep_name',
            'departments.name_khmer as dep_name_kh',
            'positions.name_english as positions_name',
            'positions.name_khmer as positions_name_kh',
            'branchs.branch_name_en',
            'branchs.branch_name_kh',
        )
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) use ($permission) {

            // HR Role: can only see their own data or subordinates if access denied
            if ($RolePermission == 'HR' && $permission->is_access != "1") {
                $query->where(function ($q) {
                    $q->where("performance_appraisals.employee_id", Auth::user()->id)
                    ->orWhere("users.line_manager", Auth::user()->id);
                });
            }

            // HOD or BM: can see same department and branch
            if (in_array($RolePermission, ['HOD', 'BM'])) {
                $query->where("users.department_id", Auth::user()->department_id)
                    ->where("users.branch_id", Auth::user()->branch_id);
            }

            // DHOD or DBM: can see their own and those they manage
            if (in_array($RolePermission, ['DHOD', 'DBM'])) {
                $query->where(function ($q) {
                    $q->where("performance_appraisals.employee_id", Auth::user()->id)
                    ->orWhere("users.line_manager", Auth::user()->id);
                });
            }

            // Employee: can see only their own
            if ($RolePermission == "Employee") {
                $query->where("performance_appraisals.employee_id", Auth::user()->id);
            }

        })
        ->when($request->from_date, function ($query, $from_date) {
            $query->where('performance_appraisals.from_date', '>=', $from_date);
        })
        ->when($request->to_date, function ($query, $to_date) {
            $query->where('performance_appraisals.to_date','<=', $to_date);
        })
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('users.number_employee', $employee_id);
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
        })
        ->when($request->branch_id, function ($query, $branch_id) {
            $query->where('users.branch_id', $branch_id);
        })
        ->when($request->department_id, function ($query, $department_id) {
            $query->where('users.department_id', $department_id);
        });
        
        // Search filter
        $searchValue = request()->input('search.value');
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('performance_appraisals.id', 'like', "%{$searchValue}%")
                ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%")
                ->orWhere('positions.name_english', 'like', "%{$searchValue}%")
                ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%")
                ->orWhere('departments.name_english', 'like', "%{$searchValue}%");
            });
        }
        return $query;
    }
    public function getStaffResigned($request){
        $from_date = null;
        $to_date = null;
        if ($request->from_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s');
        }
        if ($request->to_date) {
            $to_date = Carbon::createFromDate($request->to_date)->format('Y-m-d H:i:s');
        }

        $employees = User::with("gender")->with('position')->with('branch')
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'Employee') {
                $query->where("id", Auth::user()->id);
            }
            if ($RolePermission == 'HOD') {
                $query->whereIn("department_id", EmployeeRepository::getRoleHOD());
            }
            if ($RolePermission == 'BM') {
                $query->where("branch_id", Auth::user()->branch_id);
            }
        })
        ->whereNotIn('emp_status',['Upcoming', 'Cancel', '1','2','10','Probation'])
        ->when($from_date, function ($query, $from_date) {
            $query->where('resign_date', '>=', $from_date);
        })
        ->when($to_date, function ($query, $to_date) {
            $query->where('resign_date', '<=', $to_date);
        })
        ->when($request->branch_id, function ($query, $branch_id) {
            $query->where('branch_id', $branch_id);
        })
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('number_employee', 'LIKE', '%'.$employee_id.'%');
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('employee_name_en', 'LIKE', '%'.$employee_name.'%');
            $query->orWhere('employee_name_kh', 'LIKE', '%'.$employee_name.'%');
        })->orderBy('resign_date', 'desc')->get();
        return $employees;
    }
}