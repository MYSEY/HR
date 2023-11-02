@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.fringe_benefits')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.fringe_benefits')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" id="import_new_cvs"><i class="fa fa-plus"></i>@lang('lang.import')</a>
                    <a href="#" class="btn add-btn me-2" data-bs-toggle="modal" data-bs-target="#add_fring_benefit"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
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
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px;" class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending">@lang('lang.employee_id')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">@lang('lang.name') (@lang('lang.kh'))</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">@lang('lang.name') (@lang('lang.en'))</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending">@lang('lang.gender')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join date: activate to sort column ascending">@lang('lang.join_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Amount usd: activate to sort column ascending">@lang('lang.amount') (@lang('lang.usd'))</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Amount riel: activate to sort column ascending">@lang('lang.amount') (@lang('lang.riel'))</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Request date: activate to sort column ascending">@lang('lang.request_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payment date: activate to sort column ascending">@lang('lang.paid_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Remark: activate to sort column ascending">@lang('lang.remark')</th>
                                            <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data)>0)
                                            @foreach ($data as $key=>$item)
                                                <tr class="odd">
                                                    <td class="ids">{{++$key ?? ""}}</td>
                                                    <td >{{$item->employee->number_employee}}</td>
                                                    <td >{{$item->employee->employee_name_kh}}</td>
                                                    <td >{{$item->employee->employee_name_en}}</td>
                                                    <td >{{$item->employee->employeeGender ? $item->employee->employeeGender : ""}}</td>
                                                    <td >{{$item->employee->position ? $item->employee->position->name_english : ""}}</td>
                                                    <td >{{\Carbon\Carbon::parse($item->employee->date_of_commencement)->format('d-M-Y') ?? ''}}</td>
                                                    <td >$ {{number_format($item->amount_usd,2)}}</td>
                                                    <td >៛ {{number_format($item->amount_riel)}}</td>
                                                    <td >{{\Carbon\Carbon::parse($item->request_date)->format('d-M-Y') ?? ''}}</td>
                                                    <td>{{\Carbon\Carbon::parse($item->paid_date)->format('d-M-Y') ?? '' }}</td>
                                                    <td>{{ $item->remark ? $item->remark : ""}}</td>
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item update"  data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_fringe_benefit"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                            </div>
                                                        </div>
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

        <div id="add_fring_benefit" class="modal custom-modal fade hr-modal-select2" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_fringe_benefit')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('/fringe-benefit/store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group hr-form-group-select2">
                                        <label class="">@lang('lang.employee') <span class="text-danger">*</span></label>
                                        <select class="form-control hr-select2-option requered" id="employee_id" name="employee_id" required>
                                            <option selected disabled value="">@lang('lang.select')</option>
                                            @foreach ($employees as $item)
                                                <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">@lang('lang.amount') (@lang('lang.usd'))</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input class="form-control" min="0" max="10" step="0.00" value="0.00" id="amount_usd" name="amount_usd" value="{{old('amount_usd')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">@lang('lang.amount') (@lang('lang.riel'))</label>
                                        <div class="input-group">
                                            <span class="input-group-text">៛</span>
                                            <input class="form-control" type="number" id="amount_riel" name="amount_riel" value="{{old('amount_riel')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.request_date') <span class="text-danger">*</span></label>
                                        <input class="form-control datetimepicker" id="request_date" required name="request_date">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.paid_date') <span class="text-danger">*</span></label>
                                        <input class="form-control datetimepicker" id="paid_date" required name="paid_date">
                                    </div>
                                </div>
        
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="">@lang('lang.remark')</label>
                                        <textarea type="text" rows="3" class="form-control" name="remark" id="remark" value="{{ old('remark') }}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
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
        <div id="edit_fringe_benefit" class="modal custom-modal fade modal-lg hr-modal-select2" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.edit_fringe_benefit')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('fringe-benefit/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">@lang('lang.employee') <span class="text-danger">*</span></label>
                                        <select class="form-control hr-select2-option" id="e_employee_id" name="employee_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6"> </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">@lang('lang.amount') (@lang('lang.usd'))</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input class="form-control" type="number" id="e_amount_usd" name="amount_usd" value="{{old('amount_usd')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">@lang('lang.amount') (@lang('lang.riel'))</label>
                                        <div class="input-group">
                                            <span class="input-group-text">៛</span>
                                            <input class="form-control" type="number" id="e_amount_riel" name="amount_riel" value="{{old('amount_riel')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.request_date') <span class="text-danger">*</span></label>
                                        <input class="form-control datetimepicker" id="e_request_date" required name="request_date">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.paid_date') <span class="text-danger">*</span></label>
                                        <input class="form-control datetimepicker" id="e_paid_date" required name="paid_date">
                                    </div>
                                </div>
        
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="">@lang('lang.remark')</label>
                                        <textarea type="text" rows="3" class="form-control" name="remark" id="e_remark" value="{{ old('remark') }}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <input type="hidden" name="id" id="e_id">
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

        <!-- Delete Fring Benefits Modal -->
        <div class="modal custom-modal fade" id="delete_fringe_benefit" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('/fringe-benefit/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">Delete</button>
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Fring Benefits Modal -->
        @include('fringe_benefits.import')
    </div>
@endsection

@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function(){
        $("#import_new_cvs").on("click", function() {
            $(".thanLess").hide();
            $("#thanLess").text("");
            $('#import_fringe_benefits_cv').modal('show');
        });
        $('.delete').on('click',function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
        $('.update').on('click',function(){
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('/fringe-benefit/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        $('#e_employee_id').html('<option selected disabled> -- @lang("lang.select") --</option>');
                        $.each(response.employees, function(i, item) {
                            $('#e_employee_id').append($('<option>', {
                                value: item.id,
                                text: item.employee_name_en,
                                selected: item.id == response.success.employee_id
                            }));
                        });
                        $('#e_id').val(response.success.id);
                        $('#e_amount_usd').val(response.success.amount_usd);
                        $('#e_amount_riel').val(Number(response.success.amount_riel).toFixed(0));
                        $('#e_request_date').val(response.success.request_date);
                        $('#e_paid_date').val(response.success.paid_date);
                        $('#e_remark').val(response.success.remark);
                        $('#edit_fringe_benefit').modal('show');
                    }
                }
            });
        });
    });
</script>
