@extends('layouts.master')
@inject('numbersToWords', 'App\Traits\Convertors\ConvertNumbersToWordsClassForBlade')
<style>
    .filter-row-btn .btn {
        min-height: 38px !important;
        padding: 10px !important;
    }
    .reset-btn{
        color: #fff !important
    }
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<link rel="stylesheet" href="{{ asset('admin/css/loarding-table.css') }}">
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.motor_rentals')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.motor_rentals')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                        <a href="#" class="btn add-btn" data-toggle="modal" id="import_new_motor_rentel"><i
                            class="fa fa-plus"></i>@lang('lang.import')</a>
                        <a href="#" class="btn add-btn me-2" data-toggle="modal" data-toggle="modal" id="add_new"><i
                                class="fa fa-plus"></i>@lang('lang.add_new')</a>
                           
                    @endif
                </div>
            </div>
        </div>
        @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
            <div class="row filter-row-btn">
                <div class="col-sm-2 col-md-2">
                    <div class="form-group form-focus select-focus">
                        <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="@lang('lang.employee_id')"
                            value="{{ old('employee_id') }}">
                        {{-- <label class="focus-label">@lang('lang.filter')</label> --}}
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group form-focus select-focus">
                        <input type="text" class="form-control" name="employee_name" id="employee_name"
                            placeholder="@lang('lang.employee_name')" value="{{ old('employee_name') }}">
                        {{-- <label class="focus-label">@lang('lang.filter')</label> --}}
                    </div>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <input type="text" class="form-control floating datetimepicker" name="from_date" id="from_date" value="">
                        </div>
                        <label class="focus-label">@lang('lang.from_date')</label>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <input type="text" class="form-control floating datetimepicker" name="to_date" id="to_date" value="">
                        </div>
                        <label class="focus-label">@lang('lang.to_date')</label>
                    </div>
                </div>
               
                <div class="col-sm-4 col-md-4">
                    <div style="display: flex" class="float-end">
                        <button class="btn btn-sm btn-success btn-search me-2" data-dismiss="modal" >
                            <span class="btn-text-search">@lang('lang.search')</span>
                            <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning reset-btn">
                            <span class="btn-text-reset">@lang('lang.reload')</span>
                            <span id="btn-reset-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        <div class="content">
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-motor"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Profle: activate to sort column descending"
                                                    style="width: 94.0625px;">#</th>
                                                <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Employee ID: activate to sort column ascending"
                                                    style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                                <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Employee name: activate to sort column descending"
                                                    style="width: 178px;">@lang('lang.employee_name')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Gender: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.gender')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Position: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.position')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Department: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.department')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Start Date: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.start_date')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="End Date: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.end_date')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Total Gasoline: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.total_gasoline') </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Total working days: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.total_working_days')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Price engine oil: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.price_engine_oil')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Price motor rentel: activate to sort column ascending"
                                                    style="width: 51.475px;">@lang('lang.price_motor_rentel')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Taplab Price: activate to sort column ascending"
                                                    style="width: 51.475px;">@lang('lang.taplab_price')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="status: activate to sort column ascending"
                                                    style="width: 51.475px;">@lang('lang.status')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Resignetion Date: activate to sort column ascending"
                                                    style="width: 51.475px;">@lang('lang.last_working_day')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Create at: activate to sort column ascending"
                                                    style="width: 51.475px;">@lang('lang.created_at')</th>
                                                <th class="text-center sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Status: activate to sort column ascending"
                                                    style="width: 55.5625px;">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data) > 0)
                                                @foreach ($data as $key=>$item)
                                                    <tr class="odd">
                                                        <td class="ids stuck-scroll-3">{{ ++$key }}</td>
                                                        <td class="number_employee_id stuck-scroll-3">
                                                            {{ $item->MotorEmployee->number_employee }}
                                                        </td>
                                                        <td class="stuck-scroll-3">{{ Helper::getLang() == 'en' ? $item->MotorEmployee->employee_name_en : $item->MotorEmployee->employee_name_kh }}</td>
                                                        <td>{{ $item->MotorEmployee->EmployeeGender }}</td>
                                                        <td>{{ $item->MotorEmployee->EmployeePosition }}</td>
                                                        <td>{{ $item->MotorEmployee->EmployeeDepartment }}</td>
                                                        <td>{{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('d-M-Y') : '' }}</td>
                                                        <td>{{ $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('d-M-Y') : '' }}</td>
                                                        <td>{{ $item->total_gasoline }}</td>
                                                        <td>{{ $item->total_work_day }}</td>
                                                        <td>$ {{ $item->price_engine_oil }}</td>
                                                        <td>$ {{ $item->price_motor_rentel}}</td>
                                                        <td>$ {{ $item->price_taplab_rentel ? $item->price_taplab_rentel : "0.00"}}</td>
                                                        <td>
                                                            <div class="dropdown action-label">
                                                                @if (!$item->resigned_date)
                                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa fa-dot-circle-o text-success"></i>
                                                                        <span>@lang('lang.active')</span>
                                                                    </a>
                                                                @else
                                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i>
                                                                        <span>@lang('lang.resigned_motor')</span>
                                                                    </a>
                                                                @endif
                                                                    <div class="dropdown-menu dropdown-menu-right" id="btn-status">
                                                                        <a class="dropdown-item" data-id="{{$item->id}}" data-name="1" data-status-old="{{$item->status}}" href="#">
                                                                            <i class="fa fa-dot-circle-o text-success"></i> @lang('lang.active')
                                                                        </a>
                                                                        <a class="dropdown-item" data-id="{{$item->id}}" data-name="0" data-status-old="{{$item->status}}" href="#">
                                                                            <i class="fa fa-dot-circle-o text-danger"></i> @lang('lang.resigned_motor')
                                                                        </a>
                                                                    </div>
                                                            </div>
                                                        </td>
                                                        <td><span style="font-size: 13px" class="badge bg-inverse-danger">{{ $item->resigned_date ? \Carbon\Carbon::parse($item->resigned_date)->format('d-M-Y') :'' }}</span></td>
                                                        <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') : '' }}</td>
                                                        <td class="text-end">
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                        class="material-icons">more_vert</i></a>
                                                                @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item update"
                                                                            data-id="{{ $item->id }}"><i
                                                                                class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                        <a class="dropdown-item delete" href="#"
                                                                            data-toggle="modal" data-id="{{ $item->id }}"
                                                                            data-target="#delete_motor_rentel"><i
                                                                                class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                            
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                @include('motor_rentels.modal_form_create')
                @include('motor_rentels.modal_form_edit')
                @include('motor_rentels.import')
                {{-- @include('components.loarding-table', ["column"=> 9, "rol"=> 7]) --}}
                <!-- Delete Training Modal -->
                <div class="modal custom-modal fade" id="delete_motor_rentel" role="dialog">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="form-header">
                                    <h3>@lang('lang.delete')</h3>
                                    <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                                </div>
                                <div class="modal-btn delete-action">
                                    <form action="{{ url('motor-rentel/delete') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" class="e_id" value="">
                                        <div class="row">
                                            <div class="submit-section" style="text-align: center">
                                                <button type="submit" class="btn btn-primary submit-btn me-2">@lang('lang.delete')</button>
                                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger">@lang('lang.cancel')</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @dd($numbersToWords->convertNumbers2Words(900000, 1)) --}}
    @include('motor_rentels.print_signed_contract')
