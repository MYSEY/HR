@extends('layouts.master')
<style>
    .tooltip-inner {
        white-space: normal !important;
        text-align: left !important;
        max-width: 300px !important; 
        word-wrap: break-word !important;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.tax_expense')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.tax_expense')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if ($permission->is_create == "1")
                        <a href="{{url('fn/tax-expense/create')}}" class="btn add-btn"><i class="fa fa-plus"></i> @lang('lang.tax_request')</a>
                    @endif
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="content">
            <div class="page-menu">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-expense-request" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th class="stuck-scroll-3">#</th>
                                        <th class="stuck-scroll-3">@lang('lang.tracking_id')</th>
                                        <th class="stuck-scroll-3">@lang('lang.status')</th>
                                        <th >@lang('lang.type')</th>
                                        <th>@lang('lang.type_of_expense')</th>
                                        <th>@lang('lang.amount') @lang('lang.usd')</th>
                                        <th>@lang('lang.amount') @lang('lang.kh')</th>
                                        <th>@lang('lang.type_of_payment')</th>
                                        <th>@lang('lang.reference')</th>
                                        <th>@lang('lang.description')</th>
                                        <th>@lang('lang.request_date')</th>
                                        <th>@lang('lang.approved_date')</th>
                                        <th>@lang('lang.department')/@lang('lang.branch')</th>
                                        <th>@lang('lang.request_by')</th>
                                        <th>@lang('lang.review')</th>
                                        <th style="text-align: center;">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @if (count($datas)>0)
                                        @foreach ($datas as $key=>$item)
                                        
                                            <tr class="odd">
                                                <td class="stuck-scroll-3">{{$key+1}}</td>
                                                <td class="stuck-scroll-3"><a href="#">{{$item->tracking_id}}</a></td>
                                                <td class="stuck-scroll-3"> 
                                                    @if ($item->status == "" || $item->status == "pending")
                                                        <span class="badge bg-inverse-info" style="font-size: 13px;">@lang('lang.pending') @lang('lang.review')</span>
                                                    @elseif ($item->status == "rejected")
                                                        <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected</span>
                                                    @elseif($item->status == "approved")
                                                        <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                    @endif
                                                    
                                                </td>
                                                <td>{{$item->type == "1" ? "Special Expense": "General Expense"}}</td>
                                                <td >{{$item->expense_type == "1" ? "Regular Expense": "Irregular Expense"}}</td>
                                                <td >{{$item->ge_total_amount_usd}}</td>
                                                <td>{{$item->ge_total_amount_riel}}</td>
                                                <td>{{$item->payment_term}}</td>
                                                @if(count($item->References) <= 1)
                                                    <td>
                                                        @if(isset($item->References[0]->file_upload))
                                                            <small class="block text-ellipsis">
                                                                <a href="{{ url('uploads/FnRegularExspenses/' . $item->References[0]->file_upload) }}" target="_blank">
                                                                    {{ $item->reference }}
                                                                </a>
                                                            </small>
                                                        @endif
                                                    </td>
                                                @else
                                                    <td>
                                                        @foreach ($item->References as $rf)
                                                            <small class="block text-ellipsis">
                                                                <a href="{{ url('uploads/FnRegularExspenses/' . $rf->file_upload) }}" target="_blank">
                                                                    {{ $rf->serialref }}
                                                                </a>
                                                            </small>
                                                        @endforeach
                                                    </td>
                                                @endif
                                                <td data-toggle="tooltip" data-html="true" title="{!! $item->subject !!}">
                                                    {{ Str::limit($item->subject, 30, '...') }}
                                                </td>
                                                <td>{{$item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-M-Y H:i') : ''}}</td>
                                                <td>{{$item->date_approve ? \Carbon\Carbon::parse($item->date_approve)->format('d-M-Y H:i') : ''}}</td>
            
                                                @php
                                                    $locations = "";
                                                    if (count($item->locationDetails)>0) {
                                                        
                                                        foreach ($item->locationDetails as $key => $location) {
                                                            if ($location->Location) {
                                                                $locations .= $location->Location->branch_name_en.", ";
                                                            }
                                                            
                                                        }
                                                    }
                                                @endphp
            
                                                <td data-toggle="tooltip" data-html="true" title="{!! $locations !!}" >
                                                    {{ Str::limit($locations, 30, '...') }}
                                                </td>
                                                <td>{{$item->createdBy ? $item->createdBy->employee_name_en: ""}}</td>
                                                <td></td>
                                                <td style="text-align: center;">
                                                    @if ($item->status == "" || $item->status == "pending")
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item update" href="{{url("fn/expense-request/edit",$item->id)}}" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-numberday="{{$item->number_of_day}}" data-target="#delete_ER"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Delete Taxes Modal -->
        <div class="modal custom-modal fade" id="delete_ER" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('/fn/expense-request/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">@lang('lang.delete')</button>
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-secondary">@lang('lang.cancel')</a>
                                    </div>
                                </div>
                            </form>
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
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip({ 
            html: true,
            container: 'tr' 
        });
    });
    $(function() {
        $('.delete').on('click', function() {
            var _this = $(this).data('id');
            $('.e_id').val(_this);
        });
    });
</script>
