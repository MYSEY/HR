@extends('layouts.master')
<style>
    .s-personal{
        margin-top: 10px;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">@lang('lang.profile')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active"><a href="{{ url('users') }}">@lang('lang.profile')</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card tab-box">
                    <div class="row card-body user-tabs">
                        <div class="col-10 col-md-12">
                            <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                                <li class="nav-item" role="presentation"><a href="#emp_profile" data-bs-toggle="tab" class="nav-link active" aria-selected="true" role="tab">@lang('lang.profile')</a></li>
                                <li class="nav-item" role="presentation"><a href="#document" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">@lang('lang.document')</a></li>
                                <li class="nav-item" role="presentation"><a href="#promote" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">@lang('lang.promoted')</a></li>
                                <li class="nav-item" role="presentation"><a href="#transferred" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">@lang('lang.transferred')</a></li>
                                <li class="nav-item" role="presentation"><a href="#training" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">@lang('lang.training')</a></li>
                            </ul>
                        </div>

                        <div class="tab-content col-md-12">
                            <div id="emp_profile" class="pro-overview tab-pane fade show active" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 d-flex">
                                        <div class="profile-box flex-fill">
                                            <div class="row">
                                                <h3 class="card-title">@lang('lang.personal_informations')</h3>
                                                <div class="row">
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.name')(@lang('lang.kh'))</a>
                                                            <div class="s-personal">{{ $data->employee_name_kh}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.name')(@lang('lang.en'))</a>
                                                            <div class="s-personal">{{ $data->employee_name_en}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.employee_id')</a>
                                                            <div class="s-personal">{{ $data->number_employee }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.date_of_birth')</a>
                                                            <div class="s-personal">{{ \Carbon\Carbon::parse($data->date_of_birth)->format('d-M-Y') ?? '' }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.gender')</a>
                                                            <div class="s-personal">{{$data->EmployeeGender}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.id_card_number')</a>
                                                            <div class="s-personal">{{$data->id_card_number}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.department')</a>
                                                            <div class="s-personal">{{ $data->EmployeeDepartment }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.position')</a>
                                                            <div class="s-personal">{{$data->EmployeePosition}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.branch')</a>
                                                            <div class="s-personal">{{$data->EmployeeBranch}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.join_date')</a>
                                                            <div class="s-personal">{{ $data->joinOfDate }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.nationality')</a>
                                                            <div class="s-personal">{{$data->EmployeeNationality}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.ethnicity')</a>
                                                            <div class="s-personal">{{$data->ethnicity}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.province')</a>
                                                            <div class="s-personal">{{ $data->FullNameProvince }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.unit')</a>
                                                            <div class="s-personal">{{$data->unit}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.level')</a>
                                                            <div class="s-personal">{{$data->level}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.identity_type')</a>
                                                            <div class="s-personal">{{ $data->EmployeeIdentityType }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.identity_number')</a>
                                                            <div class="s-personal">{{$data->identity_number}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.issue_date')</a>
                                                            <div class="s-personal">{{\Carbon\Carbon::parse($data->issue_date)->format('d-M-Y') ?? ''}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.issue_expired_date')</a>
                                                            <div class="s-personal">{{ \Carbon\Carbon::parse($data->issue_expired_date)->format('d-M-Y') ?? '' }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.marital_status')</a>
                                                            <div class="s-personal">{{$data->EmployeeMaritalStatus}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.loan')</a>
                                                            <div class="s-personal">
                                                                @if ($data->is_loan == '1')
                                                                    <span style="font-size: 13px" class="badge bg-inverse-danger">Yes</span>
                                                                @elseif($data->is_loan == '0')
                                                                    <span style="font-size: 13px" class="badge bg-inverse-success">No</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.personal_phone')</a>
                                                            <div class="s-personal">{{$data->personal_phone_number}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.company_phone_number')</a>
                                                            <div class="s-personal">{{$data->company_phone_number}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.email')</a>
                                                            <div class="s-personal">{{ $data->email }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.bank_name')</a>
                                                            <div class="s-personal">{{$data->banks == null ? "" : $data->banks->name }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.bank_account_no')</a>
                                                            <div class="s-personal">{{$data->account_number}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.account_name')</a>
                                                            <div class="s-personal">{{ $data->account_name }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-md-8">
                                                        <div class="mb-3">
                                                            <a href="#">@lang('lang.current_address')</a>
                                                            <div class="s-personal">{{$data->FullCurrentAddress ?? ''}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            {{-- document --}}
                            @include('employees.contacts.create')
                            @include('employees.contacts.edit')
                            {{-- End document --}}
                            {{-- Children information --}}
                            @include('employees.childrens.modal_create_children')
                            @include('employees.childrens.modal_edit_children')
                        
                            {{-- education_info --}}
                            @include('employees.education_infos.education_create')
                            @include('employees.education_infos.education_edite')
                            
                            {{-- experience_info --}}
                            @include('employees.experience_infos.experience_create')
                            @include('employees.experience_infos.experience_edite')
                
                            {{-- document --}}
                            @include('employees.documents.document')
                            {{-- End document --}}
                
                            {{-- promote --}}
                            @include('employees.promotes.promote')
                            {{-- End promote --}}
                
                            {{-- Transferred --}}
                            @include('employees.Transferreds.transferred')
                            {{-- end Transferred --}}
                
                            {{-- Training --}}
                            @include('employees.Trainings.training')
                            {{-- End Training --}}
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">@lang('lang.emergency_contact')</h3>
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.name')</th>
                                                <th>@lang('lang.relationship')</th>
                                                <th>@lang('lang.phone1')</th>
                                                <th>@lang('lang.phone2')</th>
                                                <th>@lang('lang.created_at')</th>
                                                <th style="text-align: center">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($contact))
                                                @foreach ($contact as $item)
                                                    <tr>
                                                        <td hidden class="ids">{{$item->id}}</td>
                                                        <td>{{$item->name}}</td>
                                                        <td>{{$item->EmergencyContact}}</td>
                                                        <td>{{$item->phone}}</td>
                                                        <td>{{$item->phone_2}}</td>
                                                        <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? ''}}</td>
                                                        <td style="text-align: center">
                                                            @if (permissionAccess("m2-s1","is_update")->value == "1" || permissionAccess("m2-s1","is_delete")->value == "1")
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        @if (permissionAccess("m2-s1","is_update")->value == "1")
                                                                            <a class="dropdown-item contactUpdate" data-id="{{$item->id}}" data-bs-target="#contact_modal"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                        @endif
                                                                        @if (permissionAccess("m2-s1","is_delete")->value == "1")
                                                                            <a class="dropdown-item contactDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_contact"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
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

                    <div class="col-md-12 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">@lang('lang.children_informations')</h3>
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.name')</th>
                                                <th>@lang('lang.date_of_birth')</th>
                                                <th>@lang('lang.gender')</th>
                                                <th>@lang('lang.age')</th>
                                                <th>@lang('lang.created_at')</th>
                                                <th style="text-align: center">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($childrenInfor))
                                                @foreach ($childrenInfor as $item)
                                                    <tr>
                                                        <td hidden class="ids">{{$item->id}}</td>
                                                        <td>{{$item->name}}</td>
                                                        <td>{{$item->DateofBirthChildren}}</td>
                                                        <td>{{$item->ChildrenGender}}</td>
                                                        <td>{{$item->YearsOfChildren}}</td>
                                                        <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? ''}}</td>
                                                        <td style="text-align: center">
                                                            @if (permissionAccess("m2-s1","is_update")->value == "1" || permissionAccess("m2-s1","is_delete")->value == "1")
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        @if (permissionAccess("m2-s1","is_update")->value == "1" )
                                                                        <a class="dropdown-item childrenUpdate" data-id="{{$item->id}}" data-bs-target="#family_edit_info_modal"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                        @endif
                                                                        @if (permissionAccess("m2-s1","is_delete")->value == "1" )
                                                                        <a class="dropdown-item childrenDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_children"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
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
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">@lang('lang.education_informations')</h3>
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.date')</th>
                                                <th>@lang('lang.institution')</th>
                                                <th>@lang('lang.field_of_study')</th>
                                                <th>@lang('lang.degree')</th>
                                                <th>@lang('lang.created_at')</th>
                                                <th style="text-align: center">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($educations))
                                                @foreach ($educations as $item)
                                                    <tr>
                                                        <td hidden class="ids">{{$item->id}}</td>
                                                        <td>{{$item->EducationStartDateEdnDate}}</td>
                                                        <td>{{$item->school}}</td>
                                                        <td>{{$item->EdcutionFieldOfStudy}}</td>
                                                        <td>{{$item->Edcutiondegree}}</td>
                                                        <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? ''}}</td>
                                                        <td style="text-align: center">
                                                            @if (permissionAccess("m2-s1","is_update")->value == "1" || permissionAccess("m2-s1","is_delete")->value == "1")
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        @if (permissionAccess("m2-s1","is_update")->value == "1" )
                                                                            <a class="dropdown-item educationUpdate" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                        @endif
                                                                        @if (permissionAccess("m2-s1","is_delete")->value == "1" )
                                                                            <a class="dropdown-item educationDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_education"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
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

                    <div class="col-md-12 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">@lang('lang.experience_informations')</h3>
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.date')</th>
                                                <th>@lang('lang.company_name')</th>
                                                <th>@lang('lang.employment_type')</th>
                                                <th>@lang('lang.job_position')</th>
                                                <th>@lang('lang.location')</th>
                                                <th>@lang('lang.created_at')</th>
                                                <th style="text-align: center">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($experiences))
                                                @foreach ($experiences as $item)
                                                    <tr>
                                                        <td hidden class="ids">{{$item->id}}</td>
                                                        <td>{{$item->ExperienceStartDateEdnDate}}</td>
                                                        <td>{{$item->company_name}}</td>
                                                        <td>{{$item->EmpEmploymentType}}</td>
                                                        <td>{{$item->position}}</td>
                                                        <td>{{$item->location}}</td>
                                                        <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? ''}}</td>
                                                        <td style="text-align: center">
                                                            @if (permissionAccess("m2-s1","is_update")->value == "1" || permissionAccess("m2-s1","is_delete")->value == "1")
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        @if (permissionAccess("m2-s1","is_update")->value == "1" )
                                                                            <a class="dropdown-item experienceUpdate" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                        @endif
                                                                        @if (permissionAccess("m2-s1","is_delete")->value == "1" )
                                                                            <a class="dropdown-item experienceDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_experience"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if ($data->profile != null)
                                    <img alt="profile" src="{{ asset('/uploads/images/' . $data->profile) }}">
                                @else
                                    <img alt="profile" src="{{ asset('admin/img/defuals/default-user-icon.png') }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>  
                
                {{-- @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer') --}}
                    <div class="card">
                        <div class="card-body">
                            <a href="#" class="btn btn-success" style="background-color: #99000a" data-bs-toggle="modal" data-bs-target="#emergency_contact_modal">@lang('lang.emergency_contact')</a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <a href="#" class="btn btn-success" style="background-color: #99000a" data-bs-toggle="modal" data-bs-target="#education_info">@lang('lang.education_informations') </a>
                        </div>   
                    </div> 
                    <div class="card">
                        <div class="card-body">
                            <a href="#" class="btn btn-success" style="background-color: #99000a" data-bs-toggle="modal" data-bs-target="#experience_info">@lang('lang.experience_informations') </a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <a href="#" class="btn btn-success" style="background-color: #99000a" data-bs-toggle="modal" data-bs-target="#family_info_modal">@lang('lang.children_informations') </a>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <a href="#" class="btn btn-success" style="background-color: #99000a" id="btn-change-password">@lang('lang.change_password')</a>
                        </div>
                    </div> 
                {{-- @endif --}}
            </div>
        </div>
        {!! Toastr::message() !!}
    </div>
    @include('employees.change_password')

    <!-- Delete Transferrend Modal -->
        <div class="modal custom-modal fade" id="delete_children" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('employee/children/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_child_id" value="">
                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">Delete</button>
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-secondary btn-cancel">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Delete Transferrend Modal -->

    <!-- Delete Contact Modal -->
    <div class="modal custom-modal fade" id="delete_contact" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('employee/contact/delete')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" class="e_contact_id" value="">
                            <div class="row">
                                <div class="submit-section" style="text-align: center">
                                    <button type="submit" class="btn btn-primary submit-btn me-2">Delete</button>
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-secondary btn-cancel">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Contact Modal -->

    <!-- Delete education Modal -->
    <div class="modal custom-modal fade" id="delete_education" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('employee/education/delete')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" class="e_education_id" value="">
                            <div class="row">
                                <div class="submit-section" style="text-align: center">
                                    <button type="submit" class="btn btn-primary submit-btn me-2">Delete</button>
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-secondary btn-cancel">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete education Modal -->
    <!-- Delete experience Modal -->
    <div class="modal custom-modal fade" id="delete_experience" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('employee/experience/delete')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" class="e_experience_id" value="">
                            <div class="row">
                                <div class="submit-section" style="text-align: center">
                                    <button type="submit" class="btn btn-primary submit-btn me-2">Delete</button>
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-secondary btn-cancel">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete experience Modal -->
@endsection

@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{asset('/admin/js/noty.js')}}"></script>
<script>
  
    $(function() {

        $("#btn-change-password").on("click", function(){
            $("#modal_change_password").modal("show");
        });
        $('#btnAddEducation').on('click', function() {
            $('.education-repeatable-element:first').clone().appendTo('#education-container-repeatable-elements');
            var lastRepeatableElement = $('.education-repeatable-element:last');
            var input = lastRepeatableElement.find('input');
            var textarea = lastRepeatableElement.find('textarea');
            var select = lastRepeatableElement.find('select');
            input.val('');
            textarea.val('');
            select.prop('selectedIndex', 0)
        });
        $('#btnAddBenefit').on('click', function() {
            $('.information:first').clone().appendTo('#benefit-information');
            var lastRepeatableElement = $('.benefits information:last');
            var input = lastRepeatableElement.find('input');
            var textarea = lastRepeatableElement.find('textarea');
            var select = lastRepeatableElement.find('select');
            input.val('');
            textarea.val('');
            select.prop('selectedIndex', 0)
        });
        $('body').on('click', '.education-delete-element', function() {
            if ($('.education-repeatable-element').length > 1) {
                $(this).closest('.education-repeatable-element').remove();
            }
        });
        $('body').on('click', '#btn-add-experience', function() {
            $('.experience-repeatable-element:first').clone().appendTo('#experience-container-repeatable-elements');
            var lastRepeatableElement = $('.experience-repeatable-element:last');
            var input = lastRepeatableElement.find('input');
            var textarea = lastRepeatableElement.find('textarea');
            var select = lastRepeatableElement.find('select');
            input.val('');
            textarea.val('');
            select.prop('selectedIndex', 0)
        });
        
        $('body').on('click', '.experience-delete-element', function() {
            if ($('.experience-repeatable-element').length > 1) {
                $(this).closest('.experience-repeatable-element').remove();
            }
        });

        $('body').on('click', '#btn-add-children', function() {
            $('.children-repeatable-element:first').clone().appendTo('#children-container-repeatable-elements');
            var lastRepeatableElement = $('.children-repeatable-element:last');
            var input = lastRepeatableElement.find('input');
            var textarea = lastRepeatableElement.find('textarea');
            var select = lastRepeatableElement.find('select');
            input.val('');
            textarea.val('');
            select.prop('selectedIndex', 0)
        });
        $('body').on('click', '.children-delete-element', function() {
            if ($('.children-repeatable-element').length > 1) {
                $(this).closest('.children-repeatable-element').remove();
            }
        });
        $('.childrenDelete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_child_id').val(_this.find('.ids').text());
        });
        $('.contactDelete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_contact_id').val(_this.find('.ids').text());
        });
        $('.educationDelete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_education_id').val(_this.find('.ids').text());
        });
        $('.experienceDelete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_experience_id').val(_this.find('.ids').text());
        });

        $("#btn-change-passwork").on("click", function() {
            const currentUrl = window.location.pathname.split('/');
            let num_miss = 0;
            $(".emp_required").each(function(){
                if($(this).val()==""){ 
                    num_miss++;
                    $(this).css("border-color", "#dc3545");
                }else{
                    $(this).css("border-color", "#e3e3e3");
                }
            });
            if (num_miss > 0) {
                return false;
            }
            $.ajax({
                type: "post",
                url: "{{url('employee/change-password')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    number_employee : $("#number_employee_id").val(),
                    current_password : $("#current_password").val(),
                    new_password : $("#new_password").val(),
                    comfirm_password : $("#comfirm_password").val(),
                },
                dataType: "JSON",
                success: function (response) {
                    new Noty({
                        text: response.message,
                        type: "success",
                        timeout: 3000,
                        icon: true
                    }).show();
                    window.location.replace("{{ URL('employee/profile') }}/"+currentUrl[3]);
                },
                error: function(error) {
                    new Noty({
                        text: error.responseJSON.message,
                        type: "error",
                        timeout: 3000,
                        icon: true
                    }).show();
                }
            });
        });

        $('.childrenUpdate').on('click',function(){
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('employee/children/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        $('#e_child_id').val(response.success.id);
                        $('#e_employee_id').val(response.success.employee_id);
                        $('#e_name_children').val(response.success.name);
                        $('#e_sex').val(response.success.sex);
                        $('#e_date_of_birth').val(response.success.date_of_birth);
                        $('#family_edit_info_modal').modal('show');
                    }
                }
            });
        });

        $('.educationUpdate').on('click',function(){
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('employee/education/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        $('#e_field_of_study').html('<option selected disabled> -- @lang("lang.select") --</option>');
                        $.each(response.optionOfStudy, function(i, item) {
                            $('#e_field_of_study').append($('<option>', {
                                value: item.id,
                                text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                selected: item.id == response.success.field_of_study
                            }));
                        });

                        $('#e_degree').html('<option selected disabled> -- @lang("lang.select") --</option>');
                        $.each(response.optionDegree, function(i, item) {
                            $('#e_degree').append($('<option>', {
                                value: item.id,
                                text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                selected: item.id == response.success.degree
                            }));
                        });
                        
                        $('#e_education_id').val(response.success.id);
                        $('#e_edu_employee_id').val(response.success.employee_id);
                        $('#e_school').val(response.success.school);
                        $('#e_grade').val(response.success.grade);
                        $('#e_start_date').val(response.success.start_date);
                        $('#e_end_date').val(response.success.end_date);
                        $('#education_edite').modal('show');
                    }
                }
            });
        });
        $('.experienceUpdate').on('click',function(){
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('employee/experience/edite')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        
                        $('#e_employment_type').html('<option selected disabled> -- @lang("lang.select") --</option>');
                        $.each(response.EmploymentType, function(i, item) {
                            $('#e_employment_type').append($('<option>', {
                                value: item.id,
                                text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                selected: item.id == response.success.employment_type
                            }));
                        });
                        $('#e_experience_id').val(response.success.id);
                        $('#e_ex_employee_id').val(response.success.employee_id);
                        $('#e_company_name').val(response.success.company_name);
                        $('#e_position').val(response.success.position);
                        $('#e_start_date_experience').val(response.success.start_date);
                        $('#e_end_date_experience').val(response.success.end_date);
                        $('#e_location').val(response.success.location);
                        $('#experience_edite').modal('show');
                    }
                }
            });
        });
        $('.contactUpdate').on('click',function(){
            var localeLanguage = '{{ config('app.locale') }}';
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('employee/contact/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        if (response.relationship != '') {
                            $('#e_relationship').html('<option selected disabled> -- @lang("lang.select") --</option>');
                            $.each(response.relationship, function(i, item) {
                                $('#e_relationship').append($('<option>', {
                                    value: item.id,
                                    text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                    selected: item.id == response.success.relationship
                                }));
                            });
                        }
                        $('#e_contact_id').val(response.success.id);
                        $('#e_name').val(response.success.name);
                        $('#e_phone').val(response.success.phone);
                        $('#e_phone_2').val(response.success.phone_2);
                        $('#emergency_contact_modal_update').modal('show');
                    }
                }
            });
        });
    });
</script>
