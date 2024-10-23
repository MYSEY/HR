@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.adjustment')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.adjustment')</li>
                    </ul>
                </div>
                @if (permissionAccess("m5-s4","is_create")->value == "1")
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#Add_Adjustment"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    </div>
                @endif
            </div>
        </div>
        {!! Toastr::message() !!}

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('lang.name')</th>
                                            <th>@lang('lang.adjustment_type')</th>
                                            <th>@lang('lang.amount') @lang('lang.motor') (@lang('lang.usd'))</th>
                                            <th>@lang('lang.amount') @lang('lang.tablet') (@lang('lang.usd'))</th>
                                            <th>@lang('lang.amount') (@lang('lang.kh'))</th>
                                            <th>@lang('lang.amount') @lang('lang.engine_oil') (@lang('lang.usd'))</th>
                                            <th>@lang('lang.adjustment_date')</th>
                                            <th>@lang('lang.remark')</th>
                                            <th>@lang('lang.created_at')</th>
                                            <th>@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data)>0)
                                            @foreach ($data as $key=>$item)
                                                <tr>
                                                    <td class="sorting_1 ids">{{$item->id}}</td>
                                                    <td>{{$item->EmployeeName}}</td>
                                                    <td>{{$item->adjustment_type == 'include_taxe' ? 'Include Taxe' : 'Exclude Taxe'}}</td>
                                                    <td>{{$item->amount_usd}} $</td>
                                                    <td>{{$item->amount_table_usd}} $</td>
                                                    <td>{{$item->amount_kh}} ៛</td>
                                                    <td>{{$item->amount_engine_oil}} $</td>
                                                    <td class="position_type">{{ \Carbon\Carbon::parse($item->adjustment_date)->format('d-M-Y') ?? '' }}</td>
                                                    <td class="position_range">{{$item->description}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
                                                    <td class="text-end">
                                                        @if (permissionAccess("m5-s4","is_update")->value == "1" || permissionAccess("m5-s4","is_delete")->value == "1")
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if (permissionAccess("m5-s4","is_update")->value == "1")
                                                                        <a class="dropdown-item btn-get-data-id" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_adjustment"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                    @endif
                                                                    @if (permissionAccess("m5-s4","is_delete")->value == "1")
                                                                        <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_adjustment"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
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
                </div>
            </div>
        </div>

        <div id="Add_Adjustment" class="modal custom-modal fade hr-modal-select2" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_adjustment')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.adjustment_to')<span class="text-danger">*</span></label>
                                <select class="hr-select2-option requered" name="employee_id" id="employee_id" required>
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                    @foreach ($employees as $item)
                                        <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.amount') @lang('lang.motor') @lang('lang.usd')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control adjust_require_amount" name="amount_usd" id="amount_usd" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.amount') @lang('lang.tablet') @lang('lang.usd')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control adjust_require_amount" name="amount_table_usd" id="amount_table_usd" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.amount') @lang('lang.kh')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">៛</span>
                                    <input type="text" class="form-control adjust_require_amount" name="amount_kh" id="amount_kh" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.amount') @lang('lang.engine_oil') @lang('lang.usd')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control adjust_require_amount" name="amount_engine_oil" id="amount_engine_oil" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.adjustment_date')<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker adjust_require" type="text" required id="adjustment_date" name="adjustment_date" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.adjustment_type')<span class="text-danger">*</span></label>
                                <select class="form-control select floating" name="adjustment_type" id="adjustment_type" required>
                                    <option value="exclude_taxe">Exclude Taxe</option>
                                    <option value="include_taxe">Include Taxe</option>
                                </select>
                            </div>
                            {{-- <div class="form-group include_tax_rate" style="display: none">
                                <label class="">@lang('lang.tax_rate') (%)<span class="text-danger">*</span></label>
                                <input class="form-control @error('tax_rate') is-invalid @enderror" type="number" id="tax_rate" required name="tax_rate" value="{{old('tax_rate')}}">
                            </div> --}}
                            <div class="form-group">
                                <label>@lang('lang.remark')</label>
                                <textarea class="form-control" type="text" name="description" id="description"></textarea>
                            </div>
                            <div class="submit-section">
                                <button type="button" class="btn btn-primary submit-btn" id="save_adjustment">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>@lang('lang.loading')</span>
                                    <span class="btn-txt">@lang('lang.submit')</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- edit_adjustment --}}
        <div id="edit_adjustment" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.edit_adjustment')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>@lang('lang.adjustment_to')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option" name="employee_id" id="e_employee_id" required>
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.amount') @lang('lang.usd')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control e_adjust_require_amount" name="amount_usd" id="e_amount_usd" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.amount') @lang('lang.tablet') @lang('lang.usd')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control e_adjust_require_amount" name="amount_table_usd" id="e_amount_table_usd" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.amount') @lang('lang.kh')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control e_adjust_require_amount" name="amount_kh" id="e_amount_kh" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.amount') @lang('lang.engine_oil') @lang('lang.usd')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control e_adjust_require_amount" name="amount_engine_oil" id="e_amount_engine_oil" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.adjustment_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker e_adjust_require" type="text" required id="e_adjustment_date" name="adjustment_date" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.adjustment_type')<span class="text-danger">*</span></label>
                                <select class="form-control select floating" name="adjustment_type" id="e_adjustment_type" required>
                                </select>
                            </div>
                            {{-- <div class="form-group e_include_tax_rate" style="display: none">
                                <label class="">@lang('lang.tax_rate') (%)<span class="text-danger">*</span></label>
                                <input class="form-control" type="number" id="e_tax_rate" required name="tax_rate" value="{{old('tax_rate')}}">
                            </div> --}}
                            <div class="form-group">
                                <label>@lang('lang.remark')</label>
                                <textarea class="form-control" type="text" name="description" id="e_description"></textarea>
                            </div>
                            <div class="submit-section">
                                <input type="hidden" name="id" id="e_id">
                                <button type="button" class="btn btn-primary btn-update">
                                    <span class="e_loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>@lang('lang.loading')</span>
                                    <span class="e_btn-text">@lang('lang.submit')</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete -->
    <div class="modal custom-modal fade" id="delete_adjustment" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>@lang('lang.delete')</h3>
                        <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('motor-rentel/adjustment/delete')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="d_id" class="d_id" value="">
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
    <!-- /Delete -->
