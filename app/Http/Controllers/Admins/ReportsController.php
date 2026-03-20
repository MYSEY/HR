<?php

namespace App\Http\Controllers\Admins;

use App\Exports\DownloadKpis;
use App\Exports\ExporPerformanceDetail;
use App\Exports\ExportAnnualSalaryIncreasement;
use App\Exports\ExportBankTransfer;
use App\Exports\ExportEFiling;
use App\Exports\ExportEForm;
use App\Exports\ExportEmployeeReport;
use App\Exports\ExportFringeBenefits;
use App\Exports\ExportPA;
use App\Exports\ExportStaffResign;
use App\Exports\ExportTraining;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Branchs;
use App\Models\Department;
use App\Models\FringeBenefit;
use App\Models\GenerateAnnualSalaryIncreasement;
use App\Models\Payroll;
use App\Models\Performance;
use App\Models\PerformanceAppraisal;
use App\Models\permissions;
use App\Models\Position;
use App\Models\StaffPromoted;
use App\Models\Trainer;
use App\Models\Training;
use App\Models\TrainingDetailStaff;
use App\Models\Transferred;
use App\Models\User;
use App\Repositories\Admin\EmployeeRepository;
use App\Repositories\Admin\ReportRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    private $reportRepo;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(ReportRepository $reportRepo)
    {
        $this->reportRepo = $reportRepo;
    }

    public function employee(){
        if (permissionAccess("m7-s1","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $users = User::whereNot("emp_status", null)
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'Employee') {
                $query->where('id',Auth::user()->id);
            }
            if ($RolePermission == 'HOD') {
                $query->whereIn("department_id", EmployeeRepository::getRoleHOD());
            }
            if ($RolePermission == 'BM') {
                $query->where("branch_id", Auth::user()->branch_id);
            }
            if ($RolePermission == 'HR') {
                $query->where('line_manager', Auth::user()->id);
            }
        })
        ->get();
        return view('reports.employee_report',compact('users'));
    }
    public function employeeSearch(Request $request) {
        $users = User::whereNot("emp_status", null)->with("department")->with("position")->with("role")->with("branch")->with("gender")
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'Employee') {
                $query->where('id',Auth::user()->id);
            }
            if ($RolePermission == 'HOD') {
                $query->whereIn("department_id", EmployeeRepository::getRoleHOD());
            }
            if ($RolePermission == 'BM') {
                $query->where("branch_id", Auth::user()->branch_id);
            }
        })
        ->when($request->emp_status, function ($query, $emp_status) {
            $query->where('emp_status', $emp_status);
        })
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('number_employee', 'LIKE', '%'.$employee_id.'%');
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('employee_name_en', 'LIKE', '%'.$employee_name.'%');
        })->get();
        return response()->json([
            'success'=>$users,
        ]);
    }

    public function export(Request $request) {
        return Excel::download(new ExportEmployeeReport($request), 'EmployeeReport.xlsx');
    }

    public function newStaff(Request $request){
        if (permissionAccess("m7-s13","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $from_date = null;
        $to_date = null;
        if ($request->from_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s');
        }
        if ($request->to_date) {
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s');
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
        ->where("emp_status",'Probation')
        ->when($from_date, function ($query, $from_date) {
            $query->where('date_of_commencement', '>=', $from_date);
        })
        ->when($to_date, function ($query, $to_date) {
            $query->where('date_of_commencement','<=', $to_date);
        })
        ->when($request->branch_id, function ($query, $branch_id) {
            $query->where('branch_id', $branch_id);
        })
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('number_employee', 'LIKE', '%'.$employee_id.'%');
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('employee_name_en', 'LIKE', '%'.$employee_name.'%');
            $query->where('employee_name_kh', 'LIKE', '%'.$employee_name.'%');
        })
        ->get();

        $branch = Branchs::all();
        if ($request->research) {
            return response()->json(['employees'=>$employees]);
        }else {
            return view('reports.new_staff_report', compact('employees', 'branch'));
        }
    }

    public function staffResigned(Request $request){
        if (permissionAccess("m7-s14","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        // $from_date = null;
        // $to_date = null;
        // if ($request->from_date) {
        //     $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s');
        // }
        // if ($request->to_date) {
        //     $to_date = Carbon::createFromDate($request->to_date)->format('Y-m-d H:i:s');
        // }

        // $employees = User::with("gender")->with('position')->with('branch')
        // ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
        //     if ($RolePermission == 'Employee') {
        //         $query->where("id", Auth::user()->id);
        //     }
        //     if ($RolePermission == 'HOD') {
        //         $query->whereIn("department_id", EmployeeRepository::getRoleHOD());
        //     }
        //     if ($RolePermission == 'BM') {
        //         $query->where("branch_id", Auth::user()->branch_id);
        //     }
        // })
        // ->whereNotIn('emp_status',['Upcoming', 'Cancel', '1','2','10','Probation'])
        // ->when($from_date, function ($query, $from_date) {
        //     $query->where('resign_date', '>=', $from_date);
        // })
        // ->when($to_date, function ($query, $to_date) {
        //     $query->where('resign_date', '<=', $to_date);
        // })
        // ->when($request->branch_id, function ($query, $branch_id) {
        //     $query->where('branch_id', $branch_id);
        // })
        // ->when($request->employee_id, function ($query, $employee_id) {
        //     $query->where('number_employee', 'LIKE', '%'.$employee_id.'%');
        // })
        // ->when($request->employee_name, function ($query, $employee_name) {
        //     $query->where('employee_name_en', 'LIKE', '%'.$employee_name.'%');
        //     $query->orWhere('employee_name_kh', 'LIKE', '%'.$employee_name.'%');
        // })->orderBy('resign_date', 'desc')->get();

        $employees = $this->reportRepo->getStaffResigned($request);
        $branch = Branchs::all();
        if ($request->research) {
            return response()->json(['employees'=>$employees]);
        }else {
            return view('reports.staff_resigned_report', compact('employees', 'branch'));
        }
    }
    public function staffResignedExport(Request $request) {
        $employees = $this->reportRepo->getStaffResigned($request);
        return Excel::download(new ExportStaffResign($employees), 'EmployeeResignReport.xlsx');
    }

    public function staffPromoted(Request $request){
        if (permissionAccess("m7-s16","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $from_date = null;
        $to_date = null;
        if ($request->from_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s');
        }
        if ($request->to_date) {
            $to_date = Carbon::createFromDate($request->to_date)->format('Y-m-d H:i:s');
        }

        $staffPromotes = StaffPromoted::with("employee")->join('users', 'staff_promoteds.employee_id', '=', 'users.id')
            ->select(
                'staff_promoteds.*',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.number_employee',
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
            ->when($from_date, function ($query, $from_date) {
                $query->where('date', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('date','<=', $to_date);
            })
            ->when($request->branch_id, function ($query, $branch_id) {
                $query->where('users.branch_id', $branch_id);
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
                $query->orWhere('users.employee_name_kh', 'LIKE', '%'.$employee_name.'%');
            })->get();
        $branch = Branchs::all();
        if ($request->research) {
            return response()->json(['staffPromotes'=>$staffPromotes]);
        }else {
            return view('reports.staff_promoted_report', compact('staffPromotes', 'branch'));
        }
    }

    public function staffTransferred(Request $request){
        if (permissionAccess("m7-s15","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $from_date = null;
        $to_date = null;
        if ($request->from_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s');
        }
        if ($request->to_date) {
            $to_date = Carbon::createFromDate($request->to_date)->format('Y-m-d H:i:s');
        }

        $transferred = Transferred::with("employee")->with("branch")->with("position")->join('users', 'transferreds.employee_id', '=', 'users.id')
            ->select(
                'transferreds.*',
                'users.employee_name_en',
                'users.employee_name_kh',
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
            ->when($from_date, function ($query, $from_date) {
                $query->where('date', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('date','<=', $to_date);
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
                $query->orWhere('users.employee_name_kh', 'LIKE', '%'.$employee_name.'%');
            })->get();
        $branch = Branchs::all();
        if ($request->research) {
            return response()->json(['transferred'=>$transferred]);
        }else {
            return view('reports.staff_transferred_report', compact('transferred', 'branch'));
        }
    }

    public function trainingReport(Request $request){
        if (permissionAccess("m6-s3","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $dataTrainings = $this->reportRepo->getTrainingReport($request);
        if ($request->ajax()) {
            return response()->json($dataTrainings);
        }
        return view('reports.training_report', compact("dataTrainings"), );
    }

    public function filterTraining(Request $request){
        $dataTrainings = $this->reportRepo->getTrainingReport($request);
         // Check if it's a paginated response
        if ($dataTrainings instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            // If it's paginated, return the necessary pagination metadata
            return response()->json([
                'data' => $dataTrainings->items(), // Only send the data items
                'pagination' => [
                    'current_page' => $dataTrainings->currentPage(),
                    'last_page' => $dataTrainings->lastPage(),
                    'total' => $dataTrainings->total(),
                    'per_page' => $dataTrainings->perPage(),
                ],
            ]);
        }

        // If it's not paginated (e.g., 'all' was requested), just return the data
        return response()->json([
            'data' => $dataTrainings,
        ]);
    }

    public function trainingExport(Request $request){
        $dataTrainings = $this->reportRepo->getTrainingReport($request);
        $export = new ExportTraining($dataTrainings);
        return Excel::download($export, 'ReportTraining.xlsx');
    }

    public function bankTransfer(Request $request) {
        if (permissionAccess("m7-s9","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $banks = Bank::get();
        $departments = Department::get();
        $branchs = Branchs::get();
        $data = Payroll::with('users')
        ->leftJoin('users', 'payrolls.employee_id', '=', 'users.id')
        ->select(
            'payrolls.*',
            'users.number_employee',
            'users.branch_id',
            'users.department_id',
            'users.bank_name',
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
        ->when($request, function ($query, $request) {
            if ($request->bank_id) {
                $query->where("users.bank_name", $request->bank_id);
            }
            if ($request->department_id) {
                $query->where("users.department_id", $request->department_id);
            }
            if ($request->branch_id) {
                $query->where("users.branch_id", $request->branch_id);
            }
        })
        // ->where("payrolls.payment_date", "2024-08-19")
        ->whereBetween('payrolls.payment_date', [Helper::startOfLastendOfLastMonth()->startOfLastMonth, Helper::startOfLastendOfLastMonth()->endOfLastMonth])
        ->orderBy('employee_id')->get();
        if ($request->bank_id || $request->department_id || $request->branch_id ) {
            return response()->json([
                'success'=>$data,
            ]);
        }else{
            return view('reports.bank_transfer',compact(['data','banks','departments','branchs']));
        }

    }

    public function bankTransferExport(Request $request){
        $data = Payroll::with('users')
        ->leftJoin('users', 'payrolls.employee_id', '=', 'users.id')
        ->select(
            'payrolls.*',
            'users.number_employee',
            'users.branch_id',
            'users.department_id',
            'users.bank_name',
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
        ->when($request, function ($query, $request) {
            if ($request->bank_id) {
                $query->where("users.bank_name", $request->bank_id);
            }
            if ($request->department_id) {
                $query->where("users.department_id", $request->department_id);
            }
            if ($request->branch_id) {
                $query->where("users.branch_id", $request->branch_id);
            }
        })
        ->whereBetween('payrolls.payment_date', [Helper::startOfLastendOfLastMonth()->startOfLastMonth, Helper::startOfLastendOfLastMonth()->endOfLastMonth])
        ->orderBy('employee_id')->get();
        $export = new ExportBankTransfer($data);
        return Excel::download($export, 'ReportBankTransfer.xlsx');
    }

    public function eFilingSalary(Request $request){
        if (permissionAccess("m7-s10","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $dataPayrolls = $this->reportRepo->getEFilingSalary($request);
        $positions = Position::get();
        return view('reports.e_filing_salary',compact('dataPayrolls','positions'));
    }
    public function eFilingFilter(Request $request)
    {
        $data = $this->reportRepo->getEFilingSalary($request);
        return response()->json([
            'success'=>$data,
        ]);
    }
    public function efilingSalaryExport(Request $request){
        $data = $this->reportRepo->getEFilingSalary($request);
        $export = new ExportEFiling($data);
        return Excel::download($export, 'ReportEFiling.xlsx');
    }

    public function eFormSalary(){
        if (permissionAccess("m7-s11","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $payroll = Payroll::with('users')
        ->join('users', 'payrolls.employee_id', '=', 'users.id')
        ->select(
            'payrolls.*',
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
        ->whereBetween('payrolls.payment_date', [Helper::startOfLastendOfLastMonth()->startOfLastMonth, Helper::startOfLastendOfLastMonth()->endOfLastMonth])
        ->orderBy('id', 'DESC')->get();
        $positions = Position::get();
        return view('reports.e_form_report',compact('payroll','positions'));
    }
    public function eFormFilter(Request $request){
        $data = $this->reportRepo->getEFilingSalary($request);
        return response()->json([
            'success'=>$data,
        ]);
    }
    public function eFormSalaryExport(Request $request){
        $data = $this->reportRepo->getEFilingSalary($request);
        $export = new ExportEForm($data);
        return Excel::download($export, 'ReportEForm.xlsx');
    }

    public function fringeBenefit(Request $request){
        if (permissionAccess("m7-s8","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $datas = $this->reportRepo->getFringeBenefits($request);
        $positions = Position::get();
        return view('reports.fringe_benefits_report',compact('datas','positions'));
    }
    public function fringeBenefitFilter(Request $request){
        $data = $this->reportRepo->getFringeBenefits($request);
        return response()->json([
            'success'=>$data,
        ]);
    }
    public function fringeBenefitExport(Request $request){
        $data = $this->reportRepo->getFringeBenefits($request);
        $export = new ExportFringeBenefits($data);
        return Excel::download($export, 'ReportFringeBenefits.xlsx');
    }

    public function AnnualSalaryIncreasement(Request $request){
        if ($request->ajax()) {
            $query = $this->reportRepo->getAnnualSalaryIncreasementReport($request);
             // Pagination
            $recordsTotal = GenerateAnnualSalaryIncreasement::count();
            $recordsFiltered = $query->count();
            $start = intval(request()->input('start', 0));
            $limit = intval(request()->input('length', 10));
            $data = $query->where("generate_annual_salary_increasements.status", "approved")->orderBy('generate_annual_salary_increasements.id', 'desc')->offset($start)->limit($limit)->get();
            // ✅ Return JSON for DataTables
            return response()->json([
                'draw' => intval(request()->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        $branch = Branchs::all();
        return view('reports.annualSalary_increasement_report',compact('branch'));
    }
    public function AnnualSalaryIncreasementExport(Request $request){
        $query = $this->reportRepo->getAnnualSalaryIncreasementReport($request);
        $data = $query->where("generate_annual_salary_increasements.status", "approved")->orderBy('generate_annual_salary_increasements.id', 'desc')->get();
        $export = new ExportAnnualSalaryIncreasement($data);
        return Excel::download($export, 'annual_salary_increasement.xlsx');
    }

    public function PaReport(Request $request){
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "performance/appraisal/pa-report")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        if ($request->ajax()) {
            $query = $this->reportRepo->getPAReport($request, $permission);
            $recordsTotal = PerformanceAppraisal::where('status', 'new')->count();  // total records without filter
            $recordsFiltered = $query->count();
            $start = intval(request()->input('start', 0));
            $limit = intval(request()->input('length', 10));
            $order = request()->input('order', []);
            $columns = request()->input('columns', []);
            if (!empty($order)) {
                foreach ($order as $ord) {
                    $colIndex = $ord['column'];
                    $colDir   = $ord['dir'];
                    $colName  = $columns[$colIndex]['name'] ?? null;

                    if ($colName && $columns[$colIndex]['orderable'] === 'true') {
                        $query->orderBy($colName, $colDir);
                    }
                }
            } else {
                // Default order
                $query->orderBy('performances.id', 'desc');
            }
            $data = $query->where('performance_appraisals.status', 'approved')->orderBy('performance_appraisals.id', 'desc')->offset($start)->limit($limit)->get();
            return response()->json([
                'draw' => intval(request()->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        $branch = [];
        $department = [];
        if(Auth::user()->RolePermission == "DHOD" && Auth::user()->department->abbreviations == "CRD"){
            $branch = Branchs::whereNot("id", Auth::user()->branch_id)->get();
        }
        if(in_array(Auth::user()->RolePermission,['admin','HRAdmin','developer','BOD','CEO']) || (in_array(Auth::user()->RolePermission, ['HR']) && $permission["is_access"] == 1)){
            $branch = Branchs::all();
            $department = Department::all();
        }
        return view('reports.pa_report',compact('branch','department','permission'));
    }
    public function PaReportExport(Request $request){
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "performance/appraisal/pa-report")->first();
        $query = $this->reportRepo->getPAReport($request, $permission);
        $data = $query->where('performance_appraisals.status', 'approved')->orderBy('performance_appraisals.id', 'desc')->get();
        return Excel::download(new ExportPA($data), 'pa.xlsx');
    }
    public function PaReportExportDetail(Request $request){
        $id = $request->id;
        $data = PerformanceAppraisal::with(['titles.purposes.performanceDetail'])
        ->leftJoin('users', 'performance_appraisals.employee_id', '=', 'users.id')
        ->leftJoin('users as line_manager', 'users.line_manager', '=', 'line_manager.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->select(
            'performance_appraisals.*',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'line_manager.employee_name_kh as line_manager_name_kh',
            'line_manager.employee_name_en as line_manager_name_en',
            'users.date_of_commencement',
            'departments.name_english as dep_name',
            'positions.name_english as positions_name',
            'positions.name_khmer as positions_name_kh',
            'branchs.branch_name_en',
            'branchs.branch_name_kh',
        )->where('performance_appraisals.id',$id)->first();
        return Excel::download(new ExporPerformanceDetail($data), 'performance_appraisal_'.$id.'.xlsx');

    }

}
