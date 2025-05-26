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
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.expense_history')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.expense_history')</li>
                </ul>
            </div>
        </div>
    </div>
    <form>
    {{-- @csrf --}}
    <div class="row filter-btn"> 
        <div class="col-sm-12 col-md-12">
            <div style="display: flex" class="float-end">
                <a class="btn btn-sm btn-outline-secondary me-2" href="{{ url('/admin-expense/list') }}">@lang('lang.back')</a>
                <button type="button" class="btn btn-sm btn-outline-secondary btn_excel">
                    <span class="btn-text-reset">@lang('lang.export') to @lang('lang.excel')</span>
                    <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                </button>
            </div>
        </div>
    </div>
    </form>
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
                            {{-- <th>@lang('lang.type_of_payment')</th> --}}
                            <th>@lang('lang.reference')</th>
                            <th>@lang('lang.description')</th>
                            {{-- <th>@lang('lang.request_date')</th> --}}
                            {{-- <th>@lang('lang.approved_date')</th> --}}
                            <th>@lang('lang.location')</th>
                            {{-- <th>@lang('lang.request_by')</th> --}}
                            {{-- <th>@lang('lang.review')</th> --}}
                            <th>@lang('lang.reason')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($datas)>0)
                            @foreach ($datas as $index=>$item)
                                @php
                                    $locations = "";
                                    if ($item->type == "2" ) {
                                        if (count($item->departments)>0) {
                                            $num = 1;
                                            foreach ($item->departments as $key => $location) {
                                                if ($location->Location) {
                                                    $locations .= $num . ". " . $location->department->name_english . "\n";
                                                    $num++;
                                                    // $locations .= $location->department->name_english.", ";
                                                }
                                            }
                                        }
                                    }else{
                                        if (count($item->locationDetails)>0) {
                                            $num = 1;
                                            foreach ($item->locationDetails as $key => $location) {
                                                // dd($location->Location);
                                                if ($location->Location) {
                                                    $locations .=  $num . ". " .$location->Location->branch_name_en."\n";
                                                    $num++;
                                                }
                                                
                                            }
                                        }
                                    }
                                    
                                @endphp
                                <tr class="odd">
                                    <td class="stuck-scroll-3">{{$index+1}}</td>
                                    <td class="stuck-scroll-3"><a href="#">{{$item->tracking_id}}</a></td>
                                    <td class="stuck-scroll-3"> 
                                        <input type="hidden" class="expense_id" value="{{$item->expense_id}}">
                                        <input type="hidden" class="expense_type" value="{{$item->type}}">
                                        @if ($item->status == "" || $item->status == "pending")
                                            <span class="badge bg-inverse-info" style="font-size: 13px;">@lang('lang.pending') @lang('lang.review')  {{$item->review_type}}</span>
                                        @elseif($item->status == "pending_approve")
                                            <span class="badge bg-inverse-warning" style="font-size: 13px;">@lang('lang.pending') @lang('lang.approved')</span>
                                        @elseif ($item->status == "rejected")
                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected {{$item->review_type ? "review ".$item->review_type : "by Approved"}}</span>
                                        @elseif($item->status == "approved")
                                            <span class="badge bg-inverse-success" style="font-size: 13px;">@lang('lang.approved')</span>
                                        @endif
                                        
                                    </td>
                                    <td>
                                        {{-- {{$item->type == "1" ? "Special Expense": "General Expense"}} --}}
                                        @if ($item->type == "1")
                                            <span >Special Expense</span>
                                        @elseif ($item->type == "2")
                                            <span >Tax Expense</span>
                                        @else
                                            <span >General Expense</span>
                                        @endif
                                    </td>
                                    <td >{{$item->expense_type == "1" ? "Regular Expense": "Irregular Expense"}}</td>
                                    <td >{{$item->ge_total_amount_usd}}</td>
                                    <td>{{$item->type == "2" ? $item->te_total_tax : $item->ge_total_amount_riel}}</td>
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
                                    {{-- <td>{{$item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-M-Y H:i') : ''}}</td> --}}
                                    {{-- <td>{{$item->date_approve ? \Carbon\Carbon::parse($item->date_approve)->format('d-M-Y H:i') : ''}}</td> --}}

                                    <td data-toggle="tooltip" data-html="true" title="{!! $locations !!}" >
                                        {{ Str::limit($locations, 30, '...') }}
                                    </td>
                                    {{-- <td>{{$item->createdBy ? $item->createdBy->employee_name_en: ""}}</td> --}}
                                    <td data-toggle="tooltip" data-html="true" title="{!! $item->reason !!}">
                                        {{ Str::limit($item->reason, 25, '...') }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip({ 
            html: true,
            container: 'tr' 
        });
    });
    $(function() {
        $(".btn_excel").on("click", function () {
            var query = {
                'id': $(".expense_id").val(),
                'type': $(".expense_type").val(),
            }
            var url = "{{URL::to('admin-expense/histories-export')}}?" + $.param(query)
            window.location = url;
        });
    });
</script>
