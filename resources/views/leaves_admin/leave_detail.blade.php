@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leaves all request</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaves Employee</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a class="btn btn-outline-secondary" href="{{ url('/leaves/admin') }}">Back</a>
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
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-leave-request" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Profle: activate to sort column descending">#</th>
                                            <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Employee: activate to sort column descending" >@lang('lang.employee_name')</th>
                                            <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0"
                                                aria-label="Leave Type: activate to sort column ascending">Leave Type</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                aria-label="From: activate to sort column ascending">@lang('lang.start_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                aria-label="To: activate to sort column ascending">@lang('lang.end_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                aria-label="No of Days: activate to sort column ascending">Number of Days</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                aria-label="Reason: activate to sort column ascending">Reason</th>
                                            <th ass="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                    aria-sort="ascending" aria-label="remark: activate to sort column descending" style="text-align: center;">@lang('lang.remark')</th>     
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                aria-sort="ascending" aria-label="status: activate to sort column descending" style="text-align: center;">@lang('lang.status')</th>
                                            @if (Auth::user()->RolePermission != "HR" && (Auth::user()->department->direct_manager_id == Auth::user()->id || Auth::user()->branch->direct_manager_id == Auth::user()->id ))
                                                <th class="text-end sorting" tabindex="0"
                                                aria-controls="DataTables_Table_0"
                                                aria-label="Actions: activate to sort column ascending">@lang('lang.actions')</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($leave_requests) > 0)
                                            @foreach ($leave_requests as $key=>$request)
                                                <tr class="odd">
                                                    <td class="ids stuck-scroll-3">{{++$key ?? ""}}</td>
                                                    <td class="stuck-scroll-3 employee_name"> {{$request->employee->employee_name_en}} </td>
                                                    <td class="stuck-scroll-3">{{$request->leaveType->name}}</td>
                                                    <td >{{\Carbon\Carbon::parse($request->start_date)->format('d-M-Y') ?? ''}}</td>
                                                    <td>{{\Carbon\Carbon::parse($request->end_date)->format('d-M-Y') ?? ''}}</td>
                                                    <td>{{$request->number_of_day}} Day</td>
                                                    <td>{{$request->reason}}</td>
                                                    <td>{{$request->remark}}</td>
                                                    <td>
                                                        @if ($request->status == "rejected")
                                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">HR rejected</span>
                                                        @elseif ($request->status == "cancel_hod")
                                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">Pending HR approve cancel</span>
                                                        @elseif($request->status == "cancel")
                                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">Cancel</span>
                                                        @elseif ($request->status == "rejected_lm")
                                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">Line manager rejected</span>
                                                        @elseif ($request->status == "rejected_hod")
                                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">Head department rejected</span>
                                                        @elseif ($request->status == "pending")
                                                        <span class="badge bg-inverse-info" style="font-size: 13px;">Pending line manager approved</span>
                                                        @elseif ($request->status == "approved_lm")
                                                            <span class="badge bg-inverse-info" style="font-size: 13px;">Pending head department approved</span>
                                                        @elseif ($request->status == "approved_hod")
                                                            <span class="badge bg-inverse-info" style="font-size: 13px;">Pending HR Approved</span>
                                                        @elseif($request->status == "approved")
                                                            <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                        @endif
                                                    </td>
                                                    @if (Auth::user()->RolePermission != "HR" && (Auth::user()->department->direct_manager_id == Auth::user()->id || Auth::user()->branch->direct_manager_id == Auth::user()->id ))
                                                        <td class="text-end">
                                                            @if ($request->end_date >= \Carbon\Carbon::now()->format('Y-m-d'))
                                                                @if ($request->status == "approved")
                                                                    <button class="btn btn-outline-danger btn-sm btn-cancel" 
                                                                        data-id="{{$request->id}}"
                                                                        data-condiction="{{Auth::user()->RolePermission}}"
                                                                    >@lang('lang.cancel')</button>
                                                                @elseif($request->status == "approved_hod")
                                                                    <button class="btn btn-outline-secondary btn-sm btn-rejected" 
                                                                        data-id="{{$request->id}}"
                                                                        data-status="{{$request->status}}"
                                                                        data-employeename="{{$request->employee->employee_name_en}}"
                                                                        data-startdate="{{$request->start_date}}"
                                                                        data-enddate="{{$request->end_date}}"
                                                                        data-starthalfday="{{$request->start_half_day}}"
                                                                        data-endhalfday="{{$request->end_half_day}}"
                                                                        data-reason="{{$request->reason}}"
                                                                    >@lang('lang.reject')</button>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    @endif
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
<script>
    $(function(){
        $(".btn-cancel").on("click", function() {
            let id = $(this).data("id");
            let description = "@lang('lang.are_you_sure_want_to_cancel')?";
            let button_cancel = {
                text: '@lang("lang.cancel")',
                btnClass: 'btn-red btn-sm',
                action: function () {
                    var id = this.$content.find('.id').val();
                    let remark = this.$content.find('.remark').val();
                    if (remark == ""){
                        $(".remark").css("border","solid 1px red");
                        new Noty({
                            title: "",
                            text: "Please enter infomation in the remark.",
                            type: "error",
                            timeout: 3000,
                            icon: true
                        }).show();
                        return false;
                    }
                    axios.post('{{ URL('leaves/admin/cancel') }}', {
                        'id': id,
                        'remark': remark,
                        'status': "cancel_hod",
                    }).then(function(response) {
                        new Noty({
                            title: "",
                            text: "@lang('lang.the_process_has_been_successfully').",
                            type: "success",
                            timeout: 3000,
                            icon: true
                        }).show();
                        window.location.replace("{{ URL('/leaves/admin') }}"); 
                    }).catch(function(error) {
                        new Noty({
                            title: "",
                            text: "@lang('lang.something_went_wrong_please_try_again_later').",
                            type: "error",
                            icon: true
                        }).show();
                    });
                }
            };
            $.confirm({
                icon: 'fa fa-warning',
                title: 'Cancel request leave',
                titleClass: 'text-center',
                type: 'blue',
                content: '' +
                '<form action="" class="formName">' +
                    '<div class="form-group" style="text-align: center">' +
                        '<label>'+(description)+'</label>' +
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                    '</div>' +
                    '<div class="form-group">'+
                        '<label>Remark <span class="text-danger">*</span></label>'+
                        '<textarea class="form-control remark"></textarea>'+
                    '</div>'+
                '</form>',
                buttons: {
                    button_cancel,
                    cancel: {
                        text: '@lang("lang.close")',
                        btnClass: 'btn-secondary btn-sm',
                    },
                },
                onContentReady: function () {
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        });
        $(document).on('click','.btn-rejected', function(){
            let id = $(this).data("id");
            let status = $(this).data("status");
            let condition = $(this).data("condition");
            if (condition == "HR" && (status != "approved_hod" || status == "approved_lm")) {
                let text_message = "";
                if (status == "approved_lm") {
                    text_message = "Pending head department approved";
                }else{
                    text_message = "Pending line manager approved";
                }
                new Noty({
                    title: "",
                    text: text_message,
                    type: "error",
                    timeout: 3000,
                    icon: true
                }).show();
                return false;
            }
            let employeename = $(this).data("employeename");
            let startdate  = moment($(this).data("startdate")).format('D-MMM-YYYY');
            let enddate = moment($(this).data("enddate")).format('D-MMM-YYYY');
            let starthalfday = $(this).data("starthalfday") ? '  half day ( '+ $(this).data("starthalfday")+" )" : "";
            let endhalfday = $(this).data("endhalfday") ? '  half day ( '+ $(this).data("endhalfday")+" )" : "";
            let reason = $(this).data("reason");
            let description = "@lang('lang.are_you_sure_want_to_reject')?";
            let text_label = "";
            let danger = {
                text: '@lang("lang.reject")',
                btnClass: 'btn-red btn-sm',
                action: function () {
                    var id = this.$content.find('.id').val();
                    var remark = this.$content.find('.remark').val();
                    if (remark == ""){
                        $(".remark").css("border","solid 1px red");
                        new Noty({
                            title: "",
                            text: "Please enter infomation in the remark.",
                            type: "error",
                            timeout: 3000,
                            icon: true
                        }).show();
                        return false;
                    }

                    axios.post('{{ URL('leaves/admin/reject') }}', {
                        'id': id,
                        'status': "rejected",
                        'remark': remark,
                    }).then(function(response) {
                        new Noty({
                            title: "",
                            text: "@lang('lang.the_process_has_been_successfully').",
                            type: "success",
                            timeout: 3000,
                            icon: true
                        }).show();
                        window.location.replace("{{ URL('/leaves/admin') }}"); 
                    }).catch(function(error) {
                        new Noty({
                            title: "",
                            text: "Som@lang('lang.something_went_wrong_please_try_again_later').",
                            type: "error",
                            icon: true
                        }).show();
                    });
                }
            };
            $.confirm({
                icon: 'fa fa-warning',
                title: 'Employee request leave',
                titleClass: 'text-center',
                type: 'blue',
                content: '' +
                '<form action="" class="formName">' +
                    '<div class="form-group" style="text-align: center">' +
                        '<label>'+(description)+'</label>' +
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                    '</div>' +
                    '<div class="form-group">'+
                        '<p>Empployee Name: '+employeename+'</p>'+
                        '<p>From: '+startdate+starthalfday+'</p>'+
                        '<p>To: '+enddate+endhalfday+'</p>'+
                        '<label>Reason:</label>'+
                        '<textarea disabled class="form-control">'+reason+'</textarea>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label>Remark</label>'+
                        '<textarea class="form-control remark"></textarea>'+
                    '</div>'+
                '</form>',
                buttons: {
                    danger,
                    cancel: {
                        text: '@lang("lang.close")',
                        btnClass: 'btn-secondary btn-sm',
                    },
                },
                onContentReady: function () {
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        });
    });
</script>