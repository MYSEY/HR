@extends('layouts.master')
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
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add New</a>
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
                                <table class="table table-striped custom-table datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">Profle</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">Employee ID</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(KH)</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(EN)</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Role</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Position</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Department</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Branch</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">Mobile</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Join Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Status</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data)>0)
                                            @foreach ($data as $item)
                                                <tr class="odd">
                                                    <td>{{$item->id}}</td>
                                                    <td class="sorting_1">
                                                        <h2 class="table-avatar">
                                                            @if ($item->profile != null)
                                                                <a href="{{route('employee.profile',$item->id)}}"  class="avatar">
                                                                    <img alt="" src="{{asset('/uploads/images/'.$item->profile)}}">
                                                                </a>
                                                            @else
                                                                <a href="{{route('employee.profile',$item->id)}}">
                                                                    <img alt="" src="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                                </a>
                                                            @endif
                                                        </h2>
                                                    </td>
                                                    <td><a href="{{route('employee.profile',$item->id)}}">{{$item->number_employee}}</a></td>
                                                    <td>{{$item->employee_name_kh}}</td>
                                                    <td>{{$item->employee_name_en}}</td>
                                                    <td>{{$item->email}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->name }}</span>
                                                    </td>
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeeBrnach}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>{{$item->joinOfDate}}</td>
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
                                                                    <span>Others</span>
                                                                </a>
                                                            @endif
                                                            
                                                            <div class="dropdown-menu dropdown-menu-right" id="btn-emp-status">
                                                                <input type="hidden" id="employee_id" value="{{$item->id}}">
                                                                <a class="dropdown-item" data-id="1" href="#">
                                                                    <i class="fa fa-dot-circle-o text-success"></i> FDC
                                                                </a>
                                                                <a class="dropdown-item" data-id="2" href="#">
                                                                    <i class="fa fa-dot-circle-o text-warning"></i> UDC
                                                                </a>
                                                                <a class="dropdown-item" data-id="3" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Resignation
                                                                </a>
                                                                <a class="dropdown-item" data-id="4" href="#">
                                                                    <i class="fa fa-dot-circle-o text-success"></i> Termination
                                                                </a>
                                                                <a class="dropdown-item" data-id="5" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Death
                                                                </a>
                                                                <a class="dropdown-item" data-id="6" href="#">
                                                                    <i class="fa fa-dot-circle-o text-warning"></i> Retired
                                                                </a>
                                                                <a class="dropdown-item" data-id="7" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Lay off
                                                                </a>
                                                                <a class="dropdown-item" data-id="8" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Suspension
                                                                </a>
                                                                <a class="dropdown-item" data-id="9" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Others
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item userUpdate" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                            </div>
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

        <!-- Add User Modal -->
        <div id="add_user" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Employee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('users/store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Employee ID</label>
                                        <input type="text" class="form-control" id="number_employee" name="number_employee" value="{{$autoEmpId}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="">
                                        <label class="">Name (KH) <span class="text-danger">*</span></label>
                                        <input class="form-control @error('employee_name_kh') is-invalid @enderror" type="text" id="employee_name_kh" name="employee_name_kh" value="{{old('employee_name_kh')}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Name (EN) <span class="text-danger">*</span></label>
                                        <input class="form-control @error('employee_name_en') is-invalid @enderror" type="text" id="employee_name_en" name="employee_name_en" value="{{old('employee_name_en')}}">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="select form-control" id="gender" name="gender" value="{{old('gender')}}">
                                            <option value="">select gender</option>
                                            @foreach ($optionGender as $item)
                                                <option value="{{$item->id}}">{{$item->name_khmer}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Role Name <span class="text-danger">*</span></label>
                                        <select class="select form-control @error('role_id') is-invalid @enderror" name="role_id" id="role_id">
                                            <option selected disabled> --Select --</option>
                                            @foreach ($role as $itme )
                                                <option value="{{ $itme->id }}">{{ $itme->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Position <span class="text-danger">*</span></label>
                                        <select class="select form-control @error('position_id') is-invalid @enderror" name="position_id" id="position_id">
                                            <option selected disabled> --Select --</option>
                                            @foreach ($position as $positions )
                                                <option value="{{ $positions->id }}">{{ $positions->name_khmer }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date Of Birth <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" type="text" id="date_of_birth" name="date_of_birth" value="{{old('date_of_birth')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Profile</label>
                                        <input class="form-control" type="file" id="profile" name="profile" value="{{old('profile')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <select class="select form-control" id="department_id" name="department_id" value="{{old('department_id')}}">
                                            <option value="">Please select department</option>
                                            @foreach ($department as $item)
                                                <option value="{{$item->id}}">{{$item->name_khmer}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch</label>
                                        <select class="select form-control" id="branch_id" name="branch_id" value="{{old('branch_id')}}">
                                            <option value="">Please select branch</option>
                                            @foreach ($branch as $item)
                                                <option value="{{$item->id}}">{{$item->branch_name_kh}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <input type="text" class="form-control" id="unit" name="unit" value="{{old('unit')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label>level</label>
                                        <input type="number" class="form-control" id="level" name="level" value="{{old('level')}}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="">
                                        <label class="">Join Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker @error('date_of_commencement') is-invalid @enderror" id="date_of_commencement" name="date_of_commencement" type="text" value="{{old('date_of_commencement')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Number Of Children</label>
                                        <input class="form-control" type="number" id="number_of_children" name="number_of_children" value="{{old('number_of_children')}}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Marital status</label>
                                        <select class="select form-control" id="marital_status" name="marital_status" value="{{old('marital_status')}}">
                                            <option value="Married">Married</option>
                                            <option value="Single">Single</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nationality</label>
                                        <select class="select form-control" id="nationality" name="nationality" value="{{old('nationality')}}">
                                            <option value="Khmer">Khmer</option>
                                            <option value="Chinese">Chinese</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="">
                                        <label class="">Guarantee Letter <span class="text-danger">*</span></label>
                                        <input class="form-control @error('guarantee_letter') is-invalid @enderror" type="file" id="guarantee_letter" name="guarantee_letter" value="{{old('guarantee_letter')}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Employment Book <span class="text-danger">*</span></label>
                                        <input class="form-control @error('employment_book') is-invalid @enderror" type="file" id="employment_book" name="employment_book" value="{{old('employment_book')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Personal Phone <span class="text-danger">*</span></label>
                                        <input class="form-control @error('personal_phone_number') is-invalid @enderror" type="number" id="personal_phone_number" name="personal_phone_number" value="{{old('personal_phone_number')}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Company Phone</label>
                                        <input class="form-control" type="number" id="company_phone_number" name="company_phone_number" value="{{old('company_phone_number')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Agency Phone </label>
                                        <input class="form-control" type="number" id="agency_phone_number" name="agency_phone_number" value="{{old('agency_phone_number')}}">
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Emaill <span class="text-danger">*</span></label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email" id="" name="email"  placeholder="Enter Email" {{old('email')}}>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password">
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="">Remark</label>
                                    <textarea type="text" rows="3" class="form-control" name="remark" id="remark" value="{{old('remark')}}"></textarea>
                                </div>
                            </div>
                            
                            {{-- Bank Info --}}
                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Bank Info</label>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Bank Name</label>
                                        <input class="form-control" type="text" id="bank_name" name="bank_name" value="{{old('bank_name')}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Account Name</label>
                                        <input class="form-control" type="text" id="account_name" name="account_name" value="{{old('account_name')}}">
                                    </div>
                                </div>
                            </div>
                           <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Account Number</label>
                                        <input class="form-control" type="text" id="account_number" name="account_number" value="{{old('account_number')}}">
                                    </div>
                                </div>
                           </div>
                            {{-- Identities --}}
                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Identities</label>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Identity Type</label>
                                        <select class="select form-control" id="identity_type" name="identity_type" value="{{old('identity_type')}}">
                                            <option value="">select identity type</option>
                                            @foreach ($optionIdentityType as $item)
                                                <option value="{{$item->id}}">{{$item->name_khmer}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Identity Number</label>
                                        <input class="form-control" type="number" id="identity_number" name="identity_number" value="{{old('identity_number')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Issue Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="issue_date" name="issue_date" value="{{old('issue_date')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Issue Expired Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="issue_expired_date" name="issue_expired_date" value="{{old('issue_expired_date')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            {{-- Current Address --}}
                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Current Address</label>
                            </div>
    
                            <div id="CurrentAddress">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Province/City</label>
                                            <select class="form-control" @change="cityChange" name="current_addre_city" v-model="frm.city" :disabled="JSON.stringify(cities).length==2" value="{{old('city')}}">
                                                <option v-for="(item,text) in cities" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>District/Khan</label>
                                            <select class="form-control" @change="districChange" name="current_addre_distric" v-model="frm.distric" :disabled="JSON.stringify(districs).length==2" value="{{old('distric')}}">
                                                <option v-for="(item, text) in districs" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="no-error-label">Commune/Sangkat</label>
                                            <select class="form-control no-error-border" @change="communeChange" name="current_addre_commune" v-model="frm.commune" :disabled="JSON.stringify(communes).length==2" value="{{old('commune')}}">
                                                <option v-for="(item, text) in communes" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="no-error-label">Village</label>
                                            <select class="form-control no-error-border" @change="villageChange" name="current_addre_village" v-model="frm.village" :disabled="JSON.stringify(villages).length==2" value="{{old('village')}}">
                                                <option v-for="(item, text) in villages" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>House No</label>
                                        <input class="form-control" type="text" id="current_house_no" name="current_house_no">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Street No</label>
                                        <input class="form-control" type="text" id="current_street_no" name="current_street_no">
                                    </div>
                                </div>
                            </div>

                            {{-- Permanent Address --}}
                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Permanent Address</label>
                            </div>
    
                            <div id="PermanentAddress">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Province/City</label>
                                            <select class="form-control" @change="cityChange" name="permanet_addre_city" v-model="frm.city" :disabled="JSON.stringify(cities).length==2" value="{{old('city')}}">
                                                <option v-for="(item,text) in cities" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>District/Khan</label>
                                            <select class="form-control" @change="districChange" name="permanet_addre_distric" v-model="frm.distric" :disabled="JSON.stringify(districs).length==2" value="{{old('distric')}}">
                                                <option v-for="(item, text) in districs" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="no-error-label">Commune/Sangkat</label>
                                            <select class="form-control no-error-border" @change="communeChange" name="permanet_addre_commune" v-model="frm.commune" :disabled="JSON.stringify(communes).length==2" value="{{old('commune')}}">
                                                <option v-for="(item, text) in communes" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="no-error-label">Village</label>
                                            <select class="form-control no-error-border" @change="villageChange" name="permanet_addre_village" v-model="frm.village" :disabled="JSON.stringify(villages).length==2" value="{{old('village')}}">
                                                <option v-for="(item, text) in villages" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>House No</label>
                                        <input class="form-control" type="text" id="permanent_house_no" name="permanent_house_no">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Street No</label>
                                        <input class="form-control" type="text" id="permanent_street_no" name="permanent_street_no">
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
        <!-- /Add User Modal -->

        <!-- Edit User Modal -->
        <div id="editUserModal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit employee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <form action="{{url('users/update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Employee ID</label>
                                        <input type="text" class="form-control" id="e_number_employee" name="number_employee" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="">
                                        <label class="">Name (KH) <span class="text-danger">*</span></label>
                                        <input class="form-control @error('employee_name_kh') is-invalid @enderror" type="text" id="e_employee_name_kh" name="employee_name_kh" value="{{old('employee_name_kh')}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Name (EN) <span class="text-danger">*</span></label>
                                        <input class="form-control @error('employee_name_en') is-invalid @enderror" type="text" id="e_employee_name_en" name="employee_name_en" value="{{old('employee_name_en')}}">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="select form-control" id="e_gender" name="gender">
                                            <option value="">select gender</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Role Name <span class="text-danger">*</span></label>
                                        <select class="select form-control" name="role_id" id="e_role_id">
                                            <option selected disabled> --Select --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Position <span class="text-danger">*</span></label>
                                        <select class="select form-control" name="position_id" id="e_position">
                                            <option selected disabled> --Select --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date Of Birth <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" type="text" id="e_date_of_birth" name="date_of_birth" value="{{old('date_of_birth')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Profile</label>
                                        <input class="form-control" type="file" id="profile" name="profile" value="{{old('profile')}}">
                                        <input type="hidden" name="hidden_image" id="e_profile" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Department <span class="text-danger">*</span></label>
                                        <select class="select form-control" name="department_id" id="e_department">
                                            <option selected disabled> --Select --</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch</label>
                                        <select class="select form-control" id="e_branch_id" name="branch_id" value="{{old('branch_id')}}">
                                            <option value="">Please select branch</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <input type="text" class="form-control" id="e_unit" name="unit" value="{{old('unit')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label>level</label>
                                        <input type="number" class="form-control" id="e_level" name="level" value="{{old('level')}}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="">
                                        <label class="">Join Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker @error('date_of_commencement') is-invalid @enderror" id="e_date_of_commencement" name="date_of_commencement" type="text" value="{{old('date_of_commencement')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Number Of Children</label>
                                        <input class="form-control" type="number" id="e_number_of_children" name="number_of_children" value="{{old('number_of_children')}}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Marital status</label>
                                        <select class="select form-control" id="e_marital_status" name="marital_status" value="{{old('marital_status')}}">
                                            <option value="Married">Married</option>
                                            <option value="Single">Single</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nationality</label>
                                        <select class="select form-control" id="e_nationality" name="nationality" value="{{old('nationality')}}">
                                            <option value="Khmer">Khmer</option>
                                            <option value="Chinese">Chinese</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="">
                                        <label class="">Guarantee Letter(PDF) <span class="text-danger">*</span></label>
                                        <input class="form-control @error('guarantee_letter') is-invalid @enderror" type="file" id="guarantee_letter" name="guarantee_letter" value="{{old('guarantee_letter')}}">
                                        <input type="hidden" name="hidden_file_guarantee" id="e_guarantee_letter" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Employment Book(PDF) <span class="text-danger">*</span></label>
                                        <input class="form-control @error('employment_book') is-invalid @enderror" type="file" id="employment_book" name="employment_book" value="{{old('employment_book')}}">
                                        <input type="hidden" name="hidden_file_employment_book" id="e_employment_book" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Personal Phone <span class="text-danger">*</span></label>
                                        <input class="form-control @error('personal_phone_number') is-invalid @enderror" type="number" id="e_personal_phone_number" name="personal_phone_number" value="{{old('personal_phone_number')}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Company Phone</label>
                                        <input class="form-control" type="number" id="e_company_phone_number" name="company_phone_number" value="{{old('company_phone_number')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Agency Phone </label>
                                        <input class="form-control" type="number" id="e_agency_phone_number" name="agency_phone_number" value="{{old('agency_phone_number')}}">
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Emaill <span class="text-danger">*</span></label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email" id="e_email" name="email"  placeholder="Enter Email" {{old('email')}}>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="e_password" name="password" placeholder="Enter Password">
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="">Remark</label>
                                    <textarea type="text" rows="3" class="form-control" name="remark" id="e_remark" value="{{old('remark')}}"></textarea>
                                </div>
                            </div>
                            
                            {{-- Bank Info --}}
                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Bank Info</label>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Bank Name</label>
                                        <input class="form-control" type="text" id="e_bank_name" name="bank_name" value="{{old('bank_name')}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Account Name</label>
                                        <input class="form-control" type="text" id="e_account_name" name="account_name" value="{{old('account_name')}}">
                                    </div>
                                </div>
                            </div>
                           <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Account Number</label>
                                        <input class="form-control" type="text" id="e_account_number" name="account_number" value="{{old('account_number')}}">
                                    </div>
                                </div>
                           </div>
                            {{-- Identities --}}
                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Identities</label>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Identity Type</label>
                                        <select class="select form-control" id="e_identity_type" name="identity_type" value="{{old('identity_type')}}">
                                            <option value="">select identity type</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="">Identity Number</label>
                                        <input class="form-control" type="number" id="e_identity_number" name="identity_number" value="{{old('identity_number')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Issue Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="e_issue_date" name="issue_date" value="{{old('issue_date')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Issue Expired Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="e_issue_expired_date" name="issue_expired_date" value="{{old('issue_expired_date')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            {{-- Current Address --}}
                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Current Address</label>
                            </div>
    
                            <div id="CurrentAddress">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Province/City</label>
                                            <select class="form-control" @change="cityChange" name="current_addre_city" v-model="frm.city" :disabled="JSON.stringify(cities).length==2" value="{{old('city')}}">
                                                <option v-for="(item,text) in cities" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>District/Khan</label>
                                            <select class="form-control" @change="districChange" name="current_addre_distric" v-model="frm.distric" :disabled="JSON.stringify(districs).length==2" value="{{old('distric')}}">
                                                <option v-for="(item, text) in districs" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="no-error-label">Commune/Sangkat</label>
                                            <select class="form-control no-error-border" @change="communeChange" name="current_addre_commune" v-model="frm.commune" :disabled="JSON.stringify(communes).length==2" value="{{old('commune')}}">
                                                <option v-for="(item, text) in communes" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="no-error-label">Village</label>
                                            <select class="form-control no-error-border" @change="villageChange" name="current_addre_village" v-model="frm.village" :disabled="JSON.stringify(villages).length==2" value="{{old('village')}}">
                                                <option v-for="(item, text) in villages" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>House No</label>
                                        <input class="form-control" type="text" id="e_current_house_no" name="current_house_no">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Street No</label>
                                        <input class="form-control" type="text" id="e_current_street_no" name="current_street_no">
                                    </div>
                                </div>
                            </div>

                            {{-- Permanent Address --}}
                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Permanent Address</label>
                            </div>
    
                            <div id="PermanentAddress">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Province/City</label>
                                            <select class="form-control" @change="cityChange" name="permanet_addre_city" v-model="frm.city" :disabled="JSON.stringify(cities).length==2" value="{{old('city')}}">
                                                <option v-for="(item,text) in cities" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>District/Khan</label>
                                            <select class="form-control" @change="districChange" name="permanet_addre_distric" v-model="frm.distric" :disabled="JSON.stringify(districs).length==2" value="{{old('distric')}}">
                                                <option v-for="(item, text) in districs" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="no-error-label">Commune/Sangkat</label>
                                            <select class="form-control no-error-border" @change="communeChange" name="permanet_addre_commune" v-model="frm.commune" :disabled="JSON.stringify(communes).length==2" value="{{old('commune')}}">
                                                <option v-for="(item, text) in communes" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="no-error-label">Village</label>
                                            <select class="form-control no-error-border" @change="villageChange" name="permanet_addre_village" v-model="frm.village" :disabled="JSON.stringify(villages).length==2" value="{{old('village')}}">
                                                <option v-for="(item, text) in villages" :value="text">@{{item}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>House No</label>
                                        <input class="form-control" type="text" id="e_permanent_house_no" name="permanent_house_no">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Street No</label>
                                        <input class="form-control" type="text" id="e_permanent_street_no" name="permanent_street_no">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id" id="e_id">
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit User Modal -->

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
            $('.userUpdate').on('click',function(){
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
                                        value: item.branch_name_kh,
                                        text: item.branch_name_kh,
                                        selected: item.id == response.success.branch_id
                                    }));
                                });
                            }
                            if (response.optionIdentityType != '') {
                                $('#e_identity_type').html('<option selected disabled> --Select --</option>');
                                $.each(response.optionIdentityType, function(i, item) {
                                    $('#e_identity_type').append($('<option>', {
                                        value: item.name_khmer,
                                        text: item.name_khmer,
                                        selected: item.id == response.success.identity_type
                                    }));
                                });
                            }
                            
                            $('#e_id').val(response.success.id);
                            $('#e_number_employee').val(response.success.number_employee);
                            $('#e_employee_name_kh').val(response.success.employee_name_kh);
                            $('#e_employee_name_en').val(response.success.employee_name_en);
                            $('#e_date_of_birth').val(response.success.date_of_birth);
                            $('#e_unit').val(response.success.unit);
                            $('#e_level').val(response.success.level);
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
                let status = $(this).data('id');
                let id = $("#employee_id").val();
                if (status == 1) {
                    $.confirm({
                        title: 'Employee Status!',
                        contentClass: 'text-center',
                        backgroundDismiss: 'cancel',
                        content: ''+
                            '<form method="post">'+
                                '<div class="form-group">'+
                                    '<div class="form-group">'+
                                        '<label>Start date <span class="text-danger">*</span></label>'+
                                        '<input type="date" class="form-control start_date" id="" name="" value="">'+
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
                                    var id = this.$content.find('.id').val();
                                    var resign_reason = this.$content.find('.resign_reason').val();
                                    axios.post('{{ URL('employee/status') }}', {
                                            'id': id,
                                            'emp_status': emp_status,
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
                        }
                    });
                }
            });

            window.onload = function () {
            var main = new Vue({
                el: '#CurrentAddress',
                data() {
                    return {
                        cities:{},
                        districs:{},
                        communes:{},
                        villages:{},
                        frm:{},
                    }
                },
                mounted() {
                    this.getData();
                },
                methods:{
                    cityChange: async function(){
                        var me = this;
                        this.hidden = this.frm.city;
                        await this.getData(this.frm.city).then(function(response){
                        me.districs = response.data;
                        me.communes={};
                        me.villages={};
                    });
                },
                districChange: async function(){
                    var me = this;
                    this.hidden = this.frm.distric;
                    await this.getData(this.frm.distric).then(function(response){
                        me.communes = response.data;
                        me.villages={};
                    });
                },
                communeChange: async function(){
                    var me = this;
                    this.hidden = this.frm.commune;
                    await this.getData(this.frm.commune).then(function(response){
                        me.villages = response.data;
                    });
                },
                villageChange:function(){
                    this.hidden = this.frm.village;
                },
                getData:function(code=''){
                    if(code){ 
                        return axios.get('{{route("address")}}?code='+code)
                    }
                    else
                    { 
                        return axios.get('{{route("address")}}')
                    }
                }
            },
        
            created: async function(){
                var me = this;
                    this.getData().then(function(response){
                        me.cities = response.data;
                    });
                }
            });

            var main = new Vue({
                el: '#PermanentAddress',
                data() {
                    return {
                        cities:{},
                        districs:{},
                        communes:{},
                        villages:{},
                        frm:{},
                    }
                },
                mounted() {
                    this.getData();
                },
                methods:{
                    cityChange: async function(){
                        var me = this;
                        this.hidden = this.frm.city;
                        await this.getData(this.frm.city).then(function(response){
                        me.districs = response.data;
                        me.communes={};
                        me.villages={};
                    });
                },
                districChange: async function(){
                    var me = this;
                    this.hidden = this.frm.distric;
                    await this.getData(this.frm.distric).then(function(response){
                        me.communes = response.data;
                        me.villages={};
                    });
                },
                communeChange: async function(){
                    var me = this;
                    this.hidden = this.frm.commune;
                    await this.getData(this.frm.commune).then(function(response){
                        me.villages = response.data;
                    });
                },
                villageChange:function(){
                    this.hidden = this.frm.village;
                },
                getData:function(code=''){
                    if(code){ 
                        return axios.get('{{route("address")}}?code='+code)
                    }
                    else
                    { 
                        return axios.get('{{route("address")}}')
                    }
                }
            },
        
            created: async function(){
                var me = this;
                    this.getData().then(function(response){
                        me.cities = response.data;
                    });
                }
            });
        }
    });
</script>
