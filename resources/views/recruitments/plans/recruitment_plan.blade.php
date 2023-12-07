@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }
    .wrapper {
        width: 100%;
        height: auto;
        overflow: auto;
        position: relative;
        padding-left: 0 !important;
    }
    .custom-table
    tr>th {
        position: sticky;
        background: #fff !important;
    }

    .custom-table thead {
        top: 0;
        z-index: 2;
    }

    .custom-table tr>th {
        left: 0;
        z-index: 1;
    }

    .custom-table thead tr>th:first-child {
        z-index: 3;
    }
    .plan_date {
        position: relative;
    }

    input[type="month"]::-webkit-calendar-picker-indicator {
        background-position: right;
        background-size: auto;
        cursor: pointer;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 10;
        top: 0;
        height: auto;
        width: auto;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.recruitment_plans')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.recruitment_plans')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (permissionAccess("m3-s2","is_create")->value == "1")
                    <a href="#" class="btn add-btn" id="add_new" data-bs-toggle="modal"
                        data-bs-target="#add_plan"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        @if (permissionAccess("m3-s2","is_view")->value == "1")
            <form class="needs-validation" novalidate>
                @csrf
                <div class="row filter-btn">
                        <div class="col-sm-6 col-md-2"> 
                        <div class="form-group">
                            <select class="select form-control floating select2-hidden-accessible" data-select2-id="select2-data-1-cyfe" id="position_id" name="position_id" tabindex="-1" aria-hidden="true">
                                <option value="" data-select2-id="select2-data-3-c0n2">@lang('lang.all_position') </option>
                                @foreach ($positions as $position )
                                    <option value="{{ $position->id }}">{{ Helper::getLang() == 'en' ? $position->name_english : $position->name_khmer}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                            <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                                <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_location')</option>
                                @foreach ($branchs as $item)
                                    <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class=".col-sm-6  col-md-2">
                        <div class="form-group">
                            <select class="select form-control" id="filter_year">
                                <option value="">@lang('lang.select_year')</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" id="icon-search-download-reload" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('lang.search')">
                                <span class="btn-search-txt">
                                    <i class="fa fa-search"></i>
                                </span>
                                <span class="search-loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                            @if (permissionAccess("m3-s2","is_print")->value == "1")
                                <button type="button" class="btn btn-outline-secondary btn-sm btn_print me-2" id="icon-search-download-reload" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('lang.print')">
                                    <span class="btn-text-print"><i class="fa fa-print fa-lg"></i></span>
                                    <span id="btn-text-loading-print" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                                </button>
                            @endif
                            @if (permissionAccess("m3-s2","is_export")->value == "1")
                                <button type="button" class="btn btn-outline-secondary btn-sm me-2 btn_excel" id="icon-search-download-reload" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('lang.download')">
                                    <span class="btn-text-excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
                                    <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                                </button>
                            @endif
                           
                            <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('lang.reload')">
                                <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            {!! Toastr::message() !!}
            <div class="">
                <div id="card_by_branch"></div>
            </div>
            <div id="add_plan" class="modal custom-modal fade hr-modal-select2" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">@lang('lang.add_new_plan')</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('recruitment/plan-store') }}" method="POST" enctype="multipart/form-data"
                                class="needs-validation" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group hr-form-group-select2">
                                            <label>@lang('lang.position')<span class="text-danger">*</span></label>
                                            <select class="form-select hr-select2-option" name="position_id" id="select-position-opsition" required>
                                                <option selected disabled value="">@lang('lang.select')</option>
                                                @foreach ($positions as $item)
                                                    <option value="{{ $item->id }}">{{ Helper::getLang() == 'en' ? $item->name_english :  $item->name_khmer}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group hr-form-group-select2">
                                            <label>@lang('lang.location') <span class="text-danger">*</span></label>
                                            <select class="form-select hr-select2-option" name="branch_id" required>
                                                <option selected disabled value="">@lang('lang.select')</option>
                                                @foreach ($branchs as $item)
                                                    <option value="{{ $item->id }}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row new_element_inp">
                                    <div class="col-sm-6 col-md-6 element-plan-month-year">
                                        <div class="form-group">
                                            <label>@lang('lang.plan_of_year') <span class="text-danger">*</span></label>
                                            <input class="form-control plan_date" type="month" name="plan_date[]" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 element-plan-total-staff">
                                        <div class="form-group">
                                            <label>@lang('lang.total_staff') <span class="text-danger">*</span></label>
                                            <div style="display: flex">
                                                <input class="form-control me-3 @error('total_staff') is-invalid @enderror" type="number" name="total_staff[]" required>
                                                <div>
                                                    <a href="javascript:void(0);" class="delete-icon education-delete-element"><i class="fa fa-trash-o" style="margin-top: 12px;"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="multi_add_plan"></div>
                                <div class="row">
                                    <div class="col-ms-12 col-md-12">
                                        <div class="add-more">
                                            <a class="float-end" id="btnAddEducation"><i class="fa fa-plus-circle"></i> @lang('lang.add_more')</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="">@lang('lang.remark')</label>
                                            <textarea type="text" rows="3" class="form-control" name="remark" id="remark" value="{{ old('remark') }}"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button type="submit" class="btn btn-primary submit-btn">
                                        <span class="loading-icon" style="display: none"><i
                                                class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                        <span class="btn-txt">@lang('lang.submit')</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @include('recruitments.plans.recruitment_plan_print')
@endsection

@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(function() {
        showDatas();
        var currentYear = 2010;
        var currentDiff = moment(new Date()).format('y');
        let newYear = Number(currentDiff) + 10;
        filterYear(currentYear,newYear)
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('recruitment/plan-list') }}"); 
        });
        $(".btn-search").on("click", function(){
            $(this).prop('disabled', true);
            $(".btn-search-txt").hide();
            $(".search-loading-icon").css('display', 'block');
            let filter = {
                position_id: $("#position_id").val(),
                branch_id: $("#branch_id").val(),
                filter_year: $("#filter_year").val(),
            };
            showDatas(filter);
        });

        $(".btn_print").on("click", function (){
            $("#btn-text-loading-print").css('display', 'block');
            $(".btn_print").prop('disabled', true);
            $(".btn-text-print").css("display", "none");
            print_pdf();
        });

        $(".btn_excel").on("click", function () {
            $("#btn-text-loading-excel").css('display', 'block');
            $(".btn_excel").prop('disabled', true);
            $(".btn-text-excel").css("display", "none");
            var query = {
                position_id: $("#position_id").val() ? $("#position_id").val() : null,
                branch_id: $("#branch_id").val() ? $("#branch_id").val() : null,
                filter_year: $("#filter_year").val() ? $("#filter_year").val() : null,
            }
            var url = "{{URL::to('recruitment/plan/export')}}?" + $.param(query)
            window.location = url;
            window.setTimeout(function() {
                $(".btn_excel").prop('disabled', false);
                $(".btn-text-excel").show();
                $("#btn-text-loading-excel").css('display', 'none');
            }, 2000);
        });

        $('#btnAddEducation').on('click', function() {
            $('.new_element_inp:first').clone().appendTo('#multi_add_plan');
            var lastElementMonthYear = $('.new_element_inp:last');
            var inputMonthYear = lastElementMonthYear.find('input');
            inputMonthYear.val('');
        });

        $('body').on('click', '.education-delete-element', function() {
            if ($('.new_element_inp').length > 1) {
                $(this).closest('.new_element_inp').remove();
            }
        });
    });

    function filterYear(currentYear, expiretedYear) {
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
            $('#filter_year').append($('<option>', option));
        });
    }

    function showDatas(params){
        $.ajax({
            type: "POST",
            url: "{{ url('recruitment/show') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                position_id: params ? params.position_id ? params.position_id : null : null,
                branch_id: params ? params.branch_id ? params.branch_id : null : null,
                filter_year: params ? params.filter_year ? params.filter_year : null : null,
            },
            dataType: "JSON",
            success: function(response) {
                $(".btn-search").prop('disabled', false);
                $(".btn-search-txt").show();
                $(".search-loading-icon").css('display', 'none');
                let data_postion = response.success;

                branchs = Object.values(data_postion.reduce((r,o) => {
                    let year = moment(o.plan_date).format('y');
                    const key = `${o.branch_id}_${year}`;
                    r[key] = r[key] || {branch_id: o.branch_id, year: o.plan_date,  branch: ""};
                    r[key].branch_name_en = o.branch.branch_name_en;
                    r[key].position_id = o.position_id;
                    return r;
                }, {}));

                positions = Object.values(data_postion.reduce((r,o) => {
                    const key = `${o.branch_id}_${o.position_id}`;
                    r[key] = r[key] || {branch_id: o.branch_id, position_id: o.position_id, position: "", total_staff: 0};
                    r[key].position = o.position.name_english;
                    r[key].plan_date = o.plan_date;
                    r[key].total_staff += +o.total_staff;
                    return r;
                }, {}));

                let bydate = Object.values(data_postion.reduce((r,o) => {
                    const key = `${o.branch_id}_${o.position_id}_${o.plan_date}`;
                    r[key] = r[key] || {branch_id: o.branch_id, position_id: o.position_id, plan_date: o.plan_date, position: "", total_staff: 0};
                    r[key].position = o.position.name_english;
                    r[key].total_staff += +o.total_staff;
                    return r;
                }, {}));

                var div = "";
                var tatle_print ="";
                if (branchs.length) { 
                    branchs.map((br) => {
                        let tbd = "";
                        let tdb_print = "";
                        let tfoot_print = "";
                        let tfoot = "";
                        let br_year = moment(br.year).format('y');
                        positions.map((pos) => {
                            let td = ""
                            let tf = "";
                            for (x = 1; x <= 12; x++) {
                                let number_staff = 0;
                                let total_staff_by_month = 0;

                                let year = moment(pos.plan_date).format('y');
                                let x_month = year+'-'+x;
                                bydate.map((date) =>{
                                    let total_staff = 0;
                                    let year_month = moment(date.plan_date).format('y-M');
                                    if (date.branch_id == pos.branch_id && date.position_id == pos.position_id && year_month == x_month) {
                                        number_staff += date.total_staff;
                                    };
                                    if (date.branch_id == pos.branch_id  && year_month == x_month) {
                                        total_staff = date.total_staff;
                                        total_staff_by_month += total_staff++;
                                    }
                                });
                                td +='<td>'+(number_staff)+'</td>';
                                tf +='<td>'+(total_staff_by_month)+'</td>';
                            }
                            
                            
                            let pos_year = moment(pos.plan_date).format('y');
                            if (pos.branch_id == br.branch_id && pos_year == br_year) {
                                tbd += '<tbody>'+
                                        '<tr class="odd">'+
                                            '<th>'+(pos.position)+'</th>'+
                                            (td)+
                                            // '<td>'+(pos.total_staff)+'</td>'+
                                            '<td class="text-end">'+
                                                '<div class="dropdown dropdown-action">'+
                                                    '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>'+
                                                    '<div class="dropdown-menu dropdown-menu-right">'+
                                                        '<a class="dropdown-item detail" href="{{url("/recruitment/detail")}}/'+(pos.branch_id)+'/'+(pos.position_id)+'/'+(br_year)+'">'+
                                                        '<i class="fa fa-eye m-r-5"></i> @lang("lang.view_details")</a>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</td>'+
                                        '</tr>'+
                                '</tbody>';
                                tfoot = '<tfoot>'+
                                        '<tr>'+
                                            '<th style="text-align: center">@lang("lang.total")</th>'+
                                            (tf)+
                                            '<td></td>'+
                                    ' </tr>'+
                                '</tfoot>';

                                 // tbody print
                                 tdb_print += '<tbody>'+
                                        '<tr>'+
                                            '<td>'+(pos.position)+'</td>'+
                                            (td)+
                                        '</tr>'+
                                '</tbody>';
                                tfoot_print = '<tfoot>'+
                                        '<tr>'+
                                            '<td style="text-align: center">@lang("lang.total")</td>'+
                                            (tf)+
                                    ' </tr>'+
                                '</tfoot>';
                            }
                        });
                        if (tbd) {
                            let plan_year = moment(br.year).format('y');
                            $("#print_year").text(plan_year);
                            div +='<div class="card">'+
                                '<div class="card-header">'+
                                    '<h4><strong>@lang("lang.location"):</strong> '+(br.branch_name_en)+'</h4>'+
                                    '<h4 style="text-align: center"><strong>@lang("lang.projected_staff"):</strong> '+(plan_year)+'</h4>'+
                                '</div>'+
                                '<div class="wrapper">'+
                                    '<table class="table table-responsive table-striped custom-table mb-0 no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Position: activate to sort column descending" style="width: 30px;">@lang("lang.position")</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="January: activate to sort column ascending" style="width: 772.237px;">@lang("lang.january")</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="February: activate to sort column ascending" style="width: 772.237px;">@lang("lang.february")</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="March: activate to sort column ascending" style="width: 772.237px;">@lang("lang.march")</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="April: activate to sort column ascending" style="width: 772.237px;">@lang("lang.april")</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="May: activate to sort column ascending" style="width: 772.237px;">@lang("lang.may")</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="June: activate to sort column ascending" style="width: 772.237px;">@lang("lang.june")</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="July: activate to sort column ascending" style="width: 300.962px;">@lang("lang.july")</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="August: activate to sort column ascending" style="width: 300.962px;">@lang("lang.august")</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="September: activate to sort column ascending" style="width: 300.962px;">@lang("lang.september")</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="October: activate to sort column ascending" style="width: 300.962px;">@lang("lang.october")</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="November: activate to sort column ascending" style="width: 300.962px;">@lang("lang.november")</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="December: activate to sort column ascending" style="width: 300.962px;">@lang("lang.december")</th>'+
                                                // '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Total: activate to sort column ascending" style="width: 300.962px;">Total</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 300.962px;">@lang("lang.action")</th>'+
                                            '</tr>'+
                                        '</thead>'+
                                                (tbd)+
                                                (tfoot)+
                                    '</table>'+
                                '</div>'+
                            '</div>';
                            tatle_print += '<h4><strong>@lang("lang.location"):</strong> '+(br.branch_name_en)+'</h4>'+
                                    '<table class="table-print">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th >@lang("lang.position")</th>'+
                                                '<th >@lang("lang.january")</th>'+
                                                '<th >@lang("lang.february")</th>'+
                                                '<th >@lang("lang.march")</th>'+
                                                '<th >@lang("lang.april")</th>'+
                                                '<th >@lang("lang.may")</th>'+
                                                '<th >@lang("lang.june")</th>'+
                                                '<th >@lang("lang.july")</th>'+
                                                '<th >@lang("lang.august")</th>'+
                                                '<th >@lang("lang.september")</th>'+
                                                '<th >@lang("lang.october")</th>'+
                                                '<th >@lang("lang.november")</th>'+
                                                '<th >@lang("lang.december")</th>'+
                                            '</tr>'+
                                        '</thead>'+
                                                (tdb_print)+
                                                (tfoot_print)+
                                    '</table>';
                        }
                    });   
                }else{
                    var div ='<div class="card text-center">'+
                        '<div class="card-body">'+
                            '<p class="card-text">@lang("lang.no_data_available_for_display").</p>'+
                        '</div>'+
                    '</div>';
                }
                $("#card_by_branch").html(div);
                $("#form_print").html(tatle_print);
            }
        });
    }
    function print_pdf(type) {
        $("#print_purchase").show();
        window.setTimeout(function() {
            $("#print_purchase").hide();
            $(".btn_print").prop('disabled', false);
            $(".btn-text-print").show();
            $("#btn-text-loading-print").css('display', 'none');
        }, 2000);
        $("#print_purchase").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style-templete-recruitment-plan.css')}}",
            header: "",
            printDelay: 1000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>
