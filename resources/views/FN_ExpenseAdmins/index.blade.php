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
                                <th>@lang('lang.request_by') @lang('lang.location')</th>
                                <th>@lang('lang.position') @lang('lang.review')</th>
                                <th>@lang('lang.approve_by')</th>
                                <th>@lang('lang.asign_to')</th>
                                <th>@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datas)>0)
                                @foreach ($datas as $inx=>$item)
                                    @php
                                        $positionReviews = "";
                                        if ($item->status != "pending_approve") {
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
                                        <td class="stuck-scroll-3">{{$inx+1}}</td>
                                        <td class="stuck-scroll-3"><a href="#">{{$item->tracking_id}}</a></td>
                                        <td class="stuck-scroll-3"> 
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
                                        <td>$ {{number_format($item->ge_total_amount_usd, 2)}}</td>
                                        <td>៛ {{$item->type == "2" ? number_format($item->te_total_tax, 2) : number_format($item->ge_total_amount_riel, 2)}}</td>
                                        <td>{{$item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-M-Y H:i') : ''}}</td>
                                        <td >
                                            {{
                                                $item->requestBy->department->name_english." / ".$item->requestBy->branch->branch_name_en

                                            }}
                                        </td>
                                        <td data-toggle="tooltip" data-html="true" title="{!! $positionReviews !!}" >
                                            {{ Str::limit($positionReviews, 30, '...') }}
                                        </td>
                                        <td>
                                            {{$item->approveBy->employee_name_en}}
                                        </td>
                                        <td >
                                           @if ($permission->is_update == "1")
                                                <a class="btn btn-white btn-sm btn-rounded btn-asign" data-id="{{$item->id}}" data-positionold="{{$positionReviews}}" href="#" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                    <span >@lang('lang.asign_to')</span>
                                                </a>
                                            @else
                                                <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                    <i class="fa fa-dot-circle-o text-danger"></i> <span>You can't asign</span>
                                                </a>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{url("admin-expense/histories",$item->id)}}" ><i class="fa fa-eye m-r-5"></i> @lang('lang.view_history')</a>
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
    @include('components.loading-modal')
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
    $(function(){
        $('body').on('click', '.btn-asign', function() {
            var expense_id = $(this).data("id");
            var position_old = $(this).data("positionold");
            $.confirm({
                title: '@lang("lang.asign_to_position")',
                contentClass: 'text-center',
                // backgroundDismiss: 'cancel',
                content: ''+
                    '<form id="add-style" style="height: 25em;">'+
                        '<p class="text-danger">Old position review: </p> <p>'+position_old+'</p>'+
                        '<div class="form-group">'+
                            '<label>@lang("lang.position") <span class="text-danger">*</span></label>'+
                            '<select class="form-control hr-select2-option-emp-role form-select position_id" id="position_id">'+
                            
                            '</select>'+
                        '</div>'+
                    '</form>',
                buttons: {
                    confirm: {
                        text: 'Submit',
                        btnClass: 'add-btn-status',
                        action: function() {
                            var position_id = this.$content.find('.position_id').val();

                            if (!position_id) {
                                $.alert({
                                    title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                    content: 'Please select position for asign!',
                                });
                                return false;
                            }
                            $('#modal-loading').modal('show');
                            axios.post('{{ URL('admin-expense/asign') }}', {
                                'id': expense_id,
                                'position_id': position_id
                            }).then(function(response) {
                                $('#modal-loading').modal('hide');
                                new Noty({
                                    title: "",
                                    text: '@lang("lang.the_process_has_been_successfully")',
                                    type: "success",
                                    icon: true
                                }).show();
                            window.location.replace("{{ URL('admin-expense/list') }}");
                            }).catch(function(error) {
                                $('#modal-loading').modal('hide');
                                new Noty({
                                    title: "",
                                    text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                    type: "error",
                                    icon: true
                                }).show();
                            });
                        }
                    },
                    cancel: {
                        text: 'Cancel',
                        btnClass: 'btn-secondary btn-sm',
                    },
                },
                onContentReady: function() {
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
            $(document).ready(function(){
                $('.hr-select2-option-emp-role').each(function() {
                    $(this).select2({
                        width: '100%',
                        dropdownParent: $(this).parent(),
                    })
                });
                $.ajax({
                    type: "GET",
                    url: "{{ url('/position/show') }}",
                    data: {},
                    dataType: "JSON",
                    success: function(response) {
                        let datas = response.datas;
                        
                        $('#position_id').html('<option selected value=""> -- @lang("lang.select") --</option>');
                        if (datas != '') {
                            $.each(datas, function(i, item) {
                                $('#position_id').append($('<option>', {
                                    value: item.id,
                                    text: item.name_english
                                }));
                            });
                        }
                    }
                });
            });
        });
    });
</script>