@endsection

@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function(){
        $('#save_adjustment').on('click',function(){
            $("#save_adjustment").attr('disabled',true);
            $(".loading-icon").css('display', 'block');
            $(".btn-txt").css("display", 'none');
            var num_miss = 0;
            $(".hr-form-group-select2").each(function(){
                let formGroup = $(this);
                let value = formGroup.attr("data-select2-id");
                let requeredField = formGroup.find(".hr-select2-option").val();
                if(!value){ 
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }else if (!requeredField) {
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }else{
                    formGroup.find(".select2-selection--single").css("border-color","#198754");
                }
            });

            let length = 0; 
            $(".adjust_require_amount").each(function(){
                if($(this).val()==""){ 
                    length++;
                }
            });

            if($(".adjust_require_amount").length == length){
                $(".adjust_require_amount").css("border-color","#dc3545")
            }else{
                $(".adjust_require_amount").css("border-color","#198754")
            }

            $(".adjust_require").each(function(){
                if($(this).val()==""){ 
                    num_miss++;
                    $(this).css("border-color","#dc3545")
                }else{
                    $(this).css("border-color","#198754")
                }
            });

            if (num_miss>0 || $(".adjust_require_amount").length == length) {
                setTimeout(function () {
                    $("#save_adjustment").attr('disabled',false);
                    $(".loading-icon").css('display', 'none');
                    $(".btn-txt").css("display", 'block');
                }, 500);
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: "{{url('motor-rentel/adjustment/store')}}",
                    data: {
                        "_token":           "{{ csrf_token() }}",
                        employee_id:        $("#employee_id").val(),
                        amount_usd:         ($("#amount_usd").val() ? $("#amount_usd").val() : 0),
                        amount_table_usd:   ($("#amount_table_usd").val() ? $("#amount_table_usd").val() : 0),
                        amount_kh:          ($("#amount_kh").val() ? $("#amount_kh").val() : 0),
                        amount_engine_oil:  ($("#amount_engine_oil").val() ? $("#amount_engine_oil").val() : 0),
                        adjustment_date:    $("#adjustment_date").val(),
                        adjustment_type:    $("#adjustment_type").val(),
                        description:        $("#description").val()
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.status === 200) {
                            new Noty({
                                title: "",
                                text: "@lang('lang.the_process_has_been_successfully').",
                                type: "success",
                                timeout: 3000,
                                icon: true
                            }).show();
                            window.location.replace("{{ URL('motor-rentel/adjustment') }}");
                        }
                    }
                });
            }
        });
        $('.btn-get-data-id').on('click',function(){
            $("#e_adjustment_type").html("");
            var localeLanguage = '{{ config('app.locale') }}';
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('motor-rentel/adjustment/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        if (response.employee != '') {
                            $.each(response.employee, function(i, item) {
                                $('#e_employee_id').append($('<option>', {
                                    value: item.id,
                                    text: localeLanguage == 'en' ? item.employee_name_en : item.employee_name_kh,
                                    selected: item.id == response.success.employee_id
                                }));
                            });
                        }
                        
                        if (response.success.adjustment_type == 'include_taxe') {
                            $(".e_include_tax_rate").css('display', 'block');
                            $("#e_adjustment_type").append('<option selected value="include_taxe">Include Taxe</option> <option value="exclude_taxe">Exclude Taxe</option>');
                        } else {
                            $(".e_include_tax_rate").css('display', 'none');
                            $("#e_adjustment_type").append('<option selected value="exclude_taxe">Exclude Taxe</option> <option value="include_taxe">Include Taxe</option>');   
                        }
                        
                        $('#e_id').val(response.success.id);
                        $('#e_amount_usd').val(response.success.amount_usd);
                        $('#e_amount_table_usd').val(response.success.amount_table_usd);
                        $('#e_amount_kh').val(response.success.amount_kh);
                        $('#e_amount_engine_oil').val(response.success.amount_engine_oil);
                        $('#e_tax_rate').val(response.success.tax_rate);
                        $('#e_adjustment_date').val(response.success.adjustment_date);
                        $('#e_description').val(response.success.description);
                    }
                }
            });
        });
       
        $('.btn-update').on('click',function(){
            $(".btn-update").attr('disabled',true);
            $(".e_loading-icon").css('display', 'block');
            $(".e_btn-text").css("display", 'none');
            let e_num_miss = 0;
            let length = 0; 
            $(".e_adjust_require_amount").each(function(){
                if($(this).val()==""){ 
                    length++;
                }
            });

            if($(".e_adjust_require_amount").length == length){
                $(".e_adjust_require_amount").css("border-color","#dc3545")
            }else{
                $(".e_adjust_require_amount").css("border-color","#198754")
            }
            $(".e_adjust_require").each(function(){
                if($(this).val()==""){ 
                    e_num_miss++;
                    $(this).css("border-color","#dc3545")
                }else{
                    $(this).css("border-color","#198754")
                }
            });

            if (e_num_miss>0 || $(".e_adjust_require_amount").length == length) {
                setTimeout(function () {
                    $(".btn-update").attr('disabled',false);
                    $(".e_loading-icon").css('display', 'none');
                    $(".e_btn-text").css("display", 'block');
                }, 500);
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: "{{url('motor-rentel/adjustment/update')}}",
                    data: {
                        "_token":           "{{ csrf_token() }}",
                        id:                 $("#e_id").val(),
                        employee_id:        $("#e_employee_id").val(),
                        amount_usd:         $("#e_amount_usd").val(),
                        amount_table_usd:   $("#e_amount_table_usd").val(),
                        amount_kh:          $("#e_amount_kh").val(),
                        amount_engine_oil:  $("#e_amount_engine_oil").val(),
                        adjustment_date:    $("#e_adjustment_date").val(),
                        adjustment_type:    $("#e_adjustment_type").val(),
                        tax_rate:           $("#e_tax_rate").val(),
                        description:        $("#e_description").val()
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.status === 200) {
                            if (response.status) {
                                new Noty({
                                    title: "",
                                    text: "@lang('lang.update_successfully').",
                                    type: "success",
                                    timeout: 3000,
                                    icon: true
                                }).show();
                                window.location.replace("{{ URL('motor-rentel/adjustment') }}");
                            }
                        }
                    }
                });
            }
        });
        $('.delete').on('click',function(){
            let id = $(this).data("id");
            $('.d_id').val(id);
        });
    });
</script>
