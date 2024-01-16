@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.leave_type')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.leave_type')</li>
                    </ul>
                </div>
                {{-- <div class="col-auto float-end ms-auto">
                    @if (permissionAccess("m8-s1","is_create")->value == "1")
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_taxes"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div> --}}
            </div>
        </div>
        @if (permissionAccess("m8-s1","is_view")->value == "1")
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered review-table mb-0">
                            <thead>
                                <tr>
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('lang.default_day')</th>
                                    <th style="text-align: center;">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data)>0)
                                    @foreach ($data as $item)
                                        <tr>
                                            <td hidden class="ids">{{$item->id}}</td>
                                            <td><input type="text" class="form-control" value="{{$item->name}}"></td>
                                            <td><div class="input-group"><input type="text" class="form-control" value="{{$item->default_day}}"></div></td>
                                            <td style="text-align: center;">
                                                @if (permissionAccess("m8-s1","is_update")->value == "1")
                                                    <a class="btn btn-success update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_leave_type"><i class="fa fa-edit"></i></a>
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
        @endif
        {{-- <div id="add_taxes" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_new_tax')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('taxes/store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.tax_rate') <span class="text-danger">*</span></label>
                                        <input class="form-control @error('tax_rate') is-invalid @enderror" type="text" id="" name="tax_rate" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.tax_deduction')</label>
                                        <input class="form-control @error('tax_deduction_amount') is-invalid @enderror" type="number" id="" name="tax_deduction_amount">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.from')</label>
                                        <input class="form-control @error('from') is-invalid @enderror" type="number" id="" name="from">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.to')</label>
                                        <input class="form-control @error('to') is-invalid @enderror" type="number" id="" name="to">
                                    </div>
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
        </div> --}}

        <div id="edit_leave_type" class="modal custom-modal fade" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.edit_leave_type')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('leave/type/update') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>@lang('lang.name')<span class="text-danger">*</span></label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="e_name" name="name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>@lang('lang.default_day')<span class="text-danger">*</span></label>
                                        <input class="form-control @error('default_day') is-invalid @enderror" type="number" id="e_default_day" name="default_day">
                                    </div>
                                </div>
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
                url: "{{url('/leave/type/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        $('#e_id').val(response.success.id);
                        $('#e_name').val(response.success.name);
                        $('#e_default_day').val(response.success.default_day);
                    }
                }
            });
        });
    });
</script>
