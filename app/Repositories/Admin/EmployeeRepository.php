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
        $child_department = Department::where('parent_id', Auth::user()->department_id)->select( 'departments.id')->get();
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
        if(Auth::user()->RolePermission == 'Employee') {
            return User::where('id',Auth::user()->id)
            ->whereNotIn('emp_status',['1','2','10','Probation'])
            ->with('role')->with('department')->get();
        }else{
            if (Auth::user()->RolePermission == 'HOD') {
                $child_department = Department::where('parent_id', Auth::user()->department_id)->select( 'departments.id')->get();
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
                ->when($request->emp_status, function ($query, $emp_status) {
                    if (Auth::user()->RolePermission == 'HOD') {
                        $query->whereIn("department_id", $this->department_ids);
                    }
                    if (Auth::user()->RolePermission == 'BM') {
                        $query->where("branch_id", Auth::user()->branch_id);
                    }
                    if ($emp_status == "resign_reason") {
                        $query->with("resignStatus");
                        $query->whereNotIn('emp_status',['1','2','10','Probation','Upcoming','Cancel']); 
                    }else if($emp_status == "FDC"){
                        $query->whereIn('emp_status', ['1','10']);
                    }else{
                        $query->where('emp_status', $emp_status);
                    }
                })
                ->when($request->employee_id, function ($query, $employee_id) {
                    $query->where('number_employee', 'LIKE', '%'.$employee_id.'%');
                })
                ->when($request->employee_name, function ($query, $employee_name) {
                    $query->where('employee_name_en', 'LIKE', '%'.$employee_name.'%');
                    // $query->orWhere('employee_name_kh', 'LIKE', '%'.$employee_name.'%');
                });
                return $dataUser->get();
            }else{
                return User::with('role')->with('department')->where('emp_status','Upcoming')->get();
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
        $fdc_date = Carbon::parse($request['date_of_commencement'])->addMonths(3);
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
        return User::where('id',$request->id)->update([
            'number_employee'  => $request->number_employee,
            'last_name_kh'  => $request->last_name_kh,
            'first_name_kh'  => $request->first_name_kh,
            'last_name_en'  => $request->last_name_en,
            'first_name_en'  => $request->first_name_en,
            'employee_name_kh'  => $fullNameKH,
            'employee_name_en'  => $fullNameEN,
            'gender'  => $request->gender,
            'role_id'  => $request->role_id,
            'basic_salary'  => $request->basic_salary,
            'salary_increas'  => $request->salary_increas,
            'phone_allowance'  => $request->phone_allowance,
            'position_id'  => $request->position_id,
            'position_type'  => $request->position_type,
            'department_id'  => $request->department_id,
            'date_of_birth'  => $request->date_of_birth,
            'fdc_date'  => $request->fdc_date,
            'udc_end_date'  => $request->udc_end_date,
            'id_number_nssf'  => $request->id_number_nssf,
            'email'  => $request->email,
            'branch_id'  => $request->branch_id,
            'unit'  => $request->unit,
            'level'  => $request->level,
            'line_manager'  => $request->line_manager,
            'id_card_number'  => $request->id_card_number,
            'date_of_commencement'  => $request->date_of_commencement,
            'fdc_date'  => $fdc_date,
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
        ]);
    }
}