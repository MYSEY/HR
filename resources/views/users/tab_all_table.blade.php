<div class="tab-pane active show" id="tab_candidate_resume" role="tabpanel">
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
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Month Get Severance Pay</th>
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
                                                    <td>{{$item->PassDate}}</td>
                                                    <td>{{$item->DayOfGetSeverancePay}}</td>
                                                    <td>
                                                        @if ($item->EmployeeIsLoan == 'Yes')
                                                            <a class="btn btn-white btn-sm" href="#" aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-success"></i>
                                                                <span>{{$item->EmployeeIsLoan}}</span>
                                                            </a>
                                                        @elseif($item->EmployeeIsLoan == 'No')
                                                            <a class="btn btn-white btn-sm" href="#" aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-danger"></i>
                                                                <span>{{$item->EmployeeIsLoan}}</span>
                                                            </a>
                                                        @else
                                                            
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown action-label">
                                                            @if ($item->emp_status=='Upcoming')
                                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-success"></i>
                                                                <span>{{ $item->emp_status }}</span>
                                                            </a>
                                                            @elseif ($item->emp_status=='Probation')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                                    <span>{{ $item->emp_status }}</span>
                                                                </a>
                                                            @endif
                                                            @if (Auth::user()->RolePermission == 'Administrator')
                                                                <div class="dropdown-menu dropdown-menu-right" id="btn-emp-status">
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-id="Probation" href="#">
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
<div class="tab-pane show" id="tab_short_list" role="tabpanel">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table datatable dataTable no-footer tbl-short-list"
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
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Month Get Severance Pay</th>
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
                                                    <td>{{$item->DayOfGetSeverancePay}}</td>
                                                    <td>
                                                        @if ($item->EmployeeIsLoan == 'Yes')
                                                            <a class="btn btn-white btn-sm" href="#" aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-success"></i>
                                                                <span>{{$item->EmployeeIsLoan}}</span>
                                                            </a>
                                                        @elseif($item->EmployeeIsLoan == 'No')
                                                            <a class="btn btn-white btn-sm" href="#" aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-danger"></i>
                                                                <span>{{$item->EmployeeIsLoan}}</span>
                                                            </a>
                                                        @else
                                                            
                                                        @endif
                                                    </td>
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
<div class="tab-pane show" id="tab_not_short_list" role="tabpanel">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table datatable dataTable no-footer tbl-not-short-list"
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
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Month Get Severance Pay</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Loan</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Status</th>
                                        <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data)>0)
                                        @foreach ($data as $item)
                                            @if ($item->emp_status == "1")
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
                                                    <td>{{$item->DayOfGetSeverancePay}}</td>
                                                    <td>
                                                        @if ($item->EmployeeIsLoan == 'Yes')
                                                            <a class="btn btn-white btn-sm" href="#" aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-success"></i>
                                                                <span>{{$item->EmployeeIsLoan}}</span>
                                                            </a>
                                                        @elseif($item->EmployeeIsLoan == 'No')
                                                            <a class="btn btn-white btn-sm" href="#" aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-danger"></i>
                                                                <span>{{$item->EmployeeIsLoan}}</span>
                                                            </a>
                                                        @else
                                                            
                                                        @endif
                                                    </td>
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
<div class="tab-pane show" id="tab_interviewed_result" role="tabpanel">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table datatable dataTable no-footer tbl-result"
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
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Month Get Severance Pay</th>
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
                                                    <td>{{$item->PassDate}}</td>
                                                    <td>{{$item->DayOfGetSeverancePay}}</td>
                                                    <td>
                                                        @if ($item->EmployeeIsLoan == 'Yes')
                                                            <a class="btn btn-white btn-sm" href="#" aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-success"></i>
                                                                <span>{{$item->EmployeeIsLoan}}</span>
                                                            </a>
                                                        @elseif($item->EmployeeIsLoan == 'No')
                                                            <a class="btn btn-white btn-sm" href="#" aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-danger"></i>
                                                                <span>{{$item->EmployeeIsLoan}}</span>
                                                            </a>
                                                        @else
                                                            
                                                        @endif
                                                    </td>
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
<div class="tab-pane show" id="tab_signed_contract" role="tabpanel">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table datatable dataTable no-footer tbl-signed-contract"
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
                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Month Get Severance Pay</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Loan</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">Status</th>
                                        <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data)>0)
                                        @foreach ($data as $item)
                                            @if ($item->emp_status != "Upcoming" && $item->emp_status != "Probation" && $item->emp_status != "1" && $item->emp_status != "2")
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
                                                    <td>{{$item->DayOfGetSeverancePay}}</td>
                                                    <td>
                                                        @if ($item->EmployeeIsLoan == 'Yes')
                                                            <a class="btn btn-white btn-sm" href="#" aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-success"></i>
                                                                <span>{{$item->EmployeeIsLoan}}</span>
                                                            </a>
                                                        @elseif($item->EmployeeIsLoan == 'No')
                                                            <a class="btn btn-white btn-sm" href="#" aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-danger"></i>
                                                                <span>{{$item->EmployeeIsLoan}}</span>
                                                            </a>
                                                        @else
                                                            
                                                        @endif
                                                    </td>
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