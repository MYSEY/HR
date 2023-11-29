@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
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
                        <div class="form-group" id="col-branch">
                            <select class="select form-control" data-select2-id="select2-data-2-c0n2" id="role_type" name="role_type" required>
                                <option selected disabled value=""> -- @lang('lang.all_type') --</option>
                                <option value="BOD">Board of Director</option>
                                <option value="CEO">Chief Executive Officer</option>
                                <option value="HR">Head of HR Admin</option>
                                <option value="HOD">Head of Department</option>
                                <option value="HOCD">Head of Credit Department</option>
                                <option value="BM">Branch Manager</option>
                                <option value="employee">Employee</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" id="from_date"
                                    placeholder="@lang('lang.from_date')">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" id="to_date"
                                    placeholder="@lang('lang.to_date')">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary me-2 btn-search">
                                <span class="loading-icon-search" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-txt-search">@lang('lang.search')</span>
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
                                    <table class="table table-striped custom-table datatable dataTable no-footer tbl_role"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="#: activate to sort column ascending">#</th>
                                                <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name : activate to sort column descending">@lang('lang.name')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Type: activate to sort column ascending">@lang('lang.role_type')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="in_used: activate to sort column ascending">@lang('lang.in_used')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">@lang('lang.status') </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="remark: activate to sort column ascending">@lang('lang.remark')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="create: activate to sort column ascending">@lang('lang.created_at') </th>
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
                                                        <td>
                                                            <input type="hidden" class="status" value="{{$item->status}}">
                                                            <div class="dropdown action-label">
                                                                @if ($item->status=='1')
                                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa fa-dot-circle-o text-success"></i>
                                                                        <span>@lang('lang.active')</span>
                                                                    </a>
                                                                @elseif ($item->status=='0')
                                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i>
                                                                        <span>@lang('lang.inactive')</span>
                                                                    </a>
                                                                @endif
                                                                    <div class="dropdown-menu dropdown-menu-right" id="btn-status">
                                                                        <a class="dropdown-item" data-id="{{$item->id}}" data-name="1" data-status-old="{{$item->status}}" href="#">
                                                                            <i class="fa fa-dot-circle-o text-success"></i> @lang('lang.active')
                                                                        </a>
                                                                        <a class="dropdown-item" data-id="{{$item->id}}" data-name="0" data-status-old="{{$item->status}}" href="#">
                                                                            <i class="fa fa-dot-circle-o text-danger"></i> @lang('lang.inactive')
                                                                        </a>
                                                                    </div>
                                                            </div>
                                                        </td>
                                                        <td>{{$item->remark}}</td>
                                                        <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-M-Y')}}</td>
                                                        <td class="text-end">
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" href="{{ url('/role/detail', $item->id) }}"><i class="fa fa-eye m-r-5"></i> @lang('lang.view_details')</a>
                                                                        <a class="dropdown-item" href="{{ url('role/edit', $item->id) }}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                        <a class="dropdown-item roleDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_role"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
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
    <div class="modal custom-modal fade" id="delete_role" role="dialog">
        <div class="modal-dialog modal-sm  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>@lang('lang.delete')</h3>
                        <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ url('role/delete') }}" method="POST">
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
<script>
    $(function(){
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('role') }}"); 
        });
        $('.roleDelete').on('click',function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
        $(".btn-search").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-txt-search").hide();
            $(".loading-icon-search").css('display', 'block');
            var params = {
                role_name: $("#role_name").val(),
                role_type: $("#role_type").val(),
                from_date: $("#from_date").val(),
                to_date: $("#to_date").val(),
            }
            showDatas(params);
        });
        $('body').on('click', '#btn-status a', function() {
            let id = $(this).attr('data-id');
            let status = $(this).attr('data-name');
            let old_status = $(this).attr('data-status-old');
            let text_status = "";
            let text_old_status = "";
            if (old_status == "0") {
                text_old_status = "@lang('lang.inactive')"
            }else if(old_status == "1"){
                text_old_status = "@lang('lang.active')"
            }
            if (status == "0") {
                text_status = "@lang('lang.inactive')"
            }else if(status == "1"){
                text_status = "@lang('lang.active')"
            }
            $.confirm({
                title: '@lang("lang.change_status")!',
                contentClass: 'text-center',
                backgroundDismiss: 'cancel',
                content: ''+
                        '<label>@lang("lang.are_you_sure_want_change_status") '+'<label style="color:red">'+text_old_status+'</label>'+' @lang("lang.to_") '+'<label style="color:red">'+text_status+'</label>'+'?</label>'+
                        '<input type="hidden" class="form-control role_status" id="" name="" value="'+status+'">'+
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">',
                buttons: {
                    confirm: {
                        text: '@lang("lang.submit")',
                        btnClass: 'add-btn-status',
                        action: function() {
                            var role_status = this.$content.find('.role_status').val();
                            var id = this.$content.find('.id').val();
                            
                            axios.post('{{ URL('role/status') }}', {
                                    'role_status': role_status,
                                    'id': id,
                                }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: "@lang('lang.the_process_has_been_successfully').",
                                    type: "success",
                                    icon: true
                                }).show();
                                $('.card-footer').remove();
                                window.location.replace("{{ URL('role') }}");
                            }).catch(function(error) {
                                new Noty({
                                    title: "",
                                    text: "@lang('lang.something_went_wrong_please_try_again_later').",
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
                }
            });
        });
    })
    function showDatas(params) {
        $.ajax({
            type: "post",
            url: "{{ url('role/search') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                role_name: params.role_name ? params.role_name : null,
                role_type: params.role_type ? params.role_type : null,
                from_date: params.from_date ? params.from_date : null,
                to_date: params.to_date ? params.to_date : null,
            },
            dataType: "JSON",
            success: function(response) {
                let data =  response.role;
                $(".btn-search").prop('disabled', false);
                $(".btn-txt-search").show();
                $(".loading-icon-search").css('display', 'none');
                var tr = "";
                if (data.length > 0) {
                    let index = 0;
                    data.map((row) => {
                        index++;
                        let created_at = moment(row.created_at).format('DD-MMM-YYYY')
                        let role_status = "";
                        let status_color = "";
                        if (row.status=='1') {
                            status_color = "success";
                            role_status = "@lang('lang.active')";
                        }else{
                            status_color = "danger";
                            role_status = "@lang('lang.inactive')";
                        }
                        tr +='<tr class="odd">'+
                            '<td>'+(index)+'</td>'+
                            '<td>'+(row.role_name)+'</td>'+
                            '<td>'+(row.role_type)+'</td>'+
                            '<td>'+(row.useruse.length )+'</td>'+
                            '<td>'+
                                '<input type="hidden" class="status" value="'+(row.status)+'">'+
                                '<div class="dropdown action-label">'+
                                    '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                        '<i class="fa fa-dot-circle-o text-'+(status_color)+'"></i>'+
                                        '<span>'+(role_status)+'</span>'+
                                    '</a>'+
                                    '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                        '<a class="dropdown-item" data-id="'+(row.id)+'" data-name="1" data-status-old="'+(row.status)+'" href="#">'+
                                            '<i class="fa fa-dot-circle-o text-success"></i> @lang("lang.active")'+
                                        '</a>'+
                                        '<a class="dropdown-item" data-id="'+(row.id)+'" data-name="0" data-status-old="'+(row.status)+'" href="#">'+
                                            '<i class="fa fa-dot-circle-o text-danger"></i> @lang("lang.inactive")'+
                                        '</a>'+
                                    '</div>'+
                                '</div>'+
                            '</td>'+
                            '<td>'+(row.remark ? row.remark : "" )+'</td>'+
                            '<td>'+(created_at)+'</td>'+
                            '<td class="text-end">'+
                                '<div class="dropdown dropdown-action">'+
                                    '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">'+
                                    '<i  class="material-icons">more_vert</i>'+
                                    '</a>'+
                                    '<div class="dropdown-menu dropdown-menu-right">'+
                                        '<a class="dropdown-item" href="{{url("role/detail")}}/'+(row.id)+'"><i class="fa fa-pencil m-r-5"></i> @lang("lang.view_details")</a>'+
                                        '<a class="dropdown-item" href="{{url("role/edit")}}/'+(row.id)+'"><i class="fa fa-pencil m-r-5"></i> @lang("lang.edit")</a>'+
                                        '<a class="dropdown-item roleDelete" href="#" data-id="'+(row.id)+'" ><i class="fa fa-trash-o m-r-5"></i> @lang("lang.delete")</a>'+
                                    '</div>'+
                                '</div>'+
                            '</td>'+
                        '</tr>';
                    });
                }else{
                    var tr = '<tr><td colspan=8 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl_role tbody").html(tr);   
            }
        });
    }
</script>