@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }

    .ui-datepicker-calendar {
        display: none;
    }
    .reset-btn{
        /* background: #ffbc34 !important; */
        color: #fff !important
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Training Reports</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Training Reports</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
            </div>
        </div>
        @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
            <form  class="needs-validation" novalidate>
                {{-- @csrf --}}
                
                <div class="row">
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <input type="text" class="form-control" name="employee_id" placeholder="Employee ID" id="employee_id"
                                value="{{ old('employee_id') }}">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <input class="form-control floating" type="text" id="employee_name" name="employee_name"
                                placeholder="Employee Name">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <input class="form-control floating" type="text" id="course_name" name="course_name" placeholder="Course Name">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <select class="select form-control" data-select2-id="select2-data-2-c0n2" name="traing_type" id="training_type">
                                <option value="" data-select2-id="select2-data-2-c0n2">All Training Type</option>
                                <option value="1">Internal</option>
                                <option value="2">External</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" id="start_date" name="start_date"
                                    placeholder="Start Date">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" id="end_date" name="end_date"
                                    placeholder="End Date">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row filter-btn">
                    <div class="col-sm-2 col-md-12">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-success submit-btn me-2" id="btn-research" data-dismiss="modal">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
                                <span class="btn-txt">{{ __('Search') }}</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_print me-2">
                                <span class="btn-text-print"><i class="fa fa-print fa-lg"></i> Print</span>
                                <span id="btn-text-loading-print" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2">
                                <span class="btn-text-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</span>
                                <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-warning reset-btn">
                                <span class="btn-text-reset">Reload</span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
        <div class="content">
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table
                                        class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-traingin-report"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Profle: activate to sort column descending"
                                                    style="width: 94.0625px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Employee ID: activate to sort column ascending"
                                                    style="width: 94.0625px;">ID Card</th>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Employee name: activate to sort column descending"
                                                    style="width: 178px;">Name Kh</th>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Employee name: activate to sort column descending"
                                                    style="width: 178px;">Name En</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Gender: activate to sort column ascending"
                                                    style="width: 125.15px;">Gender</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Position: activate to sort column ascending"
                                                    style="width: 125.15px;">Position</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Date of Employment: activate to sort column ascending"
                                                    style="width: 125.15px;">Date of Employment</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Seniority: activate to sort column ascending"
                                                    style="width: 125.15px;">Length of Employment</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Course Name: activate to sort column ascending"
                                                    style="width: 125.15px;">Course Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Branch name: activate to sort column ascending"
                                                    style="width: 125.15px;">Dept/Branch</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Start Date: activate to sort column ascending"
                                                    style="width: 125.15px;">Start Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="End Date: activate to sort column ascending"
                                                    style="width: 125.15px;">End Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Duration of service: activate to sort column ascending"
                                                    style="width: 125.15px;">Duration Term</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Price/Unit: activate to sort column ascending"
                                                    style="width: 125.15px;">Price/Unit</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Discount Price: activate to sort column ascending"
                                                    style="width: 125.15px;">Discount Fee</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Total: activate to sort column ascending"
                                                    style="width: 125.15px;">Total</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Trainer: activate to sort column ascending"
                                                    style="width: 125.15px;">Trainer</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Type of Training: activate to sort column ascending"
                                                    style="width: 125.15px;">Type of Training</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Remarks: activate to sort column ascending"
                                                    style="width: 125.15px;">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($dataTrainings) > 0)
                                                @foreach ($dataTrainings as $item)
                                                    @php
                                                        $price = 0;
                                                        $discount = 0;
                                                        $total = 0;
                                                        if (count($item->employee_id) > 0) {
                                                            $price =  $item->cost_price / count($item->employee_id);
                                                            $discount = ($price * $item->discount) / 100;
                                                            $total = $price - $discount;
                                                        }
                                                        $trainer = null;
                                                        if (count($item->trainers) == 1) {
                                                            $trainer = $item->trainers[0]->type == 2 ? $item->trainers[0]->name_en : $item->trainers[0]->employee->employee_name_en;
                                                        }else{
                                                            foreach ($item->trainers as $key => $trai) {
                                                                $trainer .= $trai->type == 2 ? $trai->name_en : $trai->employee->employee_name_en.', ';
                                                            }
                                                        }
                                                    @endphp
                                                    @foreach ($item->employees as $key=>$emp)
                                                        <tr class="odd">
                                                            <td class="ids">{{ $item->id }}</td>
                                                            <td>{{ $emp->number_employee }}</td>
                                                            <td>{{ $emp->employee_name_kh }}</td>
                                                            <td>{{$emp->employee_name_en}}</td>
                                                            <td>{{$emp->EmployeeGender}}</td>
                                                            <td>{{$emp->EmployeePosition}}</td>
                                                            <td>{{ \Carbon\Carbon::parse($emp->date_of_commencement)->format('d-M-Y') ?? '' }}</td>
                                                            <td>{{$emp->SeniorityYearsOfEmployee}}</td>
                                                            <td>{{$item->course_name}}</td>
                                                            <td>{{$emp->EmployeeBranch}}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d-M-Y') ?? '' }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->end_date)->format('d-M-Y') ?? '' }}</td>
                                                            <td>
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">{{ $item->duration_month ? \Carbon\Carbon::parse($item->end_date)->addMonth($item->duration_month)->format('d-M-Y'): 0}}</span>
                                                            </td>
                                                            <td>$ {{round($price, 2)}}</td>
                                                            <td>$ {{round($discount, 2)}}</td>
                                                            <td>$ {{round($total, 2)}}</td>
                                                            <td> {{$trainer}}</td>
                                                            <td>{{ $item->training_type == 1 ? "Internal" : "External"}}</td>
                                                            <td>{{$item->remark ? $item->remark : ""}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('training.templete_print_report')
@endsection

@include('includs.script')
<script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function() {
        $("#btn-research").on("click", function () {
            $(this).prop('disabled', true);
            $(".btn-txt").hide();
            $(".loading-icon").css('display', 'block');
            let param = {
                "_token": "{{ csrf_token() }}",
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                course_name: $("#course_name").val(),
                start_date: $("#start_date").val(),
                end_date: $("#end_date").val(),
                traing_type: $("#training_type").val(),
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
            let param = {
                "_token": "{{ csrf_token() }}",
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                course_name: $("#course_name").val(),
                start_date: $("#start_date").val(),
                end_date: $("#end_date").val(),
                traing_type: $("#training_type").val(),
                btn_print: true
            };
            showdatas(param)
            print_pdf();
        });
        $(".btn_excel").on("click", function () {
            var query = {
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                course_name: $("#course_name").val(),
                start_date: $("#start_date").val(),
                end_date: $("#end_date").val(),
                traing_type: $("#training_type").val(),
            }
            var url = "{{URL::to('reports/training-export')}}?" + $.param(query)
            window.location = url;
        });
    });
    function showdatas(param) {  
        $.ajax({
            url: "{{ url('reports/training-report') }}",
            type: 'POST',
            data:param,
            dataType: 'JSON',
            success: function(data){
                dataPrint = data;
                var tr = "";
                var tr_print = "";
                if (data.length > 0) {
                    data.map((item) =>{
                        let start_date = moment(item.start_date).format('DD-MMM-YYYY');
                        let end_date = moment(item.end_date).format('DD-MMM-YYYY');
                        let month = item.duration_month ? moment(item.end_date).add(item.duration_month, 'M').format('DD-MMM-YYYY') : 0;
                        let duration_month = '<span style="font-size: 13px" class="badge bg-inverse-danger">'+(month)+'</span>';
                        let price = 0;
                        let discount = 0;
                        let total = 0;
                        if (item.employees.length > 0) {
                            price =  item.cost_price / item.employees.length;
                            discount = (price * item.discount) / 100;
                            total = price - discount;
                        }
                        let trainer = '';
                        if (item.trainers.length == 1) {
                            trainer = item.trainers[0].type == 2 ? item.trainers[0].name_en : item.trainers[0].employee.employee_name_en;
                        }else{
                            item.trainers.map((trai) => {
                                trainer += trai.type == 2 ? trai.name_en : trai.employee.employee_name_en +', ';
                            });
                        }
                        item.employees.map((emp) => {
                            let date_ofcommencement = moment(emp.date_of_commencement).format('DD-MMM-YYYY');
                            let currentDate = new Date();
                            let join_date = new Date(emp.date_of_commencement);
                            let empl_period = diff_year_month_day(join_date, currentDate);
                            tr +='<tr class="odd">'+
                                '<td class="ids">'+(item.id )+'</td>'+
                                '<td>'+(emp.number_employee )+'</td>'+
                                '<td>'+(emp.employee_name_kh )+'</td>'+
                                '<td>'+(emp.employee_name_en)+'</td>'+
                                '<td>'+(emp.gender.name_english)+'</td>'+
                                '<td>'+(emp.position.name_english)+'</td>'+
                                '<td>'+(date_ofcommencement)+'</td>'+
                                '<td>'+(empl_period)+'</td>'+
                                '<td>'+(item.course_name)+'</td>'+
                                '<td>'+(emp.branch.branch_name_en)+'</td>'+
                                '<td>'+(start_date)+'</td>'+
                                '<td>'+(end_date)+'</td>'+
                                '<td>'+(duration_month)+'</td>'+
                                '<td>$ '+(parseFloat(price).toFixed(2))+'</td>'+
                                '<td>$ '+(parseFloat(discount).toFixed(2))+'</td>'+
                                '<td>$ '+(parseFloat(total).toFixed(2))+'</td>'+
                                '<td>'+(trainer)+'</td>'+
                                '<td>'+(item.training_type == 1 ? "Internal" : "External")+'</td>'+
                                '<td>'+(item.remark ? item.remark : "")+'</td>'+
                            '</tr>';
                        });
                    });
                }
                if (param.btn_print) {
                    $("#form_print tbody").html(tr);
                }else{
                    $(".tbl-traingin-report tbody").html(tr);
                    $("#btn-research").prop('disabled', false);
                    $(".btn-txt").show();
                    $(".loading-icon").css('display', 'none');
                }
            }
        });
    }
    function diff_year_month_day(dt1, dt2){
        var time =(dt2.getTime() - dt1.getTime()) / 1000;
        var year  = Math.abs(Math.round((time/(60 * 60 * 24))/365.25));
        //   var month = Math.abs(Math.round(time/(60 * 60 * 24 * 7 * 4)));
        let current_year = moment(dt2).format('YYYY');
        let current_year2 = moment(dt2).format('YYYY-MM-D');
        let current_month = moment(dt1).format('MM-D');
        var month = Math.abs(parseInt(moment(current_year+'-'+current_month).diff(dt2, 'months', true)));
        //   var days = Math.abs(Math.round(time/(3600 * 24)));
        var days = Math.abs(parseInt(moment(current_year+'-'+current_month).diff(current_year2, 'days')));
        return year +" years, " + month + " months, " + days + " days";

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
