<div class="tab-pane active show" id="tbl_candidate_resume" role="tabpanel">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl_signed_contract"
                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">Profle</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">Employee ID</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(KH)</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(EN)</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Position</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Department</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Branch</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">Contact Number</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Role</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Position Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Basic Salary</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Phone Allowance</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Date Of Birth</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Join Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Loan</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Status</th>
                                        <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data)>0)
                                        @foreach ($data as $item)
                                            @if ($item->emp_status == "Upcoming")
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
                                                    
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->name }}</span>
                                                    </td>
                                                    <td>{{$item->EmployeePositionType}}</td>
                                                    <td>$ <a href="#">{{$item->basic_salary}}</a></td>
                                                    <td>$ <a href="#">{{$item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->joinOfDate}}</td>
                                                    <td>
                                                        @if ($item->is_loan == '1')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Yes</span>
                                                        @elseif($item->is_loan == '0')
                                                            <span style="font-size: 13px" class="badge bg-inverse-success">No</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown action-label">
                                                            @if ($item->emp_status=='Upcoming')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                                    <span>{{ $item->emp_status }}</span>
                                                                </a>
                                                            @endif
                                                            @if (Auth::user()->RolePermission == 'Administrator')
                                                                <div class="dropdown-menu dropdown-menu-right btn-emp-status" id="btn-emp-status">
                                                                    <input type="text" name="" class="join_date" value="{{$item == null ? "" : $item->date_of_commencement}}" hidden>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-id="Probation" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> Probation
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-id="Cancel" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Cancel
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
                                                                    <a class="dropdown-item btn_print" data-id="{{$item->id}}"><i class="fa fa-print fa-lg m-r-5"></i> Print</a>
                                                                    <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
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
<div class="tab-pane show" id="tbl_probations" role="tabpanel">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table datatable dataTable no-footer tbl_probation"
                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">Profle</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">Employee ID</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(KH)</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(EN)</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Position</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Department</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Branch</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">Contact Number</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Role</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Position Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Basic Salary</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Phone Allowance</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Date Of Birth</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Join Date</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Past Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Loan</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Status</th>
                                        <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data)>0)
                                        @foreach ($data as $item)
                                            @if ($item->emp_status == "Probation")
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
                                                    
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->name }}</span>
                                                    </td>
                                                    <td>{{$item->EmployeePositionType}}</td>
                                                    <td>$ <a href="#">{{$item->basic_salary}}</a></td>
                                                    <td>$ <a href="#">{{$item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->joinOfDate}}</td>
                                                    <td>{{$item->PassDate}}</td>
                                                    <td>
                                                        @if ($item->is_loan == '1')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Yes</span>
                                                        @elseif($item->is_loan == '0')
                                                            <span style="font-size: 13px" class="badge bg-inverse-success">No</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown action-label">
                                                            @if ($item->emp_status=='Probation')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                                    <span>{{ $item->emp_status }}</span>
                                                                </a>
                                                            @endif
                                                            @if (Auth::user()->RolePermission == 'Administrator')
                                                                <div class="dropdown-menu dropdown-menu-right btn-emp-status" id="btn-emp-status">
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-Salary-Increase="{{$item->salary_increas == null ? "" : $item->salary_increas}}" data-id="1" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> FDC-1
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="10" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> FDC-2
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="2" href="#">
                                                                        <i class="fa fa-dot-circle-o text-warning"></i> UDC
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="3" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Resignation
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="4" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Termination
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="5" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Death
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="6" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Retired
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
                                            @endif
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
<div class="tab-pane show" id="tbl_fdc" role="tabpanel">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table datatable dataTable no-footer tbl_fdc"
                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">Profle</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">Employee ID</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(KH)</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(EN)</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Position</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Department</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Branch</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">Contact Number</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Role</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Position Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Basic Salary</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Phone Allowance</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Date Of Birth</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Join Date</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">FDC Start Date</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">FDC End Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Loan</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Status</th>
                                        <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data)>0)
                                        @foreach ($data as $item)
                                            @if ($item->emp_status == 1 || $item->emp_status == 10)
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
                                                    
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->name }}</span>
                                                    </td>
                                                    <td>{{$item->EmployeePositionType}}</td>
                                                    <td>$ <a href="#">{{$item->basic_salary}}</a></td>
                                                    <td>$ <a href="#">{{$item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->joinOfDate}}</td>
                                                    <td>{{$item->FDCStartDate}}</td>
                                                    <td>{{$item->FDCEndDate}}</td>
                                                    <td>
                                                        @if ($item->is_loan == '1')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Yes</span>
                                                        @elseif($item->is_loan == '0')
                                                            <span style="font-size: 13px" class="badge bg-inverse-success">No</span>
                                                        @else
                                                            
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown action-label">
                                                            @if ($item->emp_status=='1')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-info"></i>
                                                                    <span>FDC-1</span>
                                                                </a>
                                                            @elseif ($item->emp_status=='10')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-info"></i>
                                                                    <span>FDC-2</span>
                                                                </a>
                                                            @endif
                                                            @if (Auth::user()->RolePermission == 'Administrator')
                                                                <div class="dropdown-menu dropdown-menu-right btn-emp-status" id="btn-emp-status">
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="1" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> FDC-1
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="10" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> FDC-2
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="2" href="#">
                                                                        <i class="fa fa-dot-circle-o text-warning"></i> UDC
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="3" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Resignation
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="4" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Termination
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="5" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Death
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="6" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Retired
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
                                            @endif
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
<div class="tab-pane show" id="tbl_udc" role="tabpanel">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table datatable dataTable no-footer tbl-udc "
                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">Profle</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">Employee ID</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(KH)</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(EN)</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Position</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Department</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Branch</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">Contact Number</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Role</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Position Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Basic Salary</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Phone Allowance</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Date Of Birth</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Join Date</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">UDC Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Loan</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Status</th>
                                        <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data)>0)
                                        @foreach ($data as $item)
                                            @if ($item->emp_status == "2")
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
                                                    
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->name }}</span>
                                                    </td>
                                                    <td>{{$item->EmployeePositionType}}</td>
                                                    <td>$ <a href="#">{{$item->basic_salary}}</a></td>
                                                    <td>$ <a href="#">{{$item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->joinOfDate}}</td>
                                                    <td>{{$item->FDCStartDate}}</td>
                                                    <td>
                                                        @if ($item->is_loan == '1')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Yes</span>
                                                        @elseif($item->is_loan == '0')
                                                            <span style="font-size: 13px" class="badge bg-inverse-success">No</span>
                                                        @else
                                                            
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown action-label">
                                                            @if ($item->emp_status=='2')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                                    <span>UDC</span>
                                                                </a>
                                                            @endif
                                                            @if (Auth::user()->RolePermission == 'Administrator')
                                                                <div class="dropdown-menu dropdown-menu-right" id="btn-emp-status">
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="3" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Resignation
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="4" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Termination
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="5" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Death
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="6" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> Retired
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
                                            @endif
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
<div class="tab-pane show" id="tbl_cancel" role="tabpanel">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table datatable dataTable no-footer tbl-cancel "
                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">Profle</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">Employee ID</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(KH)</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(EN)</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Position</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Department</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Branch</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">Contact Number</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Role</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Position Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Basic Salary</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Phone Allowance</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Date Of Birth</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Join Date</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Resign Date</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Resign Reason</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Loan</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Status</th>
                                        <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data)>0)
                                    @foreach ($data as $item)
                                        @if ($item->emp_status == "Cancel")
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
                                                
                                                <td>{{$item->EmployeePosition}}</td>
                                                <td>{{$item->EmployeeDepartment}}</td>
                                                <td>{{$item->EmployeeBranch}}</td>
                                                <td>{{$item->personal_phone_number}}</td>
                                                <td>
                                                    <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->name }}</span>
                                                </td>
                                                <td>{{$item->EmployeePositionType}}</td>
                                                <td>$ <a href="#">{{$item->basic_salary}}</a></td>
                                                <td>$ <a href="#">{{$item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                <td>{{$item->DOB ?? ''}}</td>
                                                <td>{{$item->joinOfDate}}</td>
                                                <td>{{$item->ResignDates}}</td>
                                                <td>{{$item->EmployeeResignReason == null ? $item->resign_reason : $item->EmployeeResignReason}}</td>
                                                <td>
                                                    @if ($item->is_loan == '1')
                                                        <span style="font-size: 13px" class="badge bg-inverse-danger">Yes</span>
                                                    @elseif($item->is_loan == '0')
                                                        <span style="font-size: 13px" class="badge bg-inverse-success">No</span>
                                                    @else
                                                        
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown action-label">
                                                        @if ($item->emp_status=='3')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Resignation</span>
                                                        @elseif ($item->emp_status=='4')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Termination</span>
                                                        @elseif ($item->emp_status=='5')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Death</span>
                                                        @elseif ($item->emp_status=='6')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Retired</span>
                                                        @elseif ($item->emp_status=='7')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Lay off</span>
                                                        @elseif ($item->emp_status=='8')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Suspension</span>
                                                        @elseif ($item->emp_status=='9')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Fall Probation</span>
                                                        @elseif ($item->emp_status=='Cancel')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Cancel</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                        @if (Auth::user()->RolePermission == 'Administrator')
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                {{-- <a class="dropdown-item userUpdate" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a> --}}
                                                                <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
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
<div class="tab-pane show" id="tbl_reject" role="tabpanel">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table datatable dataTable no-footer tbl_reason"
                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">Profle</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">Employee ID</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(KH)</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">Name(EN)</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Position</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Department</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Branch</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">Contact Number</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Role</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Position Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Basic Salary</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Phone Allowance</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">Date Of Birth</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Join Date</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Resign Date</th>
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Resign Reason</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Loan</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Status</th>
                                        <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data)>0)
                                        @foreach ($data as $item)
                                            @if ($item->emp_status != "Upcoming" && $item->emp_status !="Cancel" && $item->emp_status != "Probation" && $item->emp_status != "1" && $item->emp_status != "2" && $item->emp_status != "10")
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
                                                    
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->name }}</span>
                                                    </td>
                                                    <td>{{$item->EmployeePositionType}}</td>
                                                    <td>$ <a href="#">{{$item->basic_salary}}</a></td>
                                                    <td>$ <a href="#">{{$item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->joinOfDate}}</td>
                                                    <td>{{$item->ResignDates}}</td>
                                                    <td>{{$item->EmployeeResignReason == null ? $item->resign_reason : $item->EmployeeResignReason}}</td>
                                                    <td>
                                                        @if ($item->is_loan == '1')
                                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Yes</span>
                                                        @elseif($item->is_loan == '0')
                                                            <span style="font-size: 13px" class="badge bg-inverse-success">No</span>
                                                        @else
                                                            
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown action-label">
                                                            @if ($item->emp_status=='3')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Resignation</span>
                                                            @elseif ($item->emp_status=='4')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Termination</span>
                                                            @elseif ($item->emp_status=='5')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Death</span>
                                                            @elseif ($item->emp_status=='6')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Retired</span>
                                                            @elseif ($item->emp_status=='7')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Lay off</span>
                                                            @elseif ($item->emp_status=='8')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Suspension</span>
                                                            @elseif ($item->emp_status=='9')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Fall Probation</span>
                                                            @elseif ($item->emp_status=='Cancel')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Cancel</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                            @if (Auth::user()->RolePermission == 'Administrator')
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    {{-- <a class="dropdown-item userUpdate" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a> --}}
                                                                    <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
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
@include('recruitments.candidate_resumes.print_signed_contract')
<script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>
<script src="{{asset('/admin/js/format-date-kh.js')}}"></script>
<script type="text/javascript">
    $(function(){
        var tab_status = 1;
        $("#tab_candidate_resume, #tab_probation, #tab_fdc, #tab_udc, #tab_reason, #tab_cancel").on("click", function() {
            tab_status = $(this).attr('data-tab-id');
        });
        $(".btn-search").on("click", function(){
            $(this).prop('disabled', true);
            $(".btn-search-txt").hide();
            $(".search-loading-icon").css('display', 'block');
            let filter = {
                number_employee: $("#number_employee").val(),
                employee_name: $("#employee_name").val(),
            };
            showDatabytab(tab_status, filter);
        });
        $(".btn_print").on("click", function (){
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('users/print')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    var data = response.success;
                    var date_of_birth = new Date(data.date_of_birth);
                    var date_of_commencement = new Date(data.date_of_commencement);
                    var fdc_date = new Date(data.fdc_date);
                    let day = formatDate( date_of_birth, 'km', format_date={day: true});
                    let month = formatDate( date_of_birth, 'km', format_date={month: true});
                    let year = formatDate( date_of_birth, 'km', format_date={year: true});
                    let join_day = formatDate( date_of_commencement, 'km', format_date={day: true});
                    let join_month = formatDate( date_of_commencement, 'km', format_date={month: true});
                    let join_year = formatDate( date_of_commencement, 'km', format_date={year: true});
                    let end_day = formatDate( fdc_date, 'km', format_date={day: true});
                    let end_month = formatDate( fdc_date, 'km', format_date={month: true});
                    let end_year = formatDate( fdc_date, 'km', format_date={year: true});
                    if (data) {
                        if (data.gender.name_english == "Female") {
                            $("#pr_mr_or_mrs").text("អ្នកស្រី ");
                            $("#pr_gender").text("ស្រី ");
                        }else{
                            $("#pr_mr_or_mrs").text("លោក ");
                            $("#pr_gender").text("ប្រុស ");
                        }
                        $("#pr_name").text(data.employee_name_kh +" ");
                        $("#pr_born_on").text(day+" ខែ "+month+" ឆ្នាំ "+ year);
                        $("#pr_permanent_province").text(data.permanentprovince.name_km + " ");
                        $("#pr_permanent_province").text(data.permanentprovince.name_km + " ");
                        $("#pr_id_card_number").text(data.id_card_number+ "");

                        let number_home = "";
                        let number_street = "";
                        if (data.current_house_no) {
                            number_home = "ផ្ទះលេខ "+ data.current_house_no;
                        }
                        if (data.current_street_no) {
                            number_street = " ផ្លូវលេខ "+data.current_street_no;
                        }
                        let location = number_home + number_street + " ភូមិ "+data.currentvillage.name_km + " ឃុំ/សង្កាត់ " + data.currentcommune.name_km + " ស្រុក/ខណ្ឌ " + data.currentdistrict.name_km+ " ខេត្ត/ក្រុង "+data.currentprovince.name_km;

                        $("#pr_current_location").text(location);

                        $("#pr_personal_phone_number").text(data.contact_number);
                        $(".pr_join_day").text(join_day);
                        $(".pr_join_month").text(join_month);
                        $(".pr_join_year").text(join_year);
                        $("#pr_end_day").text(end_day);
                        $("#pr_end_month").text(end_month);
                        $("#pr_end_year").text(end_year);
                        $("#pr_position").text(data.position.name_khmer);
                        $("#pr_branch").text(data.branch.branch_name_kh);
                        $("#pr_employee_id").text(data.number_employee);
                        $("#pr_basic_salary").text(data.basic_salary);
                        $("#pr_salary_increase").text($("#salary_to_increase").val());
                        if (data.positiontype.name_english == "Field Staff") {
                            $("#pr_supporting_or_field_staff").text("ដោយធៀបនិងភាគរយការងារសម្រេចបានសម្រាប់បុគ្គលិកឥណទាន (គិតតាម Pro-Rate) ដោយការបង់ពន្ធជូនរាជរដ្ឋាភិបាលជាបន្ទុករបស់និយោជិត");
                        }
                        print_pdf();
                    }
                }
            });
        });
    });
    function showDatabytab(tab, filter){
        let data = {
            "_token": "{{ csrf_token() }}",
        };
        if (tab == 1) {
            data.emp_status = "Upcoming";
        }else if (tab == 2) {
            data.emp_status = "Probation";
        }else if (tab == 3) {
            data.emp_status = 'FDC';
        }else if (tab == 4) {
            data.emp_status = "2";
        }else if (tab == 5) {
            data.emp_status = "resign_reason";
        }else if (tab == 6) {
            data.emp_status = "cancel";
        };
        data.employee_id = filter.number_employee ? filter.number_employee : null;
        data.employee_name = filter.employee_name ? filter.employee_name: null;
        $.ajax({
            type: "POST",
            url: "{{url('users')}}",
            data,
            dataType: "JSON",
            success: function (response) {
                $(".btn-search").prop('disabled', false);
                $(".btn-search-txt").show();
                $(".search-loading-icon").css('display', 'none');
                var data = response.data;
                var tr = '';
                if (data) {
                    data.map((emp) => {
                        let tag_a = '';
                        if (emp.profile != null) {
                            tag_a = '<a href="{{asset("/uploads/images")}}/'+(emp.profile)+'" class="avatar">'+
                                        '<img alt="" src="{{asset("/uploads/images")}}/'+(emp.profile)+'">'+
                                    '</a>';
                        }else {
                            tag_a = '<a href="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                    '<img alt="" src="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                '</a>';
                        };
                        let DOB = moment(emp.date_of_birth).format('D-MMM-YYYY')
                        let joinOfDate = moment(emp.date_of_commencement).format('D-MMM-YYYY')
                        let PassDate = moment(emp.fdc_date).format('D-MMM-YYYY')
                        let fdc_end = moment(emp.fdc_end).format('D-MMM-YYYY')
                        let is_loan = '';
                        if (emp.is_loan == 1) {
                            is_loan = '<span style="font-size: 13px" class="badge bg-inverse-danger">Yes</span>';
                        }else{
                            is_loan = '<span style="font-size: 13px" class="badge bg-inverse-success">No</span>';
                        };
                        let all_status ='';
                        let emp_status = "";
                        let status_color = "";
                        let td = "";
                        let btn_edit = '';
                        let resign_status_td ='<td>'+(emp.resign_status ? emp.resign_status.name_english : emp.resign_reason)+'</td>';
                        all_status = '<div class="dropdown-menu dropdown-menu-right btn-emp-status" id="btn-emp-status">'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="1" href="#">'+
                                '<i class="fa fa-dot-circle-o text-success"></i> FDC-1'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="12" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-success"></i> FDC-2'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="2" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-warning"></i> UDC'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="3" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Resignation'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="4" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Termination'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="5" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Death'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="6" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Retired'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="7" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Lay off'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="8" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Suspension'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="9" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Fall Probation'+
                                '</a>'+
                            '</div>';
                        if (emp.emp_status =="Upcoming") {
                            emp_status = emp.emp_status;
                            status_color = "text-success";
                            resign_status_td ="";
                            is_loan = "";
                            all_status = '<div class="dropdown-menu dropdown-menu-right btn-emp-status" id="btn-emp-status">'+
                                '<input type="text" name="" class="join_date" value="" hidden>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-id="Probation" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-success"></i> Probation'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-id="Cancel" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Cancel'+
                                '</a>'+
                            '</div>';
                            btn_edit = '<a class="dropdown-item userUpdate" data-id="'+(emp.id)+'"><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                        }else if (emp.emp_status == "Probation") {
                            emp_status = "Probation";
                            status_color = "text-success";
                            resign_status_td ="";
                            btn_edit = '<a class="dropdown-item userUpdate" data-id="'+(emp.id)+'"><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                        }else if(emp.emp_status == '1'){
                            emp_status = "FDC-1";
                            status_color = "text-info";
                            td = '<td>'+(fdc_end)+'</td>';
                            resign_status_td ="";
                            btn_edit = '<a class="dropdown-item userUpdate" data-id="'+(emp.id)+'"><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                        }else if(emp.emp_status == '10'){
                            emp_status = "FDC-2";
                            status_color = "text-info";
                            td = '<td>'+(fdc_end)+'</td>';
                            resign_status_td ="";
                            btn_edit = '<a class="dropdown-item userUpdate" data-id="'+(emp.id)+'"><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                        }else if(emp.emp_status == '2'){
                            emp_status = "UDC";
                            status_color = "text-danger";
                            resign_status_td ="";
                            all_status = '<div class="dropdown-menu dropdown-menu-right btn-emp-status" id="btn-emp-status">'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="3" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Resignation'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="4" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Termination'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="5" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Death'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="6" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Retired'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="7" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Lay off'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="8" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Suspension'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="9" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> Fall Probation'+
                                '</a>'+
                            '</div>';
                            btn_edit = '<a class="dropdown-item userUpdate" data-id="'+(emp.id)+'"><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                        }else if(emp.emp_status == '3'){
                            emp_status = "Resignation";
                            status_color = "text-danger";
                            all_status = "";
                        }else if(emp.emp_status == '4'){
                            emp_status = "Termination";
                            status_color = "text-danger";
                            all_status = "";
                        }else if(emp.emp_status == '5'){
                            emp_status = "Death";
                            status_color = "text-danger";
                            all_status = "";
                        }else if(emp.emp_status == '6'){
                            emp_status = "Retired";
                            status_color = "text-danger";
                            status_color = "text-danger";
                            all_status = "";
                        }else if(emp.emp_status == '7'){
                            emp_status = "Lay off";
                            status_color = "text-danger";
                        }else if(emp.emp_status == '8'){
                            emp_status = "Suspension";
                            status_color = "text-danger";
                            all_status = "";
                        }else if(emp.emp_status == '9'){
                            emp_status = "Fall Probation";
                            status_color = "text-danger";
                            all_status = "";
                        }else if(emp.emp_status == 'Cancel'){
                            emp_status = "Cancel";
                            status_color = "text-danger";
                            all_status = "";
                            is_loan = "";
                        };
                        let empStatus = '<div class="dropdown action-label">'+
                                        '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                            '<i class="fa fa-dot-circle-o '+(status_color)+'"></i>'+
                                            '<span>'+(emp_status)+'</span>'+
                                        '</a>'+
                                        (all_status)+
                                    '</div>';
                        if (all_status =="" && emp.emp_status !="Upcoming") {
                            empStatus = '<span style="font-size: 13px" class="badge bg-inverse-danger">'+(emp_status)+'</span>';
                        }

                        tr +='<tr class="odd">'+
                                '<td class="ids">'+(emp.id)+'</td>'+
                                '<td class="sorting_1">'+
                                    '<h2 class="table-avatar">'+
                                        (tag_a)+
                                    '</h2>'+
                                '</td>'+
                                '<td><a href="{{url("employee/profile")}}/'+(emp.id)+'">'+(emp.number_employee)+'</a></td>'+
                                '<td><a href="{{url("employee/profile")}}/'+(emp.id)+'">'+(emp.employee_name_kh)+'</a></td>'+
                                '<td><a href="{{url("employee/profile")}}/'+(emp.id)+'">'+(emp.employee_name_en)+'</a></td>'+
                                '<td>'+(emp.position ? emp.position.name_english: "")+'</td>'+
                                '<td>'+(emp.department ? emp.department.name_english: "")+'</td>'+
                                '<td>'+(emp.branch ? emp.branch.branch_name_en: "")+'</td>'+
                                '<td>'+(emp.personal_phone_number)+'</td>'+
                                '<td>'+
                                    '<span class="badge bg-inverse-success">'+(emp.role == null ? "" : emp.role.name )+'</span>'+
                                '</td>'+
                                '<td>'+(emp.positiontype ? emp.positiontype.name_english : "")+'</td>'+
                                '<td>$ <a href="#">'+(emp.basic_salary)+'</a></td>'+
                                '<td>$ <a href="#">'+(emp.phone_allowance == null ? '0.00' : emp.phone_allowance)+'</a></td>'+
                                '<td>'+(DOB)+'</td>'+
                                '<td>'+(joinOfDate)+'</td>'+
                                '<td>'+(PassDate)+'</td>'+
                                (td)+
                                (resign_status_td)+
                                '<td>'+
                                    (is_loan)+
                                '</td>'+
                                '<td>'+
                                    (empStatus)+
                                '</td>'+
                                '<td class="text-end">'+
                                    '<div class="dropdown dropdown-action">'+
                                        '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">'+
                                        '<i  class="material-icons">more_vert</i>'+
                                        '</a>'+
                                        '<div class="dropdown-menu dropdown-menu-right">'+
                                            (btn_edit)+
                                            '<a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="'+(emp.id)+'" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                        '</tr>';
                    });
                }else{
                    tr = '<tr><td colspan=19 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                };
                if (tab == 1) {
                    $(".tbl_signed_contract tbody").html(tr);
                }else if (tab == 2) {
                    $(".tbl_probation tbody").html(tr);
                }else if (tab == 3) {
                    $(".tbl_fdc tbody").html(tr);
                }else if (tab == 4) {
                    $(".tbl-udc tbody").html(tr);
                }else if (tab == 5) {
                    $(".tbl_reason tbody").html(tr);
                }else if (tab == 6) {
                    $(".tbl-cancel tbody").html(tr);
                };
            }
        });
    }
    function print_pdf(type) {
        $("#print_purchase").show();
        $("#print_purchase").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "/admin/css/style_table.css",
            header: "",
            printDelay: 1000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>