@extends('layouts.master')
<style>
    .filter-row .btn {
        min-height: 44px !important;
        padding: 9px !important;
    }
    .reset-btn{
        background: #ffbc34 !important;
        color: #fff !important
    }
</style>
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Employee Report</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Employee Report</li>
                </ul>
            </div>
        </div>
    </div>
    @if (Auth::user()->RolePermission == 'Administrator')
        <form action="{{url('employee/report')}}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="row filter-row"> 
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select class="select form-control" id="emp_status" data-select2-id="select2-data-2-c0n2" name="emp_status">
                            <option value="" data-select2-id="select2-data-2-c0n2">employee status</option>
                            <option value="Probation">Probation</option>
                            <option value="1">FDC</option>
                            <option value="2">UDC</option>
                            <option value="3">Resignation</option>
                            <option value="4">Termination</option>
                            <option value="5">Death</option>
                            <option value="6">Retired</option>
                            <option value="7">Lay off</option>
                            <option value="8">Suspension</option>
                            <option value="9">Others</option>
                        </select>
                        <label class="focus-label">Filter</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <button type="submit" class="btn btn-success w-100 submit-btn" data-dismiss="modal">
                        <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading </span>
                        <span class="btn-txt">{{ __('Search') }}</span>
                    </button>
                </div>
                <div class="col-sm-6 col-md-2">
                    <button type="button" class="btn w-100 reset-btn">
                        <span class="btn-text-reset">Reset</span>
                        <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
                    </button>
                </div>
            </div>
        </form>
    @endif
    
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table mb-0 datatable dataTable no-footer"
                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee Name: activate to sort column descending" style="width: 178px;">Profile</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee Name: activate to sort column descending" style="width: 178px;">Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee Type: activate to sort column ascending" style="width: 108.188px;">Role</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">Department</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">Position</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">Branch</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="DOB: activate to sort column ascending" style="width: 81.0625px;">Join Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="DOB: activate to sort column ascending" style="width: 81.0625px;">DOB</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Martial Status: activate to sort column ascending" style="width: 100.25px;">Martial Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending" style="width: 52.95px;">Gender</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 51.475px;">Basic Salary</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending" style="width: 349.275px;">Address</th>
                                        <th class="text-center sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 55.5625px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($users)>0)
                                        @foreach ($users as $item)
                                            <tr class="odd">
                                                <td class="sorting_1">
                                                    <h2 class="">
                                                        @if ($item->profile != null)
                                                            <a href="#" class="avatar">
                                                                <img src="{{asset('/uploads/images/'.$item->profile)}}" alt="">
                                                            </a>
                                                        @else
                                                            <a href="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                                <img alt="" src="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                            </a>
                                                        @endif
                                                    </h2>
                                                </td>
                                                <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_en}}</a></td>
                                                <td><a href="{{route('employee.profile',$item->id)}}">{{$item->RolePermission}}</a></td>
                                                <td><a href="{{route('employee.profile',$item->id)}}">{{$item->EmployeeDepartment}}</a></td>
                                                <td><a href="{{route('employee.profile',$item->id)}}">{{$item->EmployeePosition}}</a></td>
                                                <td><a href="{{route('employee.profile',$item->id)}}">{{$item->EmployeeBranch}}</a></td>
                                                <td>{{$item->joinOfDate ?? ''}}</td>
                                                <td>{{$item->DOB ?? ''}}</td>
                                                <td>{{$item->marital_status}}</td>
                                                <td>{{ $item->EmployeeGender }}</td>
                                                <td>$ <a href="#">{{$item->basic_salary}}</a></td>
                                                <td>
                                                   {{$item->FullCurrentAddress}}
                                                </td>
                                                <td>
                                                    <div class="dropdown action-label">
                                                        @if ($item->emp_status=='Probation')
                                                            <a class="btn btn-white btn-sm" href="#">
                                                                <i class="fa fa-dot-circle-o text-success"></i>
                                                                <span>{{ $item->emp_status }}</span>
                                                            </a>
                                                        @elseif ($item->emp_status=='1')
                                                            <a class="btn btn-white btn-sm" href="#">
                                                                <i class="fa fa-dot-circle-o text-info"></i>
                                                                <span>FDC</span>
                                                            </a>
                                                        @elseif ($item->emp_status=='2')
                                                            <a class="btn btn-white btn-sm" href="#">
                                                                <i class="fa fa-dot-circle-o text-danger"></i>
                                                                <span>UDC</span>
                                                            </a>
                                                        @elseif ($item->emp_status=='3')
                                                            <a class="btn btn-white btn-sm" href="#">
                                                                <i class="fa fa-dot-circle-o text-dark"></i>
                                                                <span>Resignation</span>
                                                            </a>
                                                        @elseif ($item->emp_status=='4')
                                                            <a class="btn btn-white btn-sm" href="#">
                                                                <i class="fa fa-dot-circle-o text-dark"></i>
                                                                <span>Termination</span>
                                                            </a>
                                                        @elseif ($item->emp_status=='5')
                                                            <a class="btn btn-white btn-sm" href="#">
                                                                <i class="fa fa-dot-circle-o text-dark"></i>
                                                                <span>Death</span>
                                                            </a>
                                                        @elseif ($item->emp_status=='6')
                                                            <a class="btn btn-white btn-sm" href="#">
                                                                <i class="fa fa-dot-circle-o text-dark"></i>
                                                                <span>Retired</span>
                                                            </a>
                                                        @elseif ($item->emp_status=='7')
                                                            <a class="btn btn-white btn-sm" href="#">
                                                                <i class="fa fa-dot-circle-o text-dark"></i>
                                                                <span>Lay off</span>
                                                            </a>
                                                        @elseif ($item->emp_status=='8')
                                                            <a class="btn btn-white btn-sm" href="#">
                                                                <i class="fa fa-dot-circle-o text-dark"></i>
                                                                <span>Suspension</span>
                                                            </a>
                                                        @elseif ($item->emp_status=='9')
                                                            <a class="btn btn-white btn-sm" href="#">
                                                                <i class="fa fa-dot-circle-o text-dark"></i>
                                                                <span>Fall Probation</span>
                                                            </a>
                                                        @endif
                                                    </div>
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
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function(){
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('employee/report') }}"); 
        });
    });
</script>