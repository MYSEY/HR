@extends('layouts.master')
<style>
    .jconfirm-buttons-center{
    float: none !important;
    text-align: center !important;
}
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leaves Admin</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaves Admin</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{url('/leaves/admin/create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Leave</a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-3">
                <div class="stats-info" style="background-color: #ff9b44;">
                    <h6>Pending Requests</h6>
                    <h4>0 <span>Today</span></h4>
                </div>
            </div>
            <div class="col-md-3" >
                <div class="stats-info" style="background-color: #55ce63;">
                    <h6>Approved Leave</h6>
                    <h4>0</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info" style="background-color: #f93332d9;">
                    <h6>Reject Leave</h6>
                    <h4>0</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info" style="background-color: #c7c4c4;">
                    <h6>Unplanned Leaves</h6>
                    <h4>0</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Annual Leave</h6>
                    <h4>0</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Sick Leave</h6>
                    <h4>0</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Special Leave</h6>
                    <h4>0</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Unpaid Leave</h6>
                    <h4>0</h4>
                </div>
            </div>
        </div>

        <div class="row filter-row-btn">
            <div class="col-sm-6 col-md-2">
                <div class="form-group cls-research">
                    <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                </div>
            </div>
            <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                <div class="form-group" id="col-branch">
                    <select class="select form-control" id="leave_type_id" data-select2-id="select2-data-2-c0n3" name="leave_type_id">
                        <option value="" data-select2-id="select2-data-2-c0n3">Leave Type</option>
                        @foreach ($dataLeaveType as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
           
            <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                <div class="form-group" id="col-branch">
                    <select class="select form-control" id="status" data-select2-id="select2-data-2-c0n2" name="status">
                        <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_status')</option>
                        <option value="pending" >@lang('lang.pending')</option>
                        <option value="approved" >@lang('lang.approved')</option>
                        <option value="declined" >@lang('lang.declined')</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="start_date" placeholder="@lang('lang.start_date')">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="end_date" placeholder="@lang('lang.end_date')">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div style="display: flex" class="float-end">
                    <button class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" id="icon-search-download-reload">
                        <span class="btn-text-search"><i class="fa fa-search"></i></span>
                        <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                        <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                        <span id="btn-reset-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-leave-request" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending">#</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profile: activate to sort column descending" >@lang('lang.profile')</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending" >@lang('lang.employee_name')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Leave Type: activate to sort column ascending">Leave Type</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="From: activate to sort column ascending">@lang('lang.start_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="To: activate to sort column ascending">@lang('lang.end_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="No of Days: activate to sort column ascending"
                                                style="width: 76.925px;">Number of Days</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Reason: activate to sort column ascending"
                                                style="width: 117.075px;">Reason</th>
                                            <th class="text-center sorting" tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending"
                                                style="width: 108.613px;">@lang('lang.approve_by')</th>
                                            <th class="text-end sorting" tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                aria-label="Actions: activate to sort column ascending"
                                                style="width: 54.6125px;">@lang('lang.actions')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataLeaveRequest) > 0)
                                            @foreach ($dataLeaveRequest as $key=>$request)
                                                <tr class="odd">
                                                    <td class="ids stuck-scroll-4">{{++$key ?? ""}}</td>
                                                    <td class="sorting_1 stuck-scroll-4">
                                                        <h2 class="table-avatar">
                                                            @if ($request->employee->profile != null)
                                                                <a href="{{asset('/uploads/images/'.$request->employee->profile)}}"  class="avatar">
                                                                    <img alt="" src="{{asset('/uploads/images/'.$request->employee->profile)}}">
                                                                </a>
                                                            @else
                                                                <a href="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                                    <img alt="" src="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                                </a>
                                                            @endif
                                                        </h2>
                                                    </td>
                                                    <td class="stuck-scroll-4">
                                                        {{$request->employee->employee_name_en}}
                                                    </td>
                                                    <td class="stuck-scroll-4">{{$request->leaveType->name}}</td>
                                                    <td>{{\Carbon\Carbon::parse($request->start_date)->format('d-M-Y') ?? ''}}</td>
                                                    <td>{{\Carbon\Carbon::parse($request->end_date)->format('d-M-Y') ?? ''}}</td>
                                                    <td>{{$request->number_of_day}} Day</td>
                                                    <td>{{$request->reason}}</td>
                                                    <td class="text-center">
                                                        
                                                    </td>
                                                    <td class="text-end">
                                                        <a class="btn btn-success btn-sm btn-approved" href="#"  data-id="{{$request->id}}">@lang('lang.approved')</a>
                                                        <a class="btn btn-primary btn-sm btn_cancel" href="#" data-id="{{$request->id}}" >Reject</a>
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
<script>
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-reset-text-loading").css('display', 'block');
            window.location.replace("{{ URL('/leaves/admin') }}"); 
        });
        $(".btn-search").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-search").hide();
            $("#btn-text-loading").css('display', 'block');
            axios.post('{{ URL('leaves/admin/filter') }}', {
                'employee_id': $("#employee_id").val(),
                'employee_name': $("#employee_name").val(),
                'leave_type_id': $("#leave_type_id").val(),
                'start_date': $("#start_date").val(),
                'end_date': $("#end_date").val(),
                'status': $("#status").val(),
            }).then(function(response) {
                var rows = response.data.success;
                if (rows.length > 0) {
                    var tr = "";
                    $(rows).each(function(e, row) {
                        let start_date = moment(row.start_date).format('D-MMM-YYYY')
                        let end_date = moment(row.end_date).format('D-MMM-YYYY')
                        let profile = '<a href="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                        '<img alt="" src="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                    '</a>';
                        if (row.employee.profile != null) {
                            profile ='<a href="{{asset("/uploads/images")}}/'+(row.employee.profile)+'" class="avatar">'+
                                        '<img alt="" src="{{asset("/uploads/images")}}/'+(row.employee.profile)+'">'+
                                    '</a>';
                        };
                        tr += '<tr class="odd">'+
                            '<td class="ids">'+(e+1)+'</td>'+
                            '<td>' + (profile) + '</td>'+
                            '<td>' + (row.employee.employee_name_en) + '</td>'+
                            '<td>' + (row.leave_type.name) + '</td>'+
                            '<td>' + (start_date) + '</td>'+
                            '<td>' + (end_date) + '</td>'+
                            '<td>' + (row.number_of_day) + '</td>'+
                            '<td>' + (row.reason ? row.reason : "") + '</td>'+
                            '<td>' + (row.approved_by ? row.approved_by : "" ) + '</td>'+
                            '<td class="text-end">'+
                                '<a class="btn btn-success btn-sm" href="#">Approved</a>'+
                               ' <a class="btn btn-primary btn-sm" href="#">Reject</a>'+
                            '</td>'+
                        '</tr>';
                    });
                } else {
                    var tr = '<tr><td colspan=11 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl-leave-request tbody").html(tr);
                $("#btn-text-loading").hide();
                $(".btn-text-search").show();
                $(".btn-search").prop("disabled",false);
            })
        });
        $(document).on('click','.btn-approved', function(){
            let id = $(this).data("id");
            let description = "@lang('lang.are_you_sure_want_to_approve')?";
            let text_label = "";
            let button_ok = {
                text: '@lang("lang.ok")',
                btnClass: 'add-btn-status',
                action: function () {
                    var id = this.$content.find('.id').val();
                    axios.post('{{ URL('leaves/admin/status') }}', {
                        'id': id,
                        'status': "approved",
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
                title: '@lang("lang.approved")',
                titleClass: 'text-center',
                type: 'blue',
                content: '' +
                '<form action="" class="formName">' +
                    '<div class="form-group" style="text-align: center">' +
                        '<label>'+(description)+'</label>' +
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                    '</div>' +
                '</form>',
                onOpenBefore: function () {
                    $(".jconfirm-buttons").addClass("jconfirm-buttons-center");
                },
                buttons: {
                    button_ok,
                    cancel: {
                        text: '@lang("lang.cancel")',
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
        $(document).on('click','.btn_cancel', function(){
            let id = $(this).data("id");
            $.confirm({
                title: '@lang("lang.reject")',
                icon: 'fa fa-warning',
                titleClass: 'text-center',
                type: 'red',
                typeAnimated: true,
                content: '' +
                '<form action="" class="formName">' +
                    '<div class="form-group" style="text-align: center">' +
                        '<label>@lang("lang.are_you_sure_want_to_reject")?</label>' +
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                    '</div>' +
                    '<label>@lang("lang.remark") <span class="text-danger">*</span></label>'+
                    '<textarea class="form-control remark"></textarea>'+
                '</form>',
                // onOpenBefore: function () {
                //     $(".jconfirm-buttons").addClass("jconfirm-buttons-center");
                // },
                buttons: {
                    formSubmit: {
                        text: '@lang("lang.ok")',
                        btnClass: 'add-btn-status',
                        action: function () {
                            var id = this.$content.find('.id').val();
                            var remark = this.$content.find('.remark').val();
                            axios.post('{{ URL('leaves/admin/status') }}', {
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
                    },
                    cancel: {
                        text: '@lang("lang.cancel")',
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
