@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }

    .ui-datepicker-calendar {
        display: none;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.training_reports')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.training_reports')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
            </div>
        </div>
        @if (permissionAccess("m6-s3","is_view")->value == "1" )
            <form  class="needs-validation" novalidate>
                {{-- @csrf --}}
                
                <div class="row">
                    @if (Auth::user()->RolePermission != 'Employee')
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control" name="employee_id" placeholder="@lang('lang.employee_id')" id="employee_id"
                                    value="{{ old('employee_id') }}">
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input class="form-control floating" type="text" id="employee_name" name="employee_name"
                                    placeholder="@lang('lang.employee_name')">
                            </div>
                        </div>
                    @endif
                    
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <input class="form-control floating" type="text" id="course_name" name="course_name" placeholder="@lang('lang.course_name')">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <select class="select form-control" data-select2-id="select2-data-2-c0n2" name="traing_type" id="training_type">
                                <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_training_type')</option>
                                <option value="1">@lang('lang.internal')</option>
                                <option value="2">@lang('lang.external')</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" id="start_date" name="start_date"
                                    placeholder="@lang('lang.start_date')">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" id="end_date" name="end_date" placeholder="@lang('lang.end_date')">
                            </div>
                        </div>
                    </div>
                    <div class="<?php echo Auth::user()->RolePermission == 'Employee' ? 'col-sm-4 col-md-4' : 'col-sm-12 col-md-12'; ?>">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary submit-btn btn-research me-2" data-dismiss="modal" id="icon-search-download-reload">
                                <span class="btn-txt"><i class="fa fa-search"></i></span>
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                            @if (permissionAccess("m6-s3","is_print")->value == "1" )
                                <button type="button" class="btn btn-sm btn-outline-secondary btn_print me-2" id="icon-search-download-reload">
                                    <span class="btn-text-print"><i class="fa fa-print fa-lg"></i></span>
                                    <span id="btn-text-loading-print" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                                </button>
                            @endif
                            @if (permissionAccess("m6-s3","is_export")->value == "1" )
                                <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                                    <span class="btn-text-excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
                                    <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                                </button>
                            @endif
                            <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                                <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="content">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form method="GET" class="mb-3">
                                            <label>Show 
                                                <select name="per_page" onchange="this.form.submit()" class="per_page">
                                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                                    <option value="200" {{ request('per_page') == 200 ? 'selected' : '' }}>200</option>
                                                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>All</option>
                                                </select> entries
                                            </label>
                                        </form>
                                        <table
                                            class="table table-striped custom-table mb-0  no-footer tbl-traingin-report">
                                            <thead>
                                                <tr>
                                                    <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="Profle: activate to sort column descending"
                                                        style="width: 94.0625px;">#</th>
                                                    <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="Employee ID: activate to sort column ascending"
                                                        style="width: 94.0625px;">@lang('lang.id_card')</th>
                                                    <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="Employee name: activate to sort column descending"
                                                        style="width: 178px;">@lang('lang.name_kh')</th>
                                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="Employee name: activate to sort column descending"
                                                        style="width: 178px;">@lang('lang.name_en')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="Gender: activate to sort column ascending"
                                                        style="width: 125.15px;">@lang('lang.gender')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 125.15px;">@lang('lang.position')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Date of Employment: activate to sort column ascending"
                                                        style="width: 125.15px;">@lang('lang.date_of_employment')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Seniority: activate to sort column ascending"
                                                        style="width: 125.15px;">@lang('lang.length_of_employment')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Course Name: activate to sort column ascending"
                                                        style="width: 125.15px;">@lang('lang.course_name')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Branch name: activate to sort column ascending"
                                                        style="width: 125.15px;">@lang('lang.location')</th>
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
                                                        aria-label="Duration of service: activate to sort column ascending"
                                                        style="width: 125.15px;">@lang('lang.duration_term')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Price/Unit: activate to sort column ascending"
                                                        style="width: 125.15px;">@lang('lang.price/unit')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Discount Price: activate to sort column ascending"
                                                        style="width: 125.15px;">@lang('lang.discount_fee')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Total: activate to sort column ascending"
                                                        style="width: 125.15px;">@lang('lang.total')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Trainer: activate to sort column ascending"
                                                        style="width: 125.15px;">@lang('lang.trainer')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Type of Training: activate to sort column ascending"
                                                        style="width: 125.15px;">@lang('lang.type_of_training')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Remarks: activate to sort column ascending"
                                                        style="width: 125.15px;">@lang('lang.remark')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($dataTrainings) > 0)
                                                    @php
                                                        $num = 0;
                                                    @endphp
                                                    @foreach ($dataTrainings as $key=>$item)
                                                        @php
                                                         $num++;
                                                            $price = 0;
                                                            $discount = 0;
                                                            $total = 0;
                                                            $trainer = null;
                                                            if($item->training){
                                                                $price =  ($item->training->cost_price / $item->training->training_detail_staffs_count);
                                                                $discount = ($item->training->discount/ $item->training->training_detail_staffs_count);
                                                                $total = $price - $discount;

                                                                if (count($item->training->trainingDetailTrainer) == 1) {
                                                                    $trainer = $item->training->trainingDetailTrainer[0]->trainer->type == 2 ? $item->training->trainingDetailTrainer[0]->trainer->name_en : $item->training->trainingDetailTrainer[0]->trainer->employee->employee_name_en;
                                                                }else{
                                                                    foreach ($item->training->trainingDetailTrainer as $key => $trai) {
                                                                        $trainer .= $trai->trainer->type == 2 ? $trai->trainer->name_en : $trai->trainer->employee->employee_name_en.', ';
                                                                    }
                                                                }
                                                            }
                                                        @endphp
                                                            <tr class="odd">
                                                                <td class="ids stuck-scroll-3">{{ $num }}</td>
                                                                <td class="stuck-scroll-3">{{ $item->employee->number_employee }}</td>
                                                                <td class="stuck-scroll-3">{{ $item->employee->employee_name_kh }}</td>
                                                                <td>{{$item->employee->employee_name_en}}</td>
                                                                <td>{{$item->employee->EmployeeGender}}</td>
                                                                <td>{{$item->employee->EmployeePosition}}</td>
                                                                <td>{{ \Carbon\Carbon::parse($item->employee->date_of_commencement)->format('d-M-Y') ?? '' }}</td>
                                                                <td>{{$item->employee->SeniorityYearsOfEmployee}}</td>
                                                                <td>{{$item->training->course_name}}</td>
                                                                <td>{{$item->employee->EmployeeBranch}}</td>
                                                                <td>{{ $item->training ? \Carbon\Carbon::parse($item->training->start_date)->format('d-M-Y') : ''}}</td>
                                                                <td>{{ $item->training ? \Carbon\Carbon::parse($item->training->end_date)->format('d-M-Y') : '' }}</td>
                                                                <td>
                                                                    <span style="font-size: 13px" class="badge bg-inverse-danger">{{ $item->training ? ($item->training->duration_month ? \Carbon\Carbon::parse($item->training->end_date)->addMonth($item->training->duration_month)->format('d-M-Y') : 0): 0}}</span>
                                                                </td>
                                                                <td>$ {{round($price, 2)}}</td>
                                                                <td>$ {{round($discount, 2)}}</td>
                                                                <td>$ {{round($total, 2)}}</td>
                                                                <td> {{$trainer}}</td>
                                                                <td>{{ $item->training ? ($item->training->training_type == 1 ? "Internal" : "External") : ""}}</td>
                                                                <td>{{$item->training ? ($item->training->remark ? $item->training->remark : ""): ""}}</td>
                                                            </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        {!! $dataTrainings->withQueryString()->links('pagination::bootstrap-5') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @include('training.templete_print_report')
@endsection

@include('includs.script')
<script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function() {
        $(".btn-research").on("click", function () {
            $(this).prop('disabled', true);
            $(".btn-txt").hide();
            $(".loading-icon").css('display', 'block');
            let currentPage = $(".per_page").val();
            let param = {
                "_token": "{{ csrf_token() }}",
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                course_name: $("#course_name").val(),
                start_date: $("#start_date").val(),
                end_date: $("#end_date").val(),
                traing_type: $("#training_type").val(),
                per_page: currentPage,
            };
            showdatas(param);
        });
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('/reports/training-report') }}"); 
        });
        $(".btn_print").on("click", function() {
            $("#btn-text-loading-print").css('display', 'block');
            $(".btn_print").prop('disabled', true);
            $(".btn-text-print").css("display", "none");
            let currentPage = $(".per_page").val();
            let param = {
                "_token": "{{ csrf_token() }}",
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                course_name: $("#course_name").val(),
                start_date: $("#start_date").val(),
                end_date: $("#end_date").val(),
                traing_type: $("#training_type").val(),
                btn_print: true,
                per_page: currentPage,
            };
            showdatas(param)
            print_pdf();
        });
        $(".btn_excel").on("click", function () {
            let currentPage = $(".per_page").val();
            var query = {
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                course_name: $("#course_name").val(),
                start_date: $("#start_date").val(),
                end_date: $("#end_date").val(),
                traing_type: $("#training_type").val(),
                per_page: currentPage,
            }
            var url = "{{URL::to('reports/training-export')}}?" + $.param(query)
            window.location = url;
        });
    });
    function showdatas(param) {  
        $.ajax({
            url: "{{ url('reports/training-report-filter') }}",
            type: 'POST',
            data:param,
            dataType: 'JSON',
            success: function(response){
                dataPrint = response.data;
                let datas = response.data;
                var tr = "";
                var tr_print = "";
                let num = 0;
                if (datas.length > 0) {
                    datas.forEach(item => {
                        let start_date = moment(item.training.start_date).format('DD-MMM-YYYY');
                        let end_date = moment(item.training.end_date).format('DD-MMM-YYYY');
                        let month = item.training.duration_month ? moment(item.training.end_date).add(item.training.duration_month, 'M').format('DD-MMM-YYYY') : 0;
                        let duration_month = '<span style="font-size: 13px" class="badge bg-inverse-danger">'+(month)+'</span>';
                        let price = 0;
                        let discount = 0;
                        let total = 0;
                        let trainer = '';
                        if(item.training){
                            price =  (item.training.cost_price / item.training.training_detail_staffs_count);
                            discount = (item.training.discount / item.training.training_detail_staffs_count);
                            total = price - discount;

                            if (item.training.training_detail_trainer.length == 1) {
                                trainer = item.training.training_detail_trainer[0].trainer.type == 2 ? item.training.training_detail_trainer[0].trainer.name_en : item.training.training_detail_trainer[0].trainer.employee.employee_name_en;
                            }else{
                                item.training.training_detail_trainer.map((trai) =>{
                                    trainer += trai.trainer.type == 2 ? trai.trainer.name_en : trai.trainer.employee.employee_name_en +', ';
                                })
                            }
                        }
                        num ++;
                        let date_ofcommencement = moment(item.employee.date_of_commencement).format('DD-MMM-YYYY');
                        let currentDate = new Date();
                        let join_date = new Date(item.employee.date_of_commencement);
                        const empl_period = diffDates(join_date, currentDate);
                        tr +='<tr class="odd">'+
                            '<td class="ids stuck-scroll-3">'+(num)+'</td>'+
                            '<td class="stuck-scroll-3">'+ item.employee.number_employee  +'</td>'+
                            '<td class="stuck-scroll-3">'+ item.employee.employee_name_kh  +'</td>'+
                            '<td>'+ item.employee.employee_name_en +'</td>'+
                            '<td>'+ item.employee.gender.name_english +'</td>'+
                            '<td>'+ item.employee.position.name_english +'</td>'+
                            '<td>'+(date_ofcommencement)+'</td>'+
                            '<td>'+(empl_period)+'</td>'+
                            '<td>'+ item.training.course_name +'</td>'+
                            '<td>'+ item.employee.branch.branch_name_en +'</td>'+
                            '<td>'+(start_date)+'</td>'+
                            '<td>'+(end_date)+'</td>'+
                            '<td>'+(duration_month)+'</td>'+
                            '<td>$ '+(parseFloat(price).toFixed(2))+'</td>'+
                            '<td>$ '+(parseFloat(discount).toFixed(2))+'</td>'+
                            '<td>$ '+(parseFloat(total).toFixed(2))+'</td>'+
                            '<td>'+ trainer +'</td>'+
                            '<td>'+ (item.training.training_type == 1 ? "Internal" : "External") +'</td>'+
                            '<td>'+ (item.training.remark ? item.training.remark : "")+'</td>'+
                        '</tr>';
                    });
                }
                if (param.btn_print) {
                    $("#form_print tbody").html(tr);
                }else{
                    $(".tbl-traingin-report tbody").html(tr);
                    $(".btn-research").prop('disabled', false);
                    $(".btn-txt").show();
                    $(".loading-icon").css('display', 'none');
                }
            }
        });
    }
    function diffDates(date1, date2) {
        // Calculate the difference in milliseconds between the two dates.
        const diffInMs = Math.abs(date2.getTime() - date1.getTime());

        // Calculate the difference in seconds, minutes, hours, days, and years.
        const diffInSecs = diffInMs / 1000;
        const diffInMins = diffInSecs / 60;
        const diffInHours = diffInMins / 60;
        const diffInDays = diffInHours / 24;
        const diffInYears = diffInDays / 365.25;

        // Round the difference in years, months, and days to the nearest integer.
        const years = Math.floor(diffInYears);
        const months = Math.floor((diffInYears - years) * 12);
        // const days = Math.floor(((diffInYears - years) * 12 - months) * 30);

        var today = new Date();
        let join_date = new Date(date1).getDate();
        let total_current_date = today.getDate();
        if (join_date > total_current_date) {
            var days = join_date - total_current_date;
        }else{
            var days = total_current_date - join_date;
        }
        return years +" years, " + months + " months, " + days + " days";
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
            loadCSS: "{{asset('/admin/css/style-templete-report-training.css')}}",
            header: "",
            printDelay: 1000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>
