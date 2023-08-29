@extends('layouts.master')
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

        {{-- <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-solid nav-justified flex-column" role="tablist">
                            <li class="nav-item" role="presentation"><a class="nav-link active" data-bs-toggle="tab" href="#Personal" aria-selected="true" role="tab">Personal Informations</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="tab" href="#education" aria-selected="false" role="tab" tabindex="-1">Education Informations</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div id="Personal" class="tab-pane active show" role="tabpanel">
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <div class="title"><strong>Employee ID</strong></div>
                                        <label class="text">{{ $data->number_employee }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="title"><strong>Name Khmer</strong></div>
                                        <label class="text">{{ $data->employee_name_kh }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="title"><strong>Name English</strong></div>
                                        <label class="text">{{ $data->employee_name_en }}</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <div class="title"><strong>Gender</strong></div>
                                        <label class="text">{{ $data->gender == 1 ? 'Male' : 'Female' }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="title"><strong>Phone</strong></div>
                                        <label class="text">{{ $data->personal_phone_number }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="title"><strong>Date of Birth</strong></div>
                                        <label class="text">{{ \Carbon\Carbon::parse($data->date_of_birth)->format('d-M-Y') ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <div class="title"><strong>Email</strong></div>
                                        <label class="text">{{ $data->email }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="title"><strong>Position</strong></div>
                                        <label class="text">{{ $data->EmployeePosition }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="title"><strong>Departement</strong></div>
                                        <label class="text">{{ $data->EmployeeDepartment }}</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <div><strong>Join Date</strong></div>
                                        <label class="text">{{ $data->joinOfDate }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="title"><strong>Unit</strong></div>
                                        <label class="text">{{$data->unit}}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="title"><strong>Level</strong></div>
                                        <label class="text">{{ $data->level }}</label>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <div><strong>Nationality</strong></div>
                                        <label class="text">{{ $data->nationality }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="title"><strong>Position Type</strong></div>
                                        <label class="text">{{ $data->EmployeePositionType }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="title"><strong>Identity Type</strong></div>
                                        <label class="text">{{ $data->EmployeeIdentityType }}</label>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <div><strong>Identity Number</strong></div>
                                        <label class="text">{{ $data->identity_number }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="title"><strong>Issue Date</strong></div>
                                        <label class="text">{{ \Carbon\Carbon::parse($data->issue_date)->format('d-M-Y') ?? '' }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="title"><strong>Issue Expired Date</strong></div>
                                        <label class="text">{{ \Carbon\Carbon::parse($data->issue_expired_date)->format('d-M-Y') ?? '' }}</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <div class="title"><strong>Loan</strong></div>
                                        <label class="text">{{ $data->EmployeeIsLoan}}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div><strong>Marital Status</strong></div>
                                        <label class="text">{{ $data->marital_status }}</label>
                                    </div>
                                </div>
                            </div>
        
                            <div id="education" class="tab-pane fade" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>title</th>
                                                <th></th>
                                                <th>Sex</th>
                                                <th>Age</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        

        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    @if ($data->profile != null)
                                        <img alt="profile" src="{{ asset('/uploads/images/' . $data->profile) }}">
                                    @else
                                        <img alt="profile" src="{{ asset('admin/img/defuals/default-user-icon.png') }}">
                                    @endif
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0 mb-0">{{ $data->employee_name_en }}</h3>
                                            <h6 class="text-muted">{{ $data->EmployeeDepartment }}</h6>
                                            <small class="text-muted">{{ $data->EmployeePosition }}</small>
                                            <div class="staff-id">@lang('lang.employee_id') : {{ $data->number_employee }}</div>
                                            <div class="small doj text-muted">@lang('lang.join_date') : {{ $data->joinOfDate }}</div>
                                            <div class="small doj text-muted">@lang('lang.change_password') <a href="#" id="btn-change-password">@lang('lang.click_here')</a></div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">@lang('lang.personal_phone'):</div>
                                                <label class="text">{{ $data->personal_phone_number }}</label>
                                            </li>
                                            <li>
                                                <div class="title">@lang('lang.email'):</div>
                                                <label class="text">{{ $data->email }}</label>
                                            </li>
                                            <li>
                                                <div class="title">@lang('lang.birthday'):</div>
                                                <label class="text">{{ \Carbon\Carbon::parse($data->date_of_birth)->format('d-M-Y') ?? '' }}</label>
                                            </li>
                                            <li>
                                                <div class="title">@lang('lang.gender'):</div>
                                                <label class="text">{{ $data->gender == 1 ? 'Male' : 'Female' }}</label>
                                            </li>
                                            <li>
                                                <div class="title">@lang('lang.address'):</div>
                                                <label style="display: block;overflow: hidden;color: #888888;">{{ $data->FullCurrentAddress ?? '' }}</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card tab-box">
            <div class="row user-tabs">
                <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                    <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                        <li class="nav-item" role="presentation"><a href="#emp_profile" data-bs-toggle="tab" class="nav-link active" aria-selected="true" role="tab">@lang('lang.profile')</a></li>
                        <li class="nav-item" role="presentation"><a href="#document" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">@lang('lang.document')</a></li>
                        <li class="nav-item" role="presentation"><a href="#promote" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">@lang('lang.promoted')</a></li>
                        <li class="nav-item" role="presentation"><a href="#transferred" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">@lang('lang.transferred')</a></li>
                        <li class="nav-item" role="presentation"><a href="#training" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">@lang('lang.training')</a></li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="tab-content">
            <div id="emp_profile" class="pro-overview tab-pane fade show active" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">@lang('lang.personal_informations') </a></h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">@lang('lang.position_type')</div>
                                        <label class="text">{{ $data->EmployeePositionType }}</label>
                                    </li>
                                    <li>
                                        <div class="title">@lang('lang.identity_type')</div>
                                        <label class="text">{{ $data->EmployeeIdentityType }}</label>
                                    </li>
                                    <li>
                                        <div class="title">@lang('lang.identity_number')</div>
                                        <label class="text">{{ $data->identity_number }}</label>
                                    </li>
                                    <li>
                                        <div class="title">@lang('lang.issue_date')</div>
                                        <label class="text">{{ \Carbon\Carbon::parse($data->issue_date)->format('d-M-Y') ?? '' }}</label>
                                    </li>
                                    <li>
                                        <div class="title">@lang('lang.issue_expired_date')</div>
                                        <div class="text">{{ \Carbon\Carbon::parse($data->issue_expired_date)->format('d-M-Y') ?? '' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">@lang('lang.unit')</div>
                                        <label class="text">{{$data->unit}}</label>
                                    </li>
                                    <li>
                                        <div class="title">@lang('lang.level')</div>
                                        <label class="text">{{ $data->level }}</label>
                                    </li>
                                    <li>
                                        <div class="title">@lang('lang.nationality')</div>
                                        <label class="text">{{ $data->nationality }}</label>
                                    </li>
                                    <li>
                                        <div class="title">@lang('lang.marital_status')</div>
                                        <label class="text">{{ $data->marital_status }}</label>
                                    </li>
                                    <li>
                                        <div class="title">@lang('lang.loan')</div>
                                        @if ($data->is_loan == '1')
                                            <span style="font-size: 13px" class="badge bg-inverse-danger">Yes</span>
                                        @elseif($data->is_loan == '0')
                                            <span style="font-size: 13px" class="badge bg-inverse-success">No</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">@lang('lang.emergency_contact') <a href="" class="edit-icon" data-bs-toggle="modal" data-bs-target="#emergency_contact_modal"><i class="fa fa-pencil"></i></a></h3>
                                @if (count($contact)>0)
                                    @foreach ($contact as $item)
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Name</div>
                                                <div class="text">{{$item->name}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Relationship</div>
                                                <div class="text">{{$item->EmergencyContact}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Phone </div>
                                                <div class="text">{{$item->phone}},{{$item->phone_2}}</div>
                                            </li>
                                        </ul>
                                        <hr>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div id="emergency_contact_modal" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">@lang('lang.emergency_contact')</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('employee/contact')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('lang.name') <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('lang.relationship') <span class="text-danger">*</span></label>
                                                <select class="form-control @error('relationship') is-invalid @enderror" id="relationship" name="relationship" value="{{old('relationship')}}" required>
                                                    <option selected disabled value=""> -- @lang('lang.select') --</option>
                                                    @foreach ($relationship as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name_khmer }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('lang.phone') <span class="text-danger">*</span></label>
                                                <input class="form-control @error('phone') is-invalid @enderror" type="number" id="phone" name="phone" value="{{old('phone')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('lang.phone') 2</label>
                                                <input class="form-control" type="number" id="phone_2" name="phone_2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                                        <button class="btn btn-primary submit-btn">
                                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                            <span class="btn-txt">@lang('lang.submit')</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">@lang('lang.bank_information')</h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">@lang('lang.bank_name')</div>
                                        <div class="text">{{ $data->banks == null ? "" : $data->banks->name }}</div>
                                    </li>
                                    <li>
                                        <div class="title">@lang('lang.bank_account_no').</div>
                                        <div class="text">{{ $data->account_number }}</div>
                                    </li>
                                    <li>
                                        <div class="title">@lang('lang.account_name')</div>
                                        <label class="text">{{ $data->account_name }}</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">@lang('lang.children_informations') <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#family_info_modal"><i class="fa fa-pencil"></i></a></h3>
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.name')</th>
                                                <th>@lang('lang.date_of_birth')</th>
                                                <th>@lang('lang.gender')</th>
                                                <th>@lang('lang.age')</th>
                                                <th>@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($childrenInfor))
                                               @foreach ($childrenInfor as $item)
                                                <tr>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->DateofBirthChildren}}</td>
                                                    <td>{{$item->ChildrenGender}}</td>
                                                    <td>{{$item->YearsOfChildren}}</td>
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                            @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item childrenUpdate" data-id="{{$item->id}}" data-bs-target="#family_edit_info_modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                </div>
                                                            @endif
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

                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">@lang('lang.education_informations') <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#education_info"><i class="fa fa-pencil"></i></a></h3>
                                <div class="experience-box">
                                    <ul class="experience-list">
                                        @if (count($educations) > 0)
                                            @foreach ($educations as $item)
                                                <li>
                                                    <div class="experience-user">
                                                        <div class="before-circle"></div>
                                                    </div>
                                                    <div class="experience-content">
                                                        <div class="timeline-content">
                                                            <a href="#" class="name">{{ $item->EdcutionFieldOfStudy == null ? $item->school : $item->EdcutionFieldOfStudy}}</a>
                                                            <div>{{ $item->Edcutiondegree }}</div>
                                                            <span class="time">{{ $item->EducationStartDateEdnDate }}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">@lang('lang.experience_informations') <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#experience_info"><i class="fa fa-pencil"></i></a></h3>
                                <div class="experience-box">
                                    @if (count($experiences)>0)
                                        @foreach ($experiences as $item)
                                            <ul class="experience-list">
                                                <li>
                                                    <div class="experience-user">
                                                        <div class="before-circle"></div>
                                                    </div>
                                                    <div class="experience-content">
                                                        <div class="timeline-content">
                                                            <a href="#/" class="name">{{$item->position}} at {{$item->company_name}}</a>
                                                            <span class="time">{{$item->ExperienceStartDateEdnDate}}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Children information --}}
            @include('employees.childrens.modal_create_children')
            @include('employees.childrens.modal_edit_children')
        
            {{-- education_info --}}
            @include('employees.education_infos.education_info')
            
            {{-- experience_info --}}
            @include('employees.experience_infos.experience_info')

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
    @include('employees.change_password')
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
                    console.log(error.responseJSON);
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
                        $('#e_id').val(response.success.id);
                        $('#e_employee_id').val(response.success.employee_id);
                        $('#e_name').val(response.success.name);
                        $('#e_sex').val(response.success.sex);
                        $('#e_date_of_birth').val(response.success.date_of_birth);
                        $('#family_edit_info_modal').modal('show');
                    }
                }
            });
        });
    });
</script>
