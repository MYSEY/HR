@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 8px !important;
    }
</style>
@section('content')
<div class="">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.roles') / <span class="badge bg-inverse-danger">{{$role->role_name}}</span></h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.role_detail')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="">
        <div class="content">
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table datatable dataTable no-footer tbl_e_form_salary"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="#: activate to sort column ascending">#</th>
                                                <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending">@lang('lang.employee_id')</th>
                                                <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"aria-label="Name : activate to sort column descending">@lang('lang.name') (@lang('lang.kh'))</th>
                                                <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"aria-label="Name : activate to sort column descending">@lang('lang.name') (@lang('lang.en'))</th>
                                                <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"aria-label="gender : activate to sort column descending">@lang('lang.gender')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">@lang('lang.position') </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.join_date')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($user_use)>0)
                                                @foreach ($user_use as $key=>$item)
                                                    <tr class="odd">
                                                        <td >{{++$key ?? ""}}</td>
                                                        <td>{{$item->number_employee}}</td>
                                                        <td>{{$item->employee_name_kh}}</td>
                                                        <td>{{$item->employee_name_en}}</td>
                                                        <td>{{$item->EmployeeGender}}</td>
                                                        <td>{{$item->EmployeePosition}}</td>
                                                        <td>{{$item->joinOfDate}}</td>
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
</div>
@endsection