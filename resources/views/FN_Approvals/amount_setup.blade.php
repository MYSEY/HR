@extends('layouts.master')
<style>
    .tooltip-inner {
        white-space: pre-line !important;
        text-align: left !important;
        max-width: 300px !important; 
        /* word-wrap: break-word !important; */
    }
    .container-checkbox {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 5px;
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 1;
        left: 0;
        height: 20px;
        width: 20px;
        border: solid 1px #ccc;
        background-color: #fff;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 7px;
        top: 4px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.setup_amount_approve') ( <span class="text-danger">{{$FnApproval->Employee[0]->employee_name_en}}</span> )</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.setup_amount_approve')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ url('/fn/approval') }}" type="button" class="btn btn-icon btn-secondary me-1">
                        <i class="fa fa-angle-double-left"></i> @lang('lang.back')
                    </a>
                    @if ($permission->is_create == "1")
                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#add_approval"><i class="fa fa-plus"></i> @lang('lang.add_amount')</a>
                    @endif
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
         @php
            $type = [
                0 => __("lang.general_expense"),
                1 => __("lang.special_expense"),
                2 => __("lang.tax_expense"),
            ];
            $reference_type = [
                1 => __("lang.regular_expense"),
                2 => __("lang.irregular_expense"),
            ];
            $asset = [
                'null'=>"",
                0 => __("lang.non_fixed_asset"),
                1 => __("lang.fixed_asset"),
            ];
        @endphp
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer btn_trainer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                            <tr>
                                <th>@lang('lang.location')</th>
                                <th>@lang('lang.request_type')</th>
                                <th>@lang('lang.reference') @lang('lang.type')</th>
                                <th>@lang('lang.special') @lang('lang.type')</th>
                                <th>@lang('lang.from_amount')</th>
                                <th>@lang('lang.to_amount')</th>
                                <th style="text-align: center;">@lang('lang.option')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datas)>0)
                                @foreach ($datas as $key=>$item)
                                    <tr class="odd">
                                         <td>
                                            {{$item->location == 1 ? "Branch" : "Department"}}
                                        </td>
                                        <td>{{$type[$item->requestType->request_type]}}</td>
                                        <td>
                                            @if ($item->requestType->request_type == 0)
                                                {{$reference_type[$item->requestType->reference_type]}}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->requestType->request_type == 1)
                                                {{$asset[$item->requestType->special_fixed_asset]}}
                                            @endif
                                        </td>
                                        <td>{{$item->requestType->from_amount}}</td>
                                        <td>{{$item->requestType->to_amount}}</td>
                                        <td style="text-align: center;">
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
                        <h5 class="modal-title">@lang('lang.add_amount_approval')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('fn/approval/create/amount')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" id="fn_approval_id" name="fn_approval_id" value="{{ request()->route('id') }}">
                            <div class="form-group">
                                <label>@lang('lang.from_location') <span class="text-danger">*</span></label>
                                <select class="form-control data_required" id="location" name="location" required>
                                    <option value="" selected> </option>
                                    <option value="1"> Branch </option>
                                    <option value="2"> Department </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.request_type') <span class="text-danger">*</span></label>
                                <select class="form-control data_required" id="level_reviewer_id" name="level_reviewer_id" required>
                                    <option value="" selected> </option>
                                    @foreach ($amounts as $item)
                                        <option value="{{$item->id}}">
                                            {{$type[$item->request_type].($item->reference_type ? ",".$reference_type[$item->reference_type] : "").($item->request_type == "1" ? ",".$asset[$item->special_fixed_asset] : "")." (".$item->from_amount."=>".$item->to_amount .")"}}
                                        </option>
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
                            <form action="{{url('fn/approval/delete/amount')}}" method="POST">
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
        $('.delete').on('click', function() {
            var _this = $(this).data('id');
            $('.e_id').val(_this);
        });
    });
</script>
