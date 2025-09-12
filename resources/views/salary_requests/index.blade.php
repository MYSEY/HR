@extends('layouts.master')
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
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-leave" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('lang.employee_name')</th>
                                    <th class="sorting">@lang('lang.location')</th>
                                    <th class="sorting">@lang('lang.department')</th>
                                    <th class="sorting">@lang('lang.position')</th>
                                    <th>@lang('lang.new_basic_salary')</th>
                                    <th>@lang('lang.date_request')</th>
                                    <th>@lang('lang.description')</th>
                                    <th style="text-align: center;">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($datas)>0)
                                    @foreach ($datas as $item)
                                        <tr>
                                            <td class="ids">{{$item->id}}</td>
                                            <td>{{$item->employee->employee_name_en}}</td>
                                            <td>{{$item->employee->department->name_english}}</td>
                                            <td>{{$item->employee->branch->branch_name_en}}</td>
                                            <td>{{$item->employee->position->name_english}}</td>
                                            <td>{{$item->new_basic_salary}}</td>
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
                    console.log(response.success);
                    
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
                    // $(".e_current_salary").val(response.success);
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
</script>
