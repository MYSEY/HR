@extends('layouts.master')
<style>
    .tooltip-inner {
        white-space: pre-line; /* Ensures new lines appear */
        text-align: left !important;
        max-width: 300px; /* Adjust width if needed */
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.fn_approval')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.fn_approval')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if ($permission->is_create == "1")
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_approval"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer btn_trainer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                            <tr>
                                <th>@lang('lang.title')</th>
                                <th>@lang('lang.employee')</th>
                                <th>@lang('lang.location')</th>
                                <th>@lang('lang.description')</th>
                                <th style="text-align: center;">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datas)>0)
                                @foreach ($datas as $key=>$item)
                                    <tr class="odd">
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->employee ? $item->employee->employee_name_en : ""}}</td>
                                        <td>{{$item->location ? $item->location->branch_name_en : ""}}</td>
                                        <td data-toggle="tooltip" data-html="true" title="{!! $item->description !!}">
                                            {{ Str::limit($item->description, 30, '...') }}
                                        </td>
                                        <td style="text-align: center;">
                                            @if ($permission->is_update == "1")
                                                <a class="btn btn-success update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_approval"><i class="fa fa-edit"></i></a>
                                            @endif
                                            @if ($permission->is_delete == "1")
                                                <a class="btn btn-danger delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_approval"><i class="fa fa-trash-o m-r-5"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="add_approval" class="modal custom-modal fade hr-modal-select2" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_new_approval')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('fn/approval')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>@lang('lang.title') <span class="text-danger">*</span></label>
                                <textarea type="text" rows="3" class="form-control" name="title" id="title" value="{{old('title')}}" required></textarea>
                            </div>
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.employee') <span class="text-danger">*</span></label>
                                <select class="select form-control hr-select2-option requered @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                                    <option value="" selected> -- @lang('lang.select') --</option>
                                    @foreach ($employees as $item)
                                        <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.location') <span class="text-danger">*</span></label>
                                <select class="form-control @error('location_id') is-invalid @enderror" id="location_id" name="location_id" required>
                                    <option value="" selected> -- @lang('lang.select') --</option>
                                    @foreach ($locations as $item)
                                        <option value="{{$item->id}}">{{$item->branch_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.description')</label>
                                <textarea type="text" rows="3" class="form-control" name="description" id="description" value="{{old('description')}}"></textarea>
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

        <div id="edit_approval" class="modal custom-modal fade" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.edit_approval')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('fn/approval/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>@lang('lang.title') <span class="text-danger">*</span></label>
                                <textarea type="text" rows="3" class="form-control" name="title" id="e_title" value="{{old('title')}}" required></textarea>
                            </div>
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.employee') <span class="text-danger">*</span></label>
                                <select class="select form-control hr-select2-option emp_required" id="e_employee_id" name="employee_id" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.location') <span class="text-danger">*</span></label>
                                <select class="form-control" id="e_location_id" name="location_id" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.description')</label>
                                <textarea type="text" rows="3" class="form-control" name="description" id="e_description" value="{{old('description')}}"></textarea>
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

        <!-- Delete Taxes Modal -->
        <div class="modal custom-modal fade" id="delete_approval" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('fn/approval/delete')}}" method="POST">
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
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip({ html: true });
        });
        $('.update').on('click', function() {
            let id = $(this).data("id");
            $(".hr-form-group-select2").each(function(){
                let formGroup = $(this);
                let value = formGroup.attr("data-select2-id");
                let requeredField = formGroup.find(".hr-select2-option").val();
                let requered = formGroup.find(".emp_required").val();
                if(!value && requered == ""){ 
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }else if (!requeredField && requered == "") {
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }
            });
            $.ajax({
                type: "GET",
                url: "{{url('/fn/approval/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        $('#e_id').val(response.success.id);
                        $('#e_title').text(response.success.title);
                        $('#e_employee_id').html('');
                        if (response.success.employee_id !="") {
                            $.each(response.employees, function(i, item) {
                                $('#e_employee_id').append($('<option>', {
                                    value: item.id,
                                    text: item.employee_name_en,
                                    selected: item.id == response.success.employee_id ? true : false
                                }));
                            });
                        }
                        $('#e_location_id').html('');
                        if (response.success.location_id !="") {
                            $.each(response.locations, function(i, item) {
                                $('#e_location_id').append($('<option>', {
                                    value: item.id,
                                    text: item.branch_name_en,
                                    selected: item.id == response.success.location_id ? true : false
                                }));
                            });
                        }
                       
                        $('#e_description').text(response.success.description);
                    }
                }
            });
        });
        $('.delete').on('click', function() {
            var _this = $(this).data('id');
            $('.e_id').val(_this);
        });
    });
</script>
