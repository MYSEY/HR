@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.fn_regular_expense')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.fn_regular_expense')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if ($permission->is_update == "1")
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#addRegularExspense"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 no-footer btn_trainer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                            <tr>
                                <th>@lang('lang.serialref')</th>
                                <th>@lang('lang.description')</th>
                                <th>@lang('lang.file_upload')</th>
                                <th>@lang('lang.contactual')</th>
                                <th>@lang('lang.status')</th>
                                <th>@lang('lang.renew')</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="addRegularExspense" class="modal custom-modal fade hr-modal-select2" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_new_regular_expense')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="btn-modal-close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('fn/regular-expense')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>@lang('lang.description')</label>
                                <textarea type="text" rows="3" class="form-control" name="description" id="description" value="{{old('description')}}" required></textarea>
                            </div>

                            <div class="form-group">
                                <label>@lang('lang.contactual')</label>
                                <select class="form-control @error('tax_type') is-invalid @enderror" id="is_contactual" name="is_contactual" required>
                                    <option value="" selected disabled> -- @lang('lang.select') --</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>@lang('lang.file_upload')</label>
                                <input class="form-control" type="file" id="file_upload" name="file_upload">
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
        <div id="loading-overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; text-align: center;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>Loading Data...</p>
            </div>
        </div>
    </div>
@endsection

