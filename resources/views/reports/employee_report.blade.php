@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 8px !important;
    }

    .reset-btn {
        color: #fff !important
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-12">
                    <h3 class="page-title">@lang('lang.employee_reports')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.employee_reports')</li>
                    </ul>
                </div>
            </div>
        </div>
        @if (Auth::user()->RolePermission == 'admin')
            <form class="needs-validation" novalidate>
                @csrf
                <div class="row filter-btn"> 
                    <div class="col-sm-2 col-md-2"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="employee_id" id="number_employee" placeholder="@lang('lang.employee_id')" value="{{old('number_employee')}}">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group form-focus select-focus">
                            <select class="select form-control" id="emp_status" data-select2-id="select2-data-2-c0n2" name="emp_status">
                                <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_status')</option>
                                <option value="Upcoming">@lang('lang.upcoming')</option>
                                <option value="Probation">@lang('lang.probation')</option>
                                <option value="1">@lang('lang.fdc')-1</option>
                                <option value="10">@lang('lang.fdc')-2</option>
                                <option value="2">@lang('lang.udc')</option>
                                <option value="3">@lang('lang.resignation')</option>
                                <option value="4">@lang('lang.termination')</option>
                                <option value="5">@lang('lang.death')</option>
                                <option value="6">@lang('lang.retired')</option>
                                <option value="7">@lang('lang.lay_off')</option>
                                <option value="8">@lang('lang.suspension')</option>
                                <option value="Cancel">@lang('lang.cancel')</option>
                            </select>
                            <label class="focus-label">@lang('lang.filter')</label>
                        </div>
                    </div>
                    {{-- <div class="col-md-6 col-sm-6"></div> --}}
                    <div class="col-sm-6 col-md-6">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-success me-2 btn-search" data-dismiss="modal">
                                <span class="loading-icon-search" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-txt-search">@lang('lang.search')</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2">
                                <span class="btn-text-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> @lang('lang.excel')</span>
                                <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-warning reset-btn">
                                <span class="btn-text-reset">@lang('lang.reload')</span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
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
                                <div class="col-sm-12 col-md-12">
                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl_employee" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Profile: activate to sort column descending"
                                                    style="width: 178px;">@lang('lang.profile')</th>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Employee ID: activate to sort column descending"
                                                    style="width: 178px;">@lang('lang.employee_id')</th>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Employee Name: activate to sort column descending"
                                                    style="width: 178px;">@lang('lang.name')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Employee Type: activate to sort column ascending"
                                                    style="width: 108.188px;">@lang('lang.role_name')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Department: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.department')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Department: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.position')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Department: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.location')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="DOB: activate to sort column ascending"
                                                    style="width: 81.0625px;">@lang('lang.join_date')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="DOB: activate to sort column ascending" style="width: 81.0625px;">
                                                    @lang('lang.date_of_birth')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Martial Status: activate to sort column ascending"
                                                    style="width: 100.25px;">@lang('lang.maritial_status')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Gender: activate to sort column ascending"
                                                    style="width: 52.95px;">@lang('lang.gender')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Salary: activate to sort column ascending"
                                                    style="width: 51.475px;">@lang('lang.basic_salary')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Status: activate to sort column ascending"
                                                    style="width: 51.475px;">@lang('lang.status')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($users) > 0)
                                                @foreach ($users as $item)
                                                    <tr class="odd">
                                                        <td>
                                                            <h2>
                                                                @if ($item->profile != null)
                                                                    <a href="#" class="avatar">
                                                                        <img src="{{ asset('/uploads/images/' . $item->profile) }}" alt="">
                                                                    </a>
                                                                @else
                                                                    <a href="{{ asset('admin/img/defuals/default-user-icon.png') }}">
                                                                        <img alt="" src="{{ asset('admin/img/defuals/default-user-icon.png') }}">
                                                                    </a>
                                                                @endif
                                                            </h2>
                                                        </td>
                                                        <td><a href="{{ route('employee.profile', $item->id) }}">{{$item->number_employee}}</td>
                                                        <td>
                                                            <a href="{{ route('employee.profile', $item->id) }}">{{ $item->employee_name_en }}</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('employee.profile', $item->id) }}">{{ $item->RolePermission }}</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('employee.profile', $item->id) }}">{{ $item->EmployeeDepartment }}</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('employee.profile', $item->id) }}">{{ $item->EmployeePosition }}</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('employee.profile', $item->id) }}">{{ $item->EmployeeBranch }}</a>
                                                        </td>
                                                        <td>{{ $item->joinOfDate ?? '' }}</td>
                                                        <td>{{ $item->DOB ?? '' }}</td>
                                                        <td>{{ $item->marital_status }}</td>
                                                        <td>{{ $item->EmployeeGender }}</td>
                                                        <td>$ <a href="#">{{ $item->basic_salary }}</a></td>
                                                        <td>
                                                            @if ($item->emp_status== "Upcoming")
                                                                <span style="font-size: 13px" class="badge bg-inverse-success">@lang('lang.upcoming')</span>
                                                            @elseif ($item->emp_status == "Probation")
                                                                <span style="font-size: 13px" class="badge bg-inverse-success">@lang('lang.probation')</span>
                                                            @elseif ($item->emp_status == "1")
                                                                <span style="font-size: 13px" class="badge bg-inverse-success">@lang('lang.fdc')-1</span>
                                                            @elseif ($item->emp_status == "10")
                                                                <span style="font-size: 13px" class="badge bg-inverse-success">@lang('lang.fdc')-2</span>
                                                            @elseif ($item->emp_status == "2")
                                                                <span style="font-size: 13px" class="badge bg-inverse-success">@lang('lang.udc')</span>
                                                            @elseif ($item->emp_status=='3')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">@lang('lang.resignation')</span>
                                                            @elseif ($item->emp_status=='4')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">@lang('lang.termination')</span>
                                                            @elseif ($item->emp_status=='5')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">@lang('lang.death')</span>
                                                            @elseif ($item->emp_status=='6')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">@lang('lang.retired')</span>
                                                            @elseif ($item->emp_status=='7')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">@lang('lang.lay_off')</span>
                                                            @elseif ($item->emp_status=='8')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">@lang('lang.suspension')</span>
                                                            @elseif ($item->emp_status=='9')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">@lang('lang.fall_probation')</span>
                                                            @elseif ($item->emp_status=='Cancel')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">@lang('lang.cancel')</span>
                                                            @endif
                                                        </td>
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
    </div>
    
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('reports/employee-report') }}");
        });
        $(".btn-search").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-txt-search").hide();
            $(".loading-icon-search").css('display', 'block');
            var params = {
                number_employee: $("#number_employee").val(),
                employee_name: $("#employee_name").val(),
                emp_status: $("#emp_status").val(),
            }
            showDatas(params);
        });
        $(".btn_excel").on("click", function () {
            var query = {
                number_employee: $("#number_employee").val(),
                employee_name: $("#employee_name").val(),
                emp_status: $("#emp_status").val(),
            }
            var url = "{{URL::to('reports/employee-export')}}?" + $.param(query)
            window.location = url;
        });
    });

    function showDatas(params) {
        $.ajax({
            type: "post",
            url: "{{ url('reports/employee-search') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                employee_id: params.number_employee ? params.number_employee : null,
                employee_name: params.employee_name ? params.employee_name : null,
                emp_status: params.emp_status ? params.emp_status : null,
            },
            dataType: "JSON",
            success: function(response) {
                let data =  response.success;
                $(".btn-search").prop('disabled', false);
                $(".btn-txt-search").show();
                $(".loading-icon-search").css('display', 'none');
                var tr = "";
                if (data.length > 0) {
                    data.map((row) => {
                        let join_date = moment(row.date_of_commencement).format('DD-MMM-YYYY')
                        let date_of_birth = moment(row.date_of_birth).format('DD-MMM-YYYY')
                        let emp_status = "";
                        if (row.emp_status== "Upcoming"){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-success">@lang("lang.upcoming")</span>';
                        }else if (row.emp_status == "Probation"){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-success">@lang("lang.probation")</span>';
                        }else if (row.emp_status == "1"){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-success">@lang("lang.fdc")-1</span>';
                        }else if (row.emp_status == "10"){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-success">@lang("lang.fdc")-2</span>';
                        }else if (row.emp_status == "2"){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-success">@lang("lang.udc")</span>';
                        }else if (row.emp_status=='3'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">@lang("lang.resignation")</span>';
                        }else if (row.emp_status=='4'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">@lang("lang.termination")</span>';
                        }else if (row.emp_status=='5'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">@lang("lang.death")</span>';
                        }else if (row.emp_status=='6'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">@lang("lang.retired")</span>';
                        }else if (row.emp_status=='7'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">@lang("lang.lay_off")</span>';
                        }else if (row.emp_status=='8'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">@lang("lang.suspension")</span>';
                        }else if (row.emp_status=='9'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">@lang("lang.fall_probation")</span>';
                        }else if (row.emp_status=='Cancel'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">@lang("lang.cancel")</span>';
                        };
                        let profile = '<a href="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                        '<img alt="" src="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                    '</a>';
                        if (row.profile != null) {
                            profile ='<a href="{{asset("/uploads/images")}}/'+(row.profile)+'" class="avatar">'+
                                        '<img alt="" src="{{asset("/uploads/images")}}/'+(row.profile)+'">'+
                                    '</a>';
                        };
                        tr +='<tr class="odd">'+
                            '<td><h2>'+(profile)+'</h2></td>'+
                            '<td><a href="{{url("employee/profile")}}/'+(row.id)+'">'+(row.number_employee)+'</td>'+
                            '<td><a href="{{url("employee/profile")}}/'+(row.id)+'">'+(row.employee_name_en)+'</a></td>'+
                            '<td><a href="{{url("employee/profile")}}/'+(row.id)+'">'+(row.role ? row.role.name : "")+'</a></td>'+
                            '<td><a href="{{url("employee/profile")}}/'+(row.id)+'">'+(row.department.name_english)+'</a></td>'+
                            '<td><a href="{{url("employee/profile")}}/'+(row.id)+'">'+(row.position.name_english	)+'</a></td>'+
                            '<td><a href="{{url("employee/profile")}}/'+(row.id)+'">'+(row.branch.branch_name_en)+'</a></td>'+
                            '<td>'+(join_date)+'</td>'+
                            '<td>'+(date_of_birth)+'</td>'+
                            '<td>'+(row.marital_status ? row.marital_status : "" )+'</td>'+
                            '<td>'+(row.gender.name_english	 )+'</td>'+
                            '<td>$ <a href="#">'+(row.basic_salary )+'</a></td>'+
                            '<td>'+
                                (emp_status)+
                            '</td>'+
                        '</tr>';
                    });
                }else{
                    var tr = '<tr><td colspan=13 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl_employee tbody").html(tr);   
            }
        });
    }
</script>
