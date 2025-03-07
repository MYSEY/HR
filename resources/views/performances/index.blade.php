@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.performance')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.performance')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{url('performance/create')}}" class="btn add-btn me-2"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc stuck-scroll-4">#</th>
                                            <th class="sorting stuck-scroll-4">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4">@lang('lang.employee_name')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Total Percentage(%)</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Score achieved</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Score</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr class="odd">
                                                <td class="ids stuck-scroll-4">{{$item->id}}</td>
                                                <td class="stuck-scroll-4"><a href="{{url("performance",$item->employee_id)}}">{{$item->number_employee}}</a></td>
                                                <td class="stuck-scroll-4"><a href="">{{$item->employee_name_en}}</a></td>
                                                <td>{{$item->branch_name_en}}</td>
                                                <td>{{$item->dep_name}}</td>
                                                <td>{{$item->positions_name}}</td>
                                                <td><span class="badge bg-inverse-success">40%</span></td>
                                                <td>3.4</td>
                                                <td>3</td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="{{url("performance",$item->employee_id)}}"><i class="fa fa-regular fa-eye"></i> @lang("lang.preview")</a>
                                                            <a href="{{url("performance/1/edit")}}" class="dropdown-item userUpdate" data-id=""><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-id="" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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
