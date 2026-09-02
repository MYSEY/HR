@extends('layouts.master')
<style>
    .tooltip-inner {
        white-space: normal !important;
        text-align: left !important;
        max-width: 300px !important; 
        word-wrap: break-word !important;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.fn_level_reviewer')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.fn_level_reviewer')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    
                    @if ($permission->is_create == "1")
                        <a href="{{url('fn/level-reviewer/create')}}" class="btn add-btn"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        <form>
            {{-- @csrf --}}
            <div class="row filter-btn"> 
                <div class="col-sm-9 col-md-9"> 
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <select class="select form-control" id="location_id" data-select2-id="select2-data-2-c0n2">
                                    <option value="" data-select2-id="select2-data-2-c0n2">All @lang('lang.location')</option>
                                    <option value="1">@lang('lang.branch')</option>
                                    <option value="2">@lang('lang.department')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select class="select form-control" id="department_id" data-select2-id="select2-data-2" disabled>
                                    <option value="" data-select2-id="select2-data-2-">-- @lang('lang.select') --</option>
                                    @foreach ($departments as $item)
                                        <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select class="form-control request_type">
                                    <option value=""> All @lang('lang.request_type')</option>
                                    <option value="gr0">@lang('lang.general_expense')</option>
                                    <option value="2">@lang('lang.tax_expense')</option>
                                    <option value="1">@lang('lang.special_expense')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-sm-3 col-md-3">
                    <div style="display: flex" class="float-end">
                        <button type="button" class="btn btn-sm btn-outline-secondary submit-btn btn-research me-2" data-dismiss="modal" id="icon-search-download-reload">
                            <span class="btn-txt"><i class="fa fa-search"></i></span>
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                        @if ($permission->is_export == "1")
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                                <span class="btn-text-excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
                                <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        @endif
                        <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                            <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                            <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    @if (method_exists($datas, 'total') && $datas->total() > 9)
                        <form method="GET" class="mb-3">
                            <label>Show 
                                <select name="per_page" onchange="this.form.submit()" class="per_page">
                                    <?php
                                        for ($i = 10; $i <= $datas->total(); $i *= 2) {
                                            echo '<option value="'.$i.'" '.(request('per_page') == $i ? 'selected' : '').'>'.$i.'</option>';
                                        }
                                        if ($datas->total() > $i / 2) {
                                            echo '<option value="'.$datas->total().'" '.(request('per_page') == $datas->total() ? 'selected' : '').'>'.$datas->total().'</option>';
                                        }
                                    ?>
                                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>All</option>
                                </select> entries
                            </label>
                        </form>
                    @endif
                    <table class="table table-striped custom-table mb-0 no-footer tbl-level-review" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                            <tr>
                                <th>@lang('lang.from_amount')</th>
                                <th>@lang('lang.to_amount')</th>
                                <th>@lang('lang.from_location')</th>
                                <th>@lang('lang.model_review')</th>
                                <th>@lang('lang.request_type')</th>
                                <th>@lang('lang.reference_type')</th>
                                <th>@lang('lang.description')</th>
                                <th style="text-align: center;">@lang('lang.option')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datas)>0)
                                @php
                                    $type = [
                                        "0" => __("lang.general_expense"),
                                        "2" => __("lang.tax_expense"),
                                        "1" => __("lang.special_expense"),
                                    ];
                                @endphp
                                @foreach ($datas as $key=>$item)
                                    <tr class="odd">
                                        <td>{{$item->from_amount}}</td>
                                        <td>{{$item->to_amount}}</td>
                                        <td>{{$item->from_location =="1" ? "Branch" : "Department"}}</td>
                                        <td>{{$item->modelReview ? $item->modelReview->name_english : ""}}</td>
                                        <td>{{ $type[$item->request_type]}}</td>
                                        <td>
                                            @if ($item->reference_type == 1)
                                                @lang('lang.regular_expense')
                                            @endif
                                            @if ($item->reference_type == 2)
                                                @lang('lang.irregular_expense')
                                            @endif
                                        </td>
                                        <td>{{$item->description}}</td>
                                        <td style="text-align: center;">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if ($permission->is_update == "1")
                                                        <a class="dropdown-item update" href="{{url("fn/level-reviewer/edit",$item->group_id)}}" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                    @endif
                                                    <a class="dropdown-item btn-review" href="{{url("fn/level-reviewer/view",$item->group_id)}}"><i class="fa fa-eye m-r-5"></i> @lang('lang.review')</a>
                                                    @if ($permission->is_delete == "1")
                                                        <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->group_id}}" data-target="#delete_level"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if ($datas instanceof \Illuminate\Contracts\Pagination\Paginator)
                        {!! $datas->withQueryString()->links('pagination::bootstrap-5') !!}
                    @endif
                </div>
            </div>
        </div>
        <!-- Delete Taxes Modal -->
        <div class="modal custom-modal fade" id="delete_level" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('fn/level-reviewer/delete')}}" method="POST">
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
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip({ 
            html: true,
            container: 'tr' 
        });
    });
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('/fn/level-reviewer') }}"); 
        });
        $(document).on('change', '#location_id', function () {
            let location_type = $("#location_id").val();
            if (location_type == 1) {
                $('#department_id')
                    .prop('disabled', true)
                    .addClass('disabled-style')
                    .val('');
                    $('#department_id').trigger('change.select2');
            } else {
                $('#department_id')
                    .prop('disabled', false)
                    .removeClass('disabled-style')
                    .val('');
                $('#department_id').trigger('change.select2');
            }
        });
        $(".btn_excel").on("click", function () {
            let query = {
                "_token": "{{ csrf_token() }}",
                department_id: $("#department_id").val(),
                location_id:     $("#location_id").val(),
                request_type:     $(".request_type").val(),
            };
            var url = "{{URL::to('fn/level-reviewer/export')}}?" + $.param(query)
            window.location = url;
        });
        $("#request_type").on("change", function() {
            let value = $(this).find("option:selected").val();
            $("#reference_type").val("");
            if (value == "0") {
                $(".reference_type").css("display","block");
            } else {
                $(".reference_type").css("display","none");
            }
        });
        $("#e_request_type").on("change", function() {
            $("#e_reference_type").val("");
            let value = $(this).find("option:selected").val();
            if (value == "0") {
                $(".e_reference_type").css("display","block");
            } else {
                $(".e_reference_type").css("display","none");
            }
        });
       
        $(document).on('click','.delete', function(){
            var _this = $(this).data('id');
            $('.e_id').val(_this);
        });
        $(".btn-research").on("click", function () {
            $(this).prop('disabled', true);
            $(".btn-txt").hide();
            $(".loading-icon").css('display', 'block');
            let currentPage = $(".per_page").val();
            let param = {
                "_token":       "{{ csrf_token() }}",
                department_id:  $("#department_id").val(),
                location_id:    $("#location_id").val(),
                request_type:    $(".request_type").val(),
                per_page:       currentPage,
            };
            showdatas(param);
        });
    });
    function showdatas(param) {
        $.ajax({
            url: "{{ url('fn/level-reviewer/search') }}",
            type: 'POST',
            data: param,
            dataType: 'JSON',
            success: function(response) {
                let datas = response.success.data;
                let permission = response.permission;
                let tr = "";
                let type = {
                    "0": "General Expense",
                    "2": "Tax Expense",
                    "1": "Special Expense"
                };

                if (datas.length > 0) {
                    datas.forEach(item => {
                        // Position views
                        let positionViews = "";
                        if (item.position_review && item.position_review.length > 0) {
                            item.position_review.forEach((pos, index) => {
                                positionViews += (index + 1) + ". " + pos.name_english;
                            });
                        }
                        
                        // Determine expense reference type
                        let referenceTypeLabel = "";
                        if (item.reference_type == 1) {
                            referenceTypeLabel = "Regular Expense";
                        } else if (item.reference_type == 2) {
                            referenceTypeLabel = "Irregular Expense";
                        }

                        // Determine location
                        let fromLocationLabel = item.from_location == "1" ? "Branch" : "Department";

                        // First reviewer
                        let reviewer = item.position_review && item.position_review.length > 0
                            ? item.position_review[0].name_english
                            : "";

                        // Department
                        let department = item.department_view ? item.department_view.name_english : "";
                        let model_review = item.model_review ? item.model_review.name_english : "";

                        // Action buttons (adjust based on permission object or server-returned flags)
                        let actionButtons = "";
                        if (permission.is_update == "1") {
                            actionButtons +=  '<a class="dropdown-item update" href="{{url("fn/level-reviewer/edit")}}/'+(item.group_id)+'"><i class="fa fa-pencil m-r-5"></i> @lang("lang.edit")</a>';
                        }
                        if (permission.is_delete == "1") {
                            actionButtons += '<a class="dropdown-item delete" href="#" data-toggle="modal" data-id="'+item.group_id+'" data-target="#delete_level"><i class="fa fa-trash-o m-r-5"></i> @lang("lang.delete")</a>';
                        }
                        // Build row
                        tr += '<tr class="odd">'+
                                '<td>'+item.from_amount+'</td>'+
                                '<td>'+item.to_amount+'</td>'+
                                '<td>'+fromLocationLabel+'</td>'+
                                '<td>'+(model_review)+'</td>'+
                                '<td>'+(type[item.request_type])+'</td>'+
                                '<td>'+referenceTypeLabel+'</td>'+
                                '<td data-toggle="tooltip" data-html="true" title="'+item.description+'">'+
                                    (item.description ? strLimit(item.description, 30, '...') : "")+
                                '</td>'+
                                '<td style="text-align: center;">'+
                                    '<div class="dropdown dropdown-action">'+
                                        '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>'+
                                        '<div class="dropdown-menu dropdown-menu-right">'+
                                            '<a class="dropdown-item btn-review" href="{{url("fn/level-reviewer/view")}}/'+(item.group_id)+'"><i class="fa fa-eye m-r-5"></i> @lang("lang.review")</a>'+
                                            (actionButtons)+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>';
                    });
                }
                $(".tbl-level-review tbody").html(tr);
                 $('[data-toggle="tooltip"]').tooltip({ 
                    html: true,
                    container: 'tr' 
                });
                $(".btn-research").prop('disabled', false);
                $(".btn-txt").show();
                $(".loading-icon").css('display', 'none');
            }
        });
    }
    function strLimit(str, limit = 30, end = '...') {
        return str.length > limit ? str.substring(0, limit) + end : str;
    }

</script>
