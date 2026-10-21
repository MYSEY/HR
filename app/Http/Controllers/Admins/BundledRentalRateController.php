<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\Position;
use App\Models\BundledRentalRate;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException as ValidationValidationException;
use Nette\Schema\ValidationException;

class BundledRentalRateController extends Controller
{
    function groutId(){
       $lastInId = BundledRentalRate::orderBy('group_id', 'DESC')->first();
        return $lastInId;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index()
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "bundled-rental-rate")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $positionNames = Position::pluck('name_english', 'id');   // [id => name]
    
        $rows = BundledRentalRate::orderByDesc('group_id')
            ->orderBy('from')
            ->orderBy('to')
            ->get();
        $groups = $rows->groupBy('group_id')->map(function ($g) use ($positionNames) {
            $first = $g->first();
    
            $rates = $g->groupBy(fn ($i) => ($i->from ?? 'N') . '_' . ($i->to ?? 'N') . '_' . ($i->currency ?? 'USD') . '_' . (float) $i->amount)
                ->map(function ($x) use ($positionNames) {
                    $f = $x->first();
    
                    return [
                        'from'      => $f->from,
                        'to'        => $f->to,
                        'currency'  => $f->currency ?? 'USD',
                        'amount'    => (float) $f->amount,
                        'positions' => $x->pluck('position_id')->filter()
                            ->map(fn ($id) => $positionNames[$id] ?? $id)->values()->all(),
                    ];
                })
                ->sortBy('from')->values();
    
            return [
                'id'            => $first->group_id,
                'name'          => $first->name,
                'type'          => $first->type ?: 'motorcycle',
                'rates'         => $rates,
                'leave_day'     => $first->leave_day,
                'transfer_day' => $first->transfer_day,
                'created_at'    => $first->created_at,
            ];
        })->values();
    
