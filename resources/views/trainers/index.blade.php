@extends('layouts.master')
<style>
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
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Trainers</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Trainers</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_trainer"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        @if (Auth::user()->RolePermission == 'Administrator')
            <form class="needs-validation" novalidate>
                @csrf
                
                <div class="row filter-btn">
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <input class="form-control floating" type="text" id="trainer_name" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <input class="form-control floating" type="text" id="company_name" placeholder="Company Name">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <select class="select form-control" data-select2-id="select2-data-2-c0n2" id="filter_trainer_type">
                                <option value="" data-select2-id="select2-data-2-c0n2">All Type</option>
                                <option value="1">Internal</option>
                                <option value="2">External</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" id="from_date"
                                    placeholder="From Date">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" id="to_date"
                                    placeholder="To Date">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-success me-2" id="btn_research">
                                <span class="loading-icon-research" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
                                <span class="btn-txt-research">{{ __('Search') }}</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-warning reset-btn">
                                <span class="btn-text-reset">Reset</span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer btn_trainer"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 30px;">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Type: activate to sort column ascending" style="width: 772.237px;">Type</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Company Name: activate to sort column ascending" style="width: 772.237px;">Company Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name (KH): activate to sort column ascending" style="width: 772.237px;">Name (KH)</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name (EN): activate to sort column ascending" style="width: 772.237px;">Name (EN)</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Phone Numer: activate to sort column ascending" style="width: 772.237px;">Phone Numer</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 772.237px;">Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Remark: activate to sort column ascending" style="width: 772.237px;">Remark</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 772.237px;">Status</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Create at: activate to sort column ascending" style="width: 772.237px;">Create at</th>
                                            <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 300.962px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data)>0)
                                            @foreach ($data as $item)
                                                <tr class="odd">
                                                    <td class="sorting_1 ids">{{$item->id}}</td>
                                                    <td class="type">{{$item->type == 1 ? "Internal": "External"}}</td>
                                                    <td class="company_name">{{$item->company_name ? $item->company_name : ""}}</td>
                                                    <td class="name_kh">{{$item->type == 1 ? $item->EmployeeIn->employee_name_kh : $item->name_kh}}</td>
                                                    <td class="name_en">{{$item->type == 1 ? $item->EmployeeIn->employee_name_en : $item->name_en}}</td>
                                                    <td class="number_phone">{{$item->type == 1 ? $item->EmployeeIn->personal_phone_number : $item->number_phone}}</td>
                                                    <td class="email">{{$item->type == 1 ? $item->EmployeeIn->email : $item->email}}</td>
                                                    <td >{{$item->type == 1 ? $item->EmployeeIn->remark : $item->remark}}</td>
                                                    <td>
                                                        <input type="hidden" class="status" value="{{$item->status}}">
                                                        <div class="dropdown action-label">
                                                            @if ($item->status=='1')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                                    <span>Active</span>
                                                                </a>
                                                            @elseif ($item->status=='0')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i>
                                                                    <span>Inactive</span>
                                                                </a>
                                                            @endif
                                                                <div class="dropdown-menu dropdown-menu-right" id="btn-status">
                                                                    <a class="dropdown-item" data-id="{{$item->id}}" data-name="1" data-status-old="{{$item->status}}" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> Active
                                                                    </a>
                                                                    <a class="dropdown-item" data-id="{{$item->id}}" data-name="0" data-status-old="{{$item->status}}" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Inactive
                                                                    </a>
                                                                </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_trainer"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_trainer"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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

        <div id="add_trainer" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Trainer</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('trainer/store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Type <span class="text-danger">*</span></label>
                                        <select class="select form-control" id="change-type" name="type" required>
                                            <option value="1">Internal</option>
                                            <option value="2">External</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 trainer-internal">
                                    <div class="form-group">
                                        <label class="">Trainer <span class="text-danger">*</span></label>
                                        <select class="select form-control" name="employee_id" id="employee_id" required>
                                            @foreach ($employee as $item)
                                                <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group trainer-external">
                                        <label>Company Name<span class="text-danger">*</span></label>
                                        <input class="form-control trainer_required @error('name_en') is-invalid @enderror" type="text" name="company_name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group trainer-external">
                                        <label>Name (KH)<span class="text-danger">*</span></label>
                                        <input class="form-control trainer_required @error('name_kh') is-invalid @enderror" type="text" name="name_kh">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group trainer-external">
                                        <label>Name (EN)<span class="text-danger">*</span></label>
                                        <input class="form-control trainer_required @error('name_en') is-invalid @enderror" type="text" name="name_en">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group trainer-external">
                                        <label>Phone </label>
                                        <input class="form-control trainer_required @error('number_phone') is-invalid @enderror" type="number" name="number_phone">
                                    </div>
                                </div>
                            
                                <div class="col-sm-6">
                                    <div class="form-group trainer-external">
                                        <label>Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email">
                                    </div>
                                </div>
        
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="select form-control" id="trainer_status" name="status" value="{{old('status')}}">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
        
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="">Remark</label>
                                        <textarea type="text" rows="3" class="form-control" name="remark" id="remark" value="{{old('remark')}}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading </span>
                                    <span class="btn-txt">{{ __('Submit') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="edit_trainer" class="modal custom-modal fade" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Trainer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('trainer/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="id" class="e_id">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Type <span class="text-danger">*</span></label>
                                        <select class="select form-control" id="e_change_type" name="type" required>
                                            {{-- <option value="1">Internal</option>
                                            <option value="2">External</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 e-trainer-internal">
                                    <div class="form-group">
                                        <label class="">Trainer <span class="text-danger">*</span></label>
                                        <select class="select form-control" id="e_employee_id" name="employee_id">
                                            @foreach ($employee as $item)
                                                <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group e-trainer-external">
                                        <label>Company Name<span class="text-danger">*</span></label>
                                        <input class="form-control data-clear e_trainer_required @error('name_en') is-invalid @enderror" type="text" id="e_company_name" name="company_name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group e-trainer-external">
                                        <label>Name (KH)<span class="text-danger">*</span></label>
                                        <input class="form-control data-clear e_trainer_required @error('name_kh') is-invalid @enderror" type="text" id="e_name_kh" name="name_kh">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group e-trainer-external">
                                        <label>Name (EN)<span class="text-danger">*</span></label>
                                        <input class="form-control data-clear e_trainer_required @error('name_en') is-invalid @enderror" type="text" id="e_name_en" name="name_en">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group e-trainer-external">
                                        <label>Phone </label>
                                        <input class="form-control data-clear e_trainer_required @error('number_phone') is-invalid @enderror" type="number" id="e_number_phone" name="number_phone">
                                    </div>
                                </div>
                            
                                <div class="col-sm-6">
                                    <div class="form-group e-trainer-external">
                                        <label>Email</label>
                                        <input class="form-control data-clear @error('email') is-invalid @enderror" type="email" id="e_email" name="email">
                                    </div>
                                </div>
        
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="select form-control" id="e_status" name="status" value="{{old('status')}}">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
        
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="">Remark</label>
                                        <textarea type="text" rows="3" class="form-control" name="remark" id="e_remark" value="{{old('remark')}}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading </span>
                                    <span class="btn-txt">{{ __('Submit') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete training type Modal -->
        <div class="modal custom-modal fade" id="delete_trainer" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('trainer/delete')}}" method="POST">
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
    $(function(){
        let id = $("#change-type").val();
        if (id == 1) {
            $(".trainer-external").hide();
            $(".trainer-internal").show();
        }else{
            $(".trainer-internal").hide();
            $(".trainer-external").show();
        }
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('/trainer/list') }}"); 
        });
        $("#btn_research").on("click", function (){
            $(this).prop('disabled', true);
            $(".btn-txt-research").hide();
            $(".loading-icon-research").css('display', 'block');
            let params = {
                trainer_name: $("#trainer_name").val(),
                company_name: $("#company_name").val(),
                trainer_type: $("#filter_trainer_type").val(),
                from_date: $("#from_date").val(),
                to_date: $("#to_date").val(),
            };
            showdatas(params);
        });
        $("#change-type, #e_change_type").on("change", function(){
            let id = $("#change-type").val();
            let e_id = $("#e_change_type").val();
            if (id == 1) {
                $(".trainer-external").hide();
                $(".trainer-internal").show();
                $('.trainer_required').removeAttr('required');
            }else{
                $(".trainer-internal").hide();
                $(".trainer-external").show();
                $(".trainer_required").attr("required", "true");
            }
            if (e_id == 1) {
                $(".e-trainer-external").hide();
                $(".e-trainer-internal").show();
                $(".data-clear").val("");
                $('.e_trainer_required').removeAttr('required');
            }else{
                $(".data-clear").val("");
                $(".e-trainer-internal").hide();
                $(".e-trainer-external").show();
                $(".e_trainer_required").attr("required", "true");
            }
        });

        $('.update').on('click',function(){
            $('#e_change_type').html('<option value=""></option>');
            $('#e_status').html('<option value=""></option>');
            var _this = $(this).parents('tr');
           
            $('.e_id').val(_this.find('.ids').text());
            $('#e_company_name').val(_this.find('.company_name').text());
            $('#e_name_en').val(_this.find('.name_en').text());
            $('#e_name_kh').val(_this.find('.name_kh').text());
            $('#e_email').val(_this.find('.email').text());
            $('#e_number_phone').val(_this.find('.number_phone').text());
            $('#e_remark').text(_this.find('.remark').text());
            let status = _this.find('.status').val();
            let type = _this.find('.type').text();
            if (status == "1") {
                $('#e_status').append('<option selected value="1">Active</option> <option value="0">Inactive</option>');
            }else if(status == "0"){
                $('#e_status').append('<option selected value="0">Inactive</option> <option value="1">Active</option>');
            }
            if (type == "Internal") {
                $(".e-trainer-external").hide();
                $(".e-trainer-internal").show();
                $('#e_change_type').append('<option selected value="1">Internal</option> <option value="2">External</option>');
                let _id = _this.find('.ids').text();
                $.ajax({
                        type: "GET",
                        url: "{{url('trainer/edit')}}",
                        data: {
                            id : _id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.employee != '') {
                            $('#e_employee_id').html('<option selected disabled> --Select --</option>');
                            $.each(response.employee, function(i, item) {
                                $('#e_employee_id').append($('<option>', {
                                    value: item.id,
                                    text: item.employee_name_en,
                                    selected: item.id == response.trainer.employee_id
                                }));
                            });
                        }
                    }
                });
            }else if(type == "External"){
                $(".e-trainer-internal").hide();
                $(".e-trainer-external").show();
                $('#e_change_type').append('<option selected value="2">External</option> <option value="1">Internal</option>');
            }
        });

        $('.delete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });

        $('body').on('click', '#btn-status a', function() {
            let id = $(this).attr('data-id');
            let status = $(this).attr('data-name');
            let old_status = $(this).attr('data-status-old');
            let text_status = "";
            let text_old_status = "";
            if (old_status == "0") {
                text_old_status = "Inactive"
            }else if(old_status == "1"){
                text_old_status = "Active"
            }
            if (status == "0") {
                text_status = "Inactive"
            }else if(status == "1"){
                text_status = "Active"
            }
            $.confirm({
                title: 'Change Status!',
                contentClass: 'text-center',
                backgroundDismiss: 'cancel',
                content: ''+
                        '<label>Are you sure want change status '+'<label style="color:red">'+text_old_status+'</label>'+' to '+'<label style="color:red">'+text_status+'</label>'+'?</label>'+
                        '<input type="hidden" class="form-control trainer_status" id="" name="" value="'+status+'">'+
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">',
                buttons: {
                    confirm: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            var trainer_status = this.$content.find('.trainer_status').val();
                            var id = this.$content.find('.id').val();
                            
                            axios.post('{{ URL('trainer/status') }}', {
                                    'trainer_status': trainer_status,
                                    'id': id,
                                }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: "The process has been successfully.",
                                    type: "success",
                                    icon: true
                                }).show();
                                $('.card-footer').remove();
                                window.location.replace("{{ URL('trainer/list') }}");
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
    });
    function showdatas(params) {
        $.ajax({
            type: "post",
            url: "{{ url('trainer/list') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                trainer_name: params.trainer_name ? params.trainer_name : null,
                company_name: params.company_name ? params.company_name : null,
                trainer_type: params.trainer_type ? params.trainer_type : null,
                from_date: params.from_date ? params.from_date : null,
                to_date: params.to_date ? params.to_date : null,
            },
            dataType: "JSON",
            success: function(response) {
                let data =  response.success;
                $("#btn_research").prop('disabled', false);
                $(".btn-txt-research").show();
                $(".loading-icon-research").css('display', 'none');
                var tr = "";
                if (data.length > 0) {
                    data.map((row) =>{
                        let created_at = moment(row.created_at).format('D-MMM-YYYY');
                        let trainer_status = "";
                        let status_color = "";
                        if (row.status=='1') {
                            status_color = "success";
                            trainer_status = "Active";
                        }else{
                            status_color = "danger";
                            trainer_status = "Inactive";
                            
                        }
                        tr += '<tr class="odd">'+
                            '<td class="sorting_1 ids">'+(row.id)+'</td>'+
                            '<td class="type">'+(row.type == 1 ? "Internal": "External")+'</td>'+
                            '<td class="company_name">'+(row.company_name ? row.company_name : "")+'</td>'+
                            '<td class="name_kh">'+(row.type == 1 ? row.employee_name_kh : row.name_kh)+'</td>'+
                            '<td class="name_en">'+(row.type == 1 ? row.employee_name_en : row.name_en)+'</td>'+
                            '<td class="number_phone">'+(row.type == 1 ? row.personal_phone_number : row.number_phone)+'</td>'+
                            '<td class="email">'+(row.type == 1 ? row.user_email ? row.user_email: ""  : row.email ? row.email : "")+'</td>'+
                            '<td >'+(row.type == 1 ? row.user_remark ? row.user_remark : "" : row.remark ? row.remark : "")+'</td>'+
                            '<td>'+
                                '<input type="hidden" class="status" value="'+(row.status)+'">'+
                                '<div class="dropdown action-label">'+
                                    '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                        '<i class="fa fa-dot-circle-o text-'+(status_color)+'"></i>'+
                                        '<span>'+(trainer_status)+'</span>'+
                                    '</a>'+
                                    '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                        '<a class="dropdown-item" data-id="'+(row.id)+'" data-name="1" data-status-old="'+(row.status)+'" href="#">'+
                                            '<i class="fa fa-dot-circle-o text-success"></i> Active'+
                                        '</a>'+
                                        '<a class="dropdown-item" data-id="'+(row.id)+'" data-name="0" data-status-old="'+(row.status)+'" href="#">'+
                                            '<i class="fa fa-dot-circle-o text-danger"></i> Inactive'+
                                        '</a>'+
                                    '</div>'+
                                '</div>'+
                            '</td>'+
                            '<td>'+
                                (created_at)+
                            '</td>'+
                            '<td class="text-end">'+
                                '<div class="dropdown dropdown-action">'+
                                    '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>'+
                                    '<div class="dropdown-menu dropdown-menu-right">'+
                                        '<a class="dropdown-item update" data-toggle="modal" data-id="'+(row.id)+'" data-target="#edit_trainer"><i class="fa fa-pencil m-r-5"></i> Edit</a>'+
                                        '<a class="dropdown-item delete" href="#" data-toggle="modal" data-id="'+(row.id)+'" data-target="#delete_trainer"><i class="fa fa-trash-o m-r-5"></i> Delete</a>'+
                                    '</div>'+
                                '</div>'+
                            '</td>'+
                        '</tr>';
                    });
                }else{
                    var tr = '<tr><td colspan=11 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".btn_trainer tbody").html(tr);
            }
        });
    }
</script>
