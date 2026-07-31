@extends('layouts.master')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.staff_information')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.staff_information')</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
            </div>
            <div class="col-auto float-end ms-auto">
                <div class="btn-group btn-group-sm">
                    @if (permissionAccess("m3-s1","is_print")->value == "1" || permissionAccess("m2-s1","is_print")->value == "1")
                        @if (permissionAccess("m3-s1","is_view")->value == "1")
                            <a class="btn btn-white m-1" href="{{url('/recruitment/candidate-resume/list')}}">@lang('lang.back_to_recruitment')</a>
                        @endif
                        <a class="btn btn-white m-1" href="{{url('/users')}}">@lang('lang.back_to_employee')</a>
                        {{-- <a class="btn btn-white m-1" onclick="downloadWordBlicklistAgreement()">ទាញយកជា Word</a> --}}
                        <div class="dropdown action-label" style="margin-top: 3px;">
                            <a class="btn btn-white btn-sm dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-print fa-lg"></i> @lang('lang.print')
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" style="">
                                {{-- *** Recruitment Print ***--}}
                                @if (permissionAccess("m3-s1","is_print")->value == "1")
                                    <a class="dropdown-item btn-print" href="#" id="btn_print_signed_contract" data-signed-contract="signed contract" data-id="{{$data->id}}">@lang('lang.probation_contract')</a>
                                    <a class="dropdown-item btn-print" href="#" id="btn_contract_volunteer" data-signed-contract="contract volunteer" data-id="{{$data->id}}">Contract Volunteer</a>
                                    <a class="dropdown-item btn-print" href="#" id="btn_blacklist_agreement" data-signed-contract="blacklist agreement" data-id="{{$data->id}}">Blacklist Agreement</a>
                                    <a class="dropdown-item btn-print" href="#" id="btn_confidential_letter" data-signed-contract="confildetail letter" data-id="{{$data->id}}">Confidential Letter</a>
                                    <a class="dropdown-item btn-print" href="#" id="btn_appointed_letter" data-signed-contract="appointed letter" data-id="{{$data->id}}">Appointed Letter</a>
                                    <a class="dropdown-item btn-print" href="#" id="btn_appointment_resolution" data-signed-contract="Appointment Resolution" data-id="{{$data->id}}">Appointment Resolution</a>
                                    <a class="dropdown-item btn-print" href="#" id="btn_code_conduction_agreement" data-signed-contract="code conduction agreement" data-id="{{$data->id}}">Code Conduction Agreement</a>
                                @endif
                                {{-- *** HR Print ***--}}
                                @if (permissionAccess("m2-s1","is_print")->value == "1")
                                <a class="dropdown-item btn-print" href="#" id="btn_complete_probation" data-signed-contract="complete probation" data-id="{{$data->id}}">Complete Probation</a>
                                    <a class="dropdown-item btn-print" href="#" id="btn_print_contract" data-signed-contract="contract" data-id="{{$data->id}}">@lang('lang.fdc_contract')</a>
                                    <a class="dropdown-item btn_certificate" href="#" id="btn_employment_certificate" data-signed-contract="Employment Certificate NSSF" data-id="{{$data->id}}">Employment Certificate NSSF</a>
                                    <a class="dropdown-item btn_certificate" href="#" id="btn_employment_certificate_form" data-signed-contract="Employment Cerntificate Form" data-id="{{$data->id}}">Employment Cerntificate Form</a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h3 class="card-title">@lang('lang.personal_informations')</h3>
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.name')(@lang('lang.kh'))</a>
                                <div class="s-personal">{{ $data->employee_name_kh}}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.name')(@lang('lang.en'))</a>
                                <div class="s-personal">{{ $data->employee_name_en}}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.employee_id')</a>
                                <div class="s-personal">{{ $data->number_employee }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.date_of_birth')</a>
                                <div class="s-personal">{{ \Carbon\Carbon::parse($data->date_of_birth)->format('d-M-Y') ?? '' }}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.gender')</a>
                                <div class="s-personal">{{$data->EmployeeGender}}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.id_card_number')</a>
                                <div class="s-personal">{{$data->id_card_number}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.department')</a>
                                <div class="s-personal">{{ $data->EmployeeDepartment }}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.position')</a>
                                <div class="s-personal">{{$data->EmployeePosition}}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.branch')</a>
                                <div class="s-personal">{{$data->EmployeeBranch}}</div>
                            </div>
                        </div>
                    </div>
                    {{-- @dd($data) --}}
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.basic_salary')</a>
                                <div class="s-personal">${{ $data->basic_salary }}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.salary_increase')</a>
                                <div class="s-personal">${{$data->salary_increas}}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.phone_allowance')</a>
                                <div class="s-personal">${{$data->phone_allowance}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.join_date')</a>
                                <div class="s-personal">{{ $data->joinOfDate }}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.fdc_start_date')</a>
                                <div class="s-personal">{{ Carbon\Carbon::parse($data->fdc_date)->format('d-M-Y')}}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.contract_deadline')</a>
                                <div class="s-personal">{{Carbon\Carbon::parse($data->fdc_end)->format('d-M-Y')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.province/city')</a>
                                <div class="s-personal">{{ $data->FullNameProvince }}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.unit')</a>
                                <div class="s-personal">{{$data->unit}}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.level')</a>
                                <div class="s-personal">{{$data->level}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.identity_type')</a>
                                <div class="s-personal">{{ $data->EmployeeIdentityType }}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.identity_number')</a>
                                <div class="s-personal">{{$data->identity_number}}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.issue_date')</a>
                                <div class="s-personal">{{\Carbon\Carbon::parse($data->issue_date)->format('d-M-Y') ?? ''}}</div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.join_date')</a>
                                <div class="s-personal">{{ $data->joinOfDate }}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.nationality')</a>
                                <div class="s-personal">{{$data->EmployeeNationality}}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.ethnicity')</a>
                                <div class="s-personal">{{$data->ethnicity}}</div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.issue_expired_date')</a>
                                <div class="s-personal">{{ \Carbon\Carbon::parse($data->issue_expired_date)->format('d-M-Y') ?? '' }}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.marital_status')</a>
                                <div class="s-personal">{{$data->EmployeeMaritalStatus}}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.loan')</a>
                                <div class="s-personal">
                                    @if ($data->is_loan == '1')
                                        <span style="font-size: 13px" class="badge bg-inverse-danger">Yes</span>
                                    @elseif($data->is_loan == '0')
                                        <span style="font-size: 13px" class="badge bg-inverse-success">No</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.personal_phone')</a>
                                <div class="s-personal">{{$data->personal_phone_number}}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.company_phone_number')</a>
                                <div class="s-personal">{{$data->company_phone_number}}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.email')</a>
                                <div class="s-personal">{{ $data->email }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.bank_name')</a>
                                <div class="s-personal">{{$data->banks == null ? "" : $data->banks->name }}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.bank_account_no')</a>
                                <div class="s-personal">{{$data->account_number}}</div>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="mb-3">
                                <a href="#">@lang('lang.account_name')</a>
                                <div class="s-personal">{{ $data->account_name }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-8">
                            <div class="mb-3">
                                <a href="#">@lang('lang.current_address')</a>
                                <div class="s-personal">{{$data->FullCurrentAddress ?? ''}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="add_select" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label>@lang('lang.select') <span class="text-danger">*</span></label>
                            <select class="form-control select floating" id="management_name" name="management_name" required value="{{old('position_range')}}">
                                <option selected disabled> --@lang('lang.select')--</option>
                                @foreach ($dataManagement as $item)
                                    <option data-position="{{$item->position ? $item->position->name_khmer : ""}}" data-datas="{{$item}}" value="{{$item->employee_name_kh}}">{{Helper::getLang() == 'en' ? $item->employee_name_en : $item->employee_name_kh}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="" hidden id="add_select_id">
                        <div class="submit-section">
                            <button type="button" class="btn btn-primary print-btn">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-txt">@lang('lang.print')</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('components.loading-modal')
    @include('recruitments.candidate_resumes.prints.signed_contract')
    @include('recruitments.candidate_resumes.prints.contract')
    @include('recruitments.candidate_resumes.prints.appointed_letter')
    @include('recruitments.candidate_resumes.prints.appointment_resolution')
    @include('recruitments.candidate_resumes.prints.complete_probation')
    @include('recruitments.candidate_resumes.prints.contract_volunteer')
    @include('recruitments.candidate_resumes.prints.confidential_letter')
    @include('recruitments.candidate_resumes.prints.code_conduct_agreement')
    @include('recruitments.candidate_resumes.prints.blacklist_agreement')
    @include('recruitments.candidate_resumes.prints.Employment_Certificate_NSSF')
    @include('recruitments.candidate_resumes.prints.employment_certificate_form')
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>
<script src="{{asset('/admin/js/format-date-kh.js')}}"></script>
<script type="text/javascript">
    $(function() {
        $(".btn-print").on("click", function(){
            $('#modal-loading').modal('show');
            let id = $(this).data("id");
            let signed_contract = $(this).attr('data-signed-contract');
            printSignContract(id,signed_contract);
        });
        $('.btn_certificate').on('click', function(){
            let id = $(this).data("id");
            let printBy  = $(this).attr('data-signed-contract');
            $(".print-btn").data("print", printBy);
            $("#add_select_id").val(id);
            $('#add_select').modal('show');
        });
        $(".print-btn").on("click", function () {
            $('#modal-loading').modal('show');
            let form  = $(this).data('print');
            let data_management = $("#management_name option:selected").data("datas");
            let employee_gender = data_management.gender;
            $("#gender_male").text("");
            $("#gender_female").text("");
            if (employee_gender && (employee_gender.name_english === "Male" || employee_gender.name_khmer === "ប្រុស")) {
                $("#gender_male").text("✓");
            } else if (employee_gender && (employee_gender.name_english === "Female" || employee_gender.name_khmer === "ស្រី")) {
                $("#gender_female").text("✓");
            }
            
            $(".management_name_print").text(data_management.employee_name_kh);
            $(".management_name_en_print").text(data_management.employee_name_en);
            $(".management_position_print").text(data_management.position.name_khmer);
            printSignContract($("#add_select_id").val(),form);
        });
    });

    function printSignContract(id,signed_contract){
        $.ajax({
            type: "GET",
            url: "{{url('users/print')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                id : id
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.success;
                console.log("data: ", data);
                                
                var branch = response.branch;
                var date_of_birth = new Date(data.date_of_birth);
                var date_of_commencement = new Date(data.date_of_commencement);

                var fdc_date = new Date(data.fdc_date);
                fdc_date.setDate(fdc_date.getDate() - 1);
                fdc_date = new Date(fdc_date);

                var start_fdc_date = new Date(data.fdc_date);
                var contract_date = new Date(data.recruitment.contract_date);
                start_fdc_date.setDate(start_fdc_date.getDate());
                start_fdc_date = new Date(start_fdc_date);
                var fdc_end = new Date(data.fdc_end);
                fdc_end.setDate(fdc_end.getDate());
                fdc_end = new Date(fdc_end);

                let day = formatDate(date_of_birth, 'km', format_date={day: true});
                let month = formatDate(date_of_birth, 'km', format_date={month: true});
                let year = formatDate(date_of_birth, 'km', format_date={year: true});
                let join_day = formatDate(date_of_commencement, 'km', format_date={day: true});
                let join_month = formatDate(date_of_commencement, 'km', format_date={month: true});
                let join_year = formatDate(date_of_commencement, 'km', format_date={year: true});

                let start_fdc_day = formatDate(start_fdc_date, 'km', format_date={day: true});
                let start_fdc_month = formatDate(start_fdc_date, 'km', format_date={month: true});
                let start_fdc_year = formatDate(start_fdc_date, 'km', format_date={year: true});   

                let fdc_end_day = formatDate(fdc_end, 'km', format_date={day: true});
                let fdc_end_month = formatDate(fdc_end, 'km', format_date={month: true});
                let fdc_end_year = formatDate(fdc_end, 'km', format_date={year: true});  
                
                let end_day = formatDate(fdc_date, 'km', format_date={day: true});
                let end_month = formatDate(fdc_date, 'km', format_date={month: true});
                let end_year = formatDate(fdc_date, 'km', format_date={year: true}); 

                let pr_contract_day = formatDate(contract_date, 'km', format_date={day: true});
                let pr_contract_month = formatDate(contract_date, 'km', format_date={month: true});
                let pr_contract_year = formatDate(contract_date, 'km', format_date={year: true}); 

                $(".pr_contract_day").text(pr_contract_day);
                $(".pr_contract_month").text(pr_contract_month);
                $(".pr_contract_year").text(pr_contract_year);
                
                if (data) {
                    $("#pr_status_single").text(" ");
                    $("#pr_status_married").text(" ");
                    if (data.employee_marital_status == "Single") {
                        $("#pr_status_single").text("✓");
                    }
                    if (data.employee_marital_status == "Married") {
                        $("#pr_status_married").text("✓");
                    }
                    
                    if (data.gender.name_english == "Female") {
                        $("#gender_female_staff").text("✓");
                        $(".pr_mr_or_mrs").text("អ្នកស្រី ");
                        if (data.employee_marital_status == "Single") {
                            $(".pr_mr_or_mrs").text("កញ្ញា ");
                        }
                        $(".pr_gender").text("ស្រី ");
                    }else{
                        $("#gender_male_staff").text("✓");
                        $(".pr_mr_or_mrs").text("លោក ");
                        $(".pr_gender").text("ប្រុស ");
                    }
                    $(".pr_ceo").text(branch.employee_name_kh);
                    $(".pr_ceo_position").text(branch.name_khmer);
                    $(".pr_position").text(data.position.name_khmer);
                    $(".level").text(data.level);
                    $(".line_manager").text(data.line_manager != null ? data.line_manager.employee_name_kh : "");
                    $(".pr_line_manager_position").text(data.line_manager != null ? data.line_manager.position.name_khmer:"");
                    $(".pr_name").text(data.employee_name_kh +" ");
                    $(".pr_name_en").text(data.employee_name_en +" ");
                    $(".pr_born_on").text(day+" ខែ "+month+" ឆ្នាំ "+ year);
                    $(".pr_birth_day").text(day);
                    $(".pr_birth_month").text(month);
                    $(".pr_birth_year").text(year);
                    let location_permanent = " ភូមិ "+data.permanentvillage.name_km + " ឃុំ/សង្កាត់ " + data.permanentcommune.name_km + " ស្រុក/ខណ្ឌ " + data.permanentdistrict.name_km+ " ខេត្ត/ក្រុង "+data.permanentprovince.name_km;
                    $(".pr_permanent_province").text(location_permanent + " ");
                    $(".pr_id_card_number").text(data.id_card_number+ "");
                    let number_home = "";
                    let number_street = "";
                    if (data.current_house_no) {
                        number_home = "ផ្ទះលេខ "+ data.current_house_no;
                    }
                    if (data.current_street_no) {
                        number_street = " ផ្លូវលេខ "+data.current_street_no;
                    }
                    let currentvillage_name = data.currentvillage ? data.currentvillage.name_km : "";
                    let currentcommune_name = data.currentcommune ? data.currentcommune.name_km : "";
                    let currentdistrict_name = data.currentdistrict ? data.currentdistrict.name_km : "";
                    let currentprovince_name = data.currentprovince ? data.currentprovince.name_km : "";
                    let location = number_home + number_street + " ភូមិ "+currentvillage_name + " ឃុំ/សង្កាត់ " + currentcommune_name + " ស្រុក/ខណ្ឌ " + currentdistrict_name+ " ខេត្ត/ក្រុង "+currentprovince_name;
                    
                    $(".pr_number_home").text(number_home);
                    $(".pr_number_street").text(number_street);
                    $(".pr_currentvillage_name").text(currentvillage_name);
                    $(".pr_currentcommune_name").text(currentcommune_name);
                    $(".pr_currentdistrict_name").text(currentdistrict_name);
                    $(".pr_currentprovince_name").text(currentprovince_name);

                    $(".pr_current_location").text(location);
                    $(".pr_personal_phone_number").text(data.personal_phone_number);
                    $(".pr_join_day").text(join_day);
                    $(".pr_join_month").text(join_month);
                    $(".pr_join_year").text(join_year);
                    $(".pr_end_day").text(end_day);
                    $(".pr_end_month").text(end_month);
                    $(".pr_end_year").text(end_year);

                    $(".pr_fdc_day").text(start_fdc_day);
                    $(".pr_fdc_month").text(start_fdc_month);
                    $(".pr_fdc_year").text(start_fdc_year);

                    $(".pr_fdc_end_day").text(fdc_end_day);
                    $(".pr_fdc_end_month").text(fdc_end_month);
                    $(".pr_fdc_end_year").text(fdc_end_year);

                    $(".pr_branch").text(data.branch.branch_name_kh);
                    $(".pr_employee_id").text(data.number_employee);
                    $(".pr_basic_salary").text(data.basic_salary);
                    $(".pr_basic_salary").text(data.basic_salary);
                    $(".pr_salary_increase").text(data.salary_increas);
                    if (data.recruitment && data.recruitment.pro_rate == "1") {
                        $("#pr_supporting_or_field_staff").text("ដោយធៀបនឹងភាគរយការងារសម្រេចបានសម្រាប់បុគ្គលិកឥណទាន (គិតតាម Pro-Rate)");
                    }else{
                        $("#pr_supporting_or_field_staff").text("");
                    }
                    if (data.recruitment && data.recruitment.condition_other == "1") {
                        $(".Responsible-Lending").css("display","block");
                    }else{
                        $(".Responsible-Lending").css("display","none");
                    }
                    if (signed_contract=='signed contract') {
                        stylePrintSignContract();
                    } else if(signed_contract == 'contract') {
                        stylePrintContract();
                    }else if(signed_contract == 'appointed letter'){
                        stylePrintAppointedLetter();
                    }else if(signed_contract=='Appointment Resolution'){
                        styleAppointmentResolution();
                    }else if(signed_contract == 'complete probation'){
                        stylePrintCompleteProbation();
                    }else if(signed_contract == 'contract volunteer'){
                        styleContractVolunteer();
                    }else if(signed_contract == 'confildetail letter'){
                        styleConfidentialLetter();
                    }else if(signed_contract == 'code conduction agreement'){
                        styleCodeConductionAgreement();
                    }else if(signed_contract =="Employment Certificate NSSF"){
                        styleEmploymentCertificateNSSF();
                    }else if(signed_contract =="Employment Cerntificate Form"){
                        styleCerntificateForm();
                    }else{
                        styleBlicklistAgreement();
                    }
                    $('#add_select').modal('hide');
                    window.setTimeout(function() {
                        $('#modal-loading').modal('hide');
                    }, 2000);
                }
            }
        });
    }
    
    //style print
    function stylePrintSignContract() {
        $("#print_sign_contract").show();
        $("#print_sign_contract").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_table.css')}}",
            header: "",
            printDelay: 2000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
    function stylePrintContract() {
        $("#print_contract").show();
        $("#print_contract").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_table.css')}}",
            header: "",
            printDelay: 2000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
    function stylePrintAppointedLetter() {
        $("#print_appointed_letter").show();
        $("#print_appointed_letter").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_print_oppointed_letter.css')}}",
            header: "",
            printDelay: 2000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
    function styleAppointmentResolution(){
        $("#print_appointment_resolution").show();
        $("#print_appointment_resolution").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_print_oppointed_letter.css')}}",
            header: "",
            printDelay: 2000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
    function stylePrintCompleteProbation() {
        $("#print_complete_probation").show();
        $("#print_complete_probation").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_print_oppointed_letter.css')}}",
            header: "",
            printDelay: 2000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
    function styleContractVolunteer() {
        $("#print_contract_volunteer").show();
        $("#print_contract_volunteer").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_contract_volunteer_table.css')}}",
            header: "",
            printDelay: 2000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
    function styleConfidentialLetter() {
        $("#print_confidential_letter").show();
        $("#print_confidential_letter").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_table.css')}}",
            header: "",
            printDelay: 2000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
     function styleCodeConductionAgreement() {
        $("#print_code_conduct_agreement").show();
        $("#print_code_conduct_agreement").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_table.css')}}",
            header: "",
            printDelay: 2000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
    function styleBlicklistAgreement() {
        $("#print_blicklist_agreement").show();
        $("#print_blicklist_agreement").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_table.css')}}",
            header: "",
            printDelay: 2000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
    function styleEmploymentCertificateNSSF() {
        $(".print_employment_certificate").show();
        $(".print_employment_certificate").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/employment-certificate-NSSF.css')}}",
            header: "",
            printDelay: 2000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
    function styleCerntificateForm() {
        $("#print_cerntificate_form").show();
        $("#print_cerntificate_form").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/employment-certificate-form.css')}}",
            header: "",
            printDelay: 2000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
    // function downloadWordBlicklistAgreement() {
    //     // បង្ហាញ Div សិនដើម្បីឱ្យ JavaScript ចាប់យកទិន្នន័យដែលមានតម្លៃ Dynamic បានពេញលេញ
    //     $("#print_blicklist_agreement").show();

    //     // ចាប់យក Content HTML ទាំងអស់នៅក្នុង Div នោះ
    //     var contentHtml = document.getElementById("print_blicklist_agreement").innerHTML;

    //     // រៀបចំ Template សម្រាប់ Microsoft Word (អាន Font ខ្មែរ និងកំណត់ទំហំក្រដាស A4)
    //     var wordTemplate = `
            
    //         ${contentHtml}
    //     `;

    //     // បង្កើត Blob Object ក្នុងទម្រង់ MIME type របស់ MS-Word
    //     var blob = new Blob(['\ufeff' + wordTemplate], {
    //         type: 'application/msword;charset=utf-8'
    //     });

    //     // បង្កើត Link ស្វ័យប្រវត្តសម្រាប់ទាញយក File
    //     var url = URL.createObjectURL(blob);
    //     var downloadLink = document.createElement('a');
        
    //     var today = new Date().toISOString().slice(0, 10);
    //     downloadLink.href = url;
    //     downloadLink.download = "Blacklist_Agreement_" + today + ".doc";
        
    //     // ដំណើរការដោនឡូត
    //     document.body.appendChild(downloadLink);
    //     downloadLink.click();
    //     document.body.removeChild(downloadLink);
    //     URL.revokeObjectURL(url);

    //     // លាក់ Div នោះវិញ ប្រសិនបើលោកអ្នកចង់លាក់វានៅលើអេក្រង់ Web ធម្មតា
    //     // $("#print_blicklist_agreement").hide(); 
    // }
    
</script>