@extends('layouts.master')
@inject('numbersToWords', 'App\Traits\Convertors\ConvertNumbersToWordsClassForBlade')
<style>
    .filter-row-btn .btn {
        min-height: 38px !important;
        padding: 10px !important;
    }
    .ui-datepicker-calendar {
        display: none;
    }
     /* The container checkbox */
     .container-checkbox {
        /* display: block; */
        position: relative;
        padding-left: 35px;
        /* margin-bottom: 5px; */
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        margin-top: 10%;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 1;
        left: 0;
        height: 20px;
        width: 20px;
        border: solid 1px #ccc;
        background-color: #fff;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 7px;
        top: 4px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
<link rel="stylesheet" href="{{ asset('admin/css/loarding-table.css') }}">
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.m&t_information')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.m&t_information')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    {{-- @if ($permission->is_import == "1")
                        <a href="#" class="btn add-btn" data-toggle="modal" id="import_new_motor_rentel"><i class="fa fa-plus"></i>@lang('lang.import')</a>
                    @endif --}}
                    @if ($permission->is_create == "1")
                    <a href="{{url('motor-rentel/form')}}" class="btn add-btn"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        @if ($permission->is_view == "1")
            <div class="row filter-row-btn">
                <div class="col-sm-2 col-md-2 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <input type="text" class="form-control floating datetimepicker filter-date" name="from_date" id="from_date" value="">
                        </div>
                        <label class="focus-label">@lang('lang.from') @lang('lang.create')</label>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <input type="text" class="form-control floating datetimepicker filter-date" name="to_date" id="to_date" value="">
                        </div>
                        <label class="focus-label">@lang('lang.to') @lang('lang.create')</label>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table mb-0 tbl-motor" id="DataTables_Table_0">
                                            <thead>
                                                <tr>
                                                    <th class="stuck-scroll-3">#</th>
                                                    <th class="stuck-scroll-3">@lang('lang.employee_id')</th>
                                                    <th class="stuck-scroll-3">@lang('lang.employee_name')</th>
                                                    <th>@lang('lang.gender')</th>
                                                    <th>@lang('lang.position')</th>
                                                    <th>@lang('lang.location')</th>
                                                    <th>@lang('lang.resign_date')</th>
                                                    <th>@lang('lang.form_rentals')</th>
                                                    <th>@lang('lang.rental_status')</th>
                                                    <th>@lang('lang.motor_current_price')</th>
                                                    <th>@lang('lang.motor_new_price')</th>
                                                    <th>@lang('lang.tablet_price')</th>
                                                    {{-- <th>@lang('lang.car_price')</th> --}}
                                                    <th>@lang('lang.status')</th>
                                                    <th>@lang('lang.last_working_day')</th>
                                                    <th>@lang('lang.view') @lang('lang.contract')</th>
                                                    <th>@lang('lang.created_at')</th>
                                                    <th class="text-center">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {!! Toastr::message() !!}
        @include('motor_rentels.import')
        <!-- Delete Modal -->
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
                                <input type="hidden" name="id" class="delete_id" value="">
                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">@lang('lang.delete')</button>
                                        <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-secondary">@lang('lang.cancel')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Form Detail Modal -->
        <div class="modal fade" id="modal_view_form_details" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title font-weight-bold text-primary" id="modal_form_title">
                            <i class="fa fa-file-text-o me-2"></i> Form Detail
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="detail_form_container" class="row g-3">
                            <!-- Dynamic form details will be injected here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">@lang('lang.close')</button>
                        <button type="button" class="btn btn-primary btnPrint btn-sm">@lang('lang.print')</button>
                        <button type="button" class="btn btn-primary btnStopRenting btn-sm">@lang('lang.terminate_rental')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('motor_rentels.print_signed_contract')
    @include('motor_rentels.print_signed_contract_tablet')
    @include('motor_rentels.modal_upload_contract')
    @include('components.loading-modal')
@endsection

