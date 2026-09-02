@extends('layouts.master')
<style>
     .big-checkbox .custom-control-input {
        transform: scale(1.5); /* make checkbox 1.5x bigger */
        margin-right: 8px;
    }
    .big-checkbox .custom-control-label {
        font-size: 18px; /* adjust label text if you add one */
    }
     /* The container checkbox */
    .container-checkbox {
        /* display: block; */
        position: relative;
        padding-left: 30px;
        margin-right: 30px;
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
                    <h3 class="page-title">@lang('lang.salary_request')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.salary_request')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_salary_request"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                </div>
            </div>
        </div>
        @if (permissionAccess("m8-s1","is_view")->value == "1")
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <a href="javascript:void(0);" class="btn btn-sm btn-secondary mb-3" id="btnApprovedAll" data-userid="{{Auth::user()->id}}">
                        Approved
                    </a>
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-leave" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                                <tr>
                                    <th class="stuck-scroll-4">
                                        <div class="custom-control custom-checkbox custom-control-inline big-checkbox">
                                            <input type="checkbox" class="custom-control-input checkAll" name="checkAll" id="checkAll" onClick="toggle(this)">
                                            <label class="custom-control-label" for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th class="stuck-scroll-4">#</th>
                                    <th class="stuck-scroll-4">@lang('lang.employee_name')</th>
                                    <th class="stuck-scroll-4 sorting">@lang('lang.location')</th>
                                    <th class=" sorting">@lang('lang.department')</th>
                                    <th class="sorting">@lang('lang.position')</th>
                                    <th>@lang('lang.new_basic_salary')</th>
                                    <th>@lang('lang.status')</th>
                                    <th>@lang('lang.type')</th>
                                    <th>@lang('lang.date_request')</th>
                                    <th>@lang('lang.description')</th>
                                    <th style="text-align: center;">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($datas)>0)
                                    @foreach ($datas as $inx=>$item)
                                        <tr>
                                            <td class="stuck-scroll-4">
                                               <div class="custom-control custom-checkbox custom-control-inline big-checkbox">
                                                    <input type="checkbox" class="custom-control-input sub_chk"name="checkbox" data-id="{{$item->id}}" data-type="{{$item->type}}"
                                                    @if($item->status == '2') disabled @endif>
                                                    <label class="custom-control-label"></label>
                                                </div>
                                            </td>
                                            <td class="ids stuck-scroll-4">{{$inx+1}}</td>
                                            <td class="stuck-scroll-4">{{$item->employee->employee_name_en}}</td>
                                            <td class="stuck-scroll-4">{{$item->employee->department->name_english}}</td>
                                            <td>{{$item->employee->branch->branch_name_en}}</td>
                                            <td>{{$item->employee->position->name_english}}</td>
                                            <td>{{$item->new_basic_salary}}</td>
                                            <td> 
                                                @if ($item->status == "" || $item->status == "1")
                                                    <span class="badge bg-inverse-danger" style="font-size: 13px;">@lang('lang.new')</span>
                                                @elseif($item->status == "2")
                                                    <span class="badge bg-inverse-success" style="font-size: 13px;">@lang('lang.approved')</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->type == "1")
                                                    Employee
                                                @elseif($item->type == "0")
                                                    Annual Salary
                                                @endif
                                            </td>
                                            <td>{{$item->request_date}}</td>
                                            <td>{{$item->description}}</td>
                                            <td style="text-align: center;">
                                                @if ($item->status == 1)
                                                    <a class="btn btn-success update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_salary_request"><i class="fa fa-edit"></i></a>
                                                    <a class="btn btn-danger delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_salary"><i class="fa fa-trash-o m-r-5"></i></a> 
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
        <div id="add_salary_request" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.new_salary_request')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('salary-requests/store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label class="container-checkbox mt-4">@lang('lang.replace_to_employee')
                                        <input type="checkbox" value="1" class="checkbox-group request_type" name="type"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add_with_annual_salary_increasement')
                                        <input type="checkbox" value="0" class="checkbox-group request_type" name="type"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group hr-form-group-select2">
                                        <label>@lang('lang.employee') <span class="text-danger">*</span></label>
                                        <select class="form-control requered hr-select2-option employee-review-select employee_id" name="employee_id" required>
                                            <option value=""> </option>
                                            @foreach ($employees as $item)
                                                <option value="{{$item->id}}" data-basic="{{$item->basic_salary}}">{{$item->employee_name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.date_request') <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="request_date" required name="request_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.current_salary')</label>
                                        <input disabled class="form-control" type="number" id="current_salary">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.new_basic_salary')</label>
                                        <input class="form-control" step="any" type="number" id="new_basic_salary" name="new_basic_salary" required>
                                    </div>
                                </div>
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

        <div id="edit_salary_request" class="modal custom-modal fade" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.edit_salary_request')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('salary-requests/update') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label class="container-checkbox mt-4">@lang('lang.replace_to_employee')
                                        <input type="checkbox" value="1" class="checkbox-group e_request_type e_request_type_employee" name="type"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add_with_annual_salary_increasement')
                                        <input type="checkbox" value="0" class="checkbox-group e_request_type e_request_type_increase" name="type"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group hr-form-group-select2">
                                        <label>@lang('lang.employee') <span class="text-danger">*</span></label>
                                        <select class="form-control requered hr-select2-option employee-review-select e_employee_id" name="employee_id" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.date_request') <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker e_request_date" type="text"  required name="request_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.current_salary')</label>
                                        <input disabled class="form-control e_current_salary" type="number" id="e_current_salary">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.new_basic_salary')</label>
                                        <input class="form-control e_new_basic_salary" step="any" type="number" id="e_new_basic_salary" name="new_basic_salary" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.description')</label>
                                <textarea type="text" rows="3" class="form-control e_description" name="description" id="e_description" value="{{old('description')}}"></textarea>
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

        <!-- Delete Modal -->
        <div class="modal custom-modal fade" id="delete_salary" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ url('salary-requests/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit"
                                            class="btn btn-primary continue-btn submit-btn">@lang('lang.delete')</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">@lang('lang.cancel')</a>
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
        $(".request_type").on("click", function () {
            $(".request_type").not(this).prop("checked", false);
        });
        $(".e_request_type").on("click", function () {
            $(".e_request_type").not(this).prop("checked", false);
        });
        $('.checkAll').on('click', function(e) {
            if($(this).is(':checked',true)){
                $(".sub_chk:not(:disabled)").prop("checked", true);
            } else {
                $(".sub_chk:not(:disabled)").prop("checked", false);
            }
        });
        $('body').on('click','#btnApprovedAll',function(){
            var userid = $(this).data("userid");
            var allVals = [];
            var reqeustType = 0;
            var condistionStatus = "";
            $(".sub_chk:checked:not(:disabled)").each(function() {
                allVals.push($(this).attr('data-id'));
                if ($(this).data('type') !="1") {
                    reqeustType ++;
                }
            });
            var request_id = allVals.join(",");
            if(allVals.length <=0)
            {
                $.alert({
                    title: '@lang("lang.approve")!',
                    content: '@lang("lang.please_select_item_befor").',
                    type: 'red',
                });
            }  else {
                if (reqeustType > 0) {
                    $.alert({
                        title: '@lang("lang.you_cannot_approve")',
                        content: '@lang("lang.please_select_the_type_of_replace_employee").',
                        type: 'red',
                    });
                    return;
                }
                var actionBtn = "";
                var titleText = '@lang("lang.replace_to_employee")';
                var formContent = "";
                var columnClassText = 'col-md-4';
                formContent = ''+
                    '<form>'+
                        '<span >Are you sure want to Approved?</span>'+
                    '</form>';
                actionBtn =  {
                    text: 'Approve',
                    btnClass: 'btn-green',
                    action: function() {
                        $('#modal-loading').modal('show');
                        axios.post('{{ URL('salary-requests/approved/all') }}', {
                            'request_id': request_id,
                        }).then(function(response) {
                            $('#modal-loading').modal('hide');
                            new Noty({
                                title: "",
                                text: '@lang("lang.the_process_has_been_successfully")',
                                type: "success",
                                icon: true
                            }).show();
                            window.location.replace("{{ URL('salary-requests') }}");
                        }).catch(function(error) {
                            $('#modal-loading').modal('hide');
                            new Noty({
                                title: "",
                                text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                type: "error",
                                icon: true,
                                timeout: 3000,
                            }).show();
                        });
                    }
                }
                $.confirm({
                    title: titleText,
                    contentClass: 'text-center',
                    columnClass: columnClassText,
                    content: formContent,
                    buttons: {
                        confirm: actionBtn,
                        cancel: {
                            text: '@lang("lang.cancel")',
                            action: function () {
                                // Action for cancel button (if needed)
                            }
                        }
                    },
                    onContentReady: function () {
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click');
                        });
                    }
                });
                $(document).ready(function(){
                    $('.hr-select2-option-emp-role').each(function() {
                        $(this).select2({
                            width: '100%',
                            dropdownParent: $(this).parent(),
                        })
                    });
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/performance-admin/employees') }}",
                        data: {
                            'get_employee_id': userid,
                        },
                        dataType: "JSON",
                        success: function(response) {
                            let datas = response.datas;
                            $('#asign_employee_id').html('<option selected value=""> -- @lang("lang.select") --</option>');
                            if (datas != '') {
                                $.each(datas, function(i, item) {
                                    $('#asign_employee_id').append($('<option>', {
                                        value: item.id,
                                        html: item.employee_name_en + '&nbsp;&nbsp;' + '(' + '&nbsp;'+ item.department.name_english + '&nbsp;)'
                                    }));
                                });
                            }
                        }
                    });
                });
            }
        });
        $('.update').on('click', function() {
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('/salary-requests/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    $("#e_id").val(response.success.id);
                    $('.e_employee_id').html('');
                    $(".e_request_type").prop("checked", false);
                    if (response.success.type == 1) {
                        $(".e_request_type_employee").prop("checked", true);
                    }else{
                        $(".e_request_type_increase").prop("checked", true);
                    }
                    $.each(response.employees, function(i, item) {
                        if (item.id == response.success.employee_id) {
                            $(".e_current_salary").val(item.basic_salary);
                        }
                        $('.e_employee_id').append($('<option>', {
                            value: item.id,
                            text: item.employee_name_en,
                            selected: item.id == response.success.employee_id
                        }));
                    });
                    $(".e_request_date").val(response.success.request_date);
                    $(".e_new_basic_salary").val(response.success.new_basic_salary);
                    $(".e_description").val(response.success.description);
                      
                }
            });
        });
        $('.employee_id').on('change', function() {
            let _this = $(this).find(':selected').data('basic');
            $("#current_salary").val(_this);
        });
        $('.delete').on('click', function() {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });
    });
    function toggle(source) {
        checkboxes = $('.checkAll');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>
