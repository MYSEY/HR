<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\User;
use App\Models\RentalBrand;
use App\Models\MotorRentel;
use Illuminate\Http\Request;
use App\Exports\ExportMotorRentel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Repositories\Admin\EmployeeRepository;
use App\Repositories\Admin\PaymentRentalRepository;
use App\Models\permissions;
use App\Models\FormRental;

// use Excel;

class MotorRentelController extends Controller
{
    private $dataMotorPays;
    public function __construct(PaymentRentalRepository $dataMotorPay)
    {
        $this->dataMotorPays = $dataMotorPay;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "motor-rentel/list")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        if ($request->ajax()) {
            $query = MotorRentel::with('user')->leftJoin('users', 'motor_rentels.employee_id', '=', 'users.id')
            ->select(
                'motor_rentels.*',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.number_employee',
                'users.branch_id',
                'users.department_id',
                'users.resign_date',
            )
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) use ($permission) {
                if ($RolePermission == 'Employee') {
                    if($permission->is_access == "1"){
                        $query->where("users.department_id", Auth::user()->department_id);
                        $query->where("users.branch_id", Auth::user()->branch_id);
                    }else{
                        $query->where('users.id',Auth::user()->id);
                    }
                }
                if ($RolePermission == 'HOD') {
                    $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
                }
                if ($RolePermission == 'BM' || $RolePermission == 'HR') {
                    $query->where("users.branch_id", Auth::user()->branch_id);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                $query->where('motor_rentels.created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('motor_rentels.created_at','<=', $to_date);
            });
               
            $searchValue = $request->input('search.value');

            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {

                    // 🔹 Search main table
                    $q->where('motor_rentels.id', 'like', "%{$searchValue}%")
                    ->orWhere('motor_rentels.start_date', 'like', "%{$searchValue}%");

                    // 🔹 Search employee
                    $q->orWhereHas('user', function ($q2) use ($searchValue) {
                        $q2->where('number_employee', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_kh', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_en', 'like', "%{$searchValue}%");
                    });
                });
            }
            $recordsTotal = (clone $query)->count();
            $recordsFiltered = $query->count();

            // Pagination
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));

            // 🔥 HANDLE "ALL"
            if ($limit == -1) {
                $data = $query->get(); // get all rows
            } else {
                $data = $query->orderBy('id', 'DESC')->offset($start)->limit($limit)->get();
            }

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        return view('motor_rentels.index', compact('permission'));
    }

    public function formCreate(Request $request) {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "motor-rentel/list")->first();
        $employees = User::whereIn("emp_status", ["Probation", "1", "2", "10",'3','4','5','6','7','8','9'])
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission)use ($permission) {
            if ($RolePermission == 'Employee') {
                if($permission->is_access == "1"){
                    $query->where("users.department_id", Auth::user()->department_id);
                    $query->where("users.branch_id", Auth::user()->branch_id);
                }else{
                    $query->where('users.id',Auth::user()->id);
                }
            }
            if ($RolePermission == 'HOD') {
                $query->whereIn("department_id", EmployeeRepository::getRoleHOD());
            }
            if ($RolePermission == 'HR') {
                $query->where("branch_id", Auth::user()->branch_id);
            }
            if ($RolePermission == 'BM') {
                $query->where("branch_id", Auth::user()->branch_id);
            }
        })
        ->get();
        if ($request->ajax()) {
            $dataForms = FormRental::where("status", 0)->with(['rentalRate', 'fields', 'createdBy'])->get();
            return response()->json([
                'dataForms' => $dataForms
            ]);
        }
        
        return view('motor_rentels.form_create', compact(['employees']));
    }

    public function formEdit(Request $request, $id) {
        $data = MotorRentel::where("id", $id)->firstOrFail();
        $employees = User::whereIn("emp_status", ["Probation", "1", "2", "10",'3','4','5','6','7','8','9'])->get();
        if ($request->ajax()) {
            return response()->json([
                'dataForms' => $data
            ]);
        }
        return view('motor_rentels.form_edit', compact('employees', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. ឆែកមើល Duplicate Employee
            $isDuplicateInDB = DB::table('motor_rentels')
                ->where('employee_id', $request->employee_id)
                ->whereNull('deleted_at')
                ->exists();

            if ($isDuplicateInDB) {
                DB::rollBack();
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'status' => 400,
                        'error' => "Duplicate Employee.",
                        'message' => "Employee នេះមានក្នុងប្រព័ន្ធរួចហើយ!"
                    ], 400);
                }
                Toastr::error('Duplicate Employee.', 'Error');
                return redirect()->back();
            }

            // 2. រៀបចំ Data សម្រាប់ Save
            $data = [
                'employee_id'       => $request->employee_id,
                'form_rental'       => json_encode($request->forms), // Encode Array forms ទៅជា JSON
                'payment_status'    => "new",
                'status'            => 1,
                'created_by'        => Auth::id(),
            ];
            $motor = MotorRentel::create($data);
            DB::commit();

            // 4. Response ត្រឡប់ទៅវិញតាម Ajax
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'រក្សាទុកទិន្នន័យបានជោគជ័យ!',
                    'data' => $motor
                ]);
            }

            Toastr::success('Data saved successfully.', 'Success');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 500,
                    'error' => $e->getMessage(),
                    'message' => 'មានបញ្ហាក្នុងការ Save ទិន្នន័យ!'
                ], 500);
            }

            Toastr::error('Something went wrong!', 'Error');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = MotorRentel::where("id", $request->id)->first();
        $employee = User::whereIn("emp_status", ["Probation", "1", "2", "10",'3','4','5','6','7','8','9'])->get();
        return response()->json([
            'success' => $data,
            'employee' => $employee,
        ]);
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        
        if (!$file) {
            return response()->json(['status' => 0, 'message' => 'សូមជ្រើសរើស File!']);
        }

        $extension = strtolower($file->getClientOriginalExtension());

        if (in_array($extension, ['xlsx', 'xls', 'csv'])) {
            $spreadsheet = IOFactory::load($file);
            $allDataInSheet = $spreadsheet->getActiveSheet()->toArray();

            $userID = Auth::id();
            $importedCount = 0;
            $failedRows = [];
            $excelEmployeeIds = []; // សម្រាប់កត់ត្រាឆែក Duplicate ក្នុង Excel Sheet ខ្លួនឯង

            foreach ($allDataInSheet as $index => $csv) {
                // រំលង Header Row (Row ទី ១)
                if ($index === 0) continue;

                $rowNum          = $index + 1;
                $employee_no     = trim($csv[0] ?? '');
                $start_date_raw  = trim($csv[1] ?? '');
                $product_year    = trim($csv[2] ?? '');
                $motor_brand     = trim($csv[3] ?? '');
                $number_plate    = trim($csv[4] ?? '');
                $category        = trim($csv[5] ?? '');
                $body_number     = trim($csv[7] ?? '');
                $engine_number   = trim($csv[8] ?? '');

                // 1. ឆែករក Employee តាម number_employee
                $employee = User::where("number_employee", $employee_no)->first();

                // 2. ឆែក Required Fields
                if (
                    empty($employee) || 
                    empty($start_date_raw) || 
                    empty($product_year) || 
                    empty($motor_brand) || 
                    empty($number_plate) || 
                    empty($category) || 
                    empty($body_number) || 
                    empty($engine_number)
                ) {
                    $reason = empty($employee) ? "រកមិនឃើញ Employee ID ក្នុងប្រព័ន្ធ" : "ខ្វះ Required Fields";
                    $failedRows[] = [
                        'row' => $rowNum,
                        'employee_no' => $employee_no ?: 'N/A',
                        'reason' => $reason
                    ];
                    continue;
                }

                // 3. ឆែក Duplicate employee_id ក្នុង Excel File ខ្លួនឯង
                if (in_array($employee->id, $excelEmployeeIds)) {
                    $failedRows[] = [
                        'row' => $rowNum,
                        'employee_no' => $employee_no,
                        'reason' => "Employee នេះមានស្ទួនក្នុង Excel File"
                    ];
                    continue;
                }

                // 4. ឆែក Duplicate employee_id ក្នុង Database (Table motor_rentels)
                $isDuplicateInDB = DB::table('motor_rentels')
                    ->where('employee_id', $employee->id)
                    ->whereNull('deleted_at')
                    ->exists();

                if ($isDuplicateInDB) {
                    $failedRows[] = [
                        'row' => $rowNum,
                        'employee_no' => $employee_no,
                        'reason' => "Employee នេះមាន Record រួចហើយក្នុងប្រព័ន្ធ (Duplicate Employee)"
                    ];
                    continue;
                }

                // 5. Format Dates
                try {
                    $start_date = Carbon::parse($start_date_raw)->format('Y-m-d');
                    $start_date_taplab = !empty($csv[9]) ? Carbon::parse($csv[9])->format('Y-m-d') : null;
                } catch (\Exception $e) {
                    $failedRows[] = [
                        'row' => $rowNum,
                        'employee_no' => $employee_no,
                        'reason' => "Format កាលបរិច្ឆេទមិនត្រឹមត្រូវ"
                    ];
                    continue;
                }

                // 6. Insert ចូល Database
                $brand = RentalBrand::where('brand_name', $motor_brand)->first() 
                        ?? RentalBrand::where('brand_name', 'Other')->first();
                                    
                $arr = [
                    'employee_id'           => $employee->id,
                    'start_date'            => $start_date,
                    'product_year'          => $product_year,
                    'motor_brand_id'        => $brand->id,
                    'motorcycle_brand'      => $brand->brand_name,
                    'number_plate'          => $number_plate,
                    'category'              => $category,
                    'motor_color'           => trim($csv[6] ?? ''),
                    'body_number'           => $body_number,
                    'engine_number'         => $engine_number,
                    'start_date_taplab'     => $start_date_taplab,
                    'taplab_rentel'         => trim($csv[10] ?? ''),
                    'taplab_imei'           => trim($csv[11] ?? ''),
                    'price_taplab_rentel'   => trim($csv[12] ?? 0),
                    'status'                => 1,
                    'created_by'            => $userID,
                    'created_at'            => Carbon::now(),
                ];

                DB::table('motor_rentels')->insert($arr);
                
                // កត់ត្រា ID ទុកឆែក Duplicate ក្នុង Excel Row បន្ទាប់ៗ
                $excelEmployeeIds[] = $employee->id;
                $importedCount++;
            }

            return response()->json([
                'status'         => 1,
                'imported_count' => $importedCount,
                'failed_rows'    => $failedRows
            ]);
        }

        return response()->json(['status' => 0, 'message' => 'ប្រភេទ File មិនត្រឹមត្រូវ!']);
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
            $id          = $request->input('id');
            $employee_id = $request->input('employee_id');
            $forms       = $request->input('forms', []);

            // 1. Check Duplicate Employee (រំលង ID ខ្លួនឯង)
            $isDuplicateInDB = DB::table('motor_rentels')
                ->where('employee_id', $employee_id)
                ->where('id', '!=', $id)
                ->whereNull('deleted_at')
                ->exists();

            if ($isDuplicateInDB) {
                // Return Response 422 សម្រាប់ AJAX (Swal.fire នឹងបង្ហាញ)
                if ($request->ajax() || $request->wantsJson() || $request->status_print) {
                    return response()->json([
                        'status'  => 422,
                        'message' => "បុគ្គលិកនេះមានក្នុងប្រព័ន្ធរួចរាល់ហើយ (Duplicate Employee)!",
                        'errors'  => ['employee_id' => ['Duplicate Employee.']]
                    ], 422);
                }
                
                Toastr::error('Duplicate Employee.', 'Error');
                return redirect()->back();
            }
            
            // 2. Find & Update Data
            $data = MotorRentel::findOrFail($id);
            $data->employee_id = $employee_id;

            // រៀបចំ JSON payload
            $data->form_rental = is_string($forms) ? $forms : json_encode($forms);
            $data->payment_status  = ($data->payment_status === 'new' || empty($data->payment_status)) ? 'new' : 'update';
            $data->updated_by  = Auth::id();
            $data->save();

            // 3. Response Processing
            $getData = MotorRentel::with('user')->find($id);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status'  => 200,
                    'success' => true,
                    'message' => 'ធ្វើបច្ចុប្បន្នភាពទិន្នន័យបានជោគជ័យ!',
                    'data'    => $getData
                ]);
            }

            if ($request->status_print) {
                return response()->json([
                    'success' => $getData,
                ]);
            }

            Toastr::success('Updated successfully.', 'Success');
            return redirect()->back();

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status'  => 500,
                    'message' => 'Updated fail: ' . $e->getMessage()
                ], 500);
            }

            Toastr::error('Updated fail.', 'Error');
            return redirect()->back();
        }
    }
   public function upload(Request $request)
    {
        // 1. Validation លើ File និង Request ID (កំណត់ 3MB = 3072 KB)
        $request->validate([
            'id'   => 'required|exists:motor_rentels,id',
            'file' => 'required|file|mimes:pdf,zip,rar,7z|max:3072', 
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // 2. បង្កើតឈ្មោះ File ថ្មីដើម្បីការពារការជាន់ឈ្មោះគ្នា
                $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

                // 3. កំណត់ Destination Path
                $destinationPath = public_path('uploads/rentalContracts');

                // 4. បង្កើត Folder បើមិនទាន់មាន
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // 5. Move File ចូលទៅក្នុង Folder ជាក់ស្តែង
                $file->move($destinationPath, $filename);

                // 6. Update ទិន្នន័យទៅក្នុង Database
                MotorRentel::where('id', $request->id)->update([
                    'contract'   => $filename,
                    'updated_by' => Auth::id(),
                    'updated_at' => now(),
                ]);

                DB::commit();

                return response()->json([
                    'status'   => 200,
                    'message'  => 'File uploaded successfully.',
                    'filename' => $filename,
                ]);
            }

            return response()->json(['message' => 'No file selected.'], 400);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 500,
                'message' => 'Upload failed.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function processing(Request $request) {
        try {
            MotorRentel::where('id',$request->id)->update([
                'status' => $request->status,
                'resigned_date' => $request->resigned_date,
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

    public function terminate(Request $request) 
    {
        // Validate Input 
        $request->validate([
            'id'             => 'required',
            'form_rental_id' => 'required',
            'terminate_date' => 'required',
        ]);

        DB::beginTransaction(); // បន្ថែម beginTransaction ដើម្បីសុវត្ថិភាព Database
        try {
            $data = MotorRentel::where('id', $request->id)->firstOrFail();
            
            // 1. Decode form_rental JSON មកជា PHP Array
            $forms = is_string($data->form_rental) ? json_decode($data->form_rental, true) : $data->form_rental;

            if (!is_array($forms)) {
                $forms = [];
            }

            // 2. Loop រក form_rental_id ដែលត្រូវគ្នា រួច Append/Update terminate_date
            foreach ($forms as $key => $form) {
                if (isset($form['form_rental_id']) && $form['form_rental_id'] == $request->form_rental_id) {
                    $forms[$key]['terminate_date'] = $request->terminate_date;
                    $forms[$key]['status'] = 'terminated'; // (Optional) បន្ថែម status បញ្ជាក់ថាឈប់ជួល
                    break;
                }
            }

            // 3. Encode និង រក្សាទុកចូល Column form_rental
            $data->form_rental = json_encode($forms);
            $data->updated_by  = Auth::id();
            $data->save();

            DB::commit();

            return response()->json([
                'status'  => 200,
                'message' => 'The process has been completed successfully.'
            ]);

        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json([
                'status'  => 500,
                'message' => 'Error: ' . $exp->getMessage()
            ], 500);
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
            MotorRentel::destroy($request->id);
            Toastr::success('Deleted successfully.', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Delete fail.', 'Error');
            return redirect()->back();
        }
    }
}
