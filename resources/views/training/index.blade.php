@extends('layouts.master')
<style>
    .custom-table td {
        padding: 10px 10px !important;
    }
</style>
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Training</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Training</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" id="btn_add_training" ><i
                            class="fa fa-plus"></i> Add New</a>
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
                                            <th style="width: 30px;" class="sorting" tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                aria-label="#: activate to sort column ascending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Training Type: activate to sort column ascending"
                                                style="width: 110.95px;">Training Type</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Trainer: activate to sort column ascending"
                                                style="width: 141.175px;">Total trainer</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Employee: activate to sort column ascending"
                                                style="width: 89.45px;">Total Employee</th>
                                            <th class="sorting sorting_asc" tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                aria-label="Time Duration: activate to sort column descending"
                                                style="width: 170.062px;" aria-sort="ascending">Time Duration</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Description : activate to sort column ascending"
                                                style="width: 129.65px;">Remark </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Cost : activate to sort column ascending"
                                                style="width: 34.575px;">Cost Price </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Status : activate to sort column ascending"
                                                style="width: 97.15px;">Status </th>
                                            <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Action: activate to sort column ascending"
                                                style="width: 48.1875px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataTrainings) > 0)
                                            @foreach ($dataTrainings as $item)
                                                <tr class="odd">
                                                    <td class="sorting_1 ids">{{ $item->id }}</td>
                                                    <td class="training_type_name">{{ $item->training_type == 1 ? "Internal" : "External" }}</td>
                                                    <td>
                                                        <ul class="team-members">
                                                            <li class="dropdown avatar-dropdown">
                                                                <a href="#" class="all-users dropdown-toggle"
                                                                    data-bs-toggle="dropdown"
                                                                    aria-expanded="false">{{count($item->trainer_id)}}</a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <ul class="team-members">
                                                            <li class="dropdown avatar-dropdown">
                                                                <a href="#" class="all-users dropdown-toggle"
                                                                    data-bs-toggle="dropdown"
                                                                    aria-expanded="false">{{ count($item->employee_id) }}</a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td class="sorting_1">
                                                        {{ \Carbon\Carbon::parse($item->start_date)->format('d-M-Y') ?? '' }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($item->end_date)->format('d-M-Y') ?? '' }}
                                                    </td>
                                                    <td>{{ $item->remark }}</td>
                                                    <td>${{ $item->cost_price ? $item->cost_price : 0 }}</td>
                                                    <td>
                                                        <input type="hidden" class="status" value="{{ $item->status }}">
                                                        <div class="dropdown action-label">
                                                            @if ($item->status == '1')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                                                    href="#" data-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                                    <span>Active</span>
                                                                </a>
                                                            @elseif ($item->status == '0')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                                                    href="#" data-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i>
                                                                    <span>Inactive</span>
                                                                </a>
                                                            @endif
                                                            <div class="dropdown-menu dropdown-menu-right"
                                                                id="btn-status">
                                                                <a class="dropdown-item" data-id="{{ $item->id }}"
                                                                    data-name="1" data-status-old="{{ $item->status }}"
                                                                    href="#">
                                                                    <i class="fa fa-dot-circle-o text-success"></i> Active
                                                                </a>
                                                                <a class="dropdown-item" data-id="{{ $item->id }}"
                                                                    data-name="0" data-status-old="{{ $item->status }}"
                                                                    href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Inactive
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                    class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item detail"
                                                                    href="{{ url('/training/detail', $item->id) }}"><i
                                                                        class="fa fa-eye m-r-5"></i> View Details</a>
                                                                <a class="dropdown-item update" data-toggle="modal"
                                                                    data-id="{{ $item->id }}"
                                                                    data-target="#edit_training"><i
                                                                        class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item delete" href="#"
                                                                    data-toggle="modal" data-id="{{ $item->id }}"
                                                                    data-target="#delete_training"><i
                                                                        class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" style="text-align: center">No record to display</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('training.modal_form_create')
        @include('training.modal_form_edit')

        <!-- Delete Training Modal -->
        <div class="modal custom-modal fade" id="delete_training" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ url('training/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit"
                                            class="btn btn-primary continue-btn submit-btn">Delete</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal"
                                            class="btn btn-primary cancel-btn">Cancel</a>
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
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function() {
        $("#btn_add_training").on("click", function() {
            $('#training_type').html('');
            $('#trainer').html('');
            $("#e_training_type").val("");
            $('#training_type').val('');
            $('#training_type').append(
                '<option selected disabled value="">Choose...</option>'+
                '<option value="1">Internal</option>'+
                '<option value="2">External</option>'
            );
            $("#add_training").modal("show")
        });

        $("#training_type, #e_training_type").on("change", function() {
            $('#trainer').html('');
            $('#e_trainer').html('');
            var value_id = 0;
            if ($("#training_type").val()) {
                value_id = $("#training_type").val();
            }
            if ($("#e_training_type").val()) {
                value_id = $("#e_training_type").val();
            }
            $.ajax({
                type: "GET",
                url: "{{ url('training/trainer') }}",
                dataType: "JSON",
                success: function(response) {
                    if (response.data) {
                        response.data.map((train) =>{
                            let option = {};
                            if (value_id == 1 && train.type == 1) {
                                option ={
                                    value: train.id,
                                    text: train.employee.employee_name_en,
                                    selected: false
                                }
                                $('#trainer').append($('<option>',option)); 
                                $('#e_trainer').append($('<option>',option));
                            }
                            if(value_id == 2 && train.type == 2){
                                option ={
                                    value: train.id,
                                    text: train.name_en,
                                    selected: false
                                }
                                $('#trainer').append($('<option>',option)); 
                                $('#e_trainer').append($('<option>',option));
                            }
                        });
                    }
                }
            });
        });
        $('.update').on('click', function() {
            $('#trainer').html('');
            $('#e_trainer').html('');
            $('#e_status').html('<option value=""></option>');
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
            let status = _this.find('.status').val();
            if (status == "1") {
                $('#e_status').append(
                    '<option selected value="1">Active</option> <option value="0">Inactive</option>'
                    );
            } else if (status == "0") {
                $('#e_status').append(
                    '<option selected value="0">Inactive</option> <option value="1">Active</option>'
                    );
            }
            let id = $(this).data("id");
            $("#e_id").val(id)
            $.ajax({
                type: "GET",
                url: "{{ url('training/edit') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        $('#e_training_type').html('');
                        if (response.success.training_type == "1") {
                            $('#e_training_type').append(
                                '<option selected value="1">Internal</option> <option value="2">External</option>'
                            );
                        }
                        if (response.success.training_type == "2") {
                            $('#e_training_type').append(
                                '<option selected value="2">External</option> <option value="1">Internal</option>'
                            );
                        }
                        if (response.trainer != '') {
                            $('#e_trainer').html('');
                            $.each(response.trainer, function(i, item) {
                                let id = item.id.toString();
                                let index = response.success.trainer_id.indexOf(id);
                                if (item.type == 1 && response.success.training_type == 1) {
                                    if (index > -1) {
                                        $('#e_trainer').append($('<option>', {
                                            value: item.id,
                                            text: item.employee ? item.employee.employee_name_en: item.name_en,
                                            selected: true
                                        }));
                                    } else {
                                        $('#e_trainer').append($('<option>', {
                                            value: item.id,
                                            text: item.employee ? item.employee.employee_name_en: item.name_en,
                                            selected: false
                                        }));
                                    }
                                }
                                if (item.type == 2 && response.success.training_type == 2) {
                                    if (index > -1) {
                                        $('#e_trainer').append($('<option>', {
                                            value: item.id,
                                            text: item.name_en,
                                            selected: true
                                        }));
                                    } else {
                                        $('#e_trainer').append($('<option>', {
                                            value: item.id,
                                            text: item.name_en,
                                            selected: false
                                        }));
                                    }
                                }
                            });
                        }
                        if (response.trainingType != '') {
                            $('#e_employee').html('');
                            $.each(response.employee, function(i, item) {
                                let id = item.id.toString();
                                let index = response.success.employee_id.indexOf(id);
                                if (index > -1) {
                                    $('#e_employee').append($('<option>', {
                                        value: item.id,
                                        text: item.employee_name_en,
                                        selected: true
                                    }));
                                } else {
                                    $('#e_employee').append($('<option>', {
                                        value: item.id,
                                        text: item.employee_name_en,
                                        selected: false
                                    }));
                                }
                            });
                        }
                        $('#e_cost_price').val(response.success.cost_price);
                        $('#e_start_date').val(response.success.start_date);
                        $('#e_end_date').val(response.success.end_date);
                        $('#e_description').val(response.success.description);
                    }
                }
            });

        });

        $('body').on('click', '#btn-status a', function() {
            let id = $(this).attr('data-id');
            let status = $(this).attr('data-name');
            let old_status = $(this).attr('data-status-old');
            let text_status = "";
            let text_old_status = "";
            if (old_status == "0") {
                text_old_status = "Inactive"
            } else if (old_status == "1") {
                text_old_status = "Active"
            }
            if (status == "0") {
                text_status = "Inactive"
            } else if (status == "1") {
                text_status = "Active"
            }
            $.confirm({
                title: 'Change Status!',
                contentClass: 'text-center',
                backgroundDismiss: 'cancel',
                content: '' +
                    '<label>Are you sure want change status ' + '<label style="color:red">' +
                    text_old_status + '</label>' + ' to ' + '<label style="color:red">' +
                    text_status + '</label>' + '?</label>' +
                    '<input type="hidden" class="form-control training_status" id="" name="" value="' +
                    status + '">' +
                    '<input type="hidden" class="form-control id" id="" name="" value="' + id +
                    '">',
                buttons: {
                    confirm: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            var training_status = this.$content.find('.training_status')
                                .val();
                            var id = this.$content.find('.id').val();

                            axios.post('{{ URL('training/status') }}', {
                                'training_status': training_status,
                                'id': id,
                            }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: "The process has been successfully.",
                                    type: "success",
                                    icon: true
                                }).show();
                                $('.card-footer').remove();
                                window.location.replace(
                                    "{{ URL('training/list') }}");
                            }).catch(function(error) {
                                new Noty({
                                    title: "",
                                    text: "Something went wrong please try again later.",
                                    type: "error",
                                    icon: true
                                }).show();
                            });
                        }
                    },
                    cancel: {
                        text: 'Cancel',
                        btnClass: 'btn-red btn-sm',
                    },
                }
            });
        });

        $('.delete').on('click', function() {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });
    });
</script>
