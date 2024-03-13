@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.employee_birthday')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.employee_birthday')</li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th  tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="#: activate to sort column ascending" style="width: 265.913px;">#</th>
                                            <th  tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Profle: activate to sort column ascending" style="width: 265.913px;">@lang('lang.profile')</th>
                                            <th  tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending"aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                            <th  tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Name: activate to sort column ascending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.kh'))</th>
                                            <th  tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Name: activate to sort column ascending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.en'))</th>
                                            <th  tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Position: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                            <th  tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Department: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                            <th  tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Branch: activate to sort column ascending" style="width: 218.762px;">@lang('lang.branch')</th>
                                            <th  tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="DOB: activate to sort column ascending" style="width: 218.762px;">@lang('lang.date_of_birth')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $from_date = \Carbon\Carbon::now()->format('m-d');
                                            $to_date = \Carbon\Carbon::now()->addDays(14)->format('m-d');
                                            $num=0;
                                        @endphp
                                        @if (count($data) > 0)
                                            @foreach ($data as $key=>$item)
                                                @php
                                                    $date_of_birth = \Carbon\Carbon::parse($item->date_of_birth)->format('m-d');
                                                @endphp
                                                @if ($date_of_birth >= $from_date && $date_of_birth <= $to_date)
                                                    <tr class="odd">
                                                        <td >{{++$num ?? ''}}</td>
                                                        <td class="sorting_1"> 
                                                            <h2 class="table-avatar">
                                                                @if ($item->profile)
                                                                    <a href="{{asset('/uploads/images/'.$item->profile)}}"  class="avatar">
                                                                        <img alt="" src="{{asset('/uploads/images/'.$item->profile)}}">
                                                                    </a>
                                                                @else
                                                                    <a href="{{asset('/admin/img/defuals/default-user-icon.png')}}" class="avatar">
                                                                        <img alt="" src="{{asset('/admin/img/defuals/default-user-icon.png')}}">
                                                                    </a>
                                                                @endif
                                                            </h2>
                                                        </td>
                                                        <td><a href="{{route('employee.profile',$item->id)}}">{{$item->number_employee}}</a></td>
                                                        <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_kh}}</a></td>
                                                        <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_en}}</a></td>
                                                        <td>{{$item->EmployeePosition}}</td>
                                                        <td>{{$item->EmployeeDepartment}}</td>
                                                        <td>{{$item->EmployeeBranch}}</td>
                                                        <td>{{$item->DOB ?? ''}}</td>
                                                    </tr>
                                                @endif
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
<script>
    $(function() {

    });
</script>
