@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.payroll_adjustment')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.payroll_adjustment')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#Add_Adjustment"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px;" class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.name')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.amount')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.adjustment_type')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.adjustment_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.remark')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.created_at')</th>
                                            <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 300.962px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data)>0)
                                            @foreach ($data as $key=>$item)
                                                <tr class="odd">
                                                    <td class="sorting_1 ids">{{$item->id}}</td>
                                                    <td class="name_khmer">{{$item->EmployeeName}}</td>
                                                    <td class="name_english">{{$item->amount}}</td>
                                                    <td class="name_english">{{$item->adjustment_type == 'include_taxe' ? 'Include Taxe' : 'Exclued Taxe'}}</td>
                                                    <td class="position_type">{{ \Carbon\Carbon::parse($item->adjustment_date)->format('d-M-Y') ?? '' }}</td>
                                                    <td class="position_range">{{$item->description}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
                                                    <td class="text-end">
                                                        @if (permissionAccess("m9-s2","is_update")->value == "1" || permissionAccess("m9-s2","is_delete")->value == "1")
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if (permissionAccess("m9-s2","is_update")->value == "1")
                                                                        <a class="dropdown-item update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_payroll_adjustment"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                    @endif
                                                                    @if (permissionAccess("m9-s2","is_delete")->value == "1")
                                                                        <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_payroll_adjustment"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
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

        <div id="Add_Adjustment" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_adjustment')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('payroll/adjustment/store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>@lang('lang.adjustment_to')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option" name="employee_id" id="employee_id" required>
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                    @foreach ($employee as $item)
                                        <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.amount')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" name="amount" id="amount" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.adjustment_date')<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" required id="adjustment_date" name="adjustment_date" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.adjustment_type')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option @error('adjustment_type') is-invalid @enderror" name="adjustment_type" id="adjustment_type" required>
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                    <option value="include_taxe">Include Taxe</option>
                                    <option value="exclued_taxe">Exclued Taxe</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.remark')</label>
                                <textarea class="form-control" type="text" name="description" id="description"></textarea>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>@lang('lang.loading')</span>
                                    <span class="btn-txt">@lang('lang.submit')</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- edit_payroll_adjustment --}}
        <div id="edit_payroll_adjustment" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.edit_adjustment')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('payroll/adjustment/update') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>@lang('lang.adjustment_to')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option" name="employee_id" id="e_employee_id" required>
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                    @foreach ($employee as $item)
                                        <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.amount')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" name="amount" id="e_amount" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.adjustment_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" required id="e_adjustment_date" name="adjustment_date" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.adjustment_type')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option @error('adjustment_type') is-invalid @enderror" name="adjustment_type" id="e_adjustment_type" required>
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                    {{-- <option value="include_taxe">Include Taxe</option>
                                    <option value="exclued_taxe">Exclued Taxe</option> --}}
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.remark')</label>
                                <textarea class="form-control" type="text" name="description" id="e_description"></textarea>
                            </div>
                            <div class="submit-section">
                                <input type="hidden" name="id" id="e_id">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>@lang('lang.loading')</span>
                                    <span class="btn-txt">@lang('lang.submit')</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete -->
    <div class="modal custom-modal fade" id="delete_payroll_adjustment" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>@lang('lang.delete')</h3>
                        <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('payroll/adjustment/delete')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="e_id" class="e_id" value="">
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
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(function(){
        $('.update').on('click',function(){
            var localeLanguage = '{{ config('app.locale') }}';
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('payroll/adjustment/edit')}}",
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
                            $("#e_adjustment_type").append('<option selected value="include_taxe">Include Taxe</option> <option value="exclued_taxe">Exclued Taxe</option>');
                        } else {
                            $("#e_adjustment_type").append('<option selected value="exclued_taxe">Exclued Taxe</option> <option value="include_taxe">Include Taxe</option>');   
                        }
                        
                        $('#e_id').val(response.success.id);
                        $('#e_amount').val(response.success.amount);
                        $('#e_adjustment_date').val(response.success.adjustment_date);
                        $('#e_description').val(response.success.description);
                    }
                }
            });
        });
        $('.delete').on('click',function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
    });
</script>
