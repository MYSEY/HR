<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\permissions;
use App\Models\Branchs;
use App\Models\Department;
use App\Models\FnSpecialReview;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FnSpecialReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // NOTE: change "bundled-rental-rate" to the url of THIS page in your permissions table
        $permission = permissions::where('role_id', Auth::user()->role_id)
            ->where('url', 'fn/special/review')
            ->first();

        if (!$permission || $permission->is_view != '1') {
            if ($request->ajax()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            return view('upgrade.access_page');
        }

        // DataTables request -> return JSON
        if ($request->ajax()) {
            return $this->datatable($request);
        }

        $departments = Department::get();
        $positions   = Position::get();
        $branchs     = Branchs::whereNot('abbreviations', 'HQ')->get();

        return view('fn_special_reviews.index', compact(['permission', 'departments', 'positions', 'branchs']));
    }

    private function datatable(Request $request)
    {
        $query = FnSpecialReview::with(['department', 'branch', 'creator']);

        $recordsTotal = FnSpecialReview::count();

        // ---- Search ----
        $search = trim($request->input('search.value', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('remark', 'like', "%{$search}%")
                ->orWhere('review', 'like', "%{$search}%")
                ->orWhereHas('department', fn ($d) => $d->where('name_english', 'like', "%{$search}%"))
                ->orWhereHas('branch', fn ($b) => $b->where('branch_name_en', 'like', "%{$search}%"));
            });
        }

        $recordsFiltered = (clone $query)->count();

        // ---- Order (whitelist columns) ----
        $allowed  = ['id', 'review', 'from_date', 'to_date', 'created_at'];
        $colIndex = $request->input('order.0.column', 0);
        $colName  = $request->input("columns.{$colIndex}.name", 'id');
        $dir      = $request->input('order.0.dir', 'desc') === 'asc' ? 'asc' : 'desc';
        $query->orderBy(in_array($colName, $allowed) ? $colName : 'id', $dir);

        // ---- Paging (length = -1 means "All") ----
        $start  = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        if ($length > 0) {
            $query->skip($start)->take($length);
        }

        $rows = $query->get();

        // ---- Resolve position names with ONE query ----
        $positionIds   = $rows->pluck('position_id')->flatten()->filter()->unique()->values();
        $positionNames = Position::whereIn('id', $positionIds)->pluck('name_english', 'id'); // change column if needed

        $data = $rows->map(function ($r) use ($positionNames) {
            return [
                'id'         => $r->id,
                'department' => optional($r->department)->name_english,
                'branch'     => optional($r->branch)->branch_name_en,
                'positions'  => collect($r->position_id ?? [])
                                    ->map(fn ($id) => $positionNames[$id] ?? null)
                                    ->filter()
                                    ->values(),
                'review'     => $r->review,
                'from_date' => $r->from_date ? Carbon::parse($r->from_date)->format('d/m/Y') : null,
                'to_date'   => $r->to_date   ? Carbon::parse($r->to_date)->format('d/m/Y')   : null,
                'remark'     => $r->remark,
                'created_by' => optional($r->creator)->employee_name_en,  // change to your user name column
            ];
        });

        return response()->json([
            'draw'            => (int) $request->input('draw'),
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ]);
    }

    public function employee(Request $request)
    {
        $data = User::where('department_id', $request->id)
            ->with('position')
            ->get();

        $positions = $data->pluck('position') 
            ->filter()
            ->unique('id')
            ->values()
            ->map(fn ($p) => [
                'id'   => $p->id,
                'name' => $p->name_english,     // change to your real position column
            ]);

        return response()->json([
            'status' => 200,
            'data'   => $positions,
        ]);
    }
  
      /**
     * Shared validation rules (store + update)
     */
    private function rules(): array
    {
        return [
            'department_id'  => 'required|integer',
            'branch_id'      => 'required|integer',
            'position_ids'   => 'required|array|min:1',
            'position_ids.*' => 'integer',
            'review'         => 'required|integer|between:1,10',
            'from_date'      => 'required|date',
            'to_date'        => 'required|date|after_or_equal:from_date',
            'remark'         => 'nullable|string|max:1000',
        ];
    }
 
    private function validationError($validator)
    {
        return response()->json([
            'status'  => 422,
            'message' => 'ទិន្នន័យបញ្ចូលមិនត្រឹមត្រូវ!',
            'errors'  => $validator->errors()->all(),
        ], 422);
    }
 
    private function notFound()
    {
        return response()->json([
            'status'  => 404,
            'message' => 'រកមិនឃើញទិន្នន័យ!',
        ], 404);
    }
 
    /**
     * Store
     * POST /fn/special/store
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return $this->validationError($validator);
        }
 
        try {
            FnSpecialReview::create([
                'department_id' => $request->department_id,
                'branch_id'     => $request->branch_id,
                'position_id'   => array_map('intval', $request->position_ids),
                'review'        => $request->review,
                'from_date'     => $request->from_date,
                'to_date'       => $request->to_date,
                'remark'        => $request->remark,
                'created_by'    => auth()->id(),
                'updated_by'    => auth()->id(),
            ]);
 
            return response()->json([
                'status'  => 200,
                'message' => 'រក្សាទុកបានជោគជ័យ!',
            ]);
        } catch (\Throwable $e) {
            Log::error('FnSpecialReview store: ' . $e->getMessage());
 
            return response()->json([
                'status'  => 500,
                'message' => 'មានបញ្ហាក្នុងការរក្សាទុក!',
            ], 500);
        }
    }
 
    /**
     * Show (JSON for the Edit modal)
     * GET /fn/special/show/{id}
     */
    public function show($id)
    {
        $row = FnSpecialReview::find($id);
        if (!$row) {
            return response()->json(['status' => 404, 'message' => 'Form not found'], 404);
        }
 
        return response()->json([
            'status' => 200,
            'data'   => [
                'id'            => $row->id,
                'department_id' => $row->department_id,
                'branch_id'     => $row->branch_id,
                'position_ids'  => $row->position_id ?? [],
                'review'        => $row->review,
                'from_date'     => Carbon::createFromDate($row->from_date)->format('Y-m-d'),
                'to_date'       => Carbon::createFromDate($row->to_date)->format('Y-m-d'),
                'remark'        => $row->remark,
            ],
        ]);
    }
 
    /**
     * Update
     * POST /fn/special/update   (id comes from form_rental_id in the body)
     */
    public function update(Request $request, $id = null)
    {
        $id  = $id ?? $request->form_rental_id;
        $row = FnSpecialReview::find($id);
        if (!$row) {
            return $this->notFound();
        }
 
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return $this->validationError($validator);
        }
 
        try {
            $row->update([
                'department_id' => $request->department_id,
                'branch_id'     => $request->branch_id,
                'position_id'   => array_map('intval', $request->position_ids),
                'review'        => $request->review,
                'from_date'     => $request->from_date,
                'to_date'       => $request->to_date,
                'remark'        => $request->remark,
                'updated_by'    => auth()->id(),   // do not touch created_by
            ]);
 
            return response()->json([
                'status'  => 200,
                'message' => 'កែប្រែបានជោគជ័យ!',
            ]);
        } catch (\Throwable $e) {
            Log::error('FnSpecialReview update: ' . $e->getMessage());
 
            return response()->json([
                'status'  => 500,
                'message' => 'មានបញ្ហាក្នុងការកែប្រែ!',
            ], 500);
        }
    }
 
    /**
     * Destroy (soft delete: sets deleted_at, needs SoftDeletes in the Model)
     * DELETE /fn/special/destroy/{id}
     */
    public function destroy($id)
    {
        $row = FnSpecialReview::find($id);
        if (!$row) {
            return $this->notFound();
        }

        try {
            $row->update(['updated_by' => auth()->id()]); // record who deleted it
            FnSpecialReview::destroy($id);                       // soft delete (needs SoftDeletes in the Model)

            return response()->json([
                'status'  => 200,
                'message' => 'លុបបានជោគជ័យ!',
            ]);
        } catch (\Throwable $e) {
            Log::error('FnSpecialReview destroy: ' . $e->getMessage());

            return response()->json([
                'status'  => 500,
                'message' => 'មានបញ្ហាក្នុងការលុប!',
            ], 500);
        }
    }
}
