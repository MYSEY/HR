@extends('layouts.master')
<style>
    .custom-table td {
        padding: 10px 10px !important;
    }
    .hidden {
        /* visibility:hidden; */
        display: none !important
    }
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }
    .reset-btn{
        /* background: #ffbc34 !important; */
        color: #fff !important
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Trainings</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Trainings</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" id="btn_add_training" ><i
                            class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        @if (Auth::user()->RolePermission == 'Admin')
            <form class="needs-validation" novalidate>
                @csrf
                
                <div class="row filter-btn">
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <input class="form-control floating" type="text" id="course_name" name="course_name" placeholder="Course Name">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <select class="select form-control" data-select2-id="select2-data-2-c0n2" id="filter_training_type">
                                <option value="" data-select2-id="select2-data-2-c0n2">All Training Type</option>
                                <option value="1">Internal</option>
                                <option value="2">External</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" id="start_date" name="start_date"
                                    placeholder="Start Date">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" id="end_date" name="end_date"
                                    placeholder="End Date">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-success me-2" id="btn_research">
                                <span class="loading-icon-search" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
                                <span class="btn-txt-search">{{ __('Search') }}</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-warning reset-btn">
                                <span class="btn-text-reset">Reload</span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
        {!! Toastr::message() !!}
        <div class="content">
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer btl_training"
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
                                                    aria-label="Course Name: activate to sort column ascending"
                                                    style="width: 141.175px;">Course Name</th>
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
                                                    aria-label="Course : activate to sort column ascending"
                                                    style="width: 34.575px;">Course Fee </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Contract : activate to sort column ascending"
                                                    style="width: 97.15px;">Contract </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Description : activate to sort column ascending"
                                                    style="width: 129.65px;">Remark </th>
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
                                                        <td class="course_name">{{ $item->course_name }}</td>
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
                                                       
                                                        <td>${{ $item->cost_price ? $item->cost_price : 0 }}</td>
                                                        <td>{{ $item->status == 1 ? "Yes" : "No" }} </td>
                                                        <td>{{ $item->remark }}</td>
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
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
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
            <div class="modal-dialog modal-sm modal-dialog-centered">
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
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">Delete</button>
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger">Cancel</a>
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
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('/training/list') }}"); 
        });
        $("#btn_research").on("click", function (){
            $(this).prop('disabled', true);
            $(".btn-txt-search").hide();
            $(".loading-icon-search").css('display', 'block');
            let params = {
                course_name: $("#course_name").val(),
                training_type: $("#filter_training_type").val(),
                start_date: $("#start_date").val(),
                end_date: $("#end_date").val(),
            };
            showdatas(params);
        });
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

        $("#status,  #e_status").on("change", function(){
            let _this = $(this).val();
            if (_this == 0) {
                $('#inp_duration').addClass("hidden");
                $('#inp_discount').addClass("hidden");
                $('#duration').removeAttr('required');
                $('#duration').val('');
                $('#discount').val('');

                $('#e_inp_duration').addClass("hidden");
                $('#e_inp_discount').addClass("hidden");
                $('#e_duration').removeAttr('required');
                $('#e_duration').val('');
                $('#e_discount').val('');
            }
            if (_this == 1) {
                $('#inp_duration').removeClass("hidden");
                $('#inp_discount').removeClass("hidden");
                $('#duration').attr('required', true);
                
                $('#e_inp_duration').removeClass("hidden");
                $('#e_inp_discount').removeClass("hidden");
                $('#e_duration').attr('required', true);
            }
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
            if (value_id == 1) {
                $('#inp_contract').addClass("hidden");
                $('#inp_duration').addClass("hidden");
                $('#inp_discount').addClass("hidden");
                $('#duration').removeAttr('required');
                $('#duration').val('');
                $('#discount').val('');

                $('#e_inp_contract').addClass("hidden");
                $('#e_inp_duration').addClass("hidden");
                $('#e_inp_discount').addClass("hidden");
                $('#e_duration').removeAttr('required');
            }
            if (value_id == 2) {
                $('#status').html('');
                $('#inp_contract').removeClass("hidden");
                $('#status').append(
                    '<option value="1">Yes</option> <option selected value="0">No</option>'
                );

                $('#e_inp_contract').removeClass("hidden");
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
                                    text: train.employee ? train.employee.employee_name_en: "",
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
        $(document).on('click','.update', function(){
            $('#trainer').html('');
            $('#e_trainer').html('');
            $('#e_status').html('<option value=""></option>');
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
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
                        if (response.success.status == "1") {
                            $('#e_status').append(
                                '<option selected value="1">Yes</option> <option value="0">No</option>'
                            );
                            $('#e_inp_duration').removeClass("hidden");
                            $('#e_inp_discount').removeClass("hidden");
                        } else if (response.success.status == "0") {
                            $('#e_status').append(
                                '<option selected value="0">No</option> <option value="1">Yes</option>'
                            );
                        };
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
                            $('#e_inp_contract').removeClass("hidden");
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
                        $('#e_course_name').val(response.success.course_name);
                        $('#e_cost_price').val(response.success.cost_price);
                        $('#e_start_date').val(response.success.start_date);
                        $('#e_end_date').val(response.success.end_date);
                        $('#e_discount').val(response.success.discount);
                        $('#e_duration').val(response.success.duration_month);
                        $('#e_remark').val(response.success.remark);
                    }
                }
            });

        });

        $('.delete').on('click', function() {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });
    });
    function showdatas(params) {
        $.ajax({
            type: "post",
            url: "{{ url('training/list') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                course_name: params.course_name ? params.course_name : null,
                training_type: params.training_type ? params.training_type : null,
                start_date: params.start_date ? params.start_date : null,
                end_date: params.end_date ? params.end_date : null,
            },
            dataType: "JSON",
            success: function(response) {
                let data =  response.success;
                $("#btn_research").prop('disabled', false);
                $(".btn-txt-search").show();
                $(".loading-icon-search").css('display', 'none');
                var tr = "";
                if (data.length > 0) {
                    data.map((row) =>{
                        let start_date = moment(row.start_date).format('D-MMM-YYYY')
                        let end_date = moment(row.end_date).format('D-MMM-YYYY')
                        tr += '<tr class="odd">'+
                                '<td class="sorting_1 ids">'+(row.id)+'</td>'+
                                '<td class="training_type_name">'+(row.training_type == 1 ? "Internal" : "External")+'</td>'+
                                '<td class="course_name">'+(row.course_name)+'</td>'+
                                '<td>'+
                                    '<ul class="team-members">'+
                                        '<li class="dropdown avatar-dropdown">'+
                                            '<a href="#" class="all-users dropdown-toggle" aria-expanded="false">'+(row.trainer_id.length)+'</a>'+
                                        '</li>'+
                                    '</ul>'+
                                '</td>'+
                                '<td>'+
                                    '<ul class="team-members">'+
                                        '<li class="dropdown avatar-dropdown">'+
                                            '<a href="#" class="all-users dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">'+(row.employee_id.length)+'</a>'+
                                        '</li>'+
                                    '</ul>'+
                                '</td>'+
                                '<td class="sorting_1">'+
                                    (start_date)+' - '+(end_date)+
                                '</td>'+
                                
                                '<td>$'+(row.cost_price ? row.cost_price : 0)+'</td>'+
                                '<td>'+(row.status == 1 ? "Yes" : "No")+' </td>'+
                                '<td>'+(row.remark ? row.remark: "")+'</td>'+
                                '<td class="text-end">'+
                                    '<div class="dropdown dropdown-action">'+
                                        '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">'+
                                            '<i class="material-icons">more_vert</i>'+
                                        '</a>'+
                                        '<div class="dropdown-menu dropdown-menu-right">'+
                                            '<a class="dropdown-item detail" href="{{url("/training/detail")}}/'+(row.id)+'">'+
                                                '<i class="fa fa-eye m-r-5"></i> View Details</a>'+
                                            '<a class="dropdown-item update" data-toggle="modal" data-id="'+(row.id)+'" data-target="#edit_training">'+
                                                '<i class="fa fa-pencil m-r-5"></i> Edit</a>'+
                                            '<a class="dropdown-item delete" href="#" data-toggle="modal" data-id="'+(row.id)+'" data-target="#delete_training">'+
                                                '<i class="fa fa-trash-o m-r-5"></i> Delete</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>';
                    });
                }else{
                    var tr = '<tr><td colspan=10 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".btl_training tbody").html(tr);
            }
        });
    }
</script>
