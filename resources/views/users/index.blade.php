@extends('layouts.master')
<style>
    .filter-row .btn {
        min-height: 44px !important;
        padding: 9px !important;
    }
</style>
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Employee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">

                </div>
                <div class="col-auto float-end ms-auto">
                    @if (Auth::user()->RolePermission == 'Administrator')
                        <a href="#" class="btn add-btn" data-toggle="modal" id="add_new"><i class="fa fa-plus"></i> Add New</a>
                    @endif
                </div>
            </div>
        </div>
        @if (Auth::user()->RolePermission == 'Administrator')
            <form action="{{url('users/search')}}" method="POST">
                @csrf
                <div class="row filter-row"> 
                    <div class="col-sm-6 col-md-3"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="employee_id" id="number_employee" placeholder="Employee ID" value="{{old('number_employee')}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="Employee name" value="{{old('employee_name')}}">
                        </div>
                    </div>
                    {{-- <div class="col-sm-6 col-md-3"> 
                        <div class="form-group form-focus select-focus focused">
                            <select class="select form-control floating select2-hidden-accessible" data-select2-id="select2-data-1-cyfe" name="position_id" tabindex="-1" aria-hidden="true">
                                <option value="" data-select2-id="select2-data-3-c0n2">Select Position</option>
                                @foreach ($position as $positions )
                                    <option value="{{ $positions->id }}">{{ $positions->name_khmer }}</option>
                                @endforeach
                            </select>
                            <label class="focus-label">Position</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="select form-control" id="department_id" data-select2-id="select2-data-2-c0n2" name="department_id">
                                <option value="" data-select2-id="select2-data-2-c0n2">Selected department</option>
                                @foreach ($department as $item)
                                    <option value="{{$item->id}}">{{$item->name_khmer}}</option>
                                @endforeach
                            </select>
                            <label class="focus-label">Department</label>
                        </div>
                    </div> --}}
                    <div class="col-sm-6 col-md-2">
                        <button type="submit" class="btn btn-success w-100" data-dismiss="modal">Search</button>
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
                                <table class="table table-striped custom-table datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">Profle</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">Employee ID</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(KH)</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(EN)</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">DOB</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Role</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Position</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Department</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Branch</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">Mobile</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Join Date</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Pass Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Status</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data)>0)
                                            @foreach ($data as $item)
                                                <tr class="odd">
                                                    <td class="ids">{{$item->id}}</td>
                                                    <td class="sorting_1">
                                                        <h2 class="table-avatar">
                                                            @if ($item->profile != null)
                                                                <a href="{{asset('/uploads/images/'.$item->profile)}}"  class="avatar">
                                                                    <img alt="" src="{{asset('/uploads/images/'.$item->profile)}}">
                                                                </a>
                                                            @else
                                                                <a href="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                                    <img alt="" src="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                                </a>
                                                            @endif
                                                        </h2>
                                                    </td>
                                                    <td><a href="{{route('employee.profile',$item->id)}}">{{$item->number_employee}}</a></td>
                                                    <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_kh}}</a></td>
                                                    <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_en}}</a></td>
                                                    <td>{{$item->email}}</td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->name }}</span>
                                                    </td>
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeeBrnach}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>{{$item->joinOfDate}}</td>
                                                    <td>{{$item->PassDate}}</td>
                                                    <td>
                                                        <div class="dropdown action-label">
                                                            @if ($item->emp_status=='Probation')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                                    <span>{{ $item->emp_status }}</span>
                                                                </a>
                                                            @elseif ($item->emp_status=='1')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-info"></i>
                                                                    <span>FDC</span>
                                                                </a>
                                                            @elseif ($item->emp_status=='2')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i>
                                                                    <span>UDC</span>
                                                                </a>
                                                            @elseif ($item->emp_status=='3')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                                    <span>Resignation</span>
                                                                </a>
                                                            @elseif ($item->emp_status=='4')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                                    <span>Termination</span>
                                                                </a>
                                                            @elseif ($item->emp_status=='5')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                                    <span>Death</span>
                                                                </a>
                                                            @elseif ($item->emp_status=='6')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                                    <span>Retired</span>
                                                                </a>
                                                            @elseif ($item->emp_status=='7')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                                    <span>Lay off</span>
                                                                </a>
                                                            @elseif ($item->emp_status=='8')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                                    <span>Suspension</span>
                                                                </a>
                                                            @elseif ($item->emp_status=='9')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                                    <span>Fall Probation</span>
                                                                </a>
                                                            @elseif ($item->emp_status=='10')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                                    <span>Others</span>
                                                                </a>
                                                            @endif
                                                            @if (Auth::user()->RolePermission == 'Administrator')
                                                                <div class="dropdown-menu dropdown-menu-right" id="btn-emp-status">
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="1" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> FDC
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="2" href="#">
                                                                        <i class="fa fa-dot-circle-o text-warning"></i> UDC
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="3" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Resignation
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="4" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> Termination
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="5" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Death
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="6" href="#">
                                                                        <i class="fa fa-dot-circle-o text-warning"></i> Retired
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="7" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Lay off
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="8" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Suspension
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="9" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Fall Probation
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="10" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Others
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                            @if (Auth::user()->RolePermission == 'Administrator')
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item userUpdate" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                    <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="16" style="text-align: center">No record to display</td>
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

        @include('users.modal_form_create')
        @include('users.modal_form_edit')

        <!-- Delete User Modal -->
        <div class="modal custom-modal fade" id="delete_user" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('users/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <input type="hidden" name="hidden_image" id="e_profile" value="">

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
        <!-- /Delete User Modal -->
    </div>
@endsection
@include('includs.script')

<script>
    $(function(){
        // block Current Address
        $("#current_province, #e_current_province").on("change", function(){
            let id = $("#current_province").val() ?? $("#current_province").val() ?? $("#e_current_province").val() ?? $("#e_current_province").val();
            let optionSelect = "currentProvince";

            $('#current_district').html('<option selected disabled> --Select --</option>');
            $('#current_commune').html('<option selected disabled> --Select --</option>');
            $('#current_village').html('<option selected disabled> --Select --</option>');

            $('#e_current_district').html('<option selected disabled> --Select --</option>');
            $('#e_current_commune').html('<option selected disabled> --Select --</option>');
            $('#e_current_village').html('<option selected disabled> --Select --</option>');

            showProvince(id, optionSelect);
        });

        $("#current_district, #e_current_district").on("change", function(){
            let id = $("#current_district").val() ?? $("#current_district").val() ?? $("#e_current_district").val() ?? $("#e_current_district").val();
            let optionSelect = "currentDistrict";
            $('#current_commune').html('<option selected disabled> --Select --</option>');
            $('#current_village').html('<option selected disabled> --Select --</option>');

            $('#e_current_commune').html('<option selected disabled> --Select --</option>');
            $('#e_current_village').html('<option selected disabled> --Select --</option>');
            showProvince(id, optionSelect);
        });

        $("#current_commune, #e_current_commune").on("change", function(){
            let id = $("#current_commune").val() ?? $("#current_commune").val() ?? $("#e_current_commune").val() ?? $("#e_current_commune").val();
            let optionSelect = "currentCommune";
            $('#current_village').html('<option selected disabled> --Select --</option>');
            $('#e_current_village').html('<option selected disabled> --Select --</option>');
            showProvince(id, optionSelect);
        });

        // block Permanent Address
        $("#permanent_province, #e_permanent_province").on("change", function(){
            let id = $("#permanent_province").val() ?? $("#permanent_province").val() ?? $("#e_permanent_province").val() ?? $("#e_permanent_province").val();
            let optionSelect = "permanentProvince";
            $('#permanent_district').html('<option selected disabled> --Select --</option>');
            $('#permanent_commune').html('<option selected disabled> --Select --</option>');
            $('#permanent_village').html('<option selected disabled> --Select --</option>');

            $('#e_permanent_district').html('<option selected disabled> --Select --</option>');
            $('#e_permanent_commune').html('<option selected disabled> --Select --</option>');
            $('#e_permanent_village').html('<option selected disabled> --Select --</option>');
            showProvince(id, optionSelect);
        });
        $("#permanent_district, #e_permanent_district").on("change", function(){
            let id = $("#permanent_district").val() ?? $("#permanent_district").val() ?? $("#e_permanent_district").val() ?? $("#e_permanent_district").val();
            let optionSelect = "permanentDistrict";
            $('#permanent_commune').html('<option selected disabled> --Select --</option>');
            $('#permanent_village').html('<option selected disabled> --Select --</option>');

            $('#e_permanent_commune').html('<option selected disabled> --Select --</option>');
            $('#e_permanent_village').html('<option selected disabled> --Select --</option>');
            showProvince(id, optionSelect);
        });
        $("#permanent_commune, #e_permanent_commune").on("change", function(){
            let id = $("#permanent_commune").val() ?? $("#permanent_commune").val() ?? $("#e_permanent_commune").val() ?? $("#e_permanent_commune").val();
            let optionSelect = "permanentCommune";
            $('#permanent_village').html('<option selected disabled> --Select --</option>');
            $('#e_permanent_village').html('<option selected disabled> --Select --</option>');
            showProvince(id, optionSelect);
        });

        $("#add_new").on("click", function (){
            $('#current_district').html('<option></option>');
            $('#current_commune').html('<option></option>');
            $('#current_village').html('<option></option>');

            $('#permanent_district').html('<option></option>');
            $('#permanent_commune').html('<option></option>');
            $('#permanent_village').html('<option></option>');
            $('#add_user').modal('show');
        });
        $(".btn-close").on("click", function(){
            $("#add_user").modal('hide')
            $("#editUserModal").modal('hide')
        });

        $('.userUpdate').on('click',function(){
            $('#e_bank_name').html('<option selected value=""> </option>');
            
            $('#e_current_province').html('<option selected value="">--Select --</option>');
            $('#e_current_district').html('<option selected value=""> </option>');
            $('#e_current_commune').html('<option selected value=""> </option>');
            $('#e_current_village').html('<option selected value=""> </option>');

            $('#e_permanent_province').html('<option selected value="">--Select --</option>');
            $('#e_permanent_district').html('<option selected value=""> </option>');
            $('#e_permanent_commune').html('<option selected value=""> </option>');
            $('#e_permanent_village').html('<option selected value=""> </option>');
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('users/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        if (response.role != '') {
                            $('#e_role_id').html('<option selected disabled> --Select --</option>');
                            $.each(response.role, function(i, item) {
                                $('#e_role_id').append($('<option>', {
                                    value: item.id,
                                    text: item.name,
                                    selected: item.id == response.success.role_id
                                }));
                            });
                        }

                        if (response.position != '') {
                            $('#e_position').html('<option selected disabled> --Select --</option>');
                            $.each(response.position, function(i, item) {
                                $('#e_position').append($('<option>', {
                                    value: item.id,
                                    text: item.name_khmer,
                                    selected: item.id == response.success.position_id
                                }));
                            });
                        }
                        
                        if (response.department != '') {
                            $('#e_department').html('<option selected disabled> --Select --</option>');
                            $.each(response.department, function(i, item) {
                                $('#e_department').append($('<option>', {
                                    value: item.id,
                                    text: item.name_khmer,
                                    selected: item.id == response.success.department_id
                                }));
                            });
                        }
                        if (response.optionGender != '') {
                            $('#e_gender').html('<option selected disabled> --Select --</option>');
                            $.each(response.optionGender, function(i, item) {
                                $('#e_gender').append($('<option>', {
                                    value: item.id,
                                    text: item.name_khmer,
                                    selected: item.id == response.success.gender
                                }));
                            });
                        }
                        if (response.branch != '') {
                            $('#e_branch_id').html('<option selected disabled> --Select --</option>');
                            $.each(response.branch, function(i, item) {
                                $('#e_branch_id').append($('<option>', {
                                    value: item.id,
                                    text: item.branch_name_kh,
                                    selected: item.id == response.success.branch_id
                                }));
                            });
                        }

                        if (response.optionIdentityType != '') {
                            $.each(response.optionIdentityType, function(i, item) {
                                $('#e_identity_type').append($('<option>', {
                                    value: item.name_khmer,
                                    text: item.name_khmer,
                                    selected: item.id == response.success.identity_type
                                }));
                            });
                        }
                        
                        if (response.bank != '') {
                            $.each(response.bank, function(i, item) {
                                $('#e_bank_name').append($('<option>', {
                                    value: item.id,
                                    text: item.name,
                                    selected: item.id == response.success.bank_name
                                }));
                            });
                        }
                        
                        if (response.province != '') {
                            $.each(response.province, function(i,item) {
                                let option = {
                                    value: item.code,
                                    text: item.name_en,
                                }
                                $('#e_current_province').append($('<option>', {...option, selected: item.code == response.success.current_province})); 
                                $('#e_permanent_province').append($('<option>', {...option, selected: item.code == response.success.permanent_province})); 
                            });
                        }

                        if (response.district != '') {
                            $.each(response.district, function(i,item) {
                                if (item.province_id == response.success.current_province) {
                                    let cur_option = {}
                                    cur_option= {
                                        value:item.code,
                                        text: item.name_en,
                                        selected: item.code == response.success.current_district
                                    };
                                    $('#e_current_district').append($('<option>', cur_option));
                                }
                                if (item.province_id == response.success.permanent_province) {
                                    let per_option = {}
                                    per_option= {
                                        value:item.code,
                                        text: item.name_en,
                                        selected: item.code == response.success.permanent_district
                                    };
                                    $('#e_permanent_district').append($('<option>', per_option));
                                } 
                            });
                        }

                        if (response.conmmunes != '') {
                            $.each(response.conmmunes, function(i,item) {
                                if (item.district_id == response.success.current_district) {
                                    let cur_option = {}
                                    cur_option= {
                                        value:item.code,
                                        text: item.name_en,
                                        selected: item.code == response.success.current_commune
                                    };
                                    $('#e_current_commune').append($('<option>', cur_option));
                                }
                                if (item.district_id == response.success.permanent_district) {
                                    let per_option = {}
                                    per_option= {
                                        value:item.code,
                                        text: item.name_en,
                                        selected: item.code == response.success.permanent_commune
                                    };
                                    $('#e_permanent_commune').append($('<option>', per_option));
                                }
                            });
                        }

                        if (response.villages != '') {
                            $.each(response.villages, function(i,item) {
                                if (item.commune_id == response.success.current_commune) {
                                    let cur_option = {}
                                    cur_option= {
                                        value:item.code,
                                        text: item.name_en,
                                        selected: item.code == response.success.current_village
                                    };
                                    $('#e_current_village').append($('<option>', cur_option));
                                }
                                if (item.commune_id == response.success.permanent_commune) {
                                    let per_option = {}
                                    per_option= {
                                        value:item.code,
                                        text: item.name_en,
                                        selected: item.code == response.success.permanent_village
                                    };
                                    $('#e_permanent_village').append($('<option>', per_option));
                                }
                            });
                        }
                        
                        $('#e_id').val(response.success.id);
                        $('#e_number_employee').val(response.success.number_employee);
                        $('#e_employee_name_kh').val(response.success.employee_name_kh);
                        $('#e_employee_name_en').val(response.success.employee_name_en);
                        $('#e_date_of_birth').val(response.success.date_of_birth);
                        $('#e_unit').val(response.success.unit);
                        $('#e_level').val(response.success.level);
                        $('#e_date_of_commencement').val(response.success.date_of_commencement);
                        $('#e_number_of_children').val(response.success.number_of_children);
                        $('#e_marital_status').val(response.success.marital_status);
                        $('#e_nationality').val(response.success.nationality);
                        $('#e_personal_phone_number').val(response.success.personal_phone_number);
                        $('#e_company_phone_number').val(response.success.company_phone_number);
                        $('#e_agency_phone_number').val(response.success.agency_phone_number);
                        $('#e_email').val(response.success.email);
                        $('#e_remark').val(response.success.remark);
                        $('#e_bank_name').val(response.success.bank_name);
                        $('#e_account_name').val(response.success.account_name);
                        $('#e_account_number').val(response.success.account_number);
                        $('#e_identity_number').val(response.success.identity_number);
                        $('#e_issue_date').val(response.success.issue_date);
                        $('#e_issue_expired_date').val(response.success.issue_expired_date);
                        $('#e_profile').val(response.success.profile);
                        $('#e_guarantee_letter').val(response.success.guarantee_letter);
                        $('#e_employment_book').val(response.success.employment_book);
                        $('#e_current_house_no').val(response.success.current_house_no);
                        $('#e_current_street_no').val(response.success.current_street_no);
                        $('#e_permanent_house_no').val(response.success.permanent_house_no);
                        $('#e_permanent_street_no').val(response.success.permanent_street_no);
                        $('#editUserModal').modal('show');
                    }
                }
            });
        });
        $('.userDelete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
            $('.e_profile').val(_this.find('.image').text());
        });

        $('body').on('click', '#btn-emp-status a', function() {
            let id = $(this).attr('data-emp-id');
            let status = $(this).data('id');
            if (status == 1) {
                var emp_status = "FDC";
            } else if(status == 2) {
                var emp_status = "UDC";
            }else if(status == 3){
                var emp_status = "Resignation";
            }else if(status == 4){
                var emp_status = "Termination";
            }else if(status == 5){
                var emp_status = "Death";
            }else if(status == 6){
                var emp_status = "Retired";
            }else if(status == 7){
                var emp_status = "Lay off";
            }else if(status == 8){
                var emp_status = "Suspension";
            }else if(status == 9){
                var emp_status = "Fall Probation";
            }else if(status == 10){
                var emp_status = "Other";
            }
            let start_date = $(this).attr('data-start-date');
            let end_date = $(this).attr('data-end-date');
            if (status == 1) {
                $.confirm({
                    title: 'Employee Status!',
                    contentClass: 'text-center',
                    backgroundDismiss: 'cancel',
                    content: ''+
                        '<form method="post" class="formName">'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label><a href="#">'+emp_status+'</a></label>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>Start date <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control start_date" value="'+start_date+'">'+
                                    '<input type="hidden" class="form-control emp_status" id="" name="" value="'+status+'">'+
                                    '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>End date</label>'+
                                    '<input type="date" class="form-control end_dete" id="" name="" value="">'+
                                '</div>'+
                                '<label>Reason</label>'+
                                '<textarea class="form-control resign_reason"></textarea>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var id = this.$content.find('.id').val();
                                var start_date = this.$content.find('.start_date').val();
                                var end_dete = this.$content.find('.end_dete').val();
                                var resign_reason = this.$content.find('.resign_reason').val();

                                if (!start_date) {
                                    $.alert({
                                        title: '<span class="text-danger">Requiered</span>',
                                        content: 'Please input start date.',
                                    });
                                    return false;
                                }
                                
                                axios.post('{{ URL('employee/status') }}', {
                                        'emp_status': emp_status,
                                        'id': id,
                                        'start_date': start_date,
                                        'end_dete': end_dete,
                                        'resign_reason': resign_reason
                                    }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: "The process has been successfully.",
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('users') }}");
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
            }else if(status==2){
                $.confirm({
                    title: 'Employee Status!',
                    contentClass: 'text-center',
                    backgroundDismiss: 'cancel',
                    content: ''+
                        '<form>'+
                            '<div class="form-group">'+
                                '<label><a href="#">'+emp_status+'</a></label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>End date <span class="text-danger">*</span></label>'+
                                '<input type="date" class="form-control end_date" value="'+end_date+'">'+
                                '<input type="hidden" class="form-control emp_status" id="" name="" value="'+status+'">'+
                                '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>Reason</label>'+
                                '<textarea class="form-control resign_reason"></textarea>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var end_date = this.$content.find('.end_date').val();
                                var id = this.$content.find('.id').val();
                                var resign_reason = this.$content.find('.resign_reason').val();

                                if (!end_date) {
                                    $.alert({
                                        title: '<span class="text-danger">Requiered</span>',
                                        content: 'Please input end date.',
                                    });
                                    return false;
                                }

                                axios.post('{{ URL('employee/status') }}', {
                                        'id': id,
                                        'emp_status': emp_status,
                                        'end_date': end_date,
                                        'resign_reason': resign_reason
                                    }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: "The process has been successfully.",
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('users') }}");
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
            }else{
                $.confirm({
                    title: 'Employee Status!',
                    contentClass: 'text-center',
                    backgroundDismiss: 'cancel',
                    content: ''+
                        '<form method="post">'+
                            '<div class="form-group">'+
                                '<label><a href="#">'+emp_status+'</a></label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label>date <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control resign_date" id="" name="" value="">'+
                                    '<input type="hidden" class="form-control emp_status" id="" name="" value="'+status+'">'+
                                    '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                                '</div>'+
                                '<label>Reason</label>'+
                                '<textarea class="form-control resign_reason"></textarea>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var id = this.$content.find('.id').val();
                                var resign_date = this.$content.find('.resign_date').val();
                                var resign_reason = this.$content.find('.resign_reason').val();

                                if (!resign_date) {
                                    $.alert({
                                        title: '<span class="text-danger">Requiered</span>',
                                        content: 'Please input date.',
                                    });
                                    return false;
                                }
                                
                                axios.post('{{ URL('employee/status') }}', {
                                        'id': id,
                                        'emp_status': emp_status,
                                        'resign_date': resign_date,
                                        'resign_reason': resign_reason
                                    }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: "The process has been successfully.",
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('users') }}");
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
                    },
                    onContentReady: function() {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function(e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            }
        });
    });

    function showProvince(id, optionSelect){
        let url = "";
        let data = {
            "_token": "{{ csrf_token() }}",
        };

        // block Current Address
        if (optionSelect == "currentProvince") {
            url = "{{url('district')}}"
            data.province_id = id
        }else if (optionSelect == "currentDistrict") {
            url = "{{url('commune')}}"
            data.district_id = id
        }else if (optionSelect == "currentCommune") {
            url = "{{url('village')}}"
            data.commune_id = id
        };

        // block Permanent Address
        if (optionSelect == "permanentProvince") {
            url = "{{url('district')}}"
            data.province_id = id
        }else if (optionSelect == "permanentDistrict") {
            url = "{{url('commune')}}"
            data.district_id = id
        }else if (optionSelect == "permanentCommune") {
            url = "{{url('village')}}"
            data.commune_id = id
        }

        $.ajax({
            type: "POST",
            url,
            data,
            dataType: "JSON",
            success: function (response) {
                var data = response.data;
                if (data != '') {
                    let option = {value: "",text: ""}
                    $.each(data, function(i, item) {
                        option = {
                            value: item.code,
                            text: item.name_en,
                        }
                        if (optionSelect == "currentProvince") {
                            $('#current_district').append($('<option>', option));
                            $('#e_current_district').append($('<option>', option));
                        }else if(optionSelect == "currentDistrict"){
                            $('#current_commune').append($('<option>', option));
                            $('#e_current_commune').append($('<option>', option));
                        }else if (optionSelect == "currentCommune") {
                            $('#current_village').append($('<option>', option));
                            $('#e_current_village').append($('<option>', option));
                        }else if (optionSelect == "permanentProvince") {
                            $('#permanent_district').append($('<option>', option));
                            $('#e_permanent_district').append($('<option>', option));
                        }else if (optionSelect == "permanentDistrict") {
                            $('#permanent_commune').append($('<option>', option));
                            $('#e_permanent_commune').append($('<option>', option));
                        }else if (optionSelect == "permanentCommune") {
                            $('#permanent_village').append($('<option>', option));
                            $('#e_permanent_village').append($('<option>', option));
                        }
                    
                    });
                }
            }
        });
    }
</script>
