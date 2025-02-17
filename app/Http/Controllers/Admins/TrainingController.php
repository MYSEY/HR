<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportTrainingDetailStaff;
use App\Exports\ExportTrainingDetailTrainer;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Trainer;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TrainingDetailStaff;
use App\Models\TrainingDetailTrainer;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
        if (permissionAccess("m6-s2","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $filteredTrainings = Training::withCount('trainingDetailStaffs')->withCount("trainingDetailTrainer")->orderBy('id', 'DESC')->get();
        $dataTrainings = $filteredTrainings->filter(function ($training) {
            return $training->isStaff();
        });

        $trainer = Trainer::where("status", 1)->get();
        $employee = User::whereIn("emp_status", ['Probation','Upcoming','1','10','2'])->get();
        
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
        $trainer = TrainingDetailTrainer::where('training_id', $request->id)->with("trainer")->get();
        $employees = TrainingDetailStaff::where("training_id", $request->id)->with("employee")->get();
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
            $filteredTrainings = Training::withCount('trainingDetailStaffs')->withCount("trainingDetailTrainer")
            ->when($request->training_type, function ($query, $training_type) {
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
            $data = $filteredTrainings->filter(function ($training) {
                return $training->isStaff();
            });

            return response()->json([
                'success'=>$data->values(),
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
            DB::beginTransaction();
            Activity::all()->last();
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            $dataTraining = Training::create($data);
            if (count($request->employee_id) > 0) {
                foreach ($request->employee_id as $key => $emID) {
                    $data_detail['training_id'] = $dataTraining->id;
                    $data_detail['employee_id'] = $emID;
                    $data_detail['created_by']  = Auth::user()->id;
                    TrainingDetailStaff::create($data_detail);
                }
            }
            if (count($request->trainer_id) > 0) {
                foreach ($request->trainer_id as $key => $tr) {
                    $data_Trainer['training_id'] = $dataTraining->id;
                    $data_Trainer['trainer_id'] = $tr;
                    $data_Trainer['created_by']  = Auth::user()->id; 
                    TrainingDetailTrainer::create($data_Trainer);
                }
            }
            DB::commit();
            Toastr::success('Training created successfully.','Success');
            return redirect()->back();
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
        $employee = User::whereIn("emp_status", ['Probation','Upcoming','1','10','2'])->get();

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
            DB::beginTransaction();
            $data = Training::find($request->id);
            $data['training_type'] = $request->training_type;
            $data['course_name'] = $request->course_name;
            $data['trainer_id'] = $request->trainer_id;
            $data['employee_id'] = $request->employee_id;
            $data['cost_price'] = $request->cost_price;
            $data['discount'] = $request->discount;
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $data['duration_month'] = $request->duration_month;
            $data['remark'] = $request->remark;
            $data['status'] = $request->status;
            $data['updated_by'] = Auth::user()->id;
            $data->save();

            if (count($request->employee_id) > 0) {
                TrainingDetailStaff::where('training_id', $data->id)->delete();
                foreach ($request->employee_id as $key => $emID) {
                    $data_detail['training_id'] = $data->id;
                    $data_detail['employee_id'] = $emID;
                    $data_detail['created_by']  = Auth::user()->id;
                    TrainingDetailStaff::create($data_detail);
                }
            }
            if (count($request->trainer_id) > 0) {
                TrainingDetailTrainer::where('training_id', $data->id)->delete();
                foreach ($request->trainer_id as $key => $tr) {
                    $data_Trainer['training_id'] = $data->id;
                    $data_Trainer['trainer_id'] = $tr;
                    $data_Trainer['created_by']  = Auth::user()->id; 
                    TrainingDetailTrainer::create($data_Trainer);
                }
            }
            DB::commit();
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
        DB::beginTransaction();
        try {
            // Delete the main training record
            Training::destroy($request->id);

            // Delete related records
            TrainingDetailStaff::where('training_id', $request->id)->delete();
            TrainingDetailTrainer::where('training_id', $request->id)->delete();

            DB::commit();

            Toastr::success('Training deleted successfully.', 'Success');
        } catch (\Exception $e) {
            DB::rollback();

            // Log the exception for debugging
            Log::error('Training deletion failed: '.$e->getMessage());

            Toastr::error('Training delete failed.', 'Error');
        }
        return redirect()->back();
    }

    public function staffTrainingExport(){
        $data = Training::get();
        $dataTrainings = [];
        foreach ($data as $key => $item) {
            $em =  User::whereIn('id', $item->employee_id)
            ->with("gender")->with("position")->with("branch")
            ->get();
            $item["employees"] = $em;
            $dataTrainings[] = $item;
        }
        $export = new ExportTrainingDetailStaff($dataTrainings);
        return Excel::download($export, 'Staff_Training.xlsx');
    }
    public function trainerTrainingExport(){
        $data = Training::get();
        $dataTrainings = [];
        foreach ($data as $key => $item) {
            $dataTrainer = Trainer::whereIn('id', $item->trainer_id)->with("employee")->get();
            $item["trainers"] = $dataTrainer;
            $dataTrainings[] = $item;
        }
        $export = new ExportTrainingDetailTrainer($dataTrainings);
        return Excel::download($export, 'Staff_Training.xlsx');

    }

    public function uploads(Request $request){
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $allSheetNames = $spreadsheet->getSheetNames();
            foreach ($allSheetNames as $sheetName) {
                // upload staff trainings
                if ($sheetName == "Staff_trainings") {
                    $i = 0;
                    $staff_training =  $spreadsheet->getSheetByName($sheetName)->toArray();
                    foreach ($staff_training as $item) {
                        $i++;
                        if ($i > 2) {
                            $employee = user::where('number_employee',$item[1])->first();
                            if ($employee) {
                                    $dataCreate['training_id']              = $item[0];
                                    $dataCreate['employee_id']              = $employee->id;
                                    $dataCreate['updated_by']               = Auth::user()->id;
                                    TrainingDetailStaff::create($dataCreate);
                            }
                        }
                    }
                }
                // upload trainer to trainings
                if ($sheetName == "Trainer_upload") {
                    $i = 0;
                    $employees_trainer =  $spreadsheet->getSheetByName($sheetName)->toArray();
                    foreach ($employees_trainer as $item) {
                        $i++;
                        if ($i > 2) {
                            $trainer = Trainer::where('id',$item[1])->first();
                            if ($trainer) {
                                $dataTrainer['training_id']              = $item[0];
                                $dataTrainer['trainer_id']               = $trainer->id;
                                $dataTrainer['updated_by']               = Auth::user()->id;
                                TrainingDetailTrainer::create($dataTrainer);
                            }
                        }
                    }
                }
            }
            return 1;
        } else {
            return 0;
        }
    }
}
