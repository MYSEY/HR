@extends('layouts.master')
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
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 30px;">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Type: activate to sort column ascending" style="width: 772.237px;">Type</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Name (EN)</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Name (KH)</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Phone Numer</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Remark</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Status</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Create at</th>
                                            <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 300.962px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data)>0)
                                            @foreach ($data as $item)
                                                <tr class="odd">
                                                    <td class="sorting_1 ids">{{$item->id}}</td>
                                                    <td class="type">{{$item->type == 1 ? "Internal": "External"}}</td>
                                                    <td class="name_en">{{$item->type == 1 ? $item->EmployeeIn->employee_name_en : $item->name_en}}</td>
                                                    <td class="name_kh">{{$item->type == 1 ? $item->EmployeeIn->employee_name_kh : $item->name_kh}}</td>
                                                    <td class="number_phone">{{$item->type == 1 ? $item->EmployeeIn->personal_phone_number : $item->number_phone}}</td>
                                                    <td class="email">{{$item->type == 1 ? $item->EmployeeIn->email : $item->email}}</td>
                                                    <td >{{$item->type == 1 ? $item->EmployeeIn->remark : $item->remark}}</td>
                                                    <td>
                                                        {{-- <input type="hidden" class="role" value="{{$item->role}}"> --}}
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
                        <form action="{{url('trainer/store')}}" method="POST" enctype="multipart/form-data">
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
                                        <select class="select form-control" name="employee_id">
                                            @foreach ($employee as $item)
                                                <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group trainer-external">
                                        <label>Name (EN)<span class="text-danger">*</span></label>
                                        <input class="form-control @error('name_en') is-invalid @enderror" type="text" name="name_en">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group trainer-external">
                                        <label>Name (KH)<span class="text-danger">*</span></label>
                                        <input class="form-control @error('name_kh') is-invalid @enderror" type="text" name="name_kh">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group trainer-external">
                                        <label>Phone </label>
                                        <input class="form-control @error('number_phone') is-invalid @enderror" type="number" name="number_phone">
                                    </div>
                                </div>
                            
                                <div class="col-sm-6">
                                    <div class="form-group trainer-external">
                                        <label>Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email">
                                    </div>
                                </div>
        
                                <div class="col-sm-6">
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
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
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
                        <form action="{{url('trainer/update')}}" method="POST" enctype="multipart/form-data">
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
                                        <select class="select form-control data-clear" id="e_employee_id" name="employee_id">
                                            @foreach ($employee as $item)
                                                <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group e-trainer-external">
                                        <label>Name (EN)<span class="text-danger">*</span></label>
                                        <input class="form-control data-clear @error('name_en') is-invalid @enderror" type="text" id="e_name_en" name="name_en">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group e-trainer-external">
                                        <label>Name (KH)<span class="text-danger">*</span></label>
                                        <input class="form-control data-clear @error('name_kh') is-invalid @enderror" type="text" id="e_name_kh" name="name_kh">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group e-trainer-external">
                                        <label>Phone </label>
                                        <input class="form-control data-clear @error('number_phone') is-invalid @enderror" type="number" id="e_number_phone" name="number_phone">
                                    </div>
                                </div>
                            
                                <div class="col-sm-6">
                                    <div class="form-group e-trainer-external">
                                        <label>Email</label>
                                        <input class="form-control data-clear @error('email') is-invalid @enderror" type="email" id="e_email" name="email">
                                    </div>
                                </div>
        
                                <div class="col-sm-6">
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
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete training type Modal -->
        <div class="modal custom-modal fade" id="delete_trainer" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
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
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
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
        $("#change-type, #e_change_type").on("change", function(){
            let id = $("#change-type").val();
            let e_id = $("#e_change_type").val();
            if (id == 1) {
                $(".trainer-external").hide();
                $(".trainer-internal").show();
            }else{
                $(".trainer-internal").hide();
                $(".trainer-external").show();
            }
            if (e_id == 1) {
                $(".e-trainer-external").hide();
                $(".e-trainer-internal").show();
                $(".data-clear").val("");
            }else{
                $(".data-clear").val("");
                $(".e-trainer-internal").hide();
                $(".e-trainer-external").show();
            }
        });

        $('.update').on('click',function(){
            $('#e_change_type').html('<option value=""></option>');
            $('#e_status').html('<option value=""></option>');
            var _this = $(this).parents('tr');
           
            $('.e_id').val(_this.find('.ids').text());
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
</script>
