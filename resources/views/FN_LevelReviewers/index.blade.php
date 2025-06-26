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
                    <h3 class="page-title">@lang('lang.fn_level_reviewer')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.fn_level_reviewer')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if ($permission->is_create == "1")
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_level"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
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
                            <div class="form-group" id="col-branch">
                                <select class="select form-control" id="location_id" data-select2-id="select2-data-2-c0n2" name="location_id">
                                    <option value="" data-select2-id="select2-data-2-c0n2">All @lang('lang.location')</option>
                                    <option value="1">@lang('lang.branch')</option>
                                    <option value="2">@lang('lang.department')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select class="select form-control" id="department_id" data-select2-id="select2-data-2" name="department_id" disabled>
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
                                    <option value="0">@lang('lang.general_expense')</option>
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
                        {{-- @if ($permission->is_export == "1") --}}
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                                <span class="btn-text-excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
                                <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        {{-- @endif --}}
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
                                <th>@lang('lang.request_type')</th>
                                <th>@lang('lang.reference') @lang('lang.type')</th>
                                <th>@lang('lang.review') @lang('lang.type')</th>
                                <th>@lang('lang.from_location')</th>
                                <th>@lang('lang.position_review')</th>
                                <th>@lang('lang.department_review')</th>
                                <th>@lang('lang.description')</th>
                                <th style="text-align: center;">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datas)>0)
                                @php
                                    $requestType = [
                                        "1"=>__("lang.review"),
                                        "2"=>__("lang.review"),
                                        "3"=>__("lang.review"),
                                        "4"=>__("lang.review"),
                                        "5"=>__("lang.review"),
                                        "6"=>__("lang.review"),
                                        "7"=>__("lang.review"),
                                        "8"=>__("lang.review"),
                                        "9"=>__("lang.review"),
                                        "10"=>__("lang.review"),
                                    ];
                                    $type = [
                                        "0" => __("lang.general_expense"),
                                        "2" => __("lang.tax_expense"),
                                        "1" => __("lang.special_expense"),
                                    ];
                                @endphp
                                @foreach ($datas as $key=>$item)
                                    @php
                                        $positionViews = "";
                                        $num = 1;
                                        foreach ($item->positionReview as $value) {
                                            $positionViews .= $num . ". " . $value->name_english . "\n";
                                            $num++;
                                        }
                                    @endphp
                                    <tr class="odd">
                                        <td>{{$item->from_amount}}</td>
                                        <td>{{$item->to_amount}}</td>
                                        <td>{{ $type[$item->request_type]}}</td>
                                        <td>
                                            @if ($item->reference_type == 1)
                                                @lang('lang.regular_expense')
                                            @endif
                                            @if ($item->reference_type == 2)
                                                @lang('lang.irregular_expense')
                                            @endif
                                        </td>
                                        <td>{{ $requestType[$item->type]." ".$item->type}}</td>
                                        <td>{{$item->from_location =="1" ? "Branch" : "Department"}}</td>
                                        <td data-toggle="tooltip" data-html="true" title="{!! $positionViews !!}">{{$item->positionReview[0]->name_english}}...</td>
                                        <td>{{$item->departmentView ? $item->departmentView->name_english : ""}}</td>
                                        <td>{{$item->description}}</td>
                                        <td style="text-align: center;">
                                            @if ($permission->is_update == "1")
                                                <a class="btn btn-success update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_fn_lovel"><i class="fa fa-edit"></i></a>
                                            @endif
                                            @if ($permission->is_delete == "1")
                                                <a class="btn btn-danger delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_level"><i class="fa fa-trash-o m-r-5"></i></a>
                                            @endif
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
        <div id="add_level" class="modal custom-modal fade hr-modal-select2" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.level_review')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="levelReviewerForm" action="{{url('fn/level-reviewer')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.from_amount') <span class="text-danger">*</span></label>
                                        <input class="form-control @error('from_amount') is-invalid @enderror" type="number" id="from_amount" name="from_amount" value="" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.to_amount') <span class="text-danger">*</span></label>
                                        <input class="form-control @error('to_amount') is-invalid @enderror" type="number" id="to_amount" name="to_amount" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.request_type') <span class="text-danger">*</span></label>
                                <select class="form-control @error('request_type') is-invalid @enderror" id="request_type" name="request_type" required>
                                    <option value="" selected> </option>
                                    <option value="0">@lang('lang.general_expense')</option>
                                    <option value="2">@lang('lang.tax_expense')</option>
                                    <option value="1">@lang('lang.special_expense')</option>
                                </select>
                            </div>
                            <div class="reference_type" style="display: none">
                                <div class="form-group">
                                    <label>@lang('lang.reference') @lang('lang.type') <span class="text-danger">*</span></label>
                                    <select class="form-control" id="reference_type" name="reference_type">
                                        <option value="" selected> </option>
                                        <option value="1">@lang('lang.regular_expense')</option>
                                        <option value="2">@lang('lang.irregular_expense')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.type') <span class="text-danger">*</span></label>
                                <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="" selected> </option>
                                    <option value="1">@lang('lang.review') 1</option>
                                    <option value="2">@lang('lang.review') 2</option>
                                    <option value="3">@lang('lang.review') 3</option>
                                    <option value="4">@lang('lang.review') 4</option>
                                    <option value="5">@lang('lang.review') 5</option>
                                    <option value="6">@lang('lang.review') 6</option>
                                    <option value="7">@lang('lang.review') 7</option>
                                    <option value="8">@lang('lang.review') 8</option>
                                    <option value="9">@lang('lang.review') 9</option>
                                    <option value="10">@lang('lang.review') 10</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.from_location') <span class="text-danger">*</span></label>
                                <select class="form-control requered" id="from_location" name="from_location" required>
                                    <option value="" selected> </option>
                                    <option value="1"> Branch </option>
                                    <option value="2"> Department </option>
                                </select>
                            </div>

                            <div class="position_review">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.position_review') <span class="text-danger">*</span></label>
                                    <select class="select form-control hr-select2-option requered" multiple="" id="id_positions" name="id_positions[]" required>
                                        <option value=""> </option>
                                        @foreach ($positions as $item)
                                            <option value="{{$item->id}}">{{$item->name_english}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.department_review')</label>
                                <select class="select form-control hr-select2-option" id="department_review" name="department_review">
                                    <option value="" selected> </option>
                                    @foreach ($departments as $item)
                                        <option value="{{$item->id}}">{{$item->name_english}}</option>
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

        <div id="edit_fn_lovel" class="modal custom-modal fade hr-modal-select2" role="dialog" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.edit_level_review')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="elevelReviewerForm" action="{{url('fn/level-reviewer/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.from_amount') <span class="text-danger">*</span></label>
                                        <input class="form-control @error('from_amount') is-invalid @enderror" type="number" id="e_from_amount" name="from_amount" value="" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.to_amount') <span class="text-danger">*</span></label>
                                        <input class="form-control @error('to_amount') is-invalid @enderror" type="number" id="e_to_amount" name="to_amount" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.request_type') <span class="text-danger">*</span></label>
                                <select class="form-control @error('request_type') is-invalid @enderror" id="e_request_type" name="request_type" required>
                                </select>
                            </div>
                            <div class="e_reference_type" style="display: none">
                                <div class="form-group">
                                    <label>@lang('lang.reference') @lang('lang.type') <span class="text-danger">*</span></label>
                                    <select class="form-control" id="e_reference_type" name="reference_type">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.type') <span class="text-danger">*</span></label>
                                <select class="form-control @error('type') is-invalid @enderror" id="e_type" name="type" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.from_location') <span class="text-danger">*</span></label>
                                <select class="form-control requered" id="e_from_location" name="from_location" required>
                                    <option value="" selected> </option>
                                    <option value="1"> Branch </option>
                                    <option value="2"> Department </option>
                                </select>
                            </div>

                            <div class="position_review">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.position_review') <span class="text-danger">*</span></label>
                                    <select class="select form-control hr-select2-option e_requered" multiple="" id="e_id_positions" name="id_positions[]" required>
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.department_review')</label>
                                <select class="select form-control hr-select2-option" id="e_department_review" name="department_review">
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
    document.addEventListener('DOMContentLoaded', function () {
        // Listen for the form submission
        document.getElementById('levelReviewerForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission
            // Get form elements
            let positionsReview = document.getElementById('id_positions');
            let requestType = document.getElementById('request_type');
            let referenceType = document.getElementById('reference_type');
            
            if (requestType.value === "0" && referenceType.value === "") {
                $("#reference_type").css("border-color", "#dc3545");
                return;
            } else {
               $("#reference_type").css("border-color","#198754");
            }

            if (positionsReview.value === '') {
                $(".hr-form-group-select2").each(function(){
                    let formGroup = $(this);
                    formGroup.find(".select2-selection--multiple").css("border-color","#dc3545");
                });
                return;
            }
            this.submit();
        });

        // Listen for the form submission
        document.getElementById('elevelReviewerForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission
            // Get form elements
            let positionsReview = document.getElementById('e_id_positions');
            let requestType = document.getElementById('e_request_type');
            let referenceType = document.getElementById('e_reference_type');
            
            if (requestType.value === "0" && referenceType.value === "") {
                $("#e_reference_type").css("border-color", "#dc3545");
                return;
            } else {
               $("#e_reference_type").css("border-color","#198754");

            }
            if (positionsReview.value === '') {
                $(".hr-form-group-select2").each(function(){
                    let formGroup = $(this);
                    formGroup.find(".select2-selection--multiple").css("border-color","#dc3545");
                });
                return;
            }
            this.submit();
        });
    });
    
    $(function() {
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip({ 
                html: true,
                container: 'tr'
            });
        });
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('/fn/level-reviewer') }}"); 
        });
        // $("#location_id").on("change", function() {
        //     let location_type = $("#location_id option:checked").attr('data-id');
        //     if (location_type == 1) {
        //         $('#location_id').find('option').each(function(){
        //             if ($(this).attr('data-id') == "Supporting Staff") {
        //                 $("#position_type").val($(this).val());
        //             }
        //         }); 
        //     }else{
        //         $('#position_type').find('option').each(function(){
        //             if ($(this).attr('data-id') == "Field Staff") {
        //                 $("#position_type").val($(this).val());
        //             }
        //         });
        //     }
        // });
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
        
        $(document).on('click','.update', function(){
        // $('.update').on('click', function() {
            $(".e_reference_type").css("display","none");
            let id = $(this).data("id");
            $('#e_request_type').html("");
            $('#e_type').html("");
            $.ajax({
                type: "GET",
                url: "{{url('/fn/level-reviewer/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.data) {
                        $('#e_id').val(response.data.id);
                        $('#e_from_amount').val(response.data.from_amount);
                        $('#e_to_amount').val(response.data.to_amount);
                        
                        let requestType = [
                            {"id": "0", "value": "{{ __('lang.general_expense') }}"},
                            {"id": "2", "value": "{{ __('lang.tax_expense') }}"},
                            {"id": "1", "value": "{{ __('lang.special_expense') }}"},
                        ];
                        $.each(requestType, function(i, item) {
                            $('#e_request_type').append($('<option>', {
                                value: item.id,
                                text: item.value,
                                selected: item.id == response.data.request_type ? true : false
                            }));
                        });
                        if (response.data.request_type == 0) {
                            $(".e_reference_type").css("display","block");
                        }
                        $('#e_reference_type').html('<option >  </option>');
                        if (response.data.reference_type == 1) {
                            $("#e_reference_type").append('<option value="1" selected>@lang("lang.regular_expense")</option> <option value="2">@lang("lang.irregular_expense")</option>');
                        } else {
                            $("#e_reference_type").append('<option value="1" >@lang("lang.regular_expense")</option> <option value="2" selected>@lang("lang.irregular_expense")</option>');
                        }
                        let type = [
                            {"id": 1, "value": "{{ __('lang.review') }} 1"},
                            {"id": 2, "value": "{{ __('lang.review') }} 2"},
                            {"id": 3, "value": "{{ __('lang.review') }} 3"},
                            {"id": 4, "value": "{{ __('lang.review') }} 4"},
                            {"id": 5, "value": "{{ __('lang.review') }} 5"},
                            {"id": 6, "value": "{{ __('lang.review') }} 6"},
                            {"id": 7, "value": "{{ __('lang.review') }} 7"},
                            {"id": 8, "value": "{{ __('lang.review') }} 8"},
                            {"id": 9, "value": "{{ __('lang.review') }} 9"},
                            {"id": 10, "value": "{{ __('lang.review') }} 10"}
                        ];
                        if (response.data.type) {
                            $.each(type, function(i, item) {
                                $('#e_type').append($('<option>', {
                                    value: item.id,
                                    text: item.value,
                                    selected: item.id == response.data.type ? true : false
                                }));
                            });
                        }
                        
                        if (response.data.from_location == "1") {
                            $('#e_from_location').append(
                                '<option selected value="1">@lang("lang.branch")</option> <option value="2">@lang("lang.department")</option>'
                            );
                        } else{
                            $('#e_from_location').append(
                                '<option selected value="2">@lang("lang.department")</option> <option value="1">@lang("lang.branch")</option>'
                            );
                        };
                        $('#e_department_review').html('<option value=""> </option>');
                        if (response.data.department_review !="") {
                            $.each(response.departments, function(i, item) {
                                $('#e_department_review').append($('<option>', {
                                    value: item.id,
                                    text: item.name_english,
                                    selected: item.id == response.data.department_review ? true : false
                                }));
                            });
                        }
                        $('#e_id_positions').html('');
                        if (response.data.id_positions !="") {
                            $.each(response.positions, function(i, item) {
                                let id = item.id.toString();
                                let index = response.data.id_positions.indexOf(id);
                                if (index > -1) {
                                    $('#e_id_positions').append($('<option>', {
                                        value: item.id,
                                        text: item.name_english,
                                        selected: true
                                    }));
                                } else {
                                    $('#e_id_positions').append($('<option>', {
                                        value: item.id,
                                        text: item.name_english,
                                        selected: false
                                    }));
                                }
                            });
                        }
                        $('#e_description').text(response.data.description);
                    }
                }
            });
        });
        $(document).on('click','.delete', function(){
        // $('.delete').on('click', function() {
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
                console.log(datas);
                
                let tr = "";

                // Translations (these must match your backend translations or be prefilled in JS)
                let requestType = {
                    "1": "Review",
                    "2": "Review",
                    "3": "Review",
                    "4": "Review",
                    "5": "Review",
                    "6": "Review",
                    "7": "Review",
                    "8": "Review",
                    "9": "Review",
                    "10": "Review"
                };

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
                                positionViews += (index + 1) + ". " + pos.name_english + "<br>";
                            });
                        }

                        // Determine request type label
                        let requestTypeLabel = requestType[item.type] + " " + item.type;

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
                            ? item.position_review[0].name_english + "..."
                            : "";

                        // Department
                        let department = item.department_view ? item.department_view.name_english : "";

                        // Action buttons (adjust based on permission object or server-returned flags)
                        let actionButtons = "";
                        if (permission.is_update == "1") {
                            actionButtons += `<a class="btn btn-success update" data-toggle="modal" data-id="${item.id}" data-target="#edit_fn_lovel"><i class="fa fa-edit"></i></a> `;
                        }
                        if (permission.is_delete == "1") {
                            actionButtons += `<a class="btn btn-danger delete" href="#" data-toggle="modal" data-id="${item.id}" data-target="#delete_level"><i class="fa fa-trash-o m-r-5"></i></a>`;
                        }

                        // Build row
                        tr += `
                            <tr class="odd">
                                <td>${item.from_amount}</td>
                                <td>${item.to_amount}</td>
                                <td>${type[item.request_type]}</td>
                                <td>${referenceTypeLabel}</td>
                                <td>${requestTypeLabel}</td>
                                <td>${fromLocationLabel}</td>
                                <td data-toggle="tooltip" data-html="true" title="${positionViews}">${reviewer}</td>
                                <td>${department}</td>
                                <td>${item.description ? item.description : ""}</td>
                                <td style="text-align: center;">${actionButtons}</td>
                            </tr>
                        `;
                    });
                }

                $(".tbl-level-review tbody").html(tr);
                $('[data-toggle="tooltip"]').tooltip(); // Reinitialize tooltips
                $(".btn-research").prop('disabled', false);
                $(".btn-txt").show();
                $(".loading-icon").css('display', 'none');
            }
        });
    }

</script>