        return view('bundled_rental_rates.index', compact('groups', 'permission'));
    }
    public function formCreate() {
        $positions = Position::get();
        return view('bundled_rental_rates.form_setup', compact(['positions']));
    }
    public function formEdit($id) {
        // 1. ទាញយក Rates ទាំងអស់តាម group_id ហើយ Sort តាម from និង to ពីតូចទៅធំ
        $rates = BundledRentalRate::where('group_id', $id)
            ->orderBy('from', 'asc')
            ->orderBy('to', 'asc')
            ->get();

        if ($rates->isEmpty()) {
            return redirect()->back()->with('error', 'Data not found');
        }

        // 2. Group ទិន្នន័យតាម combination នៃ (from, to, currency, amount)
        $groupedRates = $rates->groupBy(function ($item) {
            $from = $item->from ?? 'NULL';
            $to = $item->to ?? 'NULL';
            $currency = $item->currency ?? 'USD';
            $amount = (float) $item->amount;

            return "{$from}_{$to}_{$currency}_{$amount}";
        })->map(function ($group) {
            $first = $group->first();

            return [
                'from'          => $first->from,
                'to'            => $first->to,
                'currency'      => $first->currency,
                'amount'        => $first->amount,
                'position_ids'  => $group->pluck('position_id')->filter()->values()->toArray(),
                'type'          => $first->type,
                'transfer_day' => $first->transfer_day,
                'leave_day'     => $first->leave_day,
            ];
        })->sortBy('from')->values(); // 💡 ធានា Sort ម្តងទៀតបន្ទាប់ពី Group តាម 'from'

        $groupName = $rates->first()->name ?? '';
        $positions = Position::all();

        return view('bundled_rental_rates.form_setup', compact('id', 'groupName', 'groupedRates', 'positions'));
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
        // ១. ប្រមូល Position IDs ទាំងអស់ពី Request តែម្តង
        $allPositionIds = collect($request->datas)->pluck('id_positions')->flatten()->unique()->toArray();

        // ២. Query ទាញយក Data ស្រាប់ពី DB តែ ១ ដងគត់ (Single Query)
        $existingRates = BundledRentalRate::whereIn('position_id', $allPositionIds)->get();

        $duplicateErrors = [];
        $insertData = [];

        // ៣. Loop ឆែក Memory (គ្មាន Query ទៅ DB ក្នុង Loop ទៀតទេ)
        if(self::groutId()){
            $group_id = self::groutId()->group_id + 1;
        }else{
            $group_id = 1;
        }
        foreach ($request->datas as $value) {
            $name   = $value['name'];
            if ($request->type == "motorcycle") {
                $from = $value['from'];
                $to   = $value['to'];
                if (isset($value['id_positions']) && is_array($value['id_positions']) && count($value['id_positions']) > 0) {
                    foreach ($value['id_positions'] as $positionId) {
                        // ឆែក Overlap លើ Collection ក្នុង PHP Memory (លឿនបំផុត)
                        $isDuplicate = $existingRates->where('position_id', $positionId)
                            ->filter(function ($item) use ($from, $to) {
                                return ($item->from <= $to) && ($item->to >= $from);
                            })->isNotEmpty();

                        if ($isDuplicate) {
                            $postion_name = Position::where("id", $positionId)->first();
                            $duplicateErrors[] = "Position: [{$postion_name->name_english}] មានរួចហើយនៅចន្លោះពី {$from} ដល់ {$to}!";
                        } else {
                            // រៀបចំ Data សម្រាប់ Bulk Insert
                            $insertData[] = [
                                'group_id'    => $group_id,
                                'name'        => $name,
                                'position_id' => $positionId,
                                'from'        => $from,
                                'to'          => $to,
                                'currency'    => $value['currency'],
                                'amount'      => $value['amount'],
                                'created_by'  => Auth::id(),
                                'created_at'  => now(),
                                'updated_at'  => now(),
                            ];
                        }
                    }
                }else{
                    $insertData[] = [
                        'group_id'    => $group_id,
                        'type'        => $request->type,
                        'name'        => $name,
                        'from'        => $from ?? null,
                        'to'          => $to ?? null,
                        'currency'    => $value['currency'],
                        'amount'      => $value['amount'],
                        'created_by'  => Auth::id(),
                        'created_at'  => now(),
                    ];
                }
            }else if($request->type == "leave"){
                $insertData[] = [
                    'group_id'    => $group_id,
                    'name'        => $name,
                    'type'        => $request->type,
                    'leave_day'    => $value['leave_day'],
                    'created_by'  => Auth::id(),
                    'created_at'  => now(),
                ];
            }else if($request->type == "staff_transfer"){
                $insertData[] = [
                    'group_id'      => $group_id,
                    'name'          => $name,
                    'type'          => $request->type,
                    'transfer_day' => $value['transfer_day'],
                    'created_by'    => Auth::id(),
                    'created_at'    => now(),
                ];
            }
        }

        // ៤. បើមាន duplicate តែ ១ គឺ Reject ទាំងអស់
        if (count($duplicateErrors) > 0) {
            return response()->json([
                'status'  => 422,
                'message' => 'មិនអាចរក្សាទុកបានទេ ដោយសារមាន Position ស្ទួន!',
                'errors'  => $duplicateErrors
            ], 422);
        }

        // ៥. Insert ចូល DB តែ ១ ជើងគត់ (Bulk Insert)
        try {
            DB::beginTransaction();
            
            BundledRentalRate::insert($insertData); // ប្រើ insert() ជំនួស create() ដើរលឿនដូចផ្លេកបន្ទោរ
            
            DB::commit();

            return response()->json([
                'status'  => 200,
                'message' => __('lang.created_successfully'),
            ], 200);

        } catch (\Throwable $exp) {
            DB::rollBack();
            return response()->json([
                'status'  => 500,
                'message' => $exp->getMessage(), 
            ], 500);
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
    
    
    public function update(Request $request)
    {
        $type = $request->input('type');
    
        $request->validate(array_merge([
            'group_id' => ['required', 'exists:bundled_rental_rates,group_id'],
            'name'     => ['required', 'string', 'max:255'],
            'type'     => ['required', Rule::in(self::TYPES)],
            'rates'    => ['required', 'array', 'min:1'],
        ], $this->typeRules($type, 'rates', 'position_ids')));
    
        $this->assertYearRange($request->input('rates', []), 'rates');
    
        DB::transaction(function () use ($request) {
            $groupId = $request->input('group_id');
    
            BundledRentalRate::where('group_id', $groupId)->delete();
    
            foreach ($request->input('rates', []) as $item) {
                $this->saveRows($groupId, $request->input('type'), $request->input('name'), $item);
            }
        });
    
        return response()->json(['status' => 200, 'message' => __('lang.the_process_has_been_successfully')]);
    }
    
    private function saveRows($groupId, ?string $type, ?string $name, array $item): void
    {
        // ទទួលទាំង id_positions (Create) និង position_ids (Edit) ហើយមិនឱ្យ null
        $positionIds = $item['id_positions'] ?? $item['position_ids'] ?? [];
        $positionIds = array_values(array_filter((array) $positionIds, fn ($v) => $v !== null && $v !== ''));
 
        if (empty($positionIds)) {
            $positionIds = [null];
        }
 
        foreach ($positionIds as $positionId) {
            BundledRentalRate::create([
                'group_id'      => $groupId,
                'name'          => $name,
                'type'          => $type,
                'from'          => $item['from'] ?? null,
                'to'            => $item['to'] ?? null,
                'currency'      => $item['currency'] ?? null,
                'amount'        => $item['amount'] ?? null,
                'position_id'   => $positionId,
                'leave_day'     => $item['leave_day'] ?? null,
                'transfer_day'  => $item['transfer_day'] ?? null,
            ]);
        }
    }

    private const TYPES = [
        'motorcycle', 'car', 'tuk_tuk', 'truck', 'bicycle',
        'tablet', 'laptop', 'desktop', 'camera',
        'leave', 'staff_transfer', 'other',
    ];
    
    /**
     * Validation តាម type
     * $p = 'rates' (update) ឬ 'datas' (store), $pos = position_ids / id_positions
     */
    private function typeRules(?string $type, string $p, string $pos): array
    {
        return match ($type) {
            'motorcycle' => [
                "$p.*.from"     => ['required', 'integer', 'min:0'],
                "$p.*.to"       => ['required', 'integer', 'min:0'],
                "$p.*.currency" => ['required', Rule::in(['USD', 'KHR'])],
                "$p.*.amount"   => ['required', 'numeric', 'min:0'],
                "$p.*.$pos"     => ['required', 'array', 'min:1'],
            ],
            'tablet' => [
                "$p.*.currency" => ['required', Rule::in(['USD', 'KHR'])],
                "$p.*.amount"   => ['required', 'numeric', 'min:0'],
            ],
            'leave' => [
                "$p.*.leave_day" => ['required', 'integer', 'min:1'],
            ],
            'staff_transfer' => [
                "$p.*.transfer_day" => ['required', 'integer'],
            ],
            default => [],
        };
    }
    
    // From Year ត្រូវតូចជាង ឬស្មើ To Year
    private function assertYearRange(array $items, string $key): void
    {
        foreach ($items as $i => $item) {
            $from = $item['from'] ?? null;
            $to   = $item['to'] ?? null;
    
            if ($from !== null && $to !== null && (int) $from > (int) $to) {
                throw ValidationValidationException::withMessages([
                    "$key.$i.to" => 'To Year must be greater than or equal to From Year.',
                ]);
            }
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
        $request->validate(['id' => 'required']);      // id = group_id
    
        try {
            $deleted = DB::transaction(function () use ($request) {
                // លុបគ្រប់ row ក្នុង group នេះ (មិនមែនតែ row ១ តាម primary key)
                // បើ model ប្រើ SoftDeletes ហើយចង់លុបពិត: ->forceDelete()
                return BundledRentalRate::where('group_id', $request->id)->delete();
            });
    
            if ($deleted === 0) {
                return $this->destroyResponse($request, 404, 'Data not found.');
            }
    
            return $this->destroyResponse($request, 200, 'Deleted successfully.');
    
        } catch (QueryException $e) {
            // ជាធម្មតា 23000 = Foreign key (group នេះកំពុងត្រូវបានប្រើនៅកន្លែងផ្សេង)
            $msg = $e->getCode() === '23000'
                ? 'Cannot delete: this data is being used.'
                : 'Delete fail.';
    
            return $this->destroyResponse($request, 409, $msg);
    
        } catch (\Throwable $e) {
            report($e);
    
            return $this->destroyResponse($request, 500, 'Delete fail.');
        }
    }
    
    // AJAX (Swal ក្នុងទំព័របញ្ជី) → JSON ; form ធម្មតា → redirect + Toastr (ដូចកូដចាស់)
    private function destroyResponse(Request $request, int $code, string $message)
    {
        if ($request->expectsJson()) {
            return response()->json(
                ['status' => $code, 'message' => $message],
                $code === 200 ? 200 : $code
            );
        }
    
        $code === 200 ? Toastr::success($message, 'Success') : Toastr::error($message, 'Error');
    
        return redirect()->back();
    }
}
