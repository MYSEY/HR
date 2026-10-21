<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\BundledRentalRate;
use App\Models\FormRental;
use App\Models\RentalBrand;
use App\Models\FormRentalField;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class FormRentalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "bundled-rental-rate")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        if ($request->ajax()) {
            $baseQuery = FormRental::query();
            $recordsTotal = $baseQuery->count();
            $query = FormRental::with(['rentalRate', 'createdBy']);

            $searchValue = $request->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('title', 'like', "%{$searchValue}%")
                    ->orWhere('type', 'like', "%{$searchValue}%");

                    $q->orWhereHas('rentalRate', function ($rQuery) use ($searchValue) {
                        $rQuery->where('name', 'like', "%{$searchValue}%");
                    });

                    $q->orWhereHas('createdBy', function ($uQuery) use ($searchValue) {
                        $uQuery->where('employee_name_en', 'like', "%{$searchValue}%")
                                ->orWhere('employee_name_kh', 'like', "%{$searchValue}%");
                    });
                });
            }

            $recordsFiltered = $query->count();

            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));

            if ($limit == -1) {
                $data = $query->orderBy('id', 'DESC')->get();
            } else {
                $data = $query->orderBy('id', 'DESC')
                            ->offset($start)
                            ->limit($limit)
                            ->get();
            }

            return response()->json([
                'draw'            => intval($request->input('draw')),
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $data
            ]);
        }
        $subQuery = BundledRentalRate::selectRaw('MIN(id) as id')
        ->whereNotIn("type", ['leave','staff_transfer','other'])
        ->whereNotNull('group_id')
        ->groupBy('group_id');
        $bundledRentals = BundledRentalRate::whereIn('id', $subQuery)
        ->get();
        $motorBrands = RentalBrand::orderBy('id', 'desc')->get();
        return view('form_rentals.index', compact(['permission','bundledRentals','motorBrands']));
    }

    public function formCreate() {
        $subQuery = BundledRentalRate::selectRaw('MIN(id) as id')
        ->whereNotNull('group_id')
        ->groupBy('group_id');
        $bundledRentals = BundledRentalRate::whereIn('id', $subQuery)
        ->get();
        $motorBrands = RentalBrand::orderBy('id', 'desc')->get();
        return view('form_rentals.form_create', compact(['bundledRentals','motorBrands']));
    }
    public function formEdit($id) {
        $subQuery = BundledRentalRate::selectRaw('MIN(id) as id')
        ->whereNotNull('group_id')
        ->groupBy('group_id');
        $bundledRentals = BundledRentalRate::whereIn('id', $subQuery)
        ->get();
        $motorBrands = RentalBrand::orderBy('id', 'desc')->get();
        $data = FormRental::where("id", $id)->with(['rentalRate', 'fields', 'createdBy'])->first();

        return view('form_rentals.form_edit', compact(['data','bundledRentals','motorBrands']));
    }
    public function formView(Request $request) {
        $data = FormRental::where("id", $request->id)->with(['rentalRate', 'fields', 'createdBy'])->first();
        if (!$data) {
            return response()->json(['status' => 404, 'message' => 'Form not found'], 404);
        }

        return response()->json([
            'status' => 200,
            'data'   => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'               => 'required|string',
            'condition_id'        => 'required|integer',
            'datas'               => 'required|array|min:1',
            'datas.*.field_label' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $title = trim($request->title);
            $duplicateErrors = [];

            // ១. Query ឆែក Title ស្ទួន (Query លើកទី ១)
            if (FormRental::where('title', $title)->exists()) {
                $duplicateErrors[] = "Form name: [{$title}] មានក្នុងប្រព័ន្ធរួចហើយ!";
            }

            // ២. រៀបចំ array labels & ឆែក In-Request Duplicate ក្នុង Memory (គ្មាន Query ទេ)
            $inputLabels = [];
            foreach ($request->datas as $value) {
                $label = trim($value['field_label']);
                if (in_array($label, $inputLabels)) {
                    $duplicateErrors[] = "Label: [{$label}] មានស្ទួនគ្នាក្នុង Form នេះ!";
                } else {
                    $inputLabels[] = $label;
                }
            }

            // ៣. បើមាន Error Title ឬ In-Request Label គឺ Stop ភ្លាម (មិនទាន់ប៉ះ Child DB ទេ)
            if (!empty($duplicateErrors)) {
                DB::rollback();
                return response()->json(['status' => 422, 'message' => implode('<br>', array_unique($duplicateErrors))], 422);
            }

            // ៤. Create Parent Record
            $formRental = FormRental::create([
                'title'             => $title,
                'rental_rates_id'   => $request->condition_id,
                'type'              => $request->type,
                'status'            => 0,
                'created_by'        => Auth::id(),
            ]);

            // ៥. Query ឆែក Label ស្ទួនក្នុង DB ជាមួយ Form ID តែម្តងគត់ ដោយប្រើ whereIn (Query លើកទី ២)
            $existingLabels = FormRentalField::where('form_rental_id', $formRental->id)
                ->whereIn('field_label', $inputLabels)
                ->pluck('field_label')
                ->toArray();

            if (!empty($existingLabels)) {
                DB::rollback(); // Rollback FormRental វិញភ្លាម
                foreach ($existingLabels as $existLabel) {
                    $duplicateErrors[] = "Label: [{$existLabel}] មានរួចហើយក្នុង Form នេះ!";
                }
                return response()->json(['status' => 422, 'message' => implode('<br>', $duplicateErrors)], 422);
            }

            $insertData = array_map(function ($value) use ($formRental) {
                $options = isset($value['option']) ? $value['option'] : (isset($value['options']) ? $value['options'] : null);
                return [
                    'form_rental_id' => $formRental->id,
                    'field_label'    => trim($value['field_label']),
                    'field_type'     => $value['field_type'],
                    'is_required'    => $value['is_required'],
                    'is_condition'   => $value['is_condition'],
                    'options'        => !empty($options) ? json_encode($options) : null,
                ];
            }, $request->datas);
            FormRentalField::insert($insertData);

            DB::commit();

            return response()->json([
                'status'  => 200, 
                'message' => __('lang.created_successfully') ?? 'Created successfully.'
            ]);

        } catch (\Throwable $exp) {
            DB::rollback();
            return response()->json(['status' => 500, 'message' => $exp->getMessage()], 500);
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
        $request->validate([
            'form_rental_id'      => 'required|integer|exists:form_rentals,id',
            'field_tile'          => 'required|string',
            'rental_rates_id'     => 'required|integer',
            'field_label'         => 'required|array|min:1',
            'field_label.*'       => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $formRentalId = $request->form_rental_id;
            $title        = trim($request->field_tile);
            $duplicateErrors = [];

            // ១. ឆែកស្ទួន Title ក្នុង Table form_rentals (លើកលែង ID ខ្លួនឯង)
            $isTitleDuplicate = FormRental::where('title', $title)
                ->where('id', '!=', $formRentalId)
                ->exists();

            if ($isTitleDuplicate) {
                $duplicateErrors[] = "Title: [{$title}] មានក្នុងប្រព័ន្ធរួចហើយ!";
            }

            // ២. ឆែកស្ទួន In-Request Field Labels ក្នុង Form
            $inputLabels = [];
            foreach ($request->field_label as $index => $labelVal) {
                $cleanLabel = trim($labelVal);
                if (in_array($cleanLabel, $inputLabels)) {
                    $duplicateErrors[] = "Label: [{$cleanLabel}] មានស្ទួនគ្នាក្នុង Form នេះ!";
                } else {
                    $inputLabels[] = $cleanLabel;
                }
            }

            // ប្រសិនបើមាន Duplicate Title ឬ In-Request Label គឺ Stop ភ្លាមៗ
            if (!empty($duplicateErrors)) {
                DB::rollback();
                return response()->json([
                    'status'  => 422,
                    'message' => implode('<br>', array_unique($duplicateErrors))
                ], 422);
            }

            // ៣. Update Parent Record (FormRental)
            $formRental = FormRental::findOrFail($formRentalId);
            $formRental->update([
                'title'           => $title,
                'rental_rates_id' => $request->rental_rates_id,
                'type'            => $request->type,
                'updated_by'      => Auth::id(),
            ]);

            // ៤. គ្រប់គ្រង Child Records (FormRentalField Syncing)
            $submittedFieldIds = array_filter($request->field_id ?? []); // ID ទាំងអស់ដែលផ្ញើមកពី Form
            $now = now();

            // ក. លុប Field ណាដែល User បានលុបចេញពី UI (គ្មានក្នុង $submittedFieldIds)
            FormRentalField::where('form_rental_id', $formRentalId)
                ->whereNotIn('id', $submittedFieldIds)
                ->delete();

            // ខ. Loop Update ឬ Create លើ Child Fields
            foreach ($request->field_label as $i => $labelValue) {
                $fieldId     = $request->field_id[$i] ?? null;
                $fieldLabel  = trim($labelValue);
                $fieldType   = $request->field_type[$i] ?? 'text';
                $isRequired  = $request->is_required[$i] ?? 'no';
                $isCondition = $request->is_condition[$i] ?? 'no';

                // ចាប់យកតម្លៃ option តាម index
                $rawOptions = $request->option[$i] ?? ($request->options[$i] ?? null);
                $jsonOptions = !empty($rawOptions) ? json_encode($rawOptions) : null;

                if (!empty($fieldId)) {
                    // Update Field ដែលមានស្រាប់
                    FormRentalField::where('id', $fieldId)
                        ->where('form_rental_id', $formRentalId)
                        ->update([
                            'field_label'  => $fieldLabel,
                            'field_type'   => $fieldType,
                            'is_required'  => $isRequired,
                            'is_condition' => $isCondition,
                            'options'      => $jsonOptions,
                        ]);
                } else {
                    // Insert Field ថ្មីដែលបន្ថែមតាមរយៈ #btnAddMore
                    FormRentalField::create([
                        'form_rental_id' => $formRentalId,
                        'field_label'    => $fieldLabel,
                        'field_type'     => $fieldType,
                        'is_required'    => $isRequired,
                        'is_condition'   => $isCondition,
                        'options'        => $jsonOptions,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status'  => 200,
                'message' => __('lang.updated_successfully') ?? 'Updated successfully.'
            ]);

        } catch (\Throwable $exp) {
            DB::rollback();
            return response()->json(['status' => 500, 'message' => $exp->getMessage()], 500);
        }
    }

    public function processing(Request $request) {
        try {
            FormRental::where('id',$request->id)->update([
                'status' => $request->status,
                'updated_by'      => Auth::id(),
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
        try {
            FormRental::destroy($request->id);
            Toastr::success('Deleted successfully.', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Delete fail.', 'Error');
            return redirect()->back();
        }
    }
}