@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script src="{{asset('/admin/js/format-date-kh.js')}}"></script>
<script src="{{asset('/admin/js/convertNumberToWords.js')}}"></script>
<script src="{{asset('/admin/js/convertNumberToWordsExp.js')}}"></script>
@section('script')
<script>
    $(function() {
        datashowTables();
        $(document).on('click','.btn-delete', function() {
            let id = $(this).data("id");
            $('.delete_id').val(id);
            $("#delete_motor_rentel").modal("show");
        });
        $(".action-filter").on("change", function() {
            datashowTables();
        });
        $('.filter-date').on('dp.change changeDate change', function (e) {
            datashowTables();
        });

        $('body').on('click', '#btn-status a', function() {
            let id = $(this).attr('data-id');
            let status = $(this).attr('data-name');
            let old_status = $(this).attr('data-status-old');
            let text_status = "";
            let text_old_status = "";
            if (old_status == "0") {
                text_old_status = "@lang('lang.inactive')"
            }else if(old_status == "1"){
                text_old_status = "@lang('lang.active')"
            }
            let resignation = '';
            if (status == "0") {
                text_status = "@lang('lang.inactive')"
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
                        btnClass: 'add-btn-status',
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
                        btnClass: 'btn-secondary btn-sm',
                    },
                }
            });
        });

        $('body').on('click', '.btnStopRenting', function() {
            let motorId = $(this).attr('data-motor-id');
            let formRentalId = $(this).attr('data-form-id');
            $.confirm({
                title: '@lang("lang.terminate_rental")!',
                contentClass: 'text-center',
                // backgroundDismiss: 'cancel',
                content: ''+
                        '<label>@lang("lang.are_you_sure_want_stop_renting_form")</label>'+
                        '<input type="hidden" class="form-control id" value="'+motorId+'" id="" name="">'+
                        '<input type="hidden" class="form-control form_rental_id" name="" value="'+formRentalId+'">'+
                        '<form method="post"> <br>'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label>@lang("lang.date") <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control terminate_date">'+
                                '</div>'+
                            '</div>'+
                        '</form>',
                buttons: {
                    confirm: {
                        text: '@lang("lang.submit")',
                        btnClass: 'add-btn-status',
                        action: function() {
                            var id = this.$content.find('.id').val();
                            var form_rental_id = this.$content.find('.form_rental_id').val();
                            var terminate_date = this.$content.find('.terminate_date').val();
                            if ($(".terminate_date").val() ==""){
                                $(".terminate_date").css("border","solid 1px red");
                                return false;
                            }
                            axios.post('{{ URL('motor-rentel/terminate') }}', {
                                    'id': id,
                                    'form_rental_id': form_rental_id,
                                    'terminate_date': terminate_date,
                                }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: "@lang('lang.the_process_has_been_successfully').",
                                    type: "success",
                                    icon: true
                                }).show();
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
                        btnClass: 'btn-secondary btn-sm',
                    },
                }
            });
        });

        $(document).on("click", ".btn-view-single-form", function () {
            let formIndex = $(this).data('form-index');
            
            let table = $('#DataTables_Table_0').DataTable();
            let rowData = table.row($(this).closest('tr')).data();

            let date_of_birth = rowData.user.date_of_birth ? moment(rowData.user.date_of_birth).format('DD,MM,YYYY') : "";
            $(".p_full_name").text(rowData.user.employee_name_kh);
            $(".p_gender").text(rowData.user.gender.name_khmer);
            $(".p_date_of_birth").text(date_of_birth);
            $(".p_id_card_number").text(rowData.user.id_card_number);
            $(".p_house_no").text(rowData.user.current_house_no);
            $(".p_house").text(rowData.user.currentvillage ? rowData.user.currentvillage.name_km : "");
            $(".p_commune").text(rowData.user.currentcommune ? rowData.user.currentcommune.name_km : "");
            $(".p_district").text(rowData.user.currentdistrict ? rowData.user.currentdistrict.name_km : "");
            $(".p_province").text(rowData.user.currentprovince ? rowData.user.currentprovince.name_km : "");

            if (!rowData || !rowData.form_rental) return;

            let formsData = [];
            try {
                formsData = typeof rowData.form_rental === 'string' ? JSON.parse(rowData.form_rental) : rowData.form_rental;
            } catch (e) {
                formsData = [];
            }

            let targetForm = formsData[formIndex];
            if (!targetForm) return;

            // ទាញយក targetForm ចេញពី Accessor ដែលមាន motor_age & price ស្រាប់
            let formsWithPrice = rowData.form_rental_with_price || [];
            let targetFormWithPrice = formsWithPrice[formIndex] || targetForm;

            let formTitle = targetForm.form_name;
            $('#modal_form_title').html(`<i class="fa fa-file-text-o me-2"></i> ${formTitle}`);

            let detailHtml = '';

            // 1. បង្ហាញ Fields Data ធម្មតា
            if (targetForm.fields && Object.keys(targetForm.fields).length > 0) {
                $.each(targetForm.fields, function (fieldId, fieldObj) {
                    let label = fieldObj.field_label || 'Field';
                    let val = fieldObj.value || '-';
                    detailHtml += `
                        <div class="col-6 mb-2">
                            <div class="p-2 border rounded bg-light">
                                <small class="text-muted d-block fw-normal" style="font-size: 12px;">${label}</small>
                                <span class="fw-bold text-dark" style="font-size: 14px;">${val}</span>
                            </div>
                        </div>`;

                    // --- កូដរៀបចំ Data សម្រាប់ Print (បើជាប្រភេទ Motorcycle) ---
                        // Clean label: លុប space និងបំប្លែងទៅជា lowercase ដើម្បីប្រៀបធៀប
                        let cleanLabel = label.trim().toLowerCase();
                        let rawVal = fieldObj.value || '';

                        if (cleanLabel === "motorcycle brand") {
                            $("#p_motorcycle_brand").text(rawVal);
                        } 
                        else if (cleanLabel === "plate number" || cleanLabel === "number plate") {
                            $("#p_number_plate").text(rawVal);
                        } 
                        else if (cleanLabel === "category") {
                            $("#p_category").text(rawVal);
                        } 
                        else if (cleanLabel === "body number") {
                            $("#p_body_number").text(rawVal);
                        } 
                        else if (cleanLabel === "engine number") {
                            $("#p_engine_number").text(rawVal);
                        } 
                        else if(cleanLabel === "year of manufature"){
                            $("#p_year_of_manufature").text(rawVal);
                        }
                        else if (cleanLabel === "lease start date" || cleanLabel === "start date") {
                            if (rawVal && rawVal.includes('-')) {
                                let startDate = rawVal.split('-'); // Format: YYYY-MM-DD
                                if (startDate.length === 3) {
                                    $(".p_s_day").text(startDate[0]);   // DD
                                    $(".p_s_month").text(startDate[1]); // MM
                                    $(".p_s_year").text(startDate[2]);  // YYYY
                                }
                            } else {
                                $(".p_s_day").text('');
                                $(".p_s_month").text('');
                                $(".p_s_year").text('');
                            }
                        }
                        if (cleanLabel ==="ID (IMEI)" || cleanLabel ==="id (imei)") {
                            $(".p_tablet_imei").text(rawVal);
                            
                        }
                });
            }

            // 💡 2. បន្ថែមការបង្ហាញ Motor Age ប្រសិនបើជា Form Motorcycle
            let isMotorcycle = (targetFormWithPrice.type && targetFormWithPrice.type.toLowerCase() === 'motorcycle') || 
                            (targetForm.form_name && targetForm.form_name.toLowerCase().includes('motor'));

            if (isMotorcycle) {
                let motorAge = targetFormWithPrice.motor_age !== undefined ? targetFormWithPrice.motor_age : 'N/A';
                detailHtml += `
                    <div class="col-6 mb-2">
                        <div class="p-2 border rounded bg-light border-info">
                            <small class="text-muted d-block fw-normal" style="font-size: 12px;">Motor Age (អាយុកាលម៉ូតូ)</small>
                            <span class="fw-bold text-primary" style="font-size: 14px;">${motorAge} ឆ្នាំ</span>
                        </div>
                    </div>
                    `;
            }
            // .3 បន្ថែមការបង្ហាញ Price (formatted ជាមួយ $)
            let priceVal = targetFormWithPrice.price !== undefined && targetFormWithPrice.price !== null 
                ? `${parseFloat(targetFormWithPrice.price).toFixed(2)+" "+targetFormWithPrice.currency}` 
                : '$0.00';
            let isKhr = (targetFormWithPrice.currency || '').toUpperCase() === 'KHR';
            let currency = isKhr ? 'rial' : 'dollar';
            let price_to_word = convertNumberToWordsExp(parseFloat(targetFormWithPrice.price).toFixed(2), currency)
                    .replace(/។/g, '')
                    .trim();
            $(".p_price_rentel").text(priceVal);
            $(".p_price_to_word").text(price_to_word);
            
            detailHtml += `
                <div class="col-6 mb-2">
                    <div class="p-2 border rounded bg-light border-info">
                        <small class="text-muted d-block fw-normal" style="font-size: 12px;">Current Price (តម្លៃជួល)</small>
                        <span class="fw-bold text-dark" style="font-size: 14px;">${priceVal}</span>
                    </div>
                </div>`;

            if (isMotorcycle && targetFormWithPrice.promoted_date) {
                let newPrice = targetFormWithPrice.new_price !== undefined && targetFormWithPrice.new_price !== null 
                ? `${parseFloat(targetFormWithPrice.new_price).toFixed(2)+" "+targetFormWithPrice.currency}` 
                : '$0.00';
                let promotedDate = moment(targetFormWithPrice.promoted_date).format('DD-MM-YYYY')
                 detailHtml += `
                    <div class="col-12 mt-2">
                        <h6 class="fw-bold text-primary border-bottom pb-1 mb-2"><i class="fa fa-sliders me-1"></i> Position Promoted</h6>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="p-2 border rounded bg-light">
                            <small class="text-muted d-block" style="font-size: 11px;">From Position</small>
                            <span class="fw-bold text-dark" style="font-size: 12px;">${targetFormWithPrice.promoted_from_position}</span>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="p-2 border rounded bg-light">
                            <small class="text-muted d-block" style="font-size: 11px;">To Position</small>
                            <span class="fw-bold text-dark" style="font-size: 12px;">${targetFormWithPrice.promoted_to_position}</span>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="p-2 border rounded bg-light">
                            <small class="text-muted d-block" style="font-size: 11px;">Promoted Date</small>
                            <span class="fw-bold text-dark" style="font-size: 12px;">${promotedDate}</span>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="p-2 border rounded bg-light border-info">
                            <small class="text-muted d-block fw-normal" style="font-size: 12px;">New Price (តម្លៃជួល)</small>
                            <span class="fw-bold text-dark" style="font-size: 14px;">${newPrice}</span>
                        </div>
                    </div>
                `;
            }

            // 4. ឆែកមើល Status ប្រសិនបើ Terminated
            $('.btnStopRenting')
                    .removeClass('d-none')
                    .attr('data-motor-id', rowData.id)
                    .attr('data-form-id', targetForm.form_rental_id);
            if (targetForm.status === 'terminated') {
                detailHtml += `
                    <div class="col-12 mt-2">
                        <div class="alert alert-danger d-flex align-items-center mb-0 p-2" role="alert">
                            <i class="fa fa-exclamation-triangle me-2 fs-5"></i>
                            <div>
                                <strong>ស្ថានភាព៖ </strong> បានបញ្ចប់ការជួល (Terminated)<br>
                                <small><strong>កាលបរិច្ឆេទបញ្ចប់៖ </strong> ${targetForm.terminate_date || 'N/A'}</small>
                            </div>
                        </div>
                    </div>`;
                // $('.btnStopRenting').addClass('d-none');
                $('.btnPrint').addClass('d-none');
            } else {
                let formType = (targetFormWithPrice.type || targetForm.type || '').toLowerCase().trim();

                $('.btnPrint').removeClass('d-none').attr('data-type', formType);
               
            }

            $('#detail_form_container').html(detailHtml);
            $('#modal_view_form_details').modal('show');
        });
        $(".btnPrint").on("click", function (e) {
            e.preventDefault(); 
            let type = $(this).attr("data-type") || $(this).data("type");
            $('#modal-loading').modal('show');
            print_pdf(type);
        });
        $(document).on("click", ".btn-upload-contract", function () {
            let id = $(this).data("id");
            $("#motor_id").val(id);
            $("#importContract").modal("show");
        });
    });

    function datashowTables() {
        $('#loading-overlay').show();

        var tableId = '#DataTables_Table_0';
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().clear().destroy();
            $(tableId + ' tbody').empty(); 
        }
        $(tableId).DataTable({
            retrieve: true, // បន្ថែម options នេះដើម្បីការពារ error duplicate
            processing: true,
            serverSide: true,
            pageLength: 10,
            order: [[0, 'desc']],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '{{ url("/motor-rentel/list") }}',
                type: 'GET',
                data: function (d) {
                    // d.department_id = $("#department_id").val();
                    // d.branch_id = $("#branch_id").val();
                    d.from_date = $("#from_date").val();
                    d.to_date = $("#to_date").val();
                },
                dataSrc: function (json) {
                    return json.data;
                },
                error: function (xhr, error, code) {
                    $('#loading-overlay').hide();
                    console.error("DataTables Error: ", xhr.responseText);
                }
            },
            columns: [
                { 
                    data: null, 
                    name: 'id',
                    className: 'ids stuck-scroll-3',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { 
                    data: 'user.number_employee', 
                    name: 'user.number_employee', 
                    className: 'number_employee_id stuck-scroll-3',
                    defaultContent: ''
                },
                { 
                    data: null, 
                    name: 'user.employee_name_en',
                    className: 'stuck-scroll-3',
                    render: function (data, type, row) {
                        if (!row.user) return '';
                        let isEn = '{{ Helper::getLang() }}' === 'en';
                        return isEn ? row.user.employee_name_en : row.user.employee_name_kh;
                    }
                },
                { 
                    data: null, 
                    name: 'user.gender',
                    render: function (data, type, row) {
                        if (!row.user.gender) return '';
                        let isEn = '{{ Helper::getLang() }}' === 'en';
                        return isEn ? row.user.gender.name_english : row.user.gender.name_khmer;
                    }
                },
                { 
                    data: null, 
                    name: 'user.position',
                    render: function (data, type, row) {
                        if (!row.user.position) return '';
                        let isEn = '{{ Helper::getLang() }}' === 'en';
                        return isEn ? row.user.position.name_english : row.user.position.name_khmer;
                    }
                },
                { 
                    data: null, 
                    name: 'user.branch',
                    render: function (data, type, row) {
                        if (!row.user.branch) return '';
                        let isEn = '{{ Helper::getLang() }}' === 'en';
                        return isEn ? row.user.branch.branch_name_en : row.user.branch.branch_name_kh;
                    }
                },
                { 
                    data: 'resign_date', 
                    name: 'resign_date',
                    render: function (data) {
                        if (!data) return '';
                        return `<span style="font-size: 13px" class="badge bg-inverse-danger">${moment(data).format('DD-MMM-YYYY')}</span>`;
                    }
                },
                {
                    data: 'form_rental',
                    name: 'form_rental',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        if (!data) return '';

                        let forms = [];
                        try {
                            forms = typeof data === 'string' ? JSON.parse(data) : data;
                        } catch (e) {
                            forms = [];
                        }

                        if (!Array.isArray(forms) || forms.length === 0) return '';

                        let badges = '';
                        forms.forEach(function (formItem, index) {
                            let formName = formItem.form_name;
                            let status = formItem.status;

                            // បើ Terminated ប្រើ bg-danger, បើ Active ប្រើ bg-inverse-info
                            let badgeClass = (status === 'terminated') ? 'bg-danger' : 'bg-inverse-info';

                            badges += `<span class="badge ${badgeClass} me-1 mb-1 btn-view-single-form" 
                                            style="font-size: 11px; cursor: pointer;" 
                                            data-row-id="${row.id}" 
                                            data-form-index="${index}">
                                            <i class="fa fa-eye me-1"></i>${formName}
                                    </span>`;
                        });

                        return badges;
                    }
                },
                // ==================== 💡 បន្ថែម COLUMN PRICE ទាំង ៣ ត្រង់នេះ ====================
                { 
                    data: "payment_status", 
                    name: "payment_status",
                    render: function (data, type) {
                        if (!data || data === "new") return `<span style="font-size: 13px" class="badge bg-inverse-warning">New Payment</span>`;
                        if (data === "update") return `<span style="font-size: 13px" class="badge bg-inverse-success">Updated Data</span>`;
                        return `<span style="font-size: 13px" class="badge bg-inverse-success">Current Payment</span>`;
                    }
                },
                // 1. Column: Motor Rental Price
                { 
                    data: null, 
                    name: 'price_motor_rental',
                    render: function (data, type, row) {
                        let forms = row.form_rental_with_price || [];
                        let motorForm = forms.find(f => f.type && f.type.toLowerCase() === 'motorcycle');
                        
                        if (motorForm && motorForm.price) {
                            let isKhr = (motorForm.currency || '').toUpperCase() === 'KHR';
                            let currency = isKhr ? '៛' : '$';
                            let formattedPrice = isKhr 
                                ? parseInt(motorForm.price).toLocaleString() 
                                : parseFloat(motorForm.price).toFixed(2);

                            return `<span class="fw-bold text-dark">${currency}${formattedPrice}</span>`;
                        }
                        return '$0.00';
                    }
                },
                { 
                    data: null, 
                    name: 'price_motor_rental',
                    render: function (data, type, row) {
                        let forms = row.form_rental_with_price || [];
                        let motorForm = forms.find(f => f.type && f.type.toLowerCase() === 'motorcycle');
                        
                        if (motorForm && motorForm.new_price) {
                            let isKhr = (motorForm.currency || '').toUpperCase() === 'KHR';
                            let currency = isKhr ? '៛' : '$';
                            let formattedPrice = isKhr 
                                ? parseInt(motorForm.new_price).toLocaleString() 
                                : parseFloat(motorForm.new_price).toFixed(2);

                            return `<span class="fw-bold text-dark">${currency}${formattedPrice}</span>`;
                        }
                        return '$0.00';
                    }
                },
                // 2. Column: Tablet Price
                { 
                    data: null, 
                    name: 'tablet_price',
                    render: function (data, type, row) {
                        let forms = row.form_rental_with_price || [];
                        let tabletForm = forms.find(f => f.type && f.type.toLowerCase() === 'tablet');
                        
                        if (tabletForm && tabletForm.price) {
                            let isKhr = (tabletForm.currency || '').toUpperCase() === 'KHR';
                            let currency = isKhr ? '៛' : '$';
                            let formattedPrice = isKhr 
                                ? parseInt(tabletForm.price).toLocaleString() 
                                : parseFloat(tabletForm.price).toFixed(2);

                            return `<span class="fw-bold text-dark">${currency}${formattedPrice}</span>`;
                        }
                        return '$0.00';
                    }
                },

                // 3. Column: Car Price
                // { 
                //     data: null, 
                //     name: 'car_price',
                //     render: function (data, type, row) {
                //         let forms = row.form_rental_with_price || [];
                //         let carForm = forms.find(f => f.type && f.type.toLowerCase() === 'car');
                        
                //         if (carForm && carForm.price) {
                //             let isKhr = (carForm.currency || '').toUpperCase() === 'KHR';
                //             let currency = isKhr ? '៛' : '$';
                //             let formattedPrice = isKhr 
                //                 ? parseInt(carForm.price).toLocaleString() 
                //                 : parseFloat(carForm.price).toFixed(2);

                //             return `<span class="fw-bold text-dark">${currency}${formattedPrice}</span>`;
                //         }
                //         return '$0.00';
                //     }
                // },
                // ==============================================================================
                
                { 
                    data: null, 
                    name: 'status',
                    render: function (data, type, row) {
                        let isUpdate = '{{ $permission->is_update }}' === '1';
                        let isResigned = row.resigned_date ? true : false;
                        
                        let statusText = isResigned ? '@lang("lang.inactive")' : '@lang("lang.active")';
                        let statusIcon = isResigned ? 'text-danger' : 'text-success';
                        
                        if (!isUpdate) {
                            return `
                                <div class="dropdown action-label">
                                    <a class="btn btn-white btn-sm btn-rounded" href="#">
                                        <i class="fa fa-dot-circle-o ${statusIcon}"></i>
                                        <span>${statusText}</span>
                                    </a>
                                </div>`;
                        }

                        return `
                            <div class="dropdown action-label">
                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-dot-circle-o ${statusIcon}"></i>
                                    <span>${statusText}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" id="btn-status">
                                    <a class="dropdown-item change-status" data-id="${row.id}" data-name="1" data-status-old="${row.status}" href="#">
                                        <i class="fa fa-dot-circle-o text-success"></i> @lang('lang.active')
                                    </a>
                                    <a class="dropdown-item change-status" data-id="${row.id}" data-name="0" data-status-old="${row.status}" href="#">
                                        <i class="fa fa-dot-circle-o text-danger"></i> @lang('lang.inactive')
                                    </a>
                                </div>
                            </div>`;
                    }
                },
                { 
                    data: 'resigned_date', 
                    name: 'resigned_date',
                    render: function (data) {
                        if (!data) return '';
                        return `<span style="font-size: 13px" class="badge bg-inverse-danger">${moment(data).format('DD-MMM-YYYY')}</span>`;
                    }
                },
                {
                    data: 'contract',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        if (data) {
                            return `
                                <small class="block text-ellipsis">
                                    <a href="{{asset("/uploads/rentalContracts")}}/${data}" target="_blank">
                                        <i class="la la-file-pdf"></i>
                                        <span>@lang('lang.preview') @lang('lang.contract')</span>
                                    </a>
                                </small>
                            `;
                        }
                        return ` `;
                    }
                },
                { 
                    data: 'created_at', 
                    name: 'created_at',
                    render: function (data) {
                        return data ? moment(data).format('DD-MMM-YYYY') : '';
                    }
                },
                { 
                    data: null, 
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        let isUpdate = '{{ $permission->is_update }}' === '1';
                        let isDelete = '{{ $permission->is_delete }}' === '1';
                        let isPrint = '{{ $permission->is_print }}' === '1';

                        if (!isUpdate && !isDelete) return '';
                        let editUrl = "{{ url('motor-rentel/form-edit') }}/" + row.id;

                        // let printBtn = isPrint ? `<a class="dropdown-item" data-id="${row.id}"><i class="fa fa-print fa-lg m-r-5"></i> @lang("lang.print")</a>` : '';
                        let editBtn = isUpdate ? `<a href="${editUrl}" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>` : '';
                        let deleteBtn = isDelete ? `<a class="dropdown-item btn-delete" data-id="${row.id}"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>` : '';
                        let uploadBtn = isUpdate ? `<a class="dropdown-item btn-upload-contract" data-id="${row.id}"><i class="fa fa-solid fa-upload"></i> @lang('lang.upload') @lang('lang.contract')</a>`:'';
                        return `
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    ${editBtn}
                                    ${deleteBtn}
                                    ${uploadBtn}
                                </div>
                            </div>`;
                    }
                }
            ],
            drawCallback: function() {
                $('#loading-overlay').hide();
            }
        });
    }
    function print_pdf(type) {
        let form_print = type == "motorcycle" ? "print_purchase" : "print_tablet";
        $('#modal_view_form_details').modal('hide');
        $("#"+form_print).show();
        window.setTimeout(function() {
            $('#modal-loading').modal('hide');
        }, 2000);
        $("#"+form_print).printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_table_rental.css')}}",
            header: "",
            printDelay: 1500,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>
@endsection
