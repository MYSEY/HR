@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.fn_taxes')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.fn_taxes')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if ($permission->is_create == "1")
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_taxes"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered review-table mb-0">
                        <thead>
                            <tr>
                                <th>@lang('lang.tax_rate')</th>
                                <th>@lang('lang.type')</th>
                                <th>@lang('lang.description')</th>
                                <th style="text-align: center;">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data)>0)
                                @foreach ($data as $item)
                                    <tr>
                                        <td hidden class="ids">{{$item->id}}</td>
                                        <td><input type="text" disabled class="form-control" value="{{$item->tax_rate}}%"></td>
                                        <td><div class="input-group"><span class="input-group-text"></span><input disabled class="form-control" value="{{$item->tax_type == 1 ? "WHT":"FBT" }}"></div></td>
                                        <td><div class="input-group"><span class="input-group-text"></span><input disabled class="form-control" value="{{$item->description}}"></div></td>
                                        <td style="text-align: center;">
                                            @if ($permission->is_update == "1")
                                                <a class="btn btn-success update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_taxes"><i class="fa fa-edit"></i></a>
                                            @endif
                                            @if ($permission->is_delete == "1")
                                                <a class="btn btn-danger delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_taxes"><i class="fa fa-trash-o m-r-5"></i></a>
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
        <div id="add_taxes" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_new_tax')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url("/fn/taxe")}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>@lang('lang.tax_rate') <span class="text-danger">*</span></label>
                                <input class="form-control @error('tax_rate') is-invalid @enderror" type="number" id="" name="tax_rate" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.type')</label>
                                <select class="form-control @error('tax_type') is-invalid @enderror" id="tax_type" name="tax_type" required>
                                    <option value="" selected> -- @lang('lang.select') --</option>
                                    <option value="1">WHT</option>
                                    <option value="2">FBT</option>
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

        <div id="edit_taxes" class="modal custom-modal fade" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.edit_tax')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('fn/taxe/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>@lang('lang.tax_rate') <span class="text-danger">*</span></label>
                                <input class="form-control @error('tax_rate') is-invalid @enderror" type="number" id="e_tax_rate" name="tax_rate" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.type')</label>
                                <select class="form-control @error('tax_type') is-invalid @enderror" id="e_tax_type" name="tax_type" required>
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
        <div class="modal custom-modal fade" id="delete_taxes" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('fn/taxe/delete')}}" method="POST">
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
                url: "{{url('/fn/taxe/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        $('#e_id').val(response.success.id);
                        $('#e_tax_rate').val(response.success.tax_rate);
                        if (response.success.tax_type == 1) {
                            $("#e_tax_type").append('<option selected value="1">WHT</option><option value="2">FBT</option>');
                        } else {
                            $("#e_tax_type").append('<option selected value="2">FBT</option> <option value="1">WHT</option>');   
                        }
                        $('#e_description').text(response.success.description);
                    }
                }
            });
        });
        $('.delete').on('click', function() {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });
    });
</script>
