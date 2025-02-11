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
                @if (permissionAccess("m9-s2","is_create")->value == "1")
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#Add_Adjustment"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" id="btnUpload"><i class="fa fa-plus"></i>@lang('lang.import')</a>
                    </div>
                @endif
            </div>
        </div>
        {!! Toastr::message() !!}

        <div class="row filter-btn"> 
            <div class="col-md-3">
                <div class="form-group ">
                    <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input class="form-control" type="month" id="filter_month" name="filter_month">
                </div>
            </div>
            <div class="col-md-6">
                <div style="display: flex" class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" id="icon-search-download-reload">
                        <span class="btn-txt"><i class="fa fa-search"></i></span>
                        <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped" id="tbl_adjustment">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('lang.name')</th>
                                            <th>@lang('lang.amount')</th>
                                            <th>@lang('lang.adjustment_type')</th>
                                            <th>@lang('lang.adjustment_date')</th>
                                            <th>@lang('lang.remark')</th>
                                            <th>@lang('lang.created_at')</th>
                                            <th>@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @if (count($data)>0)
                                            @foreach ($data as $key=>$item)
                                                <tr>
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
                                        @endif --}}
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
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.adjustment_to')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option requered @error('employee_id') is-invalid @enderror" name="employee_id" id="employee_id" required>
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
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('payroll/adjustment/update') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.adjustment_to')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option requered @error('employee_id') is-invalid @enderror" name="employee_id" id="e_employee_id" required>
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

        <div id="loading-overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; text-align: center;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>Loading Data...</p>
            </div>
        </div>
    </div>
    @include('payroll_item.import')
@endsection

@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
@section('script')
    <script>
        var employee_name = null;
        var filter_month = null;
        var canUpdate = @json(permissionAccess("m9-s2", "is_update")->value == "1");
        var canDelete = @json(permissionAccess("m9-s2", "is_delete")->value == "1");
        $(function(){
            $('.btn-search').on('click', function() {
                employee_name = $('#employee_name').val();
                filter_month = $('#filter_month').val();
                // Reload DataTable with the filter values
                $('#tbl_adjustment').DataTable().ajax.reload(null, false); 
            });
            
            dataTables();
            $("#btnUpload").on("click", function() {
                $(".thanLess").hide();
                $("#thanLess").text("");
                $('#adjuestmentModal').modal('show');
            });
            $(document).on("click", ".edit-btn", function() {
                let id = $(this).data("id");
                // Open modal
                $("#edit_payroll_adjustment").modal("show");
                $.ajax({
                    url: `{{ url('payroll/adjustment') }}/${id}/edit`,
                    type: "GET",
                    success: function(response) {
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
                });
            });
        });

        const deleteData = (id)=>{
            Swal.fire({
                title: "@lang('lang.are_you_sure')",
                text: "@lang('lang.are_you_sure_want_to_delete')",
                type: "warning",
                showCancelButton: `@lang('lang.cancel')`,
                confirmButtonText: `@lang('lang.deleted')`,
            }).then(function(result)
            {
                if (result.value)
                {
                    $.ajax({
                        type: "POST",
                        url: `{{url('payroll/adjustment/${id}')}}`,
                        data: { _method: "DELETE", _token: "{{ csrf_token() }}" },
                        success: function (data) {
                            if (data.mg == "success") {
                                Swal.fire("Deleted!", "Your file has been deleted.","success");
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        }

        function dataTables() {
            $('#loading-overlay').show();
            // Check if DataTable instance exists, then destroy it
            if ($.fn.DataTable.isDataTable('#tbl_adjustment')) {
                $('#tbl_adjustment').DataTable().clear().destroy();
            }
            
            $('#tbl_adjustment').DataTable({
                pageLength: 10,
                processing: true,
                serverSide: true,
                order: [[0, 'desc']],
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                ajax: {
                    url: '{{ URL("payroll/adjustment") }}',
                    type: 'GET',
                    data: function(d) {
                        d.employee_name = $('input[name="employee_name"]').val();
                        d.filter_month = $('input[name="filter_month"]').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'employee_name_en', name: 'employee_name_en' },
                    { data: 'amount', name: 'amount' },
                    { 
                        data: 'adjustment_type', 
                        name: 'adjustment_type',
                        render: function(data, type, row) {
                        return data === 'include_taxe' ? "Include Tax" : "Exclude Tax";
                    }
                    },
                    { data: 'adjustment_date', name: 'adjustment_date' },
                    { data: 'description', name: 'description' },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            return moment(data).format('YYYY-MM-DD HH:mm:ss'); // Customize the format as needed
                        }
                    },
                    {
                        data: '',
                        name: 'action',
                        render: function(data, type, row) {
                            let buttons = '';
                            if (row.id) {
                                if (canUpdate) {
                                    buttons += `<a href="#" data-id="${row.id}" class="btn btn-sm btn-outline-success btn-inline-block mr-2 edit-btn" title="Edit"><i class="fa fa-pencil m-r-5"></i></a>`;
                                }
                                if (canDelete) {
                                    buttons += `<a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-inline-block mr-2" data-toggle="modal" onclick="deleteData(${row.id})" title="Delete Record"><i class="fa fa-trash-o m-r-5"></i></a>`;
                                }
                            }
                            return buttons || '';
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [[0, 'desc']],
                initComplete: function() {
                    $('#loading-overlay').hide(); // Hide spinner when data is fully loaded
                }
            });
            $('#tbl_adjustment').on('processing.dt', function (e, settings, processing) {
                if (processing) {
                    $('#loading-overlay').show();
                } else {
                    $('#loading-overlay').hide();
                }
            });
        }
    </script>
@endsection

