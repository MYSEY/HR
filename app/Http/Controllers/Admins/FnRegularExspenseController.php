<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\FnRegularExspense;
use App\Models\permissions;
use App\Traits\GeneratingCode;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class FnRegularExspenseController extends Controller
{
    use GeneratingCode;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "fn/regular-expense")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        return view('FN_RegularExspenses.index',compact(['permission']));
    }

    public function dataShow(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "fn/regular-expense")->first();
        if ($request->ajax()) {

           $query = FnRegularExspense::query();

            // 🔍 Search
            $searchValue = $request->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('fn_regular_exspenses.serialref', 'like', "%{$searchValue}%")
                    ->orWhere('fn_regular_exspenses.description', 'like', "%{$searchValue}%")
                    ->orWhere('fn_regular_exspenses.file_upload', 'like', "%{$searchValue}%")
                    // ->orWhere('fn_regular_exspenses.is_contactual', 'like', "%{$searchValue}%")
                    ->orWhere('fn_regular_exspenses.status', 'like', "%{$searchValue}%");
                });
            }

            // Counts
            $recordsTotal = FnRegularExspense::count();
            $recordsFiltered = $query->count();

            // Pagination
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));

            // 🔥 HANDLE "ALL"
            if ($limit == -1) {
                $data = $query->get(); // get all rows
            } else {
                $data = $query->offset($start)->limit($limit)->get();
            }

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data,
                'permission' => $permission,
            ]);
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
        try{
            $request->is_contactual == 1 ? $nameDoc = "CNT" : $nameDoc = "REF";
            $autoSerialref   = $this->generateSerialCode(Carbon::today(),$nameDoc)['serialref'];
            Activity::all()->last();
            $data = $request->all();
            if($request->hasFile('file_upload')) {
                $image = $request->file('file_upload');
                $filename = $autoSerialref.'.'.$image->getClientOriginalName();
                $image->move(public_path('uploads/FnRegularExspenses'), $filename);
            }else{
                $filename = $request->hidden_image;
            }
            $data['serialref'] = $autoSerialref;
            $data['file_upload'] = $filename;
            $data['status'] = 1;
            $data['created_by'] = Auth::user()->id;
            FnRegularExspense::create($data);
            Toastr::success('Created successfully.','Success');
            DB::commit();
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create fail.','Error');
            return redirect()->back();
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    public function processing(Request $request)
    {
        DB::beginTransaction();
        try {
            FnRegularExspense::where('id',$request->id)->update([
                'status' => $request->status,
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
    public function destroy($id)
    {
        //
    }
}
