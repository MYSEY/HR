<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\Training;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataTrainings = Training::get();
        $trainer = Trainer::all();
       
        // $trainingType = TrainingType::all();
        $employee = User::whereNot("emp_status", null)->get();
        // $dataTrainings = [];
        // foreach ($data as $key => $item) {
        //     $trainers = [];
        //     foreach ($item->trainer_id as $key => $trai) {
        //         $dataTrainer = Trainer::where('id', $trai)->first();
        //         $trainers[] = [
        //             "name_kh" => $dataTrainer->name_kh,
        //             "name_en" => $dataTrainer->name_en,
        //             "email" =>  $dataTrainer->email,
        //             "number_phone" => $dataTrainer->number_phone,
        //             "remark" => $dataTrainer->remark,
        //             "status" => $dataTrainer->status
        //         ];

        //     }
        //     $employees = [];
        //     foreach ($item->employee_id as $key => $empl) {
        //         $em =  User::where('id', $empl)->select("employee_name_kh", "employee_name_en", "profile")->get();
        //         $employees[] = [
        //            "employee_name_kh" => $em[0]->employee_name_kh,
        //            "employee_name_en" => $em[0]->employee_name_en,
        //            "profile" => $em[0]->profile
        //         ];
        //     }
        //     $item["trainers"] = $trainers;
        //     $item["employees"] = $employees;
        //     $dataTrainings[] = $item;
        // }
        
        return view('training.index', compact('trainer', 'employee', 'dataTrainings'));
    }
    public function trainer(){
        $trainer = Trainer::with("employee")->get();
        return response()->json([
            'data'=>$trainer,
        ]);
    }
    public function detail(Request $request)
    {
        $training = Training::where("id", $request->id)->first();
        $trainer = Trainer::whereIn('id', $training->trainer_id)->get();
        $employees = User::whereIn("id", $training->employee_id)->get();
        return view('training.training_detail', compact('training','trainer','employees'));
    }

    public function filter(Request $request)
    {
        try {
            $start_date = null;
            $end_date = null;
            if ($request->start_date) {
                $start_date = Carbon::createFromDate($request->start_date)->format('Y-m-d H:i:s');
            }
            if ($request->end_date) {
                $end_date = Carbon::createFromDate($request->end_date.' '.'23:59:59')->format('Y-m-d H:i:s');
            }
            $data = Training::when($request->training_type, function ($query, $training_type) {
                $query->where('training_type', $training_type);
            })
            ->when($request->course_name, function ($query, $course_name) {
                $query->where('course_name', 'LIKE', '%'.$course_name.'%');
            })
            ->when($start_date, function ($query, $start_date) {
                $query->where('start_date', '>=', $start_date);
            })
            ->when($end_date, function ($query, $end_date) {
                $query->where('end_date','<=', $end_date);
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
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            Training::create($data);
            Toastr::success('Training created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Training created fail.','Error');
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
        $data = Training::where("id", $request->id)->first();
        $trainer = Trainer::with("employee")->get();
        $employee = User::all();

        return response()->json([
            'success'=>$data,
            'trainer'=>$trainer,
            'employee'=>$employee,
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
            $dataUpdate = [
                'training_type' => $request->training_type,
                'course_name' => $request->course_name,
                'trainer_id' => $request->trainer_id,
                'employee_id' => $request->employee_id,
                'cost_price' => $request->cost_price,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'duration_month' => $request->duration_month,
                'remark' => $request->remark,
                'status' => $request->status,
                'updated_by' => Auth::user()->id 
            ];
            Training::where('id',$request->id)->update($dataUpdate);
            Toastr::success('Training Updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Training Updated fail.','Error');
            return redirect()->back();
        }
    }

    public function processing(Request $request)
    {
        try {
            Training::where('id',$request->id)->update([
                'status' => $request->training_status,
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
            Training::destroy($request->id);
            Toastr::success('Training deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Training delete fail.','Error');
            return redirect()->back();
        }
    }
}
