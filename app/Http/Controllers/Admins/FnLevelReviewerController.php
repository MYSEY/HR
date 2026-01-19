<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportFnLevelDetail;
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
        $filteredIds = FnLevelReviewer::select(DB::raw('MIN(id) as id'))
            ->when($request->department_id, function ($query, $department_id) {
                $query->where('model_review', $department_id);
            })
            ->when($request->location_id, function ($query, $location_id) {
                $query->where('from_location', $location_id);
            })
            ->when($request->request_type, function ($query, $request_type) {
                if ($request_type == "gr0") {
                    $query->where('request_type', "0");
                } else {
                    $query->where('request_type', $request_type);
                }
            })
            ->groupBy('group_id');

        $filteredDatas = FnLevelReviewer::with(['departmentView', 'modelReview'])
            ->whereIn('id', $filteredIds->pluck('id'));

        $perPage = $request->get('per_page', 10);

        if ($perPage === 'all') {
            $datas = $filteredDatas->get();
        } else {
            $datas = $filteredDatas->paginate($perPage);
        }

        return $datas;

    }
    function getDataDtails($request){

        $filteredIds = FnLevelReviewer::
            when($request->group_id, function ($query, $group_id) {
                $query->where('group_id', $group_id);
            })
            ->when($request->department_id, function ($query, $department_id) {
                $query->where('department_review', $department_id);
            })
            ->when($request->location_id, function ($query, $location_id) {
                $query->where('from_location', $location_id);
            })
            ->when($request->request_type, function ($query, $request_type) {
                if ($request_type == "gr0") {
                    $query->where('request_type', "0");
                } else {
                    $query->where('request_type', $request_type);
                }
            });

        $filteredDatas = FnLevelReviewer::with(['departmentView', 'modelReview'])
            ->whereIn('id', $filteredIds->pluck('id'));

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
    public function view(Request $request)
    {
        $datas = FnLevelReviewer::where('group_id', $request->id)->get();
        return view('FN_LevelReviewers.view',compact(['datas']));
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
        $branchs = Branchs::whereNot("abbreviations","HQ")->get();
        return view('FN_LevelReviewers.form_create', compact(['branchs','positions','departments']));
    }
    public function formEdit(Request $request) {
        $departments = Department::get();
        $positions = Position::get();
        $branchs = Branchs::whereNot("abbreviations","HQ")->get();
        $datas = FnLevelReviewer::where('group_id', $request->id)->get();
        return view('FN_LevelReviewers.form_edit', compact(['datas','positions','branchs','departments']));
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
                    $data['special_fixed_asset']= $request->special_fixed_asset;
                    $data['type']               = $value["type"];
                    $data['from_location']      = $request->from_location;
                    $data['branch_id']          = $request->branch_id;
                    $data['model_review']       = $request->model_review;
                    $data['department_review']  = $value["department_review"];
                    $data['id_positions']       = $value["id_positions"];
                    $data['verify_print']       = (isset($value["verify_print"]) ? $value["verify_print"] : "");
                    $data['description']        = $request->description;
                    $data['created_by']         = Auth::user()->id;
                    FnLevelReviewer::create($data);
                }
            }
            DB::commit();
            return response()->json([
                'message' => '@lang("lang.created_successfully")',
                'status' => 200,
            ]);
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage(), 'status' => 500], 500);
        }
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
        try {
            DB::beginTransaction();
            // Remove records no longer present
            $levelIds = collect($request->levels)->pluck('id')->filter()->toArray();
            FnLevelReviewer::where('group_id', $request->group_id)
                ->whereNotIn('id', $levelIds)
                ->delete();
                
            foreach ($request->levels as $value) {
                if (!empty($value['id'])) {
                    $data = FnLevelReviewer::find($value['id']);
                    if ($data) {
                        // Update
                        $data->from_amount        = $request->from_amount;
                        $data->to_amount          = $request->to_amount;
                        $data->request_type       = $request->request_type;
                        $data->reference_type     = $request->reference_type;
                        $data->special_fixed_asset= $request->special_fixed_asset;
                        $data->type               = $value["type"];
                        $data->from_location      = $request->from_location;
                        $data->model_review       = $request->model_review;
                        $data->department_review  = $value["department_review"];
                        $data->branch_id          = $request->branch_id;
                        $data->id_positions       = $value["id_positions"];
                        $data->verify_print       = (isset($value["verify_print"]) ? $value["verify_print"] : "");
                        $data->description        = $request->description;
                        $data->updated_by         = Auth::user()->id;
                        $data->save();
                        continue;
                    }
                }

                // Create new if no id or id not found
                FnLevelReviewer::create([
                    'group_id'           => $request->group_id,
                    'from_amount'        => $request->from_amount,
                    'to_amount'          => $request->to_amount,
                    'request_type'       => $request->request_type,
                    'reference_type'     => $request->reference_type,
                    'special_fixed_asset'=> $request->special_fixed_asset,
                    'type'               => $value["type"],
                    'from_location'      => $request->from_location,
                    'model_review'       => $request->model_review,
                    'department_review'  => $value["department_review"],
                    'branch_id'          => $request->branch_id,
                    'id_positions'       => $value["id_positions"],
                    'verify_print'       => (isset($value["verify_print"]) ? $value["verify_print"] : ""),
                    'description'        => $request->description,
                    'created_by'         => Auth::user()->id,
                ]);
            }
            DB::commit();
            return response()->json([
                'message' => '@lang("lang.updated_successfully")',
                'status' => 200,
            ]);
        } catch (\Throwable $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage(), 'status' => 500], 500);
        }

    }

    public function export(Request $request)
    {
        $datas = $datas = self::getDatas($request);
        $export = new ExportFnLevelReview($datas, $request);
        return Excel::download($export, 'FN_Review.xlsx');
    }
    public function exportDetails(Request $request)
    {
        $datas = $datas = self::getDataDtails($request);
        $export = new ExportFnLevelDetail($datas, $request);
        return Excel::download($export, 'FN_Review_Details.xlsx');
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
            FnLevelReviewer::where('group_id', $request->id)->delete();
            Toastr::success('Deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Delete fail.','Error');
            return redirect()->back();
        }
    }
}
