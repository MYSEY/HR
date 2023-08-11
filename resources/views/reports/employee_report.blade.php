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
                    <h3 class="page-title">Employee Reports</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee Reports</li>
                    </ul>
                </div>
            </div>
        </div>
        @if (Auth::user()->RolePermission == 'Administrator')
            <form class="needs-validation" novalidate>
                @csrf
                <div class="row filter-btn"> 
                    <div class="col-sm-2 col-md-2"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="employee_id" id="number_employee" placeholder="Employee ID" value="{{old('number_employee')}}">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="Employee name" value="{{old('employee_name')}}">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group form-focus select-focus">
                            <select class="select form-control" id="emp_status" data-select2-id="select2-data-2-c0n2" name="emp_status">
                                <option value="" data-select2-id="select2-data-2-c0n2">All Status</option>
                                <option value="Upcoming">Upcoming</option>
                                <option value="Probation">Probation</option>
                                <option value="1">FDC-1</option>
                                <option value="10">FDC-2</option>
                                <option value="2">UDC</option>
                                <option value="3">Resignation</option>
                                <option value="4">Termination</option>
                                <option value="5">Death</option>
                                <option value="6">Retired</option>
                                <option value="7">Lay off</option>
                                <option value="8">Suspension</option>
                                <option value="Cancel">Cancel</option>
                            </select>
                            <label class="focus-label">Filter</label>
                        </div>
                    </div>
                    {{-- <div class="col-md-6 col-sm-6"></div> --}}
                    <div class="col-sm-6 col-md-6">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-success me-2 btn-search" data-dismiss="modal">
                                <span class="loading-icon-search" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading </span>
                                <span class="btn-txt-search">{{ __('Search') }}</span>
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
    
        <div class="row">
            <div class="col-md-12">
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
                                                style="width: 178px;">Profile</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Employee ID: activate to sort column descending"
                                                style="width: 178px;">Employee ID</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Employee Name: activate to sort column descending"
                                                style="width: 178px;">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="Employee Type: activate to sort column ascending"
                                                style="width: 108.188px;">Role</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="Department: activate to sort column ascending"
                                                style="width: 125.15px;">Department</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="Department: activate to sort column ascending"
                                                style="width: 125.15px;">Position</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="Department: activate to sort column ascending"
                                                style="width: 125.15px;">Branch</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="DOB: activate to sort column ascending"
                                                style="width: 81.0625px;">Join Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="DOB: activate to sort column ascending" style="width: 81.0625px;">
                                                DOB</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Martial Status: activate to sort column ascending"
                                                style="width: 100.25px;">Martial Status</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Gender: activate to sort column ascending"
                                                style="width: 52.95px;">Gender</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Salary: activate to sort column ascending"
                                                style="width: 51.475px;">Basic Salary</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending"
                                                style="width: 51.475px;">Status</th>
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
                                                            <span style="font-size: 13px" class="badge bg-inverse-success">Upcoming</span>
                                                        @elseif ($item->emp_status == "Probation")
                                                            <span style="font-size: 13px" class="badge bg-inverse-success">Probation</span>
                                                        @elseif ($item->emp_status == "1")
                                                            <span style="font-size: 13px" class="badge bg-inverse-success">FDC-1</span>
                                                        @elseif ($item->emp_status == "10")
                                                            <span style="font-size: 13px" class="badge bg-inverse-success">FDC-2</span>
                                                        @elseif ($item->emp_status == "2")
                                                            <span style="font-size: 13px" class="badge bg-inverse-success">UDC</span>
                                                        @elseif ($item->emp_status=='3')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Resignation</span>
                                                        @elseif ($item->emp_status=='4')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Termination</span>
                                                        @elseif ($item->emp_status=='5')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Death</span>
                                                        @elseif ($item->emp_status=='6')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Retired</span>
                                                        @elseif ($item->emp_status=='7')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Lay off</span>
                                                        @elseif ($item->emp_status=='8')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Suspension</span>
                                                        @elseif ($item->emp_status=='9')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Fall Probation</span>
                                                        @elseif ($item->emp_status=='Cancel')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Cancel</span>
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
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-success">Upcoming</span>';
                        }else if (row.emp_status == "Probation"){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-success">Probation</span>';
                        }else if (row.emp_status == "1"){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-success">FDC-1</span>';
                        }else if (row.emp_status == "10"){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-success">FDC-2</span>';
                        }else if (row.emp_status == "2"){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-success">UDC</span>';
                        }else if (row.emp_status=='3'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">Resignation</span>';
                        }else if (row.emp_status=='4'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">Termination</span>';
                        }else if (row.emp_status=='5'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">Death</span>';
                        }else if (row.emp_status=='6'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">Retired</span>';
                        }else if (row.emp_status=='7'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">Lay off</span>';
                        }else if (row.emp_status=='8'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">Suspension</span>';
                        }else if (row.emp_status=='9'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">Fall Probation</span>';
                        }else if (row.emp_status=='Cancel'){
                            emp_status = '<span style="font-size: 13px" class="badge bg-inverse-danger">Cancel</span>';
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
