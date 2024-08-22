@extends('layouts.master')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.staff_upcoming')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.staff_upcoming')</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
            </div>
            <div class="col-auto float-end ms-auto">
                <div class="btn-group btn-group-sm">
                    @if (permissionAccess("m4-s2","is_print")->value == "1")
                        <a class="btn btn-white m-1" href="{{url('/recruitment/candidate-resume/list')}}">@lang('lang.back_to_list')</a>
                        <div class="dropdown action-label" style="margin-top: 3px;">
                            <a class="btn btn-white btn-sm dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-print fa-lg"></i> @lang('lang.print')
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" style="">
                            <a class="dropdown-item" id="btn_print_signed_contract" href="#" data-id="{{$data->id}}">Signed Contract</a>
                            <a class="dropdown-item" id="btn_appointed_letter" href="#" data-id="{{$data->id}}">Appointed Letter</a>
                            <a class="dropdown-item" id="btn_complete_probation" href="#" data-id="{{$data->id}}">Complete Probation</a>
                            <a class="dropdown-item" href="#">Contract Volunteer</a>
                            <a class="dropdown-item" href="#">Blacklist Agreement</a>
                            <a class="dropdown-item" href="#">Confidential Letter</a>
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
    @include('components.loading-modal')
    @include('recruitments.candidate_resumes.print_signed_contract')
    @include('recruitments.candidate_resumes.print_oppointed_letter')
    @include('recruitments.candidate_resumes.print_complete_probation')
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>
<script src="{{asset('/admin/js/format-date-kh.js')}}"></script>
<script type="text/javascript">
    $(function() {
        $('#btn_print_signed_contract').on('click', function(){
            $('#modal-loading').modal('show');
            let id = $(this).data("id");
            showPrint(id);
        });
        $('#btn_appointed_letter').on('click', function(){
            $('#modal-loading').modal('show');
            let id = $(this).data("id");
            appointed_letter(id);
        });
        $('#btn_complete_probation').on('click', function(){
            $('#modal-loading').modal('show');
            let id = $(this).data("id");
            completeProbation(id);
        });
    });

    function showPrint(id){
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
                var date_of_birth = new Date(data.date_of_birth);
                var date_of_commencement = new Date(data.date_of_commencement);
                var fdc_date = new Date(data.fdc_date);
                fdc_date.setDate(fdc_date.getDate() - 1);
                fdc_date = new Date(fdc_date);
                let day = formatDate(date_of_birth, 'km', format_date={day: true});
                let month = formatDate(date_of_birth, 'km', format_date={month: true});
                let year = formatDate(date_of_birth, 'km', format_date={year: true});
                let join_day = formatDate(date_of_commencement, 'km', format_date={day: true});
                let join_month = formatDate(date_of_commencement, 'km', format_date={month: true});
                let join_year = formatDate(date_of_commencement, 'km', format_date={year: true});
                let end_day = formatDate(fdc_date, 'km', format_date={day: true});
                let end_month = formatDate(fdc_date, 'km', format_date={month: true});
                let end_year = formatDate(fdc_date, 'km', format_date={year: true});
                if (data) {
                    if (data.gender.name_english == "Female") {
                        $("#pr_mr_or_mrs").text("អ្នកស្រី ");
                        $("#pr_gender").text("ស្រី ");
                    }else{
                        $("#pr_mr_or_mrs").text("លោក ");
                        $("#pr_gender").text("ប្រុស ");
                    }
                    $(".pr_name").text(data.employee_name_kh +" ");
                    $("#pr_born_on").text(day+" ខែ "+month+" ឆ្នាំ "+ year);
                    $("#pr_permanent_province").text(data.permanentprovince.name_km + " ");
                    $("#pr_permanent_province").text(data.permanentprovince.name_km + " ");
                    $("#pr_id_card_number").text(data.id_card_number+ "");

                    let number_home = "";
                    let number_street = "";
                    if (data.current_house_no) {
                        number_home = "ផ្ទះលេខ "+ data.current_house_no;
                    }
                    if (data.current_street_no) {
                        number_street = " ផ្លូវលេខ "+data.current_street_no;
                    }
                    let location = number_home + number_street + " ភូមិ "+data.currentvillage.name_km + " ឃុំ/សង្កាត់ " + data.currentcommune.name_km + " ស្រុក/ខណ្ឌ " + data.currentdistrict.name_km+ " ខេត្ត/ក្រុង "+data.currentprovince.name_km;

                    $("#pr_current_location").text(location);

                    $("#pr_personal_phone_number").text(data.personal_phone_number);
                    $(".pr_join_day").text(join_day);
                    $(".pr_join_month").text(join_month);
                    $(".pr_join_year").text(join_year);
                    $("#pr_end_day").text(end_day);
                    $("#pr_end_month").text(end_month);
                    $("#pr_end_year").text(end_year);
                    $("#pr_position").text(data.position.name_khmer);
                    $("#pr_branch").text(data.branch.branch_name_kh);
                    $("#pr_employee_id").text(data.number_employee);
                    $("#pr_basic_salary").text(data.basic_salary);
                    $("#pr_salary_increase").text(data.salary_increas);
                    if (data.recruitment && data.recruitment.pro_rate == "1") {
                        $("#pr_supporting_or_field_staff").text("ដោយធៀបនិងភាគរយការងារសម្រេចបានសម្រាប់បុគ្គលិកឥណទាន (គិតតាម Pro-Rate)");
                    }else{
                        $("#pr_supporting_or_field_staff").text("");
                    }
                    print_pdf_sign_contract();
                    window.setTimeout(function() {
                        $('#modal-loading').modal('hide');
                    }, 2000);
                }
            }
        });
    }
    function appointed_letter(id){
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
                var date_of_birth = new Date(data.date_of_birth);
                var date_of_commencement = new Date(data.date_of_commencement);
                var fdc_date = new Date(data.fdc_date);
                fdc_date.setDate(fdc_date.getDate() - 1);
                fdc_date = new Date(fdc_date);
                let day = formatDate(date_of_birth, 'km', format_date={day: true});
                let month = formatDate(date_of_birth, 'km', format_date={month: true});
                let year = formatDate(date_of_birth, 'km', format_date={year: true});
                let join_day = formatDate(date_of_commencement, 'km', format_date={day: true});
                let join_month = formatDate(date_of_commencement, 'km', format_date={month: true});
                let join_year = formatDate(date_of_commencement, 'km', format_date={year: true});
                let end_day = formatDate(fdc_date, 'km', format_date={day: true});
                let end_month = formatDate(fdc_date, 'km', format_date={month: true});
                let end_year = formatDate(fdc_date, 'km', format_date={year: true});
                if (data) {
                    if (data.gender.name_english == "Female") {
                        $("#pr_mr_or_mrs").text("អ្នកស្រី ");
                        $("#pr_gender").text("ស្រី ");
                    }else{
                        $("#pr_mr_or_mrs").text("លោក ");
                        $("#pr_gender").text("ប្រុស ");
                    }
                    $(".pr_name").text(data.employee_name_kh +" ");
                    $("#pr_born_on").text(day+" ខែ "+month+" ឆ្នាំ "+ year);
                    $("#pr_permanent_province").text(data.permanentprovince.name_km + " ");
                    $("#pr_permanent_province").text(data.permanentprovince.name_km + " ");
                    $("#pr_id_card_number").text(data.id_card_number+ "");

                    let number_home = "";
                    let number_street = "";
                    if (data.current_house_no) {
                        number_home = "ផ្ទះលេខ "+ data.current_house_no;
                    }
                    if (data.current_street_no) {
                        number_street = " ផ្លូវលេខ "+data.current_street_no;
                    }
                    let location = number_home + number_street + " ភូមិ "+data.currentvillage.name_km + " ឃុំ/សង្កាត់ " + data.currentcommune.name_km + " ស្រុក/ខណ្ឌ " + data.currentdistrict.name_km+ " ខេត្ត/ក្រុង "+data.currentprovince.name_km;
                    $("#pr_current_location").text(location);
                    $("#pr_personal_phone_number").text(data.personal_phone_number);
                    $(".pr_join_day").text(join_day);
                    $(".pr_join_month").text(join_month);
                    $(".pr_join_year").text(join_year);
                    $("#pr_end_day").text(end_day);
                    $("#pr_end_month").text(end_month);
                    $("#pr_end_year").text(end_year);
                    $("#pr_position").text(data.position.name_khmer);
                    $("#pr_branch").text(data.branch.branch_name_kh);
                    $("#pr_employee_id").text(data.number_employee);
                    $("#pr_basic_salary").text(data.basic_salary);
                    $("#pr_salary_increase").text(data.salary_increas);
                    if (data.recruitment && data.recruitment.pro_rate == "1") {
                        $("#pr_supporting_or_field_staff").text("ដោយធៀបនិងភាគរយការងារសម្រេចបានសម្រាប់បុគ្គលិកឥណទាន (គិតតាម Pro-Rate)");
                    }else{
                        $("#pr_supporting_or_field_staff").text("");
                    }
                    print_pdf_print_appointed_letter();
                    window.setTimeout(function() {
                        $('#modal-loading').modal('hide');
                    }, 2000);
                }
            }
        });
    }
    function completeProbation(id){
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
                var date_of_birth = new Date(data.date_of_birth);
                var date_of_commencement = new Date(data.date_of_commencement);
                var fdc_date = new Date(data.fdc_date);
                fdc_date.setDate(fdc_date.getDate() - 1);
                fdc_date = new Date(fdc_date);
                let day = formatDate(date_of_birth, 'km', format_date={day: true});
                let month = formatDate(date_of_birth, 'km', format_date={month: true});
                let year = formatDate(date_of_birth, 'km', format_date={year: true});
                let join_day = formatDate(date_of_commencement, 'km', format_date={day: true});
                let join_month = formatDate(date_of_commencement, 'km', format_date={month: true});
                let join_year = formatDate(date_of_commencement, 'km', format_date={year: true});
                let end_day = formatDate(fdc_date, 'km', format_date={day: true});
                let end_month = formatDate(fdc_date, 'km', format_date={month: true});
                let end_year = formatDate(fdc_date, 'km', format_date={year: true});
                if (data) {
                    if (data.gender.name_english == "Female") {
                        $("#pr_mr_or_mrs").text("អ្នកស្រី ");
                        $("#pr_gender").text("ស្រី ");
                    }else{
                        $("#pr_mr_or_mrs").text("លោក ");
                        $("#pr_gender").text("ប្រុស ");
                    }
                    $(".pr_name").text(data.employee_name_kh +" ");
                    $("#pr_born_on").text(day+" ខែ "+month+" ឆ្នាំ "+ year);
                    $("#pr_permanent_province").text(data.permanentprovince.name_km + " ");
                    $("#pr_permanent_province").text(data.permanentprovince.name_km + " ");
                    $("#pr_id_card_number").text(data.id_card_number+ "");

                    let number_home = "";
                    let number_street = "";
                    if (data.current_house_no) {
                        number_home = "ផ្ទះលេខ "+ data.current_house_no;
                    }
                    if (data.current_street_no) {
                        number_street = " ផ្លូវលេខ "+data.current_street_no;
                    }
                    let location = number_home + number_street + " ភូមិ "+data.currentvillage.name_km + " ឃុំ/សង្កាត់ " + data.currentcommune.name_km + " ស្រុក/ខណ្ឌ " + data.currentdistrict.name_km+ " ខេត្ត/ក្រុង "+data.currentprovince.name_km;
                    $("#pr_current_location").text(location);
                    $("#pr_personal_phone_number").text(data.personal_phone_number);
                    $(".pr_join_day").text(join_day);
                    $(".pr_join_month").text(join_month);
                    $(".pr_join_year").text(join_year);
                    $("#pr_end_day").text(end_day);
                    $("#pr_end_month").text(end_month);
                    $("#pr_end_year").text(end_year);
                    $("#pr_position").text(data.position.name_khmer);
                    $("#pr_branch").text(data.branch.branch_name_kh);
                    $("#pr_employee_id").text(data.number_employee);
                    $("#pr_basic_salary").text(data.basic_salary);
                    $("#pr_salary_increase").text(data.salary_increas);
                    if (data.recruitment && data.recruitment.pro_rate == "1") {
                        $("#pr_supporting_or_field_staff").text("ដោយធៀបនិងភាគរយការងារសម្រេចបានសម្រាប់បុគ្គលិកឥណទាន (គិតតាម Pro-Rate)");
                    }else{
                        $("#pr_supporting_or_field_staff").text("");
                    }
                    print_pdf_print_complete_probation();
                    window.setTimeout(function() {
                        $('#modal-loading').modal('hide');
                    }, 2000);
                }
            }
        });
    }
    function print_pdf_sign_contract() {
        $("#print_purchase").show();
        $("#print_purchase").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_table.css')}}",
            header: "",
            printDelay: 1000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
    function print_pdf_print_appointed_letter() {
        $("#print_appointed_letter").show();
        $("#print_appointed_letter").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_print_oppointed_letter.css')}}",
            header: "",
            printDelay: 1000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
    function print_pdf_print_complete_probation() {
        $("#print_complete_probation").show();
        $("#print_complete_probation").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_print_oppointed_letter.css')}}",
            header: "",
            printDelay: 1000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>