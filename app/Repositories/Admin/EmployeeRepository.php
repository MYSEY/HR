<?php

namespace App\Repositories\Admin;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\UploadFiles\UploadFIle;
use Dflydev\DotAccessData\Data;

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

    public function getAllUsers(){
        if (Auth::user()->RolePermission == 'Administrator') {
            return User::with('role')->with('department')->get();
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
        $data['password']   = Hash::make($request->password);
        return User::create($data);
    }
}