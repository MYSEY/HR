<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Trainer::with("employee")->get();
        $employee = User::whereIn("emp_status", ['1','2', '10'])->orWhereIn("p_status", ['1','2', '10'])->get();
        return view('trainers.index', compact('data', 'employee'));
    }
    public function filter(Request $request)
    {
        
        try {
            $from_date = null;
            $to_date = null;
            if ($request->from_date) {
                $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d');
            }
            if ($request->to_date) {
                $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s');
            }
            $data = Trainer::leftJoin('users', 'trainers.employee_id', '=', 'users.id')
            ->select(
                'trainers.*', 
                'users.employee_name_kh',
                'users.employee_name_en',
                'users.personal_phone_number',
                'users.email as  user_email',
                'users.remark as user_remark',
            )
            ->when($from_date, function ($query, $from_date) {
                $query->where('trainers.created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('trainers.created_at','<=', $to_date);
            })
            ->when($request->trainer_type, function ($query, $trainer_type) {
                $query->where('type', $trainer_type);
            })
            ->when($request->company_name, function ($query, $company_name) {
                $query->where('company_name', 'LIKE', '%'.$company_name.'%');
            })
            ->when($request->trainer_name, function ($query, $trainer_name) {
                $query->where('name_en', 'LIKE', '%'.$trainer_name.'%');
                $query->orWhere('name_kh', 'LIKE', '%'.$trainer_name.'%');
                $query->orWhere('employee_name_en', 'LIKE', '%'.$trainer_name.'%');
                $query->orWhere('employee_name_kh', 'LIKE', '%'.$trainer_name.'%');
            })
            ->get();
            
            return response()->json([
                'success'=>$data,
            ]);
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Training created fail.','Error');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Activity::all()->last();
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            Trainer::create($data);
            Toastr::success('Trainer created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Trainer created fail.','Error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = Trainer::where("id", $request->id)->first();
        $employee = User::whereIn("emp_status", ['1','2'])->get();
        return response()->json([
            'trainer'=>$data,
            'employee'=>$employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            $dataUpdate =[
                'type' => $request->type,
                'company_name' => $request->company_name,
                'employee_id' => $request->employee_id,
                'name_en' => $request->name_en,
                'name_kh' => $request->name_kh,
                'email' => $request->email,
                'number_phone' => $request->number_phone,
                'remark' => $request->remark,
                'status' => $request->status,
                'updated_by' => Auth::user()->id 
            ];
            Trainer::where('id',$request->id)->update($dataUpdate);
            Toastr::success('Training type Updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Training type Updated fail.','Error');
            return redirect()->back();
        }
    }

    public function processing(Request $request)
    {
        try {
            Trainer::where('id',$request->id)->update([
                'status' => $request->trainer_status,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'The process has been successfully.'
            ]);
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            Trainer::destroy($request->id);
            Toastr::success('Trainer deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Trainer delete fail.','Error');
            return redirect()->back();
        }
    }
}