@endsection

@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script src="{{asset('/admin/js/format-date-kh.js')}}"></script>
<script src="{{asset('/admin/js/convertNumberToWords.js')}}"></script>
<script>
    $(function() {
        var currentYear = 2010;
        var newYear = moment(new Date()).format('YYYY');
        var currentDiff = moment(new Date()).diff(new Date(`01/01/${currentYear}`), 'years');

        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-reset-text-loading").css('display', 'block');
            window.location.replace("{{ URL('motor-rentel/list') }}"); 
        });

        $("#product_year, #e_product_year").on('change', function() {
            $('#e_expired_year').html('<option value=""> </option>');
            let dateYear = moment(new Date(`01/01/${$(this).val()}`)).format('YYYY-MM-DD');
            let ageMotorrentel = calculateAge(dateYear);
            $("#shelt_life").val(ageMotorrentel);
            $('#e_shelt_life').val(ageMotorrentel);

            // block Price motor rentel
            let newYearExpireted = 0;
            if (ageMotorrentel >= 0 && ageMotorrentel <= 5) {
                $("#price_motor_rentel").val(30);
                $('#e_price_motor_rentel').val(30);
                newYearExpireted = 5
            } else if (ageMotorrentel > 5 && ageMotorrentel <= 7) {
                $("#price_motor_rentel").val(25);
                $('#e_price_motor_rentel').val(25);
                newYearExpireted = 7
            } else if (ageMotorrentel > 7 && ageMotorrentel <= 10) {
                $("#price_motor_rentel").val(20);
                $('#e_price_motor_rentel').val(20);
                newYearExpireted = 10;
            } else {
                $("#price_motor_rentel").val(0);
                $('#e_price_motor_rentel').val(0);
            }
            const aYearFromNow = new Date(dateYear);
            aYearFromNow.setFullYear(aYearFromNow.getFullYear() + newYearExpireted);
            let YearExpireted = moment(aYearFromNow).format('YYYY');
            $('#expired_year').val(YearExpireted);
            $('#e_expired_year').val(YearExpireted);

            if ($("#start_date").val() || $("#e_start_date").val()) {
                let lastDay = new Date(YearExpireted, 12, 0).getDate();
                $("#end_date").val(YearExpireted+'-'+12+'-'+lastDay);
                $("#e_end_date").val(YearExpireted+'-'+12+'-'+lastDay);
            }
        });

        $("#import_new_motor_rentel").on("click", function() {
            $(".thanLess").hide();
            $("#thanLess").text("");
            $('#import_motor_rentel').modal('show');
        });

        $("#add_new").on("click", function() {
            $(".m_clear").val(" ");
            $("#shelt_life").val('');
            $("#price_motor_rentel").val('');
            [...Array(currentDiff >= 0 ? currentDiff + 1 : 0).keys()].map((num) => {
                let year = currentYear + num;
                let option = {
                    value: year,
                    text: year,
                    selected: false
                }
                if (newYear == year) {
                    option.selected = true;
                }
                $('#product_year').append($('<option>', option));
            });
            $('#add_motor_rentel').modal('show');
        });

        $("#btn-cancel").on("click", function(){
            $('#add_motor_rentel').modal('hide');
        });

        $(document).on('click','#save-print', function(){
            let btn_action = $(this).attr('data-btn');
            var num_miss = 0;
            $(".hr-form-group-select2").each(function(){
                let formGroup = $(this);
                let value = formGroup.attr("data-select2-id");
                let requeredField = formGroup.find(".hr-select2-option").val();
                let requered = formGroup.find(".emp_required").val();
                if(!value && requered == "" || !requered){ 
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }else if (!requeredField && requered == "") {
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }
            });
            $("#btn-print-loading").css('display', 'block');
            $("#save-print").prop('disabled', true);
            $(".btn-text-print").css("display", "none");
            
            $(".emp_required").each(function(){
                if($(this).val()==""){ 
                    num_miss++;
                    $(this).css("border-color","#dc3545")
                }else{
                    $(this).css("border-color","#198754")
                }
            });
            if (num_miss>0) {
                setTimeout(function () {
                    $("#save-print").attr('disabled',false);
                    $("#btn-print-loading").css('display', 'none');
                    $(".btn-text-print").css("display", 'block');
                }, 500);
                return false;
            }else{
                axios.post('{{ URL('motor-rentel/store') }}', {
                    status_print: true,
                    employee_id: $("#c_employee_id").val(),
                    number_plate: $("#number_plate").val(),
                    motorcycle_brand: $("#motorcycle_brand").val(),
                    category: $("#category").val(),
                    body_number: $("#body_number").val(),
                    engine_number: $("#engine_number").val(),
                    start_date: $("#start_date").val(),
                    end_date: $("#end_date").val(),
                    product_year: $("#product_year").val(),
                    expired_year: $("#expired_year").val(),
                    shelt_life: $("#shelt_life").val(),
                    total_gasoline: $("#total_gasoline").val(),
                    total_work_day: $("#total_work_day").val(),
                    price_engine_oil: $("#price_engine_oil").val(),
                    price_motor_rentel: $("#price_motor_rentel").val(),
                    taplab_rentel: $("#taplab_rentel").val(),
                    price_taplab_rentel: $("#price_taplab_rentel").val(),
                }).then(function(response) {
                    let data = response.data.success;
                    let date_of_birth = data.user.date_of_birth ? moment(data.user.date_of_birth).format('d,MM,YYYY') : "";
                    $("#p_full_name").text(data.user.employee_name_kh);
                    $("#p_gender").text(data.user.gender.name_khmer);
                    $("#p_date_of_birth").text(date_of_birth);
                    $("#p_id_card_number").text(data.user.id_card_number);
                    $("#p_house_no").text(data.current_house_no);
                    $("#p_house").text(data.user.currentvillage ? data.user.currentvillage.name_km : "");
                    $("#p_commune").text(data.user.currentcommune ? data.user.currentcommune.name_km : "");
                    $("#p_district").text(data.user.currentdistrict ? data.user.currentdistrict.name_km : "");
                    $("#p_province").text(data.user.currentprovince ? data.user.currentprovince.name_km : "");
                    $("#p_year_of_manufature").text(data.product_year);
                    $("#p_number_plate").text(data.number_plate);
                    $("#p_motorcycle_brand").text(data.motorcycle_brand);
                    $("#p_category").text(data.category);
                    $("#p_body_number").text(data.body_number);
                    $("#p_engine_number").text(data.engine_number);
                    let start_date = data.start_date.split('-');
                    let end_date = data.end_date.split('-');
                    // start_date
                    $("#p_s_day").text(start_date[2]);
                    $("#p_s_month").text(start_date[1]);
                    $("#p_s_year").text(start_date[0]);
                    // end_date
                    $("#p_e_day").text(end_date[2]);
                    $("#p_e_month").text(end_date[1]);
                    $("#p_e_year").text(end_date[0]);
                    // approve date
                    $("#p_a_day").text(start_date[2]);
                    $("#p_a_month").text(start_date[1]);
                    $("#p_a_year").text(start_date[0]);
                    $("#p_price_motor_rentel").text(data.price_motor_rentel);
                    let price_to_word = convertNumberToWords(data.price_motor_rentel)
                    $("#p_price_to_word").text(price_to_word);
                    print_pdf();
                    showDatas();
                    new Noty({
                        title: "",
                        text: "@lang('lang.the_process_has_been_successfully').",
                        type: "success",
                        timeout: 3000,
                        icon: true
                    }).show();
                }).catch(function(error) {
                    console.log(error);
                    new Noty({
                        title: "",
                        text: "@lang('lang.something_went_wrong_please_try_again_later').",
                        type: "error",
                        timeout: 3000,
                        icon: true
                    }).show();
                });
            }
            
        });

        $("#btn-e-save-print").on("click", function() {
            var num_miss = 0;
            $("#btn-e-print-loading").css('display', 'block');
            $("#btn-e-save-print").prop('disabled', true);
            $(".btn-e-text-print").css("display", "none");
            
            $(".e_emp_required").each(function(){
                if($(this).val()==""){ 
                    num_miss++;
                    $(this).css("border-color","#dc3545")
                }else{
                    $(this).css("border-color","#198754")
                }
            });
            if (num_miss>0) {
                setTimeout(function () {
                    $("#btn-e-save-print").attr('disabled',false);
                    $("#btn-e-print-loading").css('display', 'none');
                    $(".btn-e-text-print").css("display", 'block');
                }, 500);
                return false;
            }else{
                axios.post('{{ URL('motor-rentel/update') }}', {
                    id:$("#e_id").val(),
                    status_print: true,
                    employee_id: $("#e_employee_id").val(),
                    number_plate: $("#e_number_plate").val(),
                    motorcycle_brand: $("#e_motorcycle_brand").val(),
                    category: $("#e_category").val(),
                    body_number: $("#e_body_number").val(),
                    engine_number: $("#e_engine_number").val(),
                    start_date: $("#e_start_date").val(),
                    end_date: $("#e_end_date").val(),
                    product_year: $("#e_product_year").val(),
                    expired_year: $("#e_expired_year").val(),
                    shelt_life: $("#e_shelt_life").val(),
                    total_gasoline: $("#e_total_gasoline").val(),
                    total_work_day: $("#e_total_work_day").val(),
                    price_engine_oil: $("#e_price_engine_oil").val(),
                    price_motor_rentel: $("#e_price_motor_rentel").val(),
                    taplab_rentel: $("#e_taplab_rentel").val(),
                    price_taplab_rentel: $("#e_price_taplab_rentel").val(),
                }).then(function(response) {
                    let data = response.data.success;
                    let date_of_birth = data.user.date_of_birth ? moment(data.user.date_of_birth).format('d,MM,YYYY') : "";
                    $("#p_full_name").text(data.user.employee_name_kh);
                    $("#p_gender").text(data.user.gender.name_khmer);
                    $("#p_date_of_birth").text(date_of_birth);
                    $("#p_id_card_number").text(data.user.id_card_number);
                    $("#p_house_no").text(data.current_house_no);
                    $("#p_house").text(data.user.currentvillage ? data.user.currentvillage.name_km : "");
                    $("#p_commune").text(data.user.currentcommune ? data.user.currentcommune.name_km : "");
                    $("#p_district").text(data.user.currentdistrict ? data.user.currentdistrict.name_km : "");
                    $("#p_province").text(data.user.currentprovince ? data.user.currentprovince.name_km : "");
                    $("#p_year_of_manufature").text(data.product_year);
                    $("#p_number_plate").text(data.number_plate);
                    $("#p_motorcycle_brand").text(data.motorcycle_brand);
                    $("#p_category").text(data.category);
                    $("#p_body_number").text(data.body_number);
                    $("#p_engine_number").text(data.engine_number);
                    let start_date = data.start_date.split('-');
                    let end_date = data.end_date.split('-');
                    // start_date
                    $("#p_s_day").text(start_date[2]);
                    $("#p_s_month").text(start_date[1]);
                    $("#p_s_year").text(start_date[0]);
                    // end_date
                    $("#p_e_day").text(end_date[2]);
                    $("#p_e_month").text(end_date[1]);
                    $("#p_e_year").text(end_date[0]);
                    // approve date
                    $("#p_a_day").text(start_date[2]);
                    $("#p_a_month").text(start_date[1]);
                    $("#p_a_year").text(start_date[0]);
                    $("#p_price_motor_rentel").text(data.price_motor_rentel);
                    let price_to_word = convertNumberToWords(data.price_motor_rentel)
                    $("#p_price_to_word").text(price_to_word);
                    print_pdf();
                    showDatas();
                    new Noty({
                        title: "",
                        text: "@lang('lang.the_process_has_been_successfully').",
                        type: "success",
                        timeout: 3000,
                        icon: true
                    }).show();
                }).catch(function(error) {
                    console.log(error);
                    new Noty({
                        title: "",
                        text: "@lang('lang.something_went_wrong_please_try_again_later').",
                        type: "error",
                        timeout: 3000,
                        icon: true
                    }).show();
                });
            }
        });
        $(document).on('click','.update', function(){
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{ url('motor-rentel/edit') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        if (response.employee != '') {
                            $('#e_employee_id').html('<option selected disabled value="">@lang("lang.select")</option>');
                            $.each(response.employee, function(i, item) {
                                $('#e_employee_id').append($('<option>', {
                                    value: item.id,
                                    text: item.employee_name_en,
                                    selected: item.id == response.success.employee_id
                                }));
                            });
                        }

                        $('#e_id').val(response.success.id);
                        $('#e_start_date').val(response.success.start_date);
                        $('#e_end_date').val(response.success.end_date);
                        [...Array(currentDiff >= 0 ? currentDiff + 1 : 0).keys()].map((
                            num) => {
                            let year = currentYear + num;
                            let option = {
                                value: year,
                                text: year,
                                selected: false
                            }
                            if (year == response.success.product_year) {
                                option.selected = true;
                            }
                            $('#e_product_year').append($('<option>', option));
                        });
                        $('#e_shelt_life').val(response.success.shelt_life);
                        $('#e_number_plate').val(response.success.number_plate);
                        $("#e_motorcycle_brand").val(response.success.motorcycle_brand);
                        $("#e_category").val(response.success.category);
                        $("#e_body_number").val(response.success.body_number);
                        $("#e_engine_number").val(response.success.engine_number);
                        $('#e_total_gasoline').val(response.success.total_gasoline);
                        $('#e_total_work_day').val(response.success.total_work_day);
                        $('#e_price_engine_oil').val(response.success.price_engine_oil);
                        $('#e_price_motor_rentel').val(response.success.price_motor_rentel);
                        $('#e_taplab_rentel').val(response.success.taplab_rentel);
                        $('#e_price_taplab_rentel').val(response.success.price_taplab_rentel);
                        $('#e_expired_year').val(response.success.expired_year);
                        $('#edit_motor_rentel').modal('show');
                    }
                }
            });
        });
        $('.delete').on('click', function() {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });

        $(".btn-search").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-search").hide();
            $("#btn-text-loading").css('display', 'block');
            showDatas();
        });

        $('body').on('click', '#btn-status a', function() {
            let id = $(this).attr('data-id');
            let status = $(this).attr('data-name');
            let old_status = $(this).attr('data-status-old');
            let text_status = "";
            let text_old_status = "";
            if (old_status == "0") {
                text_old_status = "@lang('lang.resigned_motor')"
            }else if(old_status == "1"){
                text_old_status = "@lang('lang.active')"
            }
            let resignation = '';
            if (status == "0") {
                text_status = "@lang('lang.resigned_motor')"
                resignation = '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label>@lang("lang.last_working_day") <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control resigned_date">'+
                                '</div>'+
                            '</div>';
            }else if(status == "1"){
                text_status = "@lang('lang.active')"
            }

            $.confirm({
                title: '@lang("lang.change_status")!',
                contentClass: 'text-center',
                // backgroundDismiss: 'cancel',
                content: ''+
                        '<label>@lang("lang.are_you_sure_want_change_status") '+'<label style="color:red">'+text_old_status+'</label>'+' @lang("lang.to_") '+'<label style="color:red">'+text_status+'</label>'+'?</label>'+
                        '<input type="hidden" class="form-control status" id="" name="" value="'+status+'">'+
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                        '<form method="post"> <br>'+
                            resignation+
                        '</form>',
                buttons: {
                    confirm: {
                        text: '@lang("lang.submit")',
                        btnClass: 'btn-blue',
                        action: function() {
                            var id = this.$content.find('.id').val();
                            var status = this.$content.find('.status').val();
                            var resigned_date = this.$content.find('.resigned_date').val();
                            if (status == "0") {
                                if ($(".resigned_date").val() ==""){
                                    $(".resigned_date").css("border","solid 1px red");
                                    return false;
                                }
                            }
                            axios.post('{{ URL('motor-rentel/status') }}', {
                                    'id': id,
                                    'status': status,
                                    'resigned_date': resigned_date,
                                }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: "@lang('lang.the_process_has_been_successfully').",
                                    type: "success",
                                    icon: true
                                }).show();
                                $('.card-footer').remove();
                                window.location.replace("{{ URL('motor-rentel/list') }}");
                            }).catch(function(error) {
                                new Noty({
                                    title: "",
                                    text: "@lang('lang.something_went_wrong_please_try_again_later').",
                                    type: "error",
                                    icon: true
                                }).show();
                            });
                        }
                    },
                    cancel: {
                        text: '@lang("lang.cancel")',
                        btnClass: 'btn-red btn-sm',
                    },
                }
            });
        });
        
    });

    function showDatas(){
        var localeLanguage = '{{ config('app.locale') }}';
        axios.post('{{ URL('motor-rentel/list') }}', {
            'research':true,
            'employee_id': $("#employee_id").val(),
            'employee_name': $("#employee_name").val(),
            'from_date': $("#from_date").val(),
            'to_date': $("#to_date").val(),
        }).then(function(response) {
            var rows = response.data.data;
           
            if (rows.length > 0) {
                var tr = "";
                let no = 0;
                $(rows).each(function(e, row) {
                    no++;
                    let status = '';
                    if (!row.resigned_date || row.status == 1) {
                        status ='<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                            '<i class="fa fa-dot-circle-o text-success"></i>'+
                            '<span>@lang("lang.active")</span>'+
                        '</a>';
                    }else{      
                        status ='<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                            '<i class="fa fa-dot-circle-o text-danger"></i>'+
                            '<span>@lang("lang.resigned_motor")</span>'+
                        '</a>';
                    }
                    let createdAt = moment(row.created_at).format('D-MMM-YYYY')
                    let resigned_date = row.resigned_date ? moment(row.resigned_date).format('D-MMM-YYYY'): "";
                    let start_date = row.start_date ? moment(row.start_date).format('D-MMM-YYYY'): "";
                    let end_date = row.end_date ? moment(row.end_date).format('D-MMM-YYYY'): "";
                    tr += '<tr class="odd">' +
                        '<td class="ids stuck-scroll-3">' + (no) + '</td>' +
                        '<td class="number_employee_id stuck-scroll-3">' + (row.number_employee) + '</td>' +
                        '<td class="stuck-scroll-3">' + (localeLanguage == 'en' ? row.employee_name_en : row.employee_name_kh ) + '</td>' +
                        '<td>' + (row.user.gender == null ? "" : localeLanguage == 'en' ? row.user.gender.name_english : row.user.gender.name_khmer) + '</td>' +
                        '<td>' + (row.user.position ? localeLanguage == 'en' ? row.user.position.name_english : row.user.position.name_khmer : "") + '</td>' +
                        '<td>' + (localeLanguage == 'en' ? row.user.department.name_english : row.user.department.name_khmer ) + '</td>' +
                        '<td>' + (start_date) + '</td>' +
                        '<td>' + (end_date) + '</td>' +
                        '<td>' + (row.total_gasoline) + '</td>' +
                        '<td>' + (row.total_work_day) + '</td>' +
                        '<td>$ ' + (row.price_engine_oil) + '</td>' +
                        '<td>$ ' + (row.price_motor_rentel) + '</td>' +
                        '<td>$ ' + (row.price_taplab_rentel ? row.price_taplab_rentel : "0.00") + '</td>' +
                        '<td>'+
                            '<div class="dropdown action-label">'+
                                (status)+
                                '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                    '<a class="dropdown-item" data-id="'+(row.id)+'" data-name="1" data-status-old="'+(row.status)+'" href="#">'+
                                        '<i class="fa fa-dot-circle-o text-success"></i> @lang("lang.active")</a>'+
                                    '<a class="dropdown-item" data-id="'+(row.id)+'" data-name="0" data-status-old="'+(row.status)+'" href="#">'+
                                        '<i class="fa fa-dot-circle-o text-danger"></i> @lang("lang.resigned_motor")</a>'+
                                '</div>'+
                            '</div>'+
                        '</td>'+
                        '<td><span style="font-size: 13px" class="badge bg-inverse-danger">'+(resigned_date)+'</span></td>'+
                        '<td>' + (createdAt) + '</td>' +
                        '<td class="text-end">' +
                        '<div class="dropdown dropdown-action">' +
                        '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' +
                        '<i class="material-icons">more_vert</i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        ' <a class="dropdown-item update" data-id="'+(row.id)+'">' +
                        '<i class="fa fa-pencil m-r-5"></i> @lang("lang.edit")' +
                        '</a>' +
                        '<a class="dropdown-item delete" href="#" data-toggle="modal" data-id="'+(row.id)+'" data-target="#delete_motor_rentel">' +
                        '<i class="fa fa-trash-o m-r-5"></i> @lang("lang.delete")' +
                        '</a>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        ' </tr>';
                });
            } else {
                var tr =
                    '<tr><td colspan=17 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
            }
            $(".tbl-motor tbody").html(tr);
            $("#btn-text-loading").hide();
            $(".btn-text-search").show();
            $(".btn-search").prop("disabled",false);
        })
    }
    function print_pdf(type) {
        $("#print_purchase").show();
        window.setTimeout(function() {
            $("#print_purchase").hide();
            $("#save-print").prop('disabled', false);
            $(".btn-text-print").show();
            $("#btn-print-loading").css('display', 'none');
            $("#add_motor_rentel").modal("hide")

            $("#btn-e-save-print").prop('disabled', false);
            $(".btn-e-text-print").show();
            $("#btn-e-print-loading").css('display', 'none');
            $("#edit_motor_rentel").modal("hide")
        }, 2000);
        $("#print_purchase").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_table.css')}}",
            header: "",
            printDelay: 1500,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }

    function calculatorYearExpire(currentYear, expiretedYear) {
        const expiredDiff = moment(new Date(`01/01/${expiretedYear}`)).diff(new Date(`01/01/${currentYear}`), 'years');
        let seletedYear = 0;
        [...Array(expiredDiff >= 0 ? expiredDiff + 1 : 0).keys()].map((num) => {
            seletedYear++;
            let year = Number(currentYear) + num;
            let option = {
                value: year,
                text: year,
                selected: false
            }
            if (seletedYear == 6) {
                option.selected = true
            }
            $('#expired_year').append($('<option>', option));
            $('#e_expired_year').append($('<option>', option));
        });
    }

    function calculateAge(year) {
        var now = new Date();
        var past = new Date(year);
        var nowYear = now.getFullYear();
        var pastYear = past.getFullYear();
        var age = nowYear - pastYear;
        return age;
    };
</script>
