@extends('layouts.master')
@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{ url('users') }}">Profile</a></li>
                    </ul>
                </div>
            </div>
        </div>

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
                                            <div class="staff-id">Employee ID : {{ $data->number_employee }}</div>
                                            <div class="small doj text-muted">Date of Join : {{ $data->joinOfDate }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Phone:</div>
                                                <label class="text">{{ $data->personal_phone_number }}</label>
                                            </li>
                                            <li>
                                                <div class="title">Email:</div>
                                                <label class="text">{{ $data->email }}</label>
                                            </li>
                                            <li>
                                                <div class="title">Birthday:</div>
                                                <label class="text">{{ \Carbon\Carbon::parse($data->date_of_birth)->format('d-M-Y') ?? '' }}</label>
                                            </li>
                                            <li>
                                                <div class="title">Gender:</div>
                                                <label class="text">{{ $data->gender == 1 ? 'Male' : 'Female' }}</label>
                                            </li>
                                            <li>
                                                <div class="title">Address:</div>
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
                        <li class="nav-item" role="presentation"><a href="#emp_profile" data-bs-toggle="tab" class="nav-link active" aria-selected="true" role="tab">Profile</a></li>
                        <li class="nav-item" role="presentation"><a href="#document" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">Document</a></li>
                        <li class="nav-item" role="presentation"><a href="#promote" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">Promoted</a></li>
                        <li class="nav-item" role="presentation"><a href="#transferred" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">Transferred</a></li>
                        <li class="nav-item" role="presentation"><a href="#training" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">Training</a></li>
                        <li class="nav-item" role="presentation"><a href="#bank_statutory" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">Bank &amp; Statutory <small class="text-danger">(Admin Only)</small></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div id="emp_profile" class="pro-overview tab-pane fade show active" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Personal Informations </a></h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Bank Name</div>
                                        <label class="text">{{ $data->bank_name }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Bank Account No.</div>
                                        <label class="text">{{ $data->account_number }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Account Name</div>
                                        <label class="text">{{ $data->account_name }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Identity Type</div>
                                        <label class="text">{{ $data->EmployeeIdentityType }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Identity Number</div>
                                        <label class="text">{{ $data->identity_number }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Issue Date</div>
                                        <label class="text">{{ \Carbon\Carbon::parse($data->issue_date)->format('d-M-Y') ?? '' }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Issue Expired Date</div>
                                        <div class="text">{{ \Carbon\Carbon::parse($data->issue_expired_date)->format('d-M-Y') ?? '' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Unit</div>
                                        <label class="text">{{$data->unit}}</label>
                                    </li>
                                    <li>
                                        <div class="title">Level</div>
                                        <label class="text">{{ $data->level }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Nationality</div>
                                        <label class="text">{{ $data->nationality }}</label>
                                    </li>
                                    <li>
                                        <div class="title">No. of children</div>
                                        <label class="text">{{ $data->number_of_children }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Marital status</div>
                                        <label class="text">{{ $data->marital_status }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Permanent Addtress</div>
                                        <label style="display: block;overflow: hidden;color: #888888;">{{ $data->FullPermanentAddress }}</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Emergency Contact <a href="" class="edit-icon" data-bs-toggle="modal" data-bs-target="#emergency_contact_modal"><i class="fa fa-pencil"></i></a></h3>
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
                                <h5 class="modal-title">Personal Information</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('employee/contact')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relationship <span class="text-danger">*</span></label>
                                                <select class="form-control select" id="relationship" name="relationship" value="">
                                                    <option value="">select relationship</option>
                                                    @foreach ($relationship as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name_khmer }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="phone" name="phone" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone 2</label>
                                                <input class="form-control" type="text" id="phone_2" name="phone_2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                                        <button class="btn btn-primary submit-btn">Submit</button>
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
                                <h3 class="card-title">Education Informations <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#education_info"><i class="fa fa-pencil"></i></a></h3>
                                <div class="experience-box">
                                    <ul class="experience-list">
                                        @if (count($data->educations) > 0)
                                            @foreach ($data->educations as $item)
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
                                <h3 class="card-title">Experience <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#experience_info"><i class="fa fa-pencil"></i></a></h3>
                                <div class="experience-box">
                                    @if (count($data->experiences)>0)
                                        @foreach ($data->experiences as $item)
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
            {!! Toastr::message() !!}

            {{-- education_info --}}
            <div id="education_info" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{url('/employee/education')}}" method="POST">
                                @csrf
                                <div class="form-scroll" id="educationModal">
                                    <div class="row" id="education-container-repeatable-elements">
                                        <div class="education-repeatable-element repeatable-element">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon education-delete-element"><i class="fa fa-trash-o"></i></a></h3>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-focus focused">
                                                                <input type="text" value="" id="school[]" name="school[]" class="form-control floating" required>
                                                                <label class="focus-label">Institution <span class="text-danger">*</span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-focus focused">
                                                                <select class="form-control" id="field_of_study[]" name="field_of_study[]" value="">
                                                                    <option value="">select field of study</option>
                                                                    @foreach ($optionOfStudy as $item)
                                                                        <option value="{{ $item->id }}">{{ $item->name_khmer }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-focus focused">
                                                                <div class="cal-icon">
                                                                    <input type="text" value="" name="start_date[]" class="form-control floating datetimepicker" required>
                                                                </div>
                                                                <label class="focus-label">Starting Date <span class="text-danger">*</span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-focus focused">
                                                                <div class="cal-icon">
                                                                    <input type="text" value="" name="end_date[]" class="form-control floating datetimepicker" required>
                                                                </div>
                                                                <label class="focus-label">Complete Date <span class="text-danger">*</span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-focus focused">
                                                                <select class="form-control" id="degree[]"
                                                                    name="degree[]" value="">
                                                                    <option value="">select degree</option>
                                                                    @foreach ($optionDegree as $item)
                                                                        <option value="{{ $item->id }}">{{ $item->name_khmer }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-focus focused">
                                                                <input type="text" value="" id="grade[]"
                                                                    name="grade[]" class="form-control floating">
                                                                <label class="focus-label">Grade</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-more">
                                    <a class="add-repeatable-element-button" id="btnAddEducation"><i class="fa fa-plus-circle"></i> Add More</button>
                                </div>
                                <div class="submit-section">
                                    <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                                    <button type="submit" class="btn btn-primary" id="bntEducation">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- experience_info --}}
            <div id="experience_info" class="modal custom-modal fade" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{url('/employee/experience')}}" method="POST">
                                @csrf
                                <div class="form-scroll" id="experienceModal">
                                    <div class="row" id="experience-container-repeatable-elements">
                                        <div class="card experience-repeatable-element">
                                            <div class="card-body">
                                                <h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon experience-delete-element"><i class="fa fa-trash-o"></i></a></h3>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus focused">
                                                            <input type="text" class="form-control floating" id="company_name[]" name="company_name[]" value="" required>
                                                            <label class="focus-label">Company Name <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus focused">
                                                            <select class="select" id="employment_type[]" name="employment_type[]">
                                                                <option value="1">Full-Time</option>
                                                                <option value="2">Path-Time</option>
                                                            </select>
                                                            <label class="focus-label">Employment Type</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus focused">
                                                            <input type="text" class="form-control floating" id="position[]" name="position[]" value="" required>
                                                            <label class="focus-label">Job Position <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus focused">
                                                            <div class="">
                                                                <input type="text" class="form-control floating datetimepicker" id="start_date_experience[]" name="start_date_experience[]" value="" required>
                                                            </div>
                                                            <label class="focus-label">Period From <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus focused">
                                                            <div class="">
                                                                <input type="text" class="form-control floating datetimepicker" id="end_date_experience[]" name="end_date_experience[]" value="" required>
                                                            </div>
                                                            <label class="focus-label">Period To <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus focused">
                                                            <input type="text" class="form-control floating" id="location[]" name="location[]" value="">
                                                            <label class="focus-label">Location</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-more">
                                        <a href="javascript:void(0);" id="btn-add-experience"><i class="fa fa-plus-circle"></i> Add More</a>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                                    <button type="submit" class="btn btn-primary" id="bntExperience">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- document --}}
            <div class="tab-pane fade" id="document" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="project-title"><a href="">Guarantee Letter</a></h4>
                                <small class="block text-ellipsis m-b-15">
                                    <span class="text-xs">Preview guarantee letter click this <a href="{{ url('uploads/images/', $data->guarantee_letter) }}" target="_blank">link</a></span>
                                </small>
                                <embed src="{{url('uploads/images/', $data->guarantee_letter)}}" style="width:100%; height:100%;">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="project-title"><a href="">Employment Book</a></h4>
                                @if ($data->employment_book !=null)
                                    <small class="block text-ellipsis m-b-15">
                                        <span class="text-xs">Preview employment book click this <a href="{{ url('uploads/images/', $data->employment_book) }}" target="_blank">link</a></span>
                                    </small>
                                    <embed src="{{url('uploads/images/', $data->employment_book)}}" style="width:100%; height:100%;">
                                @else
                                    <span class="text-xs">Preview employment book not found</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End document --}}

            {{-- promote --}}
            <div class="tab-pane fade" id="promote" role="tabpanel">
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Promotion <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#PromotionModal"><i class="fa fa-pencil"></i></a></h3>
                            <div class="table-responsive">
                                <table class="table table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Department From</th>
                                            <th>Department To</th>
                                            <th>Position from</th>
                                            <th>Position To</th>
                                            <th>Promotion Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($empPromoted)>0)
                                            @foreach ($empPromoted as $item)   
                                                <tr>
                                                    <td>{{$item->id}}</td>
                                                    <td>{{$item->depart_id}}</td>
                                                    <td style="color:#26AF49">
                                                        {{$item->department_promoted_to}}
                                                    </td>
                                                    <td>{{$item->posit_id}}</td>
                                                    <td style="color:#26AF49">{{$item->position_promoted_to}}</td>
                                                    <td>{{$item->PormotDate}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <td colspan="7" style="text-align: center">No record to display</td>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="PromotionModal" class="modal custom-modal fade" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('/employee/promote')}}" method="POST" data-select2-id="select2-data-9-apez">
                                    @csrf
                                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Position</label>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Promotion From</label>
                                        @if (count($empPromoted) > 0)
                                            <input class="form-control" type="text" id="posit_id" name="posit_id" value="{{$empPromoted[0]->department_promoted_to}}" readonly="">
                                        @else
                                            <input class="form-control" type="text" id="posit_id" name="posit_id" value="{{$data->EmployeePosition}}" readonly="">
                                        @endif

                                    </div>
                                    <div class="form-group">
                                        <label>Promotion To <span class="text-danger">*</span></label>
                                        <select class="select" id="position_promoted_to" name="position_promoted_to" required>
                                            <option value="">Please selecte position</option>
                                            @if (count($position)>0)
                                                @foreach ($position as $item)
                                                    <option value="{{$item->name_khmer}}">{{$item->name_khmer}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
        
                                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Department</label>
                                    </div>
                                    <div class="form-group">
                                        <label>Promotion From</label>
                                        <input class="form-control" type="text" id="depart_id" name="depart_id" value="{{$data->EmployeeDepartment}}" readonly="">
                                    </div>
                                    <div class="form-group">
                                        <label>Promotion To <span class="text-danger">*</span></label>
                                        <select class="select" id="department_promoted_to" name="department_promoted_to" required>
                                            <option value="">Please selecte department</option>
                                            @if (count($department)>0)
                                                @foreach ($department as $item)
                                                    <option value="{{$item->name_khmer}}">{{$item->name_khmer}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Promotion Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input type="text" id="promote_date" name="promote_date" class="form-control datetimepicker" required>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                                        <button type="submit" class="btn btn-primary" id="bntEmpPromote">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End promote --}}

            {{-- Transferred --}}
            <div class="tab-pane fade" id="transferred" role="tabpanel">
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Transferred <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#TransferrendModal"><i class="fa fa-pencil"></i></a></h3>
                            <div class="table-responsive">
                                <table class="table table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Branch</th>
                                            <th>Date</th>
                                            <th>Descrition</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($transferred)>0)
                                            @foreach ($transferred as $item)
                                                <tr>
                                                    <td>{{$item->id}}</td>
                                                    <td>{{$item->BranchName}}</td>
                                                    <td>{{$item->TransterDate}}</td>
                                                    <td>{{$item->descrition}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <td colspan="4" style="text-align: center">No record to display</td>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="TransferrendModal" class="modal custom-modal fade" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('/employee/transferred')}}" method="POST" data-select2-id="select2-data-9-apez">
                                    @csrf
                                    <div class="form-group">
                                        <label>Branch<span class="text-danger">*</span></label>
                                        <select class="select" id="branch_id" name="branch_id" required>
                                            <option value="">Please selecte branch</option>
                                            @if (count($branch)>0)
                                                @foreach ($branch as $item)
                                                    <option value="{{$item->id}}">{{$item->branch_name_kh}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Transferred Date</label>
                                        <div class="cal-icon">
                                            <input type="text" id="date" name="date" class="form-control datetimepicker">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Descrition</label>
                                        <textarea class="form-control" rows="4" spellcheck="false" id="descrition" name="descrition" style="position: relative;"></textarea>
                                    </div>
                                    <div class="submit-section">
                                        <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                                        <button type="submit" class="btn btn-primary" id="bntEmpPromote">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end Transferred --}}

            {{-- Training --}}
            <div class="tab-pane fade" id="training" role="tabpanel">
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Training <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#TrainingModal"><i class="fa fa-pencil"></i></a></h3>
                            <div class="table-responsive">
                                <table class="table table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Descrition</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($training)>0)
                                            @foreach ($training as $item)
                                                <tr>
                                                    <td>{{$item->id}}</td>
                                                    <td>{{$item->title}}</td>
                                                    <td>{{$item->TrainingStartDate}}</td>
                                                    <td>{{$item->TrainingStartEndDate}}</td>
                                                    <td>{{$item->descrition}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <td colspan="5" style="text-align: center">No record to display</td>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="TrainingModal" class="modal custom-modal fade" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('/employee/training')}}" method="POST" data-select2-id="select2-data-9-apez">
                                    @csrf
                                    <div class="form-group">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input type="text" id="title" name="title" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Start Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input type="text" id="start_date" name="start_date" class="form-control datetimepicker" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>End Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input type="text" id="end_date" name="end_date" class="form-control datetimepicker" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Descrition</label>
                                        <textarea class="form-control" rows="4" spellcheck="false" id="descrition" name="descrition" style="position: relative;"></textarea>
                                    </div>
                                    <div class="submit-section">
                                        <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                                        <button type="submit" class="btn btn-primary" id="bntEmpPromote">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Training --}}

            <div class="tab-pane fade" id="bank_statutory" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title"> Basic Salary Information</h3>
                        <form>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Basic Salary</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" id="salary" name="salary" placeholder="Type your salary amount" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Total rate</label>
                                        <input type="text" class="form-control" id="" name="" placeholder="" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">New Salary</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" id="new_salary" name="new_salary" placeholder="new salary amount" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Total work day</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="total_work_day" name="total_work_day" placeholder="" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h3 class="card-title"> Benefits Information</h3>

                            <div id="benefit-information">
                                <div class="row information">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="" value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Amount</label>
                                            <input type="text" class="form-control" id="amount" name="amount" placeholder="" value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-4" style="padding-top: 45px;">
                                        <div class="form-group">
                                            <a class="btn btn-success btn-sm" id="btnAddBenefit"><i class="fa fa-plus-circle"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="khmer_new_year" value="khmer_new_year">
                                    <label class="form-check-label" for="khmer_new_year">Khmer new year bonus</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="pchumBen_bonus" value="pchumBen_bonus">
                                    <label class="form-check-label" for="pchumBen_bonus">PchumBen Bonus</label>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" type="submit">Save</button>
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
    $(function() {
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
    });
</script>
