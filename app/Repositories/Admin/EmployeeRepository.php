<?php

namespace App\Repositories\Admin;

use Carbon\Carbon;
use App\Models\StaffTraining;
use App\Models\Employee;
use App\Models\Education;
use App\Models\Experience;
use App\Models\StaffPromoted;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use App\Traits\UploadFiles\UploadFIle;

class EmployeeRepository extends BaseRepository
{
    use UploadFIle;
    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Employee::class;
    }
    public function updateOrCreateEducation($entry, $request)
    {
        dd($request);
        // try {
            Education::where('employee_id', $entry->id)->delete();
            $schools = $request->school;
            if (is_array($schools) && count($schools)) {
                foreach ($schools as $key => $school) :
                    if (!empty($school)) :
                        Education::create([
                            'employee_id'       => $entry->id,
                            'school'            => $school ?? '',
                            'field_of_study'    => $request->field_of_study[$key] ?? '',
                            'degree'            => $request->degree[$key] ?? '',
                            'grade'             => $request->grade[$key] ?? '',
                            'description'       => $request->education_description[$key] ?? '',
                            'end_date'          => !empty($request->education_end_date[$key]) ? Carbon::parse($request->education_end_date[$key])->format('Y-m-d') : '',
                            'start_date'        => !empty($request->education_start_date[$key]) ? Carbon::parse($request->education_start_date[$key])->format('Y-m-d') : '',
                            'updated_by'        => Auth::id(),
                        ]);
                    endif;
                endforeach;
            }
        // } catch (\Exception $exp) {
        //     /*
        //     * ERROR
        //     */
        // }
    }
    
    public function updateOrCreateExperience($entry, $request)
    {
        try {
            Experience::where('employee_id', $entry->id)->delete();
            $titles = $request->title;
            if (is_array($titles) && count($titles)) {
                foreach ($titles as $key => $title) :
                    if (!empty($title)) :
                        Experience::updateOrCreate([
                            'employee_id'       => $entry->id,
                            'title'             => $title ?? '',
                            'employment_type'   => $request->employment_type[$key] ?? '',
                            'company_name'      => $request->company_name[$key] ?? '',
                            'location'          => $request->location[$key] ?? '',
                            'description'       => $request->description[$key] ?? '',
                            'start_date'        => !empty($request->start_date[$key]) ? Carbon::parse($request->start_date[$key])->format('Y-m-d') : '',
                            'end_date'          => !empty($request->end_date[$key]) ? Carbon::parse($request->end_date[$key])->format('Y-m-d') : '',
                            'updated_by'        => Auth::id(),
                        ]);
                    endif;
                endforeach;
            }
        } catch (\Exception $exp) {
            /*
            * ERROR
            */
        }
    }

    public function trainingRepoUpdateOrCreate($entry, $request){
        try {
            StaffTraining::where('employee_id', $entry->id)->delete();
            $data = $request->title;
            if (is_array($data) && count($data)) {
                foreach ($data as $key => $item) :
                    if (!empty($item)) :
                        StaffTraining::updateOrCreate([
                            'employee_id'   => $entry->id,
                        ],[
                            'employee_id'   => $entry->id,
                            'title'         => $request->title[$key] ?? '',
                            'start_date'    => $request->start_date[$key] ?? '',
                            'end_date'      => $request->end_date[$key] ?? '',
                            'updated_by'    => Auth::id(),
                        ]);
                    endif;
                endforeach;
            }
        } catch (\Exception $exp) {
            /*
            * ERROR
            */
        }
    }
    public function StaffPromotedRepoUpdateOrCreate($entry, $request){
        try {
            StaffPromoted::create([
                'employee_id'   => $entry->id,
                'posit_id'      => $request->posit_id,
                'depart_id'     => $request->depart_id,
                'date'          => $request->date,
                'updated_by'    => Auth::id(),
            ]);
        } catch (\Exception $exp) {
            /*
            * ERROR
            */
        }
    }

    public function updatedOrcreateFdcOrUdc($entry,$request){
        try {
            if($request->fixed_dura_con_type == 'fdc'){
                Employee::where('id',$entry->id)->update([
                    'fixed_dura_con_type'   => $request->fixed_dura_con_type,
                    'fdc_date'              => $request->fdc_date,
                    'fdc_end'               => $request->fdc_end
                ]);
            }else{
                Employee::where('id',$entry->id)->update([
                    'fixed_dura_con_type'   => $request->fixed_dura_con_type,
                    'fdc_date'              => '',
                    'fdc_end'               => ''
                ]);
            }
        } catch (\Exception $exp) {
            /*
            * ERROR
            */
        }
    }
}