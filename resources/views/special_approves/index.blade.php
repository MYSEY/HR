@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.special_approve_leave')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.special_approve_leave')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if ($permission->is_create == "1")
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_special"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                    
                </div>
            </div>
        </div>
        @if ($permission->is_view == "1")
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('lang.position')</th>
                                    <th>@lang('lang.location')</th>
                                    <th style="text-align: center;">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data)>0)
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="ids">{{$item->employee_name_en}}</td>
                                            <td class="ids">{{$item->position_name_en}}</td>
                                            <td class="ids">{{$item->branch_name_en .' / '. $item->department_name_en}}</td>
                                          
                                            <td class="text-end">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item btn-view-detail" href="#" data-name="{{$item->employee_name_en}}" data-id="{{$item->id}}" ><i class="fa fa-eye m-r-5"></i> @lang('lang.view_details')</a>
                                                        @if ($permission->is_delete== "1" )
                                                            <a class="dropdown-item delete" href="#"
                                                                data-toggle="modal" data-id="{{ $item->id }}"
                                                                data-target="#delete"><i
                                                                    class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                        @endif
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
        @endif
        <div id="add_special" class="modal custom-modal fade hr-modal-select2" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_new_special_approve')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('special/approve/store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.under_approve') <span class="text-danger">*</span></label>
                                <select class="select form-control hr-select2-option requered" id="under_approve" name="under_approve" required>
                                    <option value="" selected> </option>
                                    @foreach ($employee as $item)
                                        <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="">@lang('lang.employees') <span class="text-danger">*</span></label>
                                <select class="select form-control" multiple="" name="employee_id[]" required>
                                    @foreach ($employee as $item)
                                        <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                                        @lang('lang.loading') </span>
                                    <span class="btn-txt">@lang('lang.submit')</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="view-details" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.view_detail_employees')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label >Approve leave by: <span style="font-size: 1.2em; font-weight: bold;" id="under_approve_by"></span></label><br><br>
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 no-footer btl-employees">
                                <thead>
                                    <tr>
                                        <th class="ids stuck-scroll-4">@lang('lang.name')</th>
                                        <th>@lang('lang.position')</th>
                                        <th>@lang('lang.location')</th>
                                        <th style="text-align: center;">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete  Modal -->
        <div class="modal custom-modal fade" id="delete" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ url('special/approve/delete') }}" method="POST">
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
    $(function() {
        $('.update').on('click', function() {
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('/taxes/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        $('#e_id').val(response.success.id);
                        $('#e_tax_rate').val(response.success.tax_rate);
                        $('#e_from').val(response.success.from);
                        $('#e_to').val(response.success.to);
                        $('#e_tax_deduction_amount').val(response.success.tax_deduction_amount);
                    }
                }
            });
        });
        $('.delete').on('click', function() {
            var _this = $(this).data("id");
            $('.e_id').val(_this);
        });
        $(document).on("click", ".btn-deleteEmployee", function(eex) {
            let id = $(this).data("id");
            let $btn = $(this);
            
            $.confirm({
                title: '',
                contentClass: 'text-center',
                content: '' +
                    '<form>' +
                        '<div class="form-header">' +
                            '<h3>@lang("lang.delete")</h3>' +
                            '<p>@lang("lang.are_you_sure_want_to_delete")?</p>' +
                        '</div>' +
                    '</form>',
                buttons: {
                    confirm: {
                        text: 'Submit',
                        btnClass: 'add-btn-status',
                        action: function() {
                            axios.post('{{ URL('special/approve/delete/employee') }}', {
                                'id': id
                            }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: 'Deleted successfully',
                                    type: "success",
                                    icon: true,
                                    timeout: 3000,
                                }).show();
                                $btn.closest("tr").remove();
                                if ($(".btl-employees tbody tr").length === 0) {
                                    window.location.replace("{{ URL('special/approve') }}");
                                }
                            }).catch(function(error) {
                                new Noty({
                                    title: "",
                                    text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                    type: "error",
                                    icon: true,
                                    timeout: 3000,
                                }).show();
                            });
                        }
                    },
                    cancel: {
                        text: 'Cancel',
                        btnClass: 'btn-secondary btn-sm',
                    },
                }
            }); 
            
        });
        $('.btn-view-detail').on('click', function() {
            let _this = $(this).data("name");
            let id = $(this).data("id");
            $('#under_approve_by').text(_this);
            $(".btl-employees tbody").html("");
            $.ajax({
                type: "GET",
                url: "{{ url('special/approve/employees') }}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    var tr = "";
                    if (response.datas.length > 0) {
                       $(response.datas).each(function(e, row) {
                           tr += '<tr class="odd">'+
                               '<td class="ids stuck-scroll-4">' +(row.employee_name_en)+'</td>'+
                               '<td>' + (row.position_name_en) + '</td>'+
                               '<td>' + (row.branch_name_en) + " / " +(row.department_name_en)+'</td>'+
                               '<td class="text-end">'+
                                '<a class="btn btn-primary btn-deleteEmployee" href="#" data-id="'+(row.id)+'"><i class="fa fa-trash-o m-r-5"></i></a>'+
                               '</td>'+
                           '</tr>';
                       });
                   } else {
                       tr = '<tr><td colspan=4 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                   }
                   $(".btl-employees tbody").html(tr);
                   $('#view-details').modal('show');
                }
            });
        });
    });
</script>
