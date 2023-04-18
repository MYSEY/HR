<?php

namespace App\Repositories\Admin;

use Carbon\Carbon;
use App\Models\User;
use Dflydev\DotAccessData\Data;
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

    public function getAllUsers($request){
        if (Auth::user()->RolePermission == 'Administrator') {
            if($request->employee_id || $request->employee_name){
                $dataUser = [];

                if ($request->employee_id && $request->employee_name =="") {

                    $dataUser = User::with('role')->with('department')->where('number_employee', 'LIKE', '%'.$request->employee_id.'%');
                }

                if ($request->employee_name && $request->empolyee_id =="") {
                    $dataUser= User::with('role')->with('department')
                    ->orWhere('employee_name_kh', 'LIKE', '%'.$request->employee_name.'%')
                    ->orWhere('employee_name_en', 'LIKE', '%'.$request->employee_name.'%');
                }

                // if ($request->position_id && $request->employee_name =="" && $request->empolyee_id =="" && $request->department_id =="") {
                //     $dataUser= User::with('role')->with('department')
                //     ->where('position_id', '=', $request->position_id);
                // }

                // if ($request->department_id && $request->employee_name =="" && $request->empolyee_id =="" && $request->position_id =="") {
                //     $dataUser= User::with('role')->with('department')
                //     ->where('department_id', '=', $request->department_id);
                // }

                if ($request->employee_name && $request->employee_id) {
                    $dataUser = User::with('role')->with('department')
                    ->where('number_employee', '=', $request->employee_id)
                    ->where('employee_name_kh', 'LIKE', '%'.$request->employee_name.'%')
                    ->where('employee_name_en', 'LIKE', '%'.$request->employee_name.'%');
                }

                // if ($request->employee_id && $request->employee_name &&  $request->position_id && $request->department_id =="") {
                //     $dataUser = User::with('role')->with('department')
                //             ->where('number_employee', '=', $request->employee_id)
                //             ->where('employee_name_kh', 'LIKE', '%'.$request->employee_name.'%')
                //             ->where('employee_name_en', 'LIKE', '%'.$request->employee_name.'%')
                //             ->where('position_id', '=', $request->position_id);
                // }
                
                // if ($request->employee_id && $request->employee_name &&  $request->position_id && $request->department_id) {
                //     $dataUser = User::with('role')->with('department')
                //             ->where('number_employee', '=', $request->employee_id)
                //             ->where('employee_name_kh', 'LIKE', '%'.$request->employee_name.'%')
                //             ->where('employee_name_en', 'LIKE', '%'.$request->employee_name.'%')
                //             ->where('position_id', '=', $request->position_id)
                //             ->where('department_id', '=', $request->department_id);
                // }

                return $dataUser->get();
            }else{
                return User::with('role')->with('department')->get();
            }
        } else {
            return User::where('role_id',Auth::user()->role_id)
            ->where('position_id',Auth::user()->position_id)
            ->where('department_id',Auth::user()->department_id)
            ->where('branch_id',Auth::user()->branch_id)
            ->with('role')->with('department')->get();
        }
    }
    public function createUsers($request){
        $data = $request->all();
        $newDateTime = Carbon::parse($data['date_of_commencement'])->addMonths(3);
        $data['fdc_date'] = $newDateTime;
        $data['password']   = Hash::make($request->password);
        return User::create($data);
    }
    public function updatedUsers($request){
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
        return User::where('id',$request->id)->update([
            'number_employee'  => $request->number_employee,
            'employee_name_kh'  => $request->employee_name_kh,
            'employee_name_en'  => $request->employee_name_en,
            'gender'  => $request->gender,
            'role_id'  => $request->role_id,
            'position_id'  => $request->position_id,
            'department_id'  => $request->department_id,
            'date_of_birth'  => $request->date_of_birth,
            'email'  => $request->email,
            'branch_id'  => $request->branch_id,
            'unit'  => $request->unit,
            'level'  => $request->level,
            'date_of_commencement'  => $request->date_of_commencement,
            'number_of_children'  => $request->number_of_children,
            'marital_status'  => $request->marital_status,
            'nationality'  => $request->nationality,
            'personal_phone_number'  => $request->personal_phone_number,
            'company_phone_number'  => $request->company_phone_number,
            'agency_phone_number'  => $request->agency_phone_number,
            'password'  => $request->password == "" ? Auth::user()->password : Hash::make($request->password),
            'remark'  => $request->remark,
            'bank_name'  => $request->bank_name,
            'account_name'  => $request->account_name,
            'account_number'  => $request->account_number,
            'identity_type'  => $request->identity_type,
            'identity_number'  => $request->identity_number,
            'issue_date'  => $request->issue_date,
            'issue_expired_date'  => $request->issue_expired_date,
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
        ]);
    }
}