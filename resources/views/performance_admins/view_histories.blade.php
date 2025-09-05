@extends('layouts.master')
<style>
    .tooltip-inner {
        white-space: pre-line !important;
        text-align: left !important;
        max-width: 300px !important; 
        /* word-wrap: break-word !important; */
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.view_history')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.view_history')</li>
                    </ul>
                </div>
            </div>
        </div>
        <form>
    {{-- @csrf --}}
    <div class="row filter-btn"> 
        <div class="col-sm-12 col-md-12">
            <div style="display: flex" class="float-end">
                <a href="{{ url('/performance-admin') }}" type="button" class="btn btn-icon btn-soft-success me-1">
                    <i class="fa fa-angle-double-left"></i> @lang('lang.back')
                </a>
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
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-nowrap sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.status')</th>
                                            <th class="sorting stuck-scroll-4">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc ">@lang('lang.employee_name')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.from_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.to_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.kip')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.total_weight')</th>
                                            <th>@lang('lang.review_by')</th>
                                            <th>@lang('lang.review') @lang('lang.date')</th>
                                            <th>@lang('lang.approve_by')</th>
                                            <th>@lang('lang.approve') @lang('lang.date')</th>
                                            <th>@lang('lang.reason')</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($datas)>0)
                                            @foreach ($datas as $inx=>$item)
                                                <tr class="odd">
                                                    <td class="stuck-scroll-4">{{$inx+1}}</td>
                                                    <td class="stuck-scroll-4">
                                                        @if ($item->status == "preparing") 
                                                            <span class="badge bg-inverse-info" style="font-size: 13px;">Preparing</span>
                                                        @endif
                                                        @if ($item->status == "1") 
                                                            <span class="badge bg-inverse-info" style="font-size: 13px;">Pending Review</span>
                                                        @endif
                                                        @if ($item->status == "2") 
                                                            <span class="badge bg-inverse-warning" style="font-size: 13px;">Pending Accepted</span>
                                                        @endif
                                                        @if ($item->status == "3") 
                                                            <span class="badge bg-inverse-warning" style="font-size: 13px;">Pending Verify</span>
                                                        @endif
                                                        @if ($item->status == "4") 
                                                            <span class="badge bg-inverse-warning" style="font-size: 13px;">Pending Approve</span>
                                                        @endif
                                                        @if ($item->status == "5") 
                                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">Return</span>
                                                        @endif
                                                        @if ($item->status == "approved") 
                                                            <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$item->number_employee}}</td>
                                                    <td>{{$item->employee_name_kh}}</td>
                                                    <td>{{$item->branch_name_en}}</td>
                                                    <td>{{$item->dep_name}}</td>
                                                    <td>{{$item->positions_name}}</td>
                                                    <td>{{$item->from_date}}</td>
                                                    <td>{{$item->to_date}}</td>
                                                    <td>{{$item->type}}</td>
                                                    <td>{{$item->total_weight}} %</td>
                                                    <td>{{$item->review_employee_name_en}}</td>
                                                    <td>{{$item->review_date}}</td>
                                                    <td></td>
                                                    <td>{{$item->approve_date}}</td>
                                                    <td data-toggle="tooltip" data-html="true" title="{!! $item->reason !!}" >
                                                        {{ Str::limit($item->reason, 30, '...') }}
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="{{url('performance-admin/histories/detail')}}/{{$item->id}}">
                                                                    <i class="fa fa-regular fa-eye"></i> Preview
                                                                </a>
                                                            </div>
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
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
    <script>
    </script>
@endsection