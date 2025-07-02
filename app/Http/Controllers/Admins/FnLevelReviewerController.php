<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportFnLevelReview;
use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\Department;
use App\Models\FnLevelReviewer;
use App\Models\permissions;
use App\Models\Position;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

class FnLevelReviewerController extends Controller
{

    function getDatas($request){

       $filteredDatas = FnLevelReviewer::with(["departmentView", "modelReview"])
        ->when($request->department_id, function ($query, $department_id) {
            $query->where('department_review', $department_id);
        })
        ->when($request->location_id, function ($query, $location_id) {
            $query->where('from_location', $location_id);
        })
        ->when($request->request_type, function ($query, $request_type) {
            if ( $request_type =="gr0") {
               $query->where('request_type', "0");
            }else{
                $query->where('request_type', $request_type);
            }
          
        })
        ->orderBy('type', 'ASC')
        ->orderBy('request_type', 'ASC');

        $perPage = $request->get('per_page', 10);

        if ($perPage === 'all') {
            $datas = $filteredDatas->get();
        } else {
            $datas = $filteredDatas->paginate($perPage);
        }

        return $datas;
    }
    function groutId(){
       $lastInId = FnLevelReviewer::orderBy('group_id', 'DESC')->first();
        return $lastInId;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "fn/level-reviewer")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $departments = Department::get();
        $positions = Position::get();
        $datas = self::getDatas($request);
        return view('FN_LevelReviewers.index',compact(['datas','permission', 'positions','departments']));
    }
    public function filter(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "fn/level-reviewer")->first();
        return response()->json([
            'permission' => $permission,
            'success' => self::getDatas($request),
        ]);
    }

    public function formCreate() {
        $departments = Department::get();
        $positions = Position::get();
        return view('FN_LevelReviewers.form_create', compact(['positions','departments']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            Activity::all()->last();
            if(self::groutId()){
                $group_id = self::groutId()->group_id + 1;
            }else{
                $group_id = 1;
            }
            if (count($request->levels) > 0) {
                foreach ($request->levels as $key => $value) {
                    $data['group_id']           = $group_id;
                    $data['from_amount']        = $request->from_amount;
                    $data['to_amount']          = $request->to_amount;
                    $data['request_type']       = $request->request_type;
                    $data['reference_type']     = $request->reference_type;
                    $data['type']               = $value["type"];
                    $data['from_location']      = $request->from_location;
                    $data['model_review']       = $request->model_review;
                    $data['department_review']  = $value["department_review"];
                    $data['id_positions']       = $value["id_positions"];
                    $data['description']        = $request->description;
                    $data['created_by']         = Auth::user()->id;
                    FnLevelReviewer::create($data);
                }
            }
            Toastr::success('Created successfully.','Success');
            DB::commit();
            return response()->json([
                'message' => 'Created successfully.',
                'status' => 200,
            ]);
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage(), 'status' => 500], 500);
        }
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
            FnLevelReviewer::create($data);
            Toastr::success('Created successfully.','Success');
            DB::commit();
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Created fail.','Error');
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
        $data = FnLevelReviewer::where('id',$request->id)->first();
        $departments = Department::get();
        $positions = Position::get();
        return response()->json([
            'data'=>$data,
            'departments'=>$departments,
            'positions'=>$positions,
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
            $data = FnLevelReviewer::find($request->id);
            $data['from_amount'] = $request->from_amount;
            $data['to_amount'] = $request->to_amount;
            $data['request_type'] = $request->request_type;
            $data['reference_type'] = $request->reference_type;
            $data['type'] = $request->type;
            $data['from_location'] = $request->from_location;
            $data['model_review'] = $request->model_review;
            $data['department_review'] = $request->department_review;
            $data['id_positions'] = $request->id_positions;
            $data['description'] = $request->description;
            $data['updated_by'] = Auth::user()->id;
            $data->save();
            Toastr::success('Updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Updated fail.','Error');
            return redirect()->back();
        }
    }

    public function export(Request $request)
    {
        $datas = $datas = self::getDatas($request);
        $export = new ExportFnLevelReview($datas, $request);
        return Excel::download($export, 'FN_Review.xlsx');
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
            FnLevelReviewer::destroy($request->id);
            Toastr::success('Deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Delete fail.','Error');
            return redirect()->back();
        }
    }
}