@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('addRegularExspense').addEventListener('submit', function (event) {
            event.preventDefault();

            let form = event.target; // Explicitly reference the form
            let is_contactual = document.getElementById('is_contactual');
            let fileUpload = document.getElementById('file_upload');
            let isValid = true;

            // Validate is_contactual is not empty
            if (is_contactual.value === '') {
                $("#is_contactual").css("border-color", "#dc3545");
                isValid = false;
            } else {
                $("#is_contactual").css("border-color", "");
            }

            // If is_contactual is 1, require file upload
            if (is_contactual.value === '1' && fileUpload.files.length === 0) {
                $("#file_upload").css("border-color", "#dc3545");
                new Noty({
                    title: "",
                    text: "Please upload a file before submitting.",
                    type: "error",
                    icon: true
                }).show();
                isValid = false;
            } else {
                $("#file_upload").css("border-color", "");
            }
            if (isValid) {
                form.submit();
            }
        });
    });
    $(function() {
        dataTables();
        $(document).on('click', '#btn-renew-contract', function() {
            let description = $(this).data("description");
            $("#description").val(description);
            $("#addRegularExspense").modal("show");
        });
        $(document).on('click', '#btn-modal-close', function() {
            $("#description").val("");
            $("#file_upload").val("");
        });
        $(document).on('click', '#btn-status a', function() {
            let id = $(this).attr('data-id');
            let status = $(this).attr('data-name');
            let old_status = $(this).attr('data-status-old');
            let text_status = "";
            let text_old_status = "";
            if(old_status == 1){
                text_old_status = "@lang('lang.active')"
            }else{
                text_old_status = "@lang('lang.inactive')"
            }
            if(status == "1"){
                text_status = "@lang('lang.active')"
            }else{
                text_status = "@lang('lang.inactive')"
            }
            $.confirm({
                title: '@lang("lang.change_status")!',
                contentClass: 'text-center',
                backgroundDismiss: 'cancel',
                content: ''+
                        '<label>@lang("lang.are_you_sure_want_change_status") '+'<label style="color:red">'+text_old_status+'</label>'+' @lang("lang.to_") '+'<label style="color:red">'+text_status+'</label>'+'?</label>'+
                        '<input type="hidden" class="form-control regular_expense_status" id="" name="" value="'+status+'">'+
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">',
                buttons: {
                    confirm: {
                        text: '@lang("lang.submit")',
                        btnClass: 'add-btn-status',
                        action: function() {
                            var regular_expense_status = this.$content.find('.regular_expense_status').val();
                            var id = this.$content.find('.id').val();
                            
                            axios.post('{{ URL('fn/regular-expense/processing') }}', {
                                    'status': regular_expense_status,
                                    'id': id,
                                }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: "@lang('lang.the_process_has_been_successfully').",
                                    type: "success",
                                    icon: true
                                }).show();
                                $('.card-footer').remove();
                                window.location.replace("{{ URL('fn/regular-expense') }}");
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
    });

    function dataTables() {
        $('#loading-overlay').show();
        if ($.fn.DataTable.isDataTable('#DataTables_Table_0')) {
            $('#DataTables_Table_0').DataTable().clear().destroy();
        }
       $('#DataTables_Table_0').DataTable({
            destroy: true,
            pageLength: 10,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '{{ URL("/fn/regular-expense/indexshow") }}',
                type: 'GET',
            },
            columns: [

                // SERIAL REF
                {
                    data: 'serialref',
                    name: 'serialref'
                },

                // DESCRIPTION
                {
                    data: 'description',
                    name: 'description'
                },

                // FILE UPLOAD
                {
                    data: 'file_upload',
                    orderable: false,
                    searchable: false,
                    render: function (file_upload) {
                        if (file_upload !=null) {
                            return `
                                <small class="block text-ellipsis">
                                    <span class="text-xs">
                                        @lang('lang.preview_file_click_here')
                                        <a href="{{asset("/uploads/FnRegularExspenses")}}/${file_upload}" target="_blank">link</a>
                                    </span>
                                </small>
                            `;
                        }
                        return `<span class="text-xs">@lang('lang.preview_file_not_found')</span>`;
                    }
                },

                // IS CONTACTUAL
                {
                    data: 'is_contactual',
                    render: function (is_contactual) {
                        if (is_contactual ==1) {
                            return `
                                Yes
                            `;
                        }
                        return `No`;
                    }
                },

                // STATUS
                {
                    data: 'status',
                    orderable: false,
                    searchable: false,
                    render: function (status, type, row) {

                        @if ($permission->is_update == "1")
                            if (status == 1) {
                                return `
                                <div class="dropdown action-label">
                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown">
                                        <i class="fa fa-dot-circle-o text-success"></i>
                                        <span>{{ __('lang.active') }}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" id="btn-status">
                                        <a class="dropdown-item" data-id="${row.id}" data-name="1" data-status-old="${status}">
                                            <i class="fa fa-dot-circle-o text-success"></i> {{ __('lang.active') }}
                                        </a>
                                        <a class="dropdown-item" data-id="${row.id}" data-name="0" data-status-old="${status}">
                                            <i class="fa fa-dot-circle-o text-danger"></i> {{ __('lang.inactive') }}
                                        </a>
                                    </div>
                                </div>`;
                            } else {
                                return `
                                <div class="dropdown action-label">
                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown">
                                        <i class="fa fa-dot-circle-o text-danger"></i>
                                        <span>{{ __('lang.inactive') }}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" id="btn-status">
                                        <a class="dropdown-item" data-id="${row.id}" data-name="1" data-status-old="${status}">
                                            <i class="fa fa-dot-circle-o text-success"></i> {{ __('lang.active') }}
                                        </a>
                                        <a class="dropdown-item" data-id="${row.id}" data-name="0" data-status-old="${status}">
                                            <i class="fa fa-dot-circle-o text-danger"></i> {{ __('lang.inactive') }}
                                        </a>
                                    </div>
                                </div>`;
                            }
                        @else
                            return status == 1
                                ? `<span class="badge bg-inverse-success">{{ __('lang.active') }}</span>`
                                : `<span class="badge bg-inverse-danger">{{ __('lang.inactive') }}</span>`;
                        @endif
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (row) {
                        @if ($permission->is_create == "1")
                            return `
                                    <button class="btn btn-outline-secondary btn-sm" id="btn-renew-contract"
                                    data-description="${row.description}">
                                    Renew Contract
                                    </button>
                                `;
                        @endif
                        return ``;
                    }
                },
            ],
            initComplete: function () {
                $('#loading-overlay').hide();
            }
        });

        $('#DataTables_Table_0').on('processing.dt', function (e, settings, processing) {
            processing ? $('#loading-overlay').show() : $('#loading-overlay').hide();
        });
    }
</script>
@endsection