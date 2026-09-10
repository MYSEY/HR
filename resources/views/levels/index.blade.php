@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.level')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.level')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if ($permission->is_create == "1")
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_level"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                    
                </div>
            </div>
        </div>
        @if ($permission->is_view == "1")
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable no-footer">
                            <thead>
                                <tr>
                                    <th>@lang('lang.level')</th>
                                    <th>@lang('lang.description')</th>
                                    <th style="text-align: center;" data-orderable="false">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data) > 0)
                                    @foreach ($data as $item)
                                        <tr>
                                            <td data-order="{{ $item->sort_order }}">
                                                {{ $item->name }}
                                            </td>
                                            <td></td>
                                            <td class="text-end">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if ($permission->is_update == "1")
                                                            <a class="dropdown-item update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_level"><i class="fa fa-edit"></i> @lang('lang.edit')</a>
                                                        @endif
                                                        @if ($permission->is_delete == "1")
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
        <div id="add_level" class="modal custom-modal fade hr-modal-select2" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_new')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('level/store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <div class="form-group">
                                    <label>@lang('lang.level')<span class="text-danger">*</span></label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" required>
                                </div>
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
        <div id="edit_level" class="modal custom-modal fade" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.edit') @lang('lang.level')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('level/update') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>@lang('lang.level') <span class="text-danger">*</span></label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="e_name" name="name" required>
                            </div>
                            
                            <div class="submit-section">
                                <input type="hidden" class="ids" name="id" id="e_id">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                    <span class="btn-txt">@lang('lang.submit')</span>
                                </button>
                            </div>
                        </form>
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
                            <form action="{{ url('level/delete') }}" method="POST">
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
        $(document).ready(function() {
            // Check if DataTable already exists, destroy, and re-initialize safely
            if ($.fn.DataTable.isDataTable('.datatable')) {
                $('.datatable').DataTable().destroy();
            }

            $('.datatable').DataTable({
                destroy: true,
                paging: true,
                searching: true,
                ordering: true,
                order: [[0, 'asc']], // Sort by Name (first column) ascending
                columnDefs: [
                    { orderable: false, targets: -1 } // Disable sorting on the last column (Action)
                ]
            });
        });
        $('.update').on('click', function() {
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('/level/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        $('#e_id').val(response.success.id);
                        $('#e_name').val(response.success.name);
                    }
                }
            });
        });
        $('.delete').on('click', function() {
            var _this = $(this).data("id");
            $('.e_id').val(_this);
        });
    });
</script>
