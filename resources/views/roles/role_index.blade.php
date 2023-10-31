@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 8px !important;
    }

    #filter_month {
        position: relative;
    }

    input[type="month"]::-webkit-calendar-picker-indicator {
        background-position: right;
        background-size: auto;
        cursor: pointer;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
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
                <h3 class="page-title">@lang('lang.roles')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.roles')</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                    <a href="{{url('role/create')}}" class="btn add-btn" ><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                @endif
            </div>
        </div>
    </div>
    
    <div class="">
        @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
            <form>
                {{-- @csrf --}}
                <div class="row filter-btn">
                    <div class="col-sm-6 col-md-2">
                        <div class="form-group cls-research">
                            <input type="text" class="form-control" name="role_name" id="role_name" placeholder="@lang('lang.name')" value="{{old('name')}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group cls-research">
                            <input class="form-control" type="month" id="filter_month">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group" id="col-branch">
                            <select class="select form-control" data-select2-id="select2-data-2-c0n2" id="role_type" name="role_type" required>
                                <option selected disabled value=""> -- @lang('lang.all_type') --</option>
                                <option value="admin">@lang('lang.admin')</option>
                                <option value="developer">@lang('lang.developer')</option>
                                <option value="employee">@lang('lang.employee')</option>
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-sm-6 col-md-6">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary submit-btn me-2">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-txt">@lang('lang.search')</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2">
                                <span class="btn-text-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <label >@lang('lang.excel')</label></span>
                                <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary reset-btn">
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
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table datatable dataTable no-footer tbl_e_form_salary"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="#: activate to sort column ascending">#</th>
                                                <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name : activate to sort column descending">@lang('lang.name')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Type: activate to sort column ascending">@lang('lang.type')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="in_used: activate to sort column ascending">@lang('lang.in_used')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">@lang('lang.status') </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="remark: activate to sort column ascending">@lang('lang.remark')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="create: activate to sort column ascending">@lang('lang.create') </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="action: activate to sort column ascending">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($role)>0)
                                                @foreach ($role as $key=>$item)
                                                    <tr class="odd">
                                                        <td class="ids stuck-scroll-4">{{++$key ?? ""}}</td>
                                                        <td>{{$item->role_name}}</td>
                                                        <td>{{$item->role_type}}</td>
                                                        <td>{{count($item->useruse)}}</td>
                                                        <td>{{$item->status}}</td>
                                                        <td>{{$item->remark}}</td>
                                                        <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-M-Y')}}</td>
                                                        <td class="text-end">
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item detail" href="{{ url('/role/detail', $item->id) }}"><i class="fa fa-eye m-r-5"></i> @lang('lang.view_details')</a>
                                                                        <a class="dropdown-item userUpdate" href="{{ url('role/edit', $item->id) }}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                        <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                    </div>
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
        </div>
    </div>
</div>
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script src="{{ asset('/admin/js/date-range-bicker.js') }}"></script>
<script>
</script>