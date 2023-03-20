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
                    @if (Auth::user()->role_id == '1')
                        {{-- <a href="{{ url('employee/create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add New</a> --}}
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i> Add New</a>
                    @endif
                </div>
            </div>
        </div>
        {{-- @if ($message = Session::get('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif  --}}
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
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(kh)</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(en)</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Email</th>
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
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeeBrnach}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>{{$item->joinOfDate}}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">{{$item->status}}</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item" href="#" data-id="{{$item->id}}" id="bnt_delete"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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

        <div id="add_employee" class="modal custom-modal fade" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Employee</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('employee')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="pro-overview" role="tabpanel">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="">User Name <span class="text-danger">*</span></label>
                                                <select class="select form-control @error('user_id') is-invalid @enderror" id="userName" name="user_id" value="{{old('user_id')}}">
                                                    @foreach ($user as $item)
                                                        <option value="{{$item->id}}" data-email={{ $item->email }} data-personal_phone_number={{ $item->phone }} data-position_id={{ $item->position_id }}>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
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
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Position</label>
                                                <select class="select form-control" id="position_id" name="position_id" value="{{old('position_id')}}">
                                                    <option value="">Please select position</option>
                                                    @foreach ($position as $item)
                                                        <option value="{{$item->id}}">{{$item->name_khmer}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
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
                                        
                                        <div class="col-sm-6">
                                            <div class="">
                                                <label class="">Join Date <span class="text-danger">*</span></label>
                                                <div class="cal-icon">
                                                    <input class="form-control datetimepicker @error('date_of_commencement') is-invalid @enderror" id="date_of_commencement" name="date_of_commencement" type="text" value="{{old('date_of_commencement')}}">
                                                    {{-- <p class="text-danger">{!! $errors->first('date_of_commencement') !!}</p> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="">Number Of Children</label>
                                                <input class="form-control" type="number" id="number_of_children" name="number_of_children" value="{{old('number_of_children')}}">
                                            </div>
                                        </div>
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
                                        <div class="col-sm-6">
                                            <div class="">
                                                <label class="">Guarantee Letter <span class="text-danger">*</span></label>
                                                <input class="form-control @error('guarantee_letter') is-invalid @enderror" type="file" id="guarantee_letter" name="guarantee_letter" value="{{old('guarantee_letter')}}">
                                                {{-- <p class="text-danger">{!! $errors->first('guarantee_letter') !!}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="">Employment Book <span class="text-danger">*</span></label>
                                                <input class="form-control @error('employment_book') is-invalid @enderror" type="file" id="employment_book" name="employment_book" value="{{old('employment_book')}}">
                                                {{-- <p class="text-danger">{!! $errors->first('employment_book') !!}</p> --}}
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="">Remark</label>
                                                <textarea type="text" rows="3" class="form-control" name="remark" id="remark" value="{{old('remark')}}"></textarea>
                                            </div>
                                        </div>
                    
                                        <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                            <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Bank Info</label>
                                        </div>
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
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="">Account Number</label>
                                                <input class="form-control" type="text" id="account_number" name="account_number" value="{{old('account_number')}}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                            <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Contact Info</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="">Personal Phone <span class="text-danger">*</span></label>
                                                <input class="form-control @error('personal_phone_number') is-invalid @enderror" type="number" id="personal_phone_number" name="personal_phone_number" value="{{old('personal_phone_number')}}">
                                                {{-- <p class="text-danger">{!! $errors->first('personal_phone_number') !!}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="">Company Phone</label>
                                                <input class="form-control" type="number" id="company_phone_number" name="company_phone_number" value="{{old('company_phone_number')}}">
                                                {{-- <p class="text-danger">{!! $errors->first('company_phone_number') !!}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="">Agency Phone </label>
                                                <input class="form-control" type="number" id="agency_phone_number" name="agency_phone_number" value="{{old('agency_phone_number')}}">
                                                {{-- <p class="text-danger">{!! $errors->first('agency_phone_number') !!}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="">Email <span class="text-danger">*</span></label>
                                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{old('email')}}">
                                                {{-- <p class="text-danger">{!! $errors->first('email') !!}</p> --}}
                                            </div>
                                        </div>
                    
                                        <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                            <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Identities</label>
                                        </div>
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
                                        
                                        <div class="submit-section" style="text-align: right">
                                            <button class="btn btn-primary submit-btn">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('includs.script')
<script>
    $(function(){
        $('#userName').on('change',function()
        {
            $('#email').val($(this).find(':selected').data('email'));
            $('#personal_phone_number').val($(this).find(':selected').data('personal_phone_number'));
            $('#position_id').val($(this).find(':selected').data('position_id'));
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
    
        $("#DataTables_Table_0 tbody").delegate("#bnt_delete", "click", function(){
            let delId = $(this).data("id");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YES',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: "/employee/delete",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id   : delId
                        },
                        success: function (response) {
                            if(response.status==1){
                                Swal.fire('Deleted!','Your file has been deleted.','success')
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        });
    });
</script>