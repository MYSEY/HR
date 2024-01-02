<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Trainer;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

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
        $trainer = Trainer::where("status", 1)->get();
        $employee = User::whereNot("emp_status", null)->get();
        
        return view('training.index', compact('trainer', 'employee', 'dataTrainings'));
    }
    public function trainer(){
        $trainer = Trainer::where("status", 1)->with("employee")->get();
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
            Activity::all()->last();
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
            $data = Training::find($request->id);
            $data['training_type'] = $request->training_type;
            $data['course_name'] = $request->course_name;
            $data['trainer_id'] = $request->trainer_id;
            $data['employee_id'] = $request->employee_id;
            $data['cost_price'] = $request->cost_price;
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $data['duration_month'] = $request->duration_month;
            $data['remark'] = $request->remark;
            $data['status'] = $request->status;
            $data['updated_by'] = Auth::user()->id;
            $data->save();
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
