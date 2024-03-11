@if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'HR' || Auth::user()->RolePermission == 'developer')
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
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">@lang('lang.profile')</th>
                                            <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.kh'))</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.en'))</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.gender')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.date_of_birth')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.position_type')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">@lang('lang.contact_number')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.role_name')</th>
                                            @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.basic_salary')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.salary_increase')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.phone_allowance')</th>
                                            @endif
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.join_date')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Past Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.past_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.loan')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.status')</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data)>0)
                                            @foreach ($data as $key=>$item)
                                                <tr class="odd">
                                                    <td class="ids stuck-scroll-4">{{++$key ?? ''}}</td>
                                                    <td class="sorting_1 stuck-scroll-4">
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
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->number_employee}}</a></td>
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_kh}}</a></td>
                                                    <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_en}}</a></td>
                                                    <td>{{$item->EmployeeGender}}</td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->position == "" ? "" : $item->position->position_type}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->role_name }}</span>
                                                    </td>
                                                    @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                        <td>$<a href="#">{{$item->basic_salary}}</a></td>
                                                        <td>$<a href="#">{{$item->salary_increas == null ? '0.00' : $item->salary_increas}}</a></td>
                                                        <td>$<a href="#">{{$item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                    @endif
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
                                                        @if (permissionAccess("m2-s1","is_update")->value == "1")
                                                            <div class="dropdown action-label">
                                                                @if ($item->emp_status=='Upcoming')
                                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa fa-dot-circle-o text-success"></i>
                                                                        <span>{{ $item->emp_status }}</span>
                                                                    </a>
                                                                @endif
                                                                <div class="dropdown-menu dropdown-menu-right btn-emp-status" id="btn-emp-status">
                                                                    {{-- <input type="text" name="" class="join_date" value="{{$item == null ? "" : $item->date_of_commencement}}" hidden> --}}
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-join-date={{$item->date_of_commencement}} data-start-date="{{$item->fdc_date}}" data-id="Probation" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> @lang('lang.probation')
                                                                    </a>
                                                                    <a class="dropdown-item" data-emp-id="{{$item->id}}" data-id="Cancel" href="#">
                                                                        <i class="fa fa-dot-circle-o text-danger"></i> @lang('lang.cancel')
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                                <i class="fa fa-dot-circle-o text-success"></i> <span>{{ $item->emp_status }}</span>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        @if (permissionAccess("m2-s1","is_update")->value == "1" || permissionAccess("m2-s1","is_print")->value == "1" || permissionAccess("m2-s1","is_delete")->value == "1")
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if (permissionAccess("m2-s1","is_update")->value == "1")
                                                                        <a class="dropdown-item" href="{{url('user/form/edit',$item->id)}}" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                    @endif
                                                                    @if (permissionAccess("m2-s1","is_print")->value == "1")
                                                                        <a class="dropdown-item btn_print" data-id="{{$item->id}}"><i class="fa fa-print fa-lg m-r-5"></i> @lang('lang.print')</a>
                                                                    @endif
                                                                    @if (permissionAccess("m2-s1","is_delete")->value == "1")
                                                                        <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
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
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">@lang('lang.profile')</th>
                                            <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.kh'))</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.en'))</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.gender')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.date_of_birth')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.position_type')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">@lang('lang.contact_number')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.role_name')</th>
                                            @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.basic_salary')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.salary_increase')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.phone_allowance')</th>
                                            @endif
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.join_date')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.past_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.loan')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.status')</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataProbation)>0)
                                            @foreach ($dataProbation as $key=>$item)
                                                <tr class="odd">
                                                    <td class="ids stuck-scroll-4">{{++$key ?? ''}}</td>
                                                    <td class="sorting_1 stuck-scroll-4">
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
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->number_employee}}</a></td>
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_kh}}</a></td>
                                                    <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_en}}</a></td>
                                                    <td>{{$item->EmployeeGender}}</td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->position == "" ? "" : $item->position->position_type}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->role_name }}</span>
                                                    </td>
                                                    @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                        <td>$<a href="#">{{$item->basic_salary}}</a></td>
                                                        <td>$<a href="#">{{$item->salary_increas == null ? '0.00' : $item->salary_increas}}</a></td>
                                                        <td>$<a href="#">{{$item->phone_allowance == null ? '0.00' : number_format($item->phone_allowance,2)}}</a></td>
                                                    @endif
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
                                                                @if (permissionAccess("m2-s1","is_update")->value == "1")
                                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa fa-dot-circle-o text-success"></i>
                                                                        <span>{{ $item->emp_status }}</span>
                                                                    </a>
                                                                @else
                                                                    <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> <span>{{ $item->emp_status }}</span>
                                                                    </a>
                                                                @endif
                                                             @endif
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
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Lay Off
                                                                </a>
                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="8" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> No need to input
                                                                </a>
                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="9" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Failed Probation
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        @if (permissionAccess("m2-s1","is_update")->value == "1" || permissionAccess("m2-s1","is_delete")->value == "1")
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if (permissionAccess("m2-s1","is_update")->value == "1")
                                                                        <a class="dropdown-item" href="{{url('user/form/edit',$item->id)}}" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                    @endif
                                                                    @if (permissionAccess("m2-s1","is_delete")->value == "1")
                                                                        <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
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
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">@lang('lang.profile')</th>
                                            <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.kh'))</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.en'))</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.gender')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.date_of_birth')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.position_type')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">@lang('lang.contact_number')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.role_name')</th>
                                            @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.basic_salary')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.salary_increase')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.phone_allowance')</th>
                                            @endif
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.join_date')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.fdc_start_date')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.contract_deadline')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.loan')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.status')</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataFDC)>0)
                                            @foreach ($dataFDC as $key=>$item)
                                                <tr class="odd">
                                                    <td class="ids stuck-scroll-4">{{++$key ?? ""}}</td>
                                                    <td class="sorting_1 stuck-scroll-4">
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
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->number_employee}}</a></td>
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_kh}}</a></td>
                                                    <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_en}}</a></td>
                                                    <td>{{$item->EmployeeGender}}</td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->position == "" ? "" : $item->position->position_type}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->role_name }}</span>
                                                    </td>
                                                    @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                        <td>$<a href="#">{{$item->basic_salary}}</a></td>
                                                        <td>$<a href="#">{{$item->salary_increas == null ? '0.00' : $item->salary_increas}}</a></td>
                                                        <td>$<a href="#">{{$item->phone_allowance == null ? '0.00' : number_format($item->phone_allowance,2)}}</a></td>
                                                    @endif
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
                                                            @if (permissionAccess("m2-s1","is_update")->value == "1")
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
                                                            @else
                                                                @if ($item->emp_status=='1')
                                                                    <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> <span>FDC-{{ $item->emp_status }}</span>
                                                                    </a>
                                                                @elseif ($item->emp_status=='10')
                                                                    <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> <span>FDC-2</span>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                           
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
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Lay Off
                                                                </a>
                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="8" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> No need to input
                                                                </a>
                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="9" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Failed Probation
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        @if (permissionAccess("m2-s1","is_update")->value == "1" || permissionAccess("m2-s1","is_delete")->value == "1")
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if (permissionAccess("m2-s1","is_update")->value == "1")
                                                                        <a class="dropdown-item" href="{{url('user/form/edit',$item->id)}}" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                    @endif
                                                                    @if (permissionAccess("m2-s1","is_delete")->value == "1")
                                                                        <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
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
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">@lang('lang.profile')</th>
                                            <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.kh'))</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.en'))</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.gender')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.date_of_birth')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.position_type')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">@lang('lang.contact_number')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.role_name')</th>
                                            @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.basic_salary')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.salary_increase')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.phone_allowance')</th>
                                            @endif
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.join_date')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.udc_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.loan')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.status')</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataUDC)>0)
                                            @foreach ($dataUDC as $key=>$item)
                                                <tr class="odd">
                                                    <td class="ids stuck-scroll-4">{{++$key ?? ""}}</td>
                                                    <td class="sorting_1 stuck-scroll-4">
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
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->number_employee}}</a></td>
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_kh}}</a></td>
                                                    <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_en}}</a></td>
                                                    <td>{{$item->EmployeeGender}}</td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->position == "" ? "" : $item->position->position_type}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->role_name }}</span>
                                                    </td>
                                                    @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                    <td>$<a href="#">{{$item->basic_salary}}</a></td>
                                                    <td>$<a href="#">{{$item->salary_increas == null ? '0.00' : $item->salary_increas}}</a></td>
                                                    <td>$<a href="#">{{$item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                    @endif
                                                    <td>{{$item->joinOfDate}}</td>
                                                    <td>{{$item->UDCStartDate}}</td>
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
                                                            @if (permissionAccess("m2-s1","is_update")->value == "1")
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                                    <span>UDC</span>
                                                                </a>
                                                            @else
                                                                <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                                    <i class="fa fa-dot-circle-o text-success"></i> <span>UDC</span>
                                                                </a>
                                                            @endif
                                                            
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
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Lay Off
                                                                </a>
                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="8" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> No need to input
                                                                </a>
                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="9" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Failed Probation
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        @if (permissionAccess("m2-s1","is_update")->value == "1" || permissionAccess("m2-s1","is_delete")->value == "1")
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if (permissionAccess("m2-s1","is_update")->value == "1")
                                                                        <a class="dropdown-item" href="{{url('user/form/edit',$item->id)}}" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                    @endif
                                                                    @if (permissionAccess("m2-s1","is_delete")->value == "1")
                                                                        <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
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
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">@lang('lang.profile')</th>
                                            <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.kh'))</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.en'))</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.gender')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.date_of_birth')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.position_type')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">@lang('lang.contact_number')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.role_name')</th>
                                            @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.basic_salary')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.salary_increase')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.phone_allowance')</th>
                                            @endif
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.join_date')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.resign_date')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.resign_reason')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.loan')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.status')</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataCanContract)>0)
                                            @foreach ($dataCanContract as $key=>$item)
                                                <tr class="odd">
                                                    <td class="ids stuck-scroll-4">{{++$key ?? "" }}</td>
                                                    <td class="sorting_1 stuck-scroll-4">
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
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->number_employee}}</a></td>
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_kh}}</a></td>
                                                    <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_en}}</a></td>
                                                    <td>{{$item->EmployeeGender}}</td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->position == "" ? "" : $item->position->position_type}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->role_name }}</span>
                                                    </td>
                                                    @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                    <td>$<a href="#">{{$item->basic_salary}}</a></td>
                                                    <td>$<a href="#">{{$item->salary_increas == null ? '0.00' : $item->salary_increas}}</a></td>
                                                    <td>$<a href="#">{{$item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                    @endif
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
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Lay Off</span>
                                                            @elseif ($item->emp_status=='8')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">No need to input</span>
                                                            @elseif ($item->emp_status=='9')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Failed Probation</span>
                                                            @elseif ($item->emp_status=='Cancel')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Cancel</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        @if (permissionAccess("m2-s1","is_delete")->value == "1")
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    {{-- <a class="dropdown-item userUpdate" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a> --}}
                                                                    <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                </div>
                                                            </div>
                                                        @endif
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
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">@lang('lang.profile')</th>
                                            <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.kh'))</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.en'))</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.gender')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.date_of_birth')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.position_type')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">@lang('lang.contact_number')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.role_name')</th>
                                            @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.basic_salary')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.salary_increase')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.phone_allowance')</th>
                                            @endif
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.join_date')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.resign_date')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.resign_reason')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.loan')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.status')</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataResign)>0)
                                            @foreach ($dataResign as $key=>$item)
                                                <tr class="odd">
                                                    <td class="ids stuck-scroll-4">{{++$key ?? ""}}</td>
                                                    <td class="sorting_1 stuck-scroll-4">
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
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->number_employee}}</a></td>
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_kh}}</a></td>
                                                    <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_en}}</a></td>
                                                    <td>{{$item->EmployeeGender}}</td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->position == "" ? "" : $item->position->position_type}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->role_name }}</span>
                                                    </td>
                                                    @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                    <td>$<a href="#">{{$item->basic_salary}}</a></td>
                                                    <td>$<a href="#">{{$item->salary_increas == null ? '0.00' : $item->salary_increas}}</a></td>
                                                    <td>$<a href="#">{{$item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                    @endif
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
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Lay Off</span>
                                                            @elseif ($item->emp_status=='8')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">No need to input</span>
                                                            @elseif ($item->emp_status=='9')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Failed Probation</span>
                                                            @elseif ($item->emp_status=='Cancel')
                                                                <span style="font-size: 13px" class="badge bg-inverse-danger">Cancel</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        @if (permissionAccess("m2-s1","is_delete")->value == "1")
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    {{-- <a class="dropdown-item userUpdate" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a> --}}
                                                                    <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                </div>
                                                            </div>
                                                        @endif
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
@else
    <div class="tab-pane active show" id="tbl_probations" role="tabpanel">
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
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">@lang('lang.profile')</th>
                                            <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.kh'))</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.en'))</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.gender')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.date_of_birth')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.position_type')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">@lang('lang.contact_number')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.role_name')</th>
                                            @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.basic_salary')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.salary_increase')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.phone_allowance')</th>
                                            @endif
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.join_date')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.past_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.loan')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.status')</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataProbation)>0)
                                            @foreach ($dataProbation as $key=>$item)
                                                <tr class="odd">
                                                    <td class="ids stuck-scroll-4">{{++$key ?? ""}}</td>
                                                    <td class="sorting_1 stuck-scroll-4">
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
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->number_employee}}</a></td>
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_kh}}</a></td>
                                                    <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_en}}</a></td>
                                                    <td>{{$item->EmployeeGender}}</td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->position == "" ? "" : $item->position->position_type}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->role_name }}</span>
                                                    </td>
                                                    @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                    <td>$<a href="#">{{$item->basic_salary}}</a></td>
                                                    <td>$<a href="#">{{$item->salary_increas == null ? '0.00' : $item->salary_increas}}</a></td>
                                                    <td>$<a href="#">{{$item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                    @endif
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
                                                                @if (permissionAccess("m2-s1","is_update")->value == "1")
                                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa fa-dot-circle-o text-success"></i>
                                                                        <span>{{ $item->emp_status }}</span>
                                                                    </a>
                                                                @else
                                                                    <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> <span>{{ $item->emp_status }}</span>
                                                                    </a>
                                                                @endif
                                                            @endif
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
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Lay Off
                                                                </a>
                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="8" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> No need to input
                                                                </a>
                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="9" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Failed Probation
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        @if (permissionAccess("m2-s1","is_update")->value == "1" || permissionAccess("m2-s1","is_delete")->value == "1")
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if (permissionAccess("m2-s1","is_update")->value == "1")
                                                                        <a class="dropdown-item userUpdate" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                    @endif
                                                                    @if (permissionAccess("m2-s1","is_delete")->value == "1")
                                                                        <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
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
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">@lang('lang.profile')</th>
                                            <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.kh'))</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.en'))</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.gender')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.date_of_birth')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.position_type')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">@lang('lang.contact_number')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.role_name')</th>
                                            @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.basic_salary')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.salary_increase')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.phone_allowance')</th>
                                            @endif
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.join_date')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.fdc_start_date')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.contract_deadline')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.loan')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.status')</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataFDC)>0)
                                            @foreach ($dataFDC as $key=>$item)
                                                <tr class="odd">
                                                    <td class="ids stuck-scroll-4">{{++$key ?? ""}}</td>
                                                    <td class="sorting_1 stuck-scroll-4">
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
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->number_employee}}</a></td>
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_kh}}</a></td>
                                                    <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_en}}</a></td>
                                                    <td>{{$item->EmployeeGender}}</td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->position == "" ? "" : $item->position->position_type}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->role_name }}</span>
                                                    </td>
                                                    @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                    <td>$<a href="#">{{$item->basic_salary}}</a></td>
                                                    <td>$<a href="#">{{$item->salary_increas == null ? '0.00' : $item->salary_increas}}</a></td>
                                                    <td>$<a href="#">{{$item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                    @endif
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
                                                            @if (permissionAccess("m2-s1","is_update")->value == "1")
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
                                                            @else
                                                                @if ($item->emp_status=='1')
                                                                    <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> <span>FDC-{{ $item->emp_status }}</span>
                                                                    </a>
                                                                @elseif ($item->emp_status=='10')
                                                                    <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> <span>FDC-2</span>
                                                                    </a>
                                                                @endif
                                                            @endif
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
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Lay Off
                                                                </a>
                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="8" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> No need to input
                                                                </a>
                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="9" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Failed Probation
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        @if (permissionAccess("m2-s1","is_update")->value == "1" || permissionAccess("m2-s1","is_delete")->value == "1")
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if (permissionAccess("m2-s1","is_update")->value == "1")
                                                                        <a class="dropdown-item userUpdate" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                    @endif
                                                                    @if (permissionAccess("m2-s1","is_delete")->value == "1")
                                                                        <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
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
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">@lang('lang.profile')</th>
                                            <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.kh'))</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.en'))</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.gender')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.date_of_birth')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.position_type')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">@lang('lang.contact_number')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.role_name')</th>
                                            @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.basic_salary')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.salary_increase')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.phone_allowance')</th>
                                            @endif
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.join_date')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.udc_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.loan')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.status')</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataUDC)>0)
                                            @foreach ($dataUDC as $key=>$item)
                                                <tr class="odd">
                                                    <td class="ids stuck-scroll-4">{{++$key ?? ""}}</td>
                                                    <td class="sorting_1 stuck-scroll-4">
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
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->number_employee}}</a></td>
                                                    <td class="stuck-scroll-4"><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_kh}}</a></td>
                                                    <td><a href="{{route('employee.profile',$item->id)}}">{{$item->employee_name_en}}</a></td>
                                                    <td>{{$item->EmployeeGender}}</td>
                                                    <td>{{$item->DOB ?? ''}}</td>
                                                    <td>{{$item->EmployeeBranch}}</td>
                                                    <td>{{$item->EmployeeDepartment}}</td>
                                                    <td>{{$item->EmployeePosition}}</td>
                                                    <td>{{$item->position == "" ? "" : $item->position->position_type}}</td>
                                                    <td>{{$item->personal_phone_number}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success">{{ $item->role == null ? "" : $item->role->role_name }}</span>
                                                    </td>
                                                    @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                    <td>$<a href="#">{{$item->basic_salary}}</a></td>
                                                    <td>$<a href="#">{{$item->salary_increas == null ? '0.00' : $item->salary_increas}}</a></td>
                                                    <td>$<a href="#">{{$item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                    @endif
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
                                                                @if (permissionAccess("m2-s1","is_update")->value == "1")
                                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa fa-dot-circle-o text-dark"></i>
                                                                        <span>UDC</span>
                                                                    </a>
                                                                @else
                                                                    <a class="btn btn-white btn-sm btn-rounded" href="#">
                                                                        <i class="fa fa-dot-circle-o text-success"></i> <span>UDC</span>
                                                                    </a>
                                                                @endif
                                                            @endif
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
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Lay Off
                                                                </a>
                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="8" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> No need to input
                                                                </a>
                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}" data-start-date="{{$item->fdc_date}}" data-end-date="{{$item->fdc_end}}" data-id="9" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Failed Probation
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        @if (permissionAccess("m2-s1","is_update")->value == "1" || permissionAccess("m2-s1","is_delete")->value == "1")
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if (permissionAccess("m2-s1","is_update")->value == "1")
                                                                        <a class="dropdown-item userUpdate" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                    @endif
                                                                    @if (permissionAccess("m2-s1","is_delete")->value == "1")
                                                                        <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
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
@endif


@include('recruitments.candidate_resumes.print_signed_contract')
@include('components.loading-modal')
<script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>
<script src="{{asset('/admin/js/format-date-kh.js')}}"></script>
<script type="text/javascript">
    $(function(){
        var ref_this = $("ul.nav-tabs li a.active");
        var tab_status = ref_this.attr("data-tab-id");
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
            $('#modal-loading').modal('show');
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

                        $("#pr_personal_phone_number").text(data.personal_phone_number);
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
                        $("#pr_salary_increase").text(data.salary_increas);
                        if (data.positiontype.name_english == "Field Staff") {
                            $("#pr_supporting_or_field_staff").text("ដោយធៀបនិងភាគរយការងារសម្រេចបានសម្រាប់បុគ្គលិកឥណទាន (គិតតាម Pro-Rate) ដោយការបង់ពន្ធជូនរាជរដ្ឋាភិបាលជាបន្ទុករបស់និយោជិត");
                        }
                        print_pdf();
                    }
                }
            });
        });
        $(".btn-export").on("click", function (){
            var query = {
                number_employee: $("#number_employee").val(),
                employee_name: $("#employee_name").val(),
            }
            if (tab_status == 1) {
                query.emp_status = "Upcoming";
            }else if (tab_status == 2) {
                query.emp_status = "Probation";
            }else if (tab_status == 3) {
                query.emp_status = 'FDC';
            }else if (tab_status == 4) {
                query.emp_status = "2";
            }else if (tab_status == 5) {
                query.emp_status = "resign_reason";
            }else if (tab_status == 6) {
                query.emp_status = "cancel";
            };
            var url = "{{URL::to('users/export')}}?" + $.param(query)
            window.location = url;
        });
    });
    function showDatabytab(tab, filter){
        let is_update = "{{ Helper::permissionAccess('m2-s1','is_update') }}";
        let is_delete = "{{ Helper::permissionAccess('m2-s1','is_delete') }}";
        let is_view_salary = "{{ Helper::permissionAccess('m2-s1','is_view_salary') }}";
        var localeLanguage = '{{ config('app.locale') }}';
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
            data.emp_status = "Cancel";
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
                    let index = 0;
                    let btn_edit = '';
                    data.map((emp) => {
                        index++;
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
                       
                        let resign_status_td ='<td>'+(emp.resign_status ? emp.resign_status.name_english : emp.resign_reason)+'</td>';
                        all_status = '<div class="dropdown-menu dropdown-menu-right btn-emp-status" id="btn-emp-status">'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-Salary-Increase="'+(emp.salary_increas)+'" data-id="1" href="#">'+
                                '<i class="fa fa-dot-circle-o text-success"></i> FDC-1'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-end-date="'+(emp.fdc_end)+'" data-id="10" href="#">'+
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
                                    '<i class="fa fa-dot-circle-o text-success"></i> @lang("lang.probation")'+
                                '</a>'+
                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-id="Cancel" href="#">'+
                                    '<i class="fa fa-dot-circle-o text-danger"></i> @lang("lang.cancel")'+
                                '</a>'+
                            '</div>';
                            if (is_update == 1) {
                                btn_edit = '<a class="dropdown-item userUpdate" href="{{url("user/form/edit")}}/'+(emp.id)+'" data-id="'+(emp.id)+'"><i class="fa fa-pencil m-r-5"></i> @lang("lang.edit")</a>';
                            }
                        }else if (emp.emp_status == "Probation") {
                            emp_status = "Probation";
                            status_color = "text-success";
                            resign_status_td ="";
                            if (is_update == 1) {
                                btn_edit = '<a class="dropdown-item userUpdate" href="{{url("user/form/edit")}}/'+(emp.id)+'" data-id="'+(emp.id)+'"><i class="fa fa-pencil m-r-5"></i> @lang("lang.edit")</a>';
                            }
                        }else if(emp.emp_status == '1'){
                            emp_status = "FDC-1";
                            status_color = "text-info";
                            td = '<td>'+(fdc_end)+'</td>';
                            resign_status_td ="";
                            if (is_update == 1) {
                                btn_edit = '<a class="dropdown-item userUpdate" href="{{url("user/form/edit")}}/'+(emp.id)+'" data-id="'+(emp.id)+'"><i class="fa fa-pencil m-r-5"></i> @lang("lang.edit")</a>';
                            }
                        }else if(emp.emp_status == '10'){
                            emp_status = "FDC-2";
                            status_color = "text-info";
                            td = '<td>'+(fdc_end)+'</td>';
                            resign_status_td ="";
                            if (is_update == 1) {
                                btn_edit = '<a class="dropdown-item userUpdate" href="{{url("user/form/edit")}}/'+(emp.id)+'" data-id="'+(emp.id)+'"><i class="fa fa-pencil m-r-5"></i> @lang("lang.edit")</a>';
                            }
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
                            if (is_update == 1) {
                                btn_edit = '<a class="dropdown-item userUpdate" href="{{url("user/form/edit")}}/'+(emp.id)+'" data-id="'+(emp.id)+'"><i class="fa fa-pencil m-r-5"></i> @lang("lang.edit")</a>';
                            }
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
                        if (!is_update || is_update == 0) {
                            empStatus = '<a class="btn btn-white btn-sm btn-rounded" href="#">'+
                                            '<i class="fa fa-dot-circle-o '+(status_color)+'"></i>'+
                                            '<span>'+(emp_status)+'</span>'+
                                        '</a>';
                        }         
                        if (all_status =="" && emp.emp_status !="Upcoming") {
                            empStatus = '<span style="font-size: 13px" class="badge bg-inverse-danger">'+(emp_status)+'</span>';
                        }
                        let deleted = "";
                        if (is_delete == 1) {
                            deleted = '<a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="'+(emp.id)+'" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang("lang.delete")</a>';
                        }
                        let dropdown_action = "";
                        if (is_delete == 1 || is_update == 1) {
                            dropdown_action = '<div class="dropdown dropdown-action">'+
                                '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">'+
                                '<i  class="material-icons">more_vert</i>'+
                                '</a>'+
                                '<div class="dropdown-menu dropdown-menu-right">'+
                                    (btn_edit)+
                                    (deleted)+
                                '</div>'+
                            '</div>';
                        }
                        let basic_salary = "";
                        let salary_increas = "";
                        let phone_allowance = "";
                        if (is_view_salary == 1) {
                            basic_salary =    '<td>$ <a href="#">'+(emp.basic_salary)+'</a></td>';
                            salary_increas =  '<td>$ <a href="#">'+(emp.salary_increas)+'</a></td>';
                            phone_allowance = '<td>$ <a href="#">'+(emp.phone_allowance == null ? '0.00' : emp.phone_allowance)+'</a></td>';
                        }
                        tr +='<tr class="odd">'+
                                '<td class="ids stuck-scroll-4">'+(index)+'</td>'+
                                '<td class="sorting_1 stuck-scroll-4">'+
                                    '<h2 class="table-avatar">'+
                                        (tag_a)+
                                    '</h2>'+
                                '</td>'+
                                '<td class="stuck-scroll-4"><a href="{{url("employee/profile")}}/'+(emp.id)+'">'+(emp.number_employee)+'</a></td>'+
                                '<td class="stuck-scroll-4"><a href="{{url("employee/profile")}}/'+(emp.id)+'">'+(emp.employee_name_kh)+'</a></td>'+
                                '<td><a href="{{url("employee/profile")}}/'+(emp.id)+'">'+(emp.employee_name_en)+'</a></td>'+
                                '<td>'+(emp.gender ? localeLanguage == 'en'?  emp.gender.name_english : emp.gender.name_khmer : "")+'</td>'+
                                '<td>'+(DOB)+'</td>'+
                                '<td>'+(emp.branch ? localeLanguage == 'en' ? emp.branch.branch_name_en : emp.branch.branch_name_kh : "")+'</td>'+
                                '<td>'+(emp.department ? localeLanguage == 'en' ? emp.department.name_english :  emp.department.name_khmer : "")+'</td>'+
                                '<td>'+(emp.position ? localeLanguage == 'en' ? emp.position.name_english : emp.position.name_khmer : "")+'</td>'+
                                '<td>'+(emp.positiontype ? emp.positiontype.name_english : "")+'</td>'+
                                '<td>'+(emp.personal_phone_number)+'</td>'+
                                '<td>'+
                                    '<span class="badge bg-inverse-success">'+(emp.role == null ? "" : emp.role.role_name )+'</span>'+
                                '</td>'+
                                (basic_salary)+
                                (salary_increas)+
                                (phone_allowance)+
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
                                    (dropdown_action)+
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
        window.setTimeout(function() {
            $('#modal-loading').modal('hide');
        }, 2000);
        $("#print_purchase").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_table.css')}}",
            header: "",
            printDelay: 1000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>