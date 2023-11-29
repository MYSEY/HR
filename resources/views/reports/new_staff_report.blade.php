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
    <div class="page-header">
        <div class="row align-items-center">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.new_staff_reports')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.new_staff_reports')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
            </div>
        </div>
    </div>
    @if (permissionAccess("m7-s13","is_view")->value == "1")
        <div class="row filter-btn">
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="employee_id" id="employee_id"
                        placeholder="@lang('lang.employee_id')" value="{{ old('employee_id') }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="employee_name" id="employee_name"
                        placeholder="@lang('lang.employee_name')" value="{{ old('employee_name') }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <select class="select form-control" id="branch_id" name="branch_id" value="{{old('branch_id')}}">
                        <option value="">@lang('lang.location')</option>
                        @foreach ($branch as $item)
                            <option value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="from_date" placeholder="@lang('lang.from_date')">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="to_date" placeholder="@lang('lang.to_date')">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div style="display: flex" class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal">
                        <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                        <span class="btn-text-search">@lang('lang.search')</span>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary reset-btn">
                        <span class="btn-text-reset">@lang('lang.reload')</span>
                        <span id="btn-reset-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                    </button>
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
                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-new-staff-report"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Profle: activate to sort column descending"
                                                    style="width: 94.0625px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Employee ID: activate to sort column ascending"
                                                    style="width: 94.0625px;">@lang('lang.id_card')</th>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
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
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.position')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Branch name: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.location')</th>
                                                
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Join Date: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.join_date')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Remark: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.remark')</th>
                                                {{-- <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Action: activate to sort column ascending"
                                                    style="width: 125.15px;">Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($employees) > 0)
                                                @foreach ($employees as $key=>$item)
                                                    <tr class="odd">
                                                        <td class="ids">{{ ++$key }}</td>
                                                        <td>{{ $item->number_employee }}</td>
                                                        <td>{{ $item->employee_name_kh }}</td>
                                                        <td>{{ $item->employee_name_en }}</td>
                                                        <td>{{ $item->EmployeeGender }}</td>
                                                        <td>{{ $item->position ? $item->EmployeePosition : "" }}</td>
                                                        <td>{{ $item->branch ? $item->EmployeeBranch : "" }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->date_of_commencement)->format('d-M-Y') ?? '' }}</td>
                                                        <td>{{ $item->remark }}</td>
                                                    </tr>
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
    @endif
@endsection

@include('includs.script')

<script>
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-reset-text-loading").css('display', 'block');
            window.location.replace("{{ URL('reports/new_staff-report') }}");
        });
        // $(".btn-export").on("click", function(){
        //     var query = {
        //         'employee_id': $("#employee_id").val(),
        //         'employee_name': $("#employee_name").val(),
        //         'branch_id': $("#branch_id").val(),
        //         'from_date': $("#from_date").val(),
        //         'to_date': $("#to_date").val(),
        //     }
        //     var url = "{{URL::to('motor-rentel/export')}}?" + $.param(query)
        //     window.location = url;
        // });
        $(".btn-search").on("click", function() {
            var localeLanguage = '{{ config('app.locale') }}';
            $(this).prop('disabled', true);
            $(".btn-text-search").hide();
            $("#btn-text-loading").css('display', 'block');
            var localeLanguage = '{{ config('app.locale') }}';
            axios.post('{{ URL('reports/new_staff-report') }}', {
                'research':true,
                'employee_id': $("#employee_id").val(),
                'employee_name': $("#employee_name").val(),
                'branch_id': $("#branch_id").val(),
                'from_date': $("#from_date").val(),
                'to_date': $("#to_date").val(),
            }).then(function(response) {
                var rows = response.data.employees;
                if (rows.length > 0) {
                    var tr = "";
                    $(rows).each(function(e, row) {
                        let date_of_commencement = moment(row.date_of_commencement).format('D-MMM-YYYY');
                        if (localeLanguage == 'en') {
                            var gender = row.gender == null ? "" : row.gender.name_english;
                        } else {
                            var gender = row.gender == null ? "" : row.gender.name_khmer;
                        }
                        tr += '<tr class="odd">'+
                            '<td class="ids">'+(e+1)+'</td>'+
                            '<td>' + (row.number_employee) + '</td>'+
                            '<td>'+( row.employee_name_kh )+'</td>'+
                            '<td>'+( row.employee_name_en )+'</td>'+
                            '<td>'+( gender )+'</td>'+
                            '<td>'+( row.position ? localeLanguage == 'en' ? row.position.name_english : row.position.name_khmer: "" )+'</td>'+
                            '<td>'+( row.branch ? localeLanguage == 'en' ? row.branch.branch_name_en : row.branch.branch_name_kh : "" )+'</td>'+
                            '<td>'+( date_of_commencement )+'</td>'+
                            '<td>'+( row.remark ? row.remark : "" )+'</td>'+
                        '</tr>';
                    });
                } else {
                    var tr = '<tr><td colspan=9 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl-new-staff-report tbody").html(tr);
                $("#btn-text-loading").hide();
                $(".btn-text-search").show();
                $(".btn-search").prop("disabled",false);
            })
        });
    });
</script>
