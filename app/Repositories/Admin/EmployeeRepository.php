<?php

namespace App\Repositories\Admin;

use App\Models\Department;
use Carbon\Carbon;
use App\Models\User;
use App\Models\GenerateIdEmployee;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\UploadFiles\UploadFIle;
use Illuminate\Support\Facades\DB;

class EmployeeRepository extends BaseRepository
{
    use UploadFIle;
    /**
     * @var array
     */
    protected $fieldSearchable = [];
    protected $department_ids = [];

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
        return User::class;
    }

    public static function getRoleHOD(){
        $child_department = Department::where('parent_id', Auth::user()->department_id)->select('departments.id')->get();
            $child_department_ids = [];
            foreach ($child_department as $key => $dpm) {
                $child_department_ids [] = [
                    $dpm->id
                ];
            }
        $child_department_ids []= [Auth::user()->department_id];
        return $child_department_ids;
    }

    public function getAllUsers($request){
        // 1. Check salary permissions
        $salaryPerm = DB::table('permissions')
            ->where('role_id', Auth::user()->role_id)
            ->where('url', 'users')
            ->first();
        $canViewStaffSalary    = $salaryPerm && $salaryPerm->is_view_salary_staff == '1'; // View all staff salaries
        $canViewPersonalSalary = $salaryPerm && $salaryPerm->is_view_salary == '1';       // View personal salary only
        $currentUserId         = Auth::user()->id;

        // Helper closure to set financial fields to 0 if unauthorized
        $applySalaryPermission = function ($users) use ($canViewStaffSalary, $canViewPersonalSalary, $currentUserId) {
            $users->transform(function ($user) use ($canViewStaffSalary, $canViewPersonalSalary, $currentUserId) {
                // 1. Full access: Can view staff salaries -> keep all values
                if ($canViewStaffSalary) {
                    return $user;
                }

                // 2. Personal access: Can view personal salary AND this record belongs to logged-in user -> keep values
                if ($canViewPersonalSalary && $user->id == $currentUserId) {
                    return $user;
                }
                $user->basic_salary    = 0;
                $user->salary_increas  = 0;
                $user->phone_allowance = 0;

                return $user;
            });

            return $users;
        };
        if(Auth::user()->RolePermission == 'Employee') {
            $users = User::where('id',Auth::user()->id)
                ->whereNotIn('emp_status',['1','2','10','Probation'])
                ->with('role')->with('department')->get();

            return $applySalaryPermission($users);
        }else{
            if (Auth::user()->RolePermission == 'HOD') {
                $child_department = Department::where('parent_id', Auth::user()->department_id)->select('departments.id')->get();
                    $child_department_ids = [];
                    foreach ($child_department as $key => $dpm) {
                        $child_department_ids [] = [
                            $dpm->id
                        ];
                    }
                $child_department_ids []= [Auth::user()->department_id];
                $this->department_ids = $child_department_ids;
            }
            if($request->emp_status || $request->employee_id || $request->employee_name){
                $dataUser = [];
                $dataUser = User::with('role')->with("gender")->with('department')->with('position')->with('branch')->with('positiontype')
                ->with("currentprovince")
                ->with("currentdistrict")
                ->with("currentcommune")
                ->with("currentvillage")
                ->with("permanentprovince")
                ->with("permanentdistrict")
                ->with("permanentcommune")
                ->with("permanentvillage")
                ->when($request->employee_id, function ($query, $employee_id) {
                    $query->where('number_employee', 'LIKE', '%'.$employee_id.'%');
                })
                ->when($request->employee_name, function ($query, $employee_name) {
                    $query->where('employee_name_en', 'LIKE', '%'.$employee_name.'%');
                    // $query->orWhere('employee_name_kh', 'LIKE', '%'.$employee_name.'%');
                })
                ->when($request->emp_status, function ($query, $emp_status) {
                    if (Auth::user()->RolePermission == 'HOD') {
                        $query->whereIn("department_id", $this->department_ids);
                        if ($emp_status == "resign_reason") {
                            $query->with("resignStatus");
                            $query->whereNotIn('emp_status',['1','2','10','Probation','Upcoming','Cancel']); 
                        }else if($emp_status == "FDC"){
                            $query->whereIn('emp_status', ['1','10']);
                        }else{
                            $query->where('emp_status', $emp_status);
                        }
                    }
                    if (Auth::user()->RolePermission == 'BM') {
                        $query->where("branch_id", Auth::user()->branch_id);
                        if ($emp_status == "resign_reason") {
                            $query->with("resignStatus");
                            $query->whereNotIn('emp_status',['1','2','10','Probation','Upcoming','Cancel']); 
                        }else if($emp_status == "FDC"){
                            $query->whereIn('emp_status', ['1','10']);
                        }else{
                            $query->where('emp_status', $emp_status);
                        }
                    }
                    if (in_array(Auth::user()->RolePermission, ['HR','DHOD','DBM']) && permissionAccess("m2-s1","is_access")->value != "1"){
                        if ($emp_status == "resign_reason") {
                            $query->where("line_manager", Auth::user()->id);
                            $query->with("resignStatus");
                            $query->whereNotIn('emp_status',['1','2','10','Probation','Upcoming','Cancel']); 
                        }else if($emp_status == "FDC"){
                            $query->where("line_manager", Auth::user()->id);
                            $query->whereIn('emp_status',['1','10']);
                            if (Auth::user()->emp_status == "1" || Auth::user()->emp_status == "10") {
                                $query->orWhere("id", Auth::user()->id);
                            }
                            $query->whereIn('emp_status', ['1','10']);
                        }else{
                            if (Auth::user()->emp_status == $emp_status) {
                                $query->where("line_manager", Auth::user()->id);
                                $query->where('emp_status', $emp_status);
                                $query->orWhere("id", Auth::user()->id);
                            }else{
                                $query->where("line_manager", Auth::user()->id);
                                $query->where('emp_status', $emp_status);
                            }
                        }
                    }
                    if (Auth::user()->RolePermission == 'HR' && permissionAccess("m2-s1","is_access")->value == "1"){
                        if ($emp_status == "resign_reason") {
                            $query->with("resignStatus");
                            $query->whereNotIn('emp_status',['1','2','10','Probation','Upcoming','Cancel']); 
                        }else if($emp_status == "FDC"){
                            $query->whereIn('emp_status', ['1','10']);
                        }else{
                            $query->where('emp_status', $emp_status);
                        }
                    }
                    if (in_array(Auth::user()->RolePermission, ['admin','HRAdmin','developer','BOD','CEO'])){
                        if ($emp_status == "resign_reason") {
                            $query->with("resignStatus");
                            $query->whereNotIn('emp_status',['1','2','10','Probation','Upcoming','Cancel'])->orderBy('resign_date', 'desc'); 
                        }else if($emp_status == "FDC"){
                            $query->whereIn('emp_status', ['1','10']);
                        }else{
                            $query->where('emp_status', $emp_status);
                        }
                    }
                    
                });
            
                $users = $dataUser->get();
                return $applySalaryPermission($users);
            }else{
                $users = User::with('role')->with('department')->where('emp_status','Upcoming')->get();
                return $applySalaryPermission($users);
            }
        }
    }
    public function createUsers($request){
        $data = $request->all(); 
        $newDateTime = Carbon::parse($data['date_of_commencement'])->addMonths(3);
        $fullNameKH = $request->last_name_kh.' '.$request->first_name_kh;
        $fullNameEN = $request->last_name_en.' '.$request->first_name_en;
        $data['employee_name_kh'] = $fullNameKH;
        $data['employee_name_en'] = $fullNameEN;
        $data['fdc_date'] = $newDateTime;
        $data['emp_status'] = 'Probation';
        $data['created_by'] = Auth::user()->id;
        $data['password']   = Hash::make($request->password);
        $user = User::create($data);
        GenerateIdEmployee::create([
            'employee_id'   => $user->id,
            'number_employee'   => $user->number_employee,
            'created_by' => Auth::user()->id,
        ]);
        return $user;
    }
    public function updatedUsers($request){
        $udc_end_date = Carbon::parse($request['fdc_end'])->addMonths(3);
        if($request->hasFile('profile')) {
            $image = $request->file('profile');
            $filename = time().'.'.$image->getClientOriginalName();
            $image->move(public_path('uploads/images'), $filename);
        }else{
            $filename = $request->hidden_image;
        }

        if ($request->hasFile('guarantee_letter')) {
            $file = $request->file('guarantee_letter');
            $filenameGuarant = time().'.'.$file->getClientOriginalName();
            $file->move(public_path('uploads/images'), $filenameGuarant);
        }else{
            $filenameGuarant = $request->hidden_file_guarantee;
        }
        if ($request->hasFile('employment_book')) {
            $file = $request->file('employment_book');
            $filenameBook = time().'.'.$file->getClientOriginalName();
            $file->move(public_path('uploads/images'), $filenameBook);
        }else{
            $filenameBook = $request->hidden_file_employment_book;
        }
        $fullNameKH = $request->last_name_kh.' '.$request->first_name_kh;
        $fullNameEN = $request->last_name_en.' '.$request->first_name_en;
        $dataUpdate  = [
                    'number_employee'  => $request->number_employee,
                    'last_name_kh'  => $request->last_name_kh,
                    'first_name_kh'  => $request->first_name_kh,
                    'last_name_en'  => $request->last_name_en,
                    'first_name_en'  => $request->first_name_en,
                    'employee_name_kh'  => $fullNameKH,
                    'employee_name_en'  => $fullNameEN,
                    'gender'  => $request->gender,
                    'role_id'  => $request->role_id,
                    // 'basic_salary'  => $request->basic_salary,
                    // 'salary_increas'  => $request->salary_increas,
                    // 'phone_allowance'  => $request->phone_allowance,
                    'position_id'  => $request->position_id,
                    'position_type'  => $request->position_type,
                    'department_id'  => $request->department_id,
                    'date_of_birth'  => $request->date_of_birth,
                    'fdc_date'  => $request->fdc_date,
                    'fdc_end'  => $udc_end_date,
                    'fdc_end'  => $request->fdc_end,
                    'udc_end_date'  => $udc_end_date,
                    'id_number_nssf'  => $request->id_number_nssf,
                    'email'  => $request->email,
                    'branch_id'  => $request->branch_id,
                    'unit'  => $request->unit,
                    'level'  => $request->level,
                    'line_manager'  => $request->line_manager,
                    'id_card_number'  => $request->id_card_number,
                    'date_of_commencement'  => $request->date_of_commencement,
                    'marital_status'  => $request->marital_status,
                    'nationality'  => $request->nationality,
                    'ethnicity'  => $request->ethnicity,
                    'personal_phone_number'  => $request->personal_phone_number,
                    'company_phone_number'  => $request->company_phone_number,
                    'agency_phone_number'  => $request->agency_phone_number,
                    'remark'  => $request->remark,
                    'bank_name'  => $request->bank_name,
                    'account_name'  => $request->account_name,
                    'account_number'  => $request->account_number,
                    'identity_type'  => $request->identity_type,
                    'identity_number'  => $request->identity_number,
                    'issue_date'  => $request->issue_date,
                    'issue_expired_date'  => $request->issue_expired_date,
                    'type_of_employees_nssf'  => $request->type_of_employees_nssf,
                    'spouse_nssf'  => $request->spouse_nssf,
                    'spouse'  => $request->spouse,
                    'status_nssf'  => $request->status_nssf,
                    'current_house_no'  => $request->current_house_no,
                    'current_street_no'  => $request->current_street_no,
                    'current_province'   => $request->current_province,
                    'current_district'   => $request->current_district,
                    'current_commune'   => $request->current_commune,
                    'current_village'   => $request->current_village,
                    'permanent_province' => $request->permanent_province,
                    'permanent_district' => $request->permanent_district,
                    'permanent_commune' => $request->permanent_commune,
                    'permanent_village' => $request->permanent_village,
                    'permanent_house_no'  => $request->permanent_house_no,
                    'permanent_street_no'  => $request->permanent_street_no,
                    'profile'  => $filename,
                    'guarantee_letter'  => $filenameGuarant,
                    'employment_book'  => $filenameBook,
                    'updated_by'  => Auth::user()->id,
                    'is_loan'  => $request->is_loan
        ];
        if (permissionAccess("m2-s1","is_view_salary")->value == "1") {
            $dataUpdate["basic_salary"] = $request->basic_salary;
            $dataUpdate["salary_increas"] = $request->salary_increas;
            $dataUpdate["phone_allowance"] = $request->phone_allowance;
        }
        return User::where('id',$request->id)->update($dataUpdate);
    }
}