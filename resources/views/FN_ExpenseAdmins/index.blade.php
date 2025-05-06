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
                <h3 class="page-title">@lang('lang.expense_admin')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.expense_admin')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-expense-request" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                            <tr>
                                <th class="stuck-scroll-3">#</th>
                                <th class="stuck-scroll-3">@lang('lang.tracking_id')</th>
                                <th class="stuck-scroll-3">@lang('lang.status')</th>
                                <th>@lang('lang.amount') @lang('lang.usd')</th>
                                <th>@lang('lang.amount') @lang('lang.kh')</th>
                                <th>@lang('lang.request_date')</th>
                                <th>@lang('lang.review') or @lang('lang.approve')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datas)>0)
                                @foreach ($datas as $key=>$item)
                                    @php
                                        $positionReviews = "";
                                        if ($item->status == "pending" ) {
                                            if (count($item->PositionReviews)>0) {
                                                $num = 1;
                                                foreach ($item->PositionReviews as $key => $position) {
                                                    $positionReviews .= $num . ". " . $position->name_english . "\n";
                                                    $num++;
                                                }
                                            }
                                        }else{
                                            if ($item->approveBy) {
                                                $num = 1;
                                                $positionReviews =  $num . ". " .$item->approveBy->position->name_english;  
                                            }
                                        }
                                        
                                    @endphp
                                    <tr class="odd">
                                        <td class="stuck-scroll-3">{{$key+1}}</td>
                                        <td class="stuck-scroll-3"><a href="#">{{$item->tracking_id}}</a></td>
                                        <td class="stuck-scroll-3"> 
                                            @if ($item->status == "" || $item->status == "pending")
                                                <span class="badge bg-inverse-info" style="font-size: 13px;">@lang('lang.pending') @lang('lang.review')  {{$item->review_type}}</span>
                                            @elseif($item->status == "pending_approve")
                                                <span class="badge bg-inverse-warning" style="font-size: 13px;">@lang('lang.pending') @lang('lang.approved')</span>
                                            @elseif ($item->status == "rejected")
                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">@lang('lang.reject')</span>
                                            @elseif($item->status == "approved")
                                                <span class="badge bg-inverse-success" style="font-size: 13px;">@lang('lang.approved')</span>
                                            @endif
                                        </td>
                                        <td >{{$item->ge_total_amount_usd}}</td>
                                        <td>{{$item->ge_total_amount_riel}}</td>
                                        <td>{{$item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-M-Y H:i') : ''}}</td>
                                        <td data-toggle="tooltip" data-html="true" title="{!! $positionReviews !!}" >
                                            {{ Str::limit($positionReviews, 30, '...') }}
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
@endsection
@include('includs.script')
<script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>
<script src="{{asset('/admin/js/convertNumberToWordsExp.js')}}"></script>
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip({ 
            html: true,
            container: 'tr' 
        });
    });
</script>
