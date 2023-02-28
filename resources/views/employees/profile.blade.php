@extends('layouts.master')
@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{ url('employee') }}">Profile</a></li>
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
                                        <a href="#">
                                            <img alt="" src="{{ asset('/uploads/images/' . $data->profile) }}">
                                        </a>
                                    @else
                                        <a href="#">
                                            <img alt="" src="{{ asset('admin/img/defuals/default-user-icon.png') }}">
                                        </a>
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
                                            <div class="staff-msg"><a class="btn btn-custom" href="">Send Message</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Phone:</div>
                                                <div class="text"><a href="">{{ $data->personal_phone_number }}</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Email:</div>
                                                <div class="text"><a href="">{{ $data->email }}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Birthday:</div>
                                                <div class="text">
                                                    {{ \Carbon\Carbon::parse($data->date_of_birth)->format('d-M-Y') ?? '' }}
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Gender:</div>
                                                <div class="text">{{ $data->gender == 1 ? 'Male' : 'FeMale' }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Address:</div>
                                                <div class="text">{{ $data->FullAddressEn ?? '' }}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="pro-edit"><a data-bs-target="#profile_info" data-bs-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
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
                                <h3 class="card-title">Personal Informations <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#personal_info_modal"><i class="fa fa-pencil"></i></a></h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Identity Type</div>
                                        <label for="">{{ $data->identity_type }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Identity Number</div>
                                        <label for="">{{ $data->identity_number }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Issue Date</div>
                                        <label for="">{{ $data->issue_date }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Issue Expired Date</div>
                                        <label for="">{{ $data->issue_expired_date }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Tel</div>
                                        <label for=""><a
                                                href="">{{ $data->personal_phone_number }}</a></label>
                                    </li>
                                    <li>
                                        <div class="title">Nationality</div>
                                        <label for="">{{ $data->nationality }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Marital status</div>
                                        <label for="">{{ $data->marital_status }}</label>
                                    </li>
                                    <li>
                                        <div class="title">No. of children</div>
                                        <label for="">{{ $data->number_of_children }}</label>
                                    </li>
                                    <li>
                                        <div class="title">Permanent Addtress</div>
                                        <label for="">{{ $data->FullPermanentAddress }}</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Emergency Contact <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#emergency_contact_modal"><i
                                            class="fa fa-pencil"></i></a></h3>
                                <h5 class="section-title">Primary</h5>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Name</div>
                                        <div class="text">John Doe</div>
                                    </li>
                                    <li>
                                        <div class="title">Relationship</div>
                                        <div class="text">Father</div>
                                    </li>
                                    <li>
                                        <div class="title">Phone </div>
                                        <div class="text">9876543210, 9876543210</div>
                                    </li>
                                </ul>
                                <hr>
                                <h5 class="section-title">Secondary</h5>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Name</div>
                                        <div class="text">Karen Wills</div>
                                    </li>
                                    <li>
                                        <div class="title">Relationship</div>
                                        <div class="text">Brother</div>
                                    </li>
                                    <li>
                                        <div class="title">Phone </div>
                                        <div class="text">9876543210, 9876543210</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Bank information</h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Bank name</div>
                                        <div class="text">{{ $data->bank_name }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Bank account No.</div>
                                        <div class="text">{{ $data->account_number }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Account Name</div>
                                        <div class="text">{{ $data->account_name }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Family Informations <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#family_info_modal"><i
                                            class="fa fa-pencil"></i></a></h3>
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Relationship</th>
                                                <th>Date of Birth</th>
                                                <th>Phone</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Leo</td>
                                                <td>Brother</td>
                                                <td>Feb 16th, 2019</td>
                                                <td>9876543210</td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a aria-expanded="false" data-bs-toggle="dropdown"
                                                            class="action-icon dropdown-toggle" href="#"><i
                                                                class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="#" class="dropdown-item"><i
                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a href="#" class="dropdown-item"><i
                                                                    class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
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
                                <h3 class="card-title">Education Informations <a href="#" class="edit-icon"
                                        data-bs-toggle="modal" data-bs-target="#education_info"><i
                                            class="fa fa-pencil"></i></a></h3>
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
                                                            <a href="#"
                                                                class="name">{{ $item->EdcutionFieldOfStudy }}</a>
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
                            <form>
                                {{-- @csrf --}}
                                <div class="form-scroll" id="btn_education">
                                    <div class="row" id="education-container-repeatable-elements">
                                        <div class="education-repeatable-element repeatable-element">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h3 class="card-title">Education Informations <a
                                                            href="javascript:void(0);"
                                                            class="delete-icon education-delete-element"><i
                                                                class="fa fa-trash-o"></i></a></h3>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-focus focused">
                                                                <input type="text" value="" id="school[]"
                                                                    name="school[]" class="form-control floating">
                                                                <label class="focus-label">Institution</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-focus focused">
                                                                <select class="form-control" id="field_of_study[]"
                                                                    name="field_of_study[]" value="">
                                                                    <option value="">select field of study</option>
                                                                    @foreach ($optionOfStudy as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->name_khmer }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-focus focused">
                                                                <div class="cal-icon">
                                                                    <input type="text" value=""
                                                                        name="start_date[]"
                                                                        class="form-control floating datetimepicker">
                                                                </div>
                                                                <label class="focus-label">Starting Date</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-focus focused">
                                                                <div class="cal-icon">
                                                                    <input type="text" value=""
                                                                        name="end_date[]"
                                                                        class="form-control floating datetimepicker">
                                                                </div>
                                                                <label class="focus-label">Complete Date</label>
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
                                    <a class="add-repeatable-element-button" id="btnAddEducation"><i
                                            class="fa fa-plus-circle"></i> Add More</button>
                                </div>
                                <div class="submit-section">
                                    <input type="hidden" name="employee_id" id="employee_id"
                                        value="{{ $data->id }}">
                                    <a href="#" class="btn btn-primary" id="bntEducation">Submit</a>
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
                            <form>
                                <div class="form-scroll">
                                    <div class="row" id="experience-container-repeatable-elements">
                                        <div class="card experience-repeatable-element">
                                            <div class="card-body">
                                                <h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon experience-delete-element"><i class="fa fa-trash-o"></i></a></h3>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus focused">
                                                            <input type="text" class="form-control floating" id="title[]" name="title[]" value="">
                                                            <label class="focus-label">Title</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus focused">
                                                            <input type="text" class="form-control floating" id="company_name[]" name="company_name[]" value="">
                                                            <label class="focus-label">Company Name</label>
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
                                                            <input type="text" class="form-control floating" id="position[]" name="position[]" value="">
                                                            <label class="focus-label">Job Position</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus focused">
                                                            <div class="">
                                                                <input type="text" class="form-control floating datetimepicker" id="start_date_experience[]" name="start_date_experience[]" value="">
                                                            </div>
                                                            <label class="focus-label">Period From</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus focused">
                                                            <div class="">
                                                                <input type="text" class="form-control floating datetimepicker" id="end_date_experience[]" name="end_date_experience[]" value="">
                                                            </div>
                                                            <label class="focus-label">Period To</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus focused">
                                                            <input type="text" class="form-control floating" id="location[]" name="location[]" value="">
                                                            <label class="focus-label">Location</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus focused">
                                                            <input type="text" class="form-control floating" id="description[]" name="description[]" value="">
                                                            <label class="focus-label">description</label>
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
                                    <input type="hidden" name="employee_id" id="employee_id"
                                        value="{{ $data->id }}">
                                    <a href="#" class="btn btn-primary" id="bntExperience">Submit</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="document" role="tabpanel">
                <div class="row">
                    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="project-title"><a href="">Guarantee Letter</a></h4>
                                <span class="text-xs">Preview guarantee letter click this link</span>
                                <a href="{{ url('uploads/images/', $data->guarantee_letter) }}" target="_blank">{{ $data->guarantee_letter }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="project-title"><a href="">Employment Book</a></h4>
                                <small class="block text-ellipsis m-b-15">
                                    <span class="text-xs">Preview employment book click this link</span>
                                </small>
                                <a href="{{ url('uploads/images/', $data->employment_book) }}" target="_blank">{{ $data->employment_book }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="promote" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">employee promoted</h3>
                        <form data-select2-id="select2-data-9-apez">
                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Position</label>
                            </div>
                            <div class="form-group">
                                <label>Promotion From <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" value="{{$data->EmployeePosition}}" readonly="">
                            </div>
                            <div class="form-group">
                                <label>Promotion To <span class="text-danger">*</span></label>
                                <select class="select" id="posit_id" name="posit_id">
                                    <option value="">Please selecte position</option>
                                    @if (count($position)>0)
                                        @foreach ($position as $item)
                                            <option value="{{$item->id}}">{{$item->name_khmer}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Department</label>
                            </div>
                            <div class="form-group">
                                <label>Promotion From <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" value="{{$data->EmployeeDepartment}}" readonly="">
                            </div>
                            <div class="form-group">
                                <label>Promotion To <span class="text-danger">*</span></label>
                                <select class="select" id="depart_id" name="depart_id">
                                    <option value="">Please selecte department</option>
                                    @if (count($department)>0)
                                        @foreach ($department as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Promotion Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" id="promote_date" name="promote_date" class="form-control datetimepicker">
                                </div>
                            </div>
                            <div class="submit-section">
                                <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                                <a href="#" class="btn btn-primary" id="bntEmpPromote">Submit</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="bank_statutory" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title"> Basic Salary Information</h3>
                        <form>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Salary basis <span
                                                class="text-danger">*</span></label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-1-rz5a" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-3-kj4f">Select salary basis type</option>
                                            <option>Hourly</option>
                                            <option>Daily</option>
                                            <option>Weekly</option>
                                            <option>Monthly</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Salary amount <small class="text-muted">per
                                                month</small></label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control"
                                                placeholder="Type your salary amount" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Payment type</label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-4-9wvp" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-6-w4a8">Select payment type</option>
                                            <option>Bank transfer</option>
                                            <option>Check</option>
                                            <option>Cash</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h3 class="card-title"> PF Information</h3>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">PF contribution</label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-7-5olp" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-9-dfst">Select PF contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">PF No. <span class="text-danger">*</span></label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-10-78yd" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-12-k8pv">Select PF contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Employee PF rate</label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-13-b077" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-15-avom">Select PF contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Additional rate <span
                                                class="text-danger">*</span></label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-16-27z9" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-18-8pn4">Select additional rate</option>
                                            <option>0%</option>
                                            <option>1%</option>
                                            <option>2%</option>
                                            <option>3%</option>
                                            <option>4%</option>
                                            <option>5%</option>
                                            <option>6%</option>
                                            <option>7%</option>
                                            <option>8%</option>
                                            <option>9%</option>
                                            <option>10%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Total rate</label>
                                        <input type="text" class="form-control" placeholder="N/A" value="11%">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Employee PF rate</label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-19-3dv9" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-21-susa">Select PF contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Additional rate <span
                                                class="text-danger">*</span></label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-22-5lnh" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-24-nc3j">Select additional rate</option>
                                            <option>0%</option>
                                            <option>1%</option>
                                            <option>2%</option>
                                            <option>3%</option>
                                            <option>4%</option>
                                            <option>5%</option>
                                            <option>6%</option>
                                            <option>7%</option>
                                            <option>8%</option>
                                            <option>9%</option>
                                            <option>10%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Total rate</label>
                                        <input type="text" class="form-control" placeholder="N/A" value="11%">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h3 class="card-title"> ESI Information</h3>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">ESI contribution</label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-25-t1lm" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-27-9e7b">Select ESI contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">ESI No. <span class="text-danger">*</span></label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-28-5tzz" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-30-q4mj">Select ESI contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Employee ESI rate</label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-31-8f3g" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-33-71qi">Select ESI contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Additional rate <span
                                                class="text-danger">*</span></label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-34-fcb7" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-36-s2z0">Select additional rate</option>
                                            <option>0%</option>
                                            <option>1%</option>
                                            <option>2%</option>
                                            <option>3%</option>
                                            <option>4%</option>
                                            <option>5%</option>
                                            <option>6%</option>
                                            <option>7%</option>
                                            <option>8%</option>
                                            <option>9%</option>
                                            <option>10%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Total rate</label>
                                        <input type="text" class="form-control" placeholder="N/A" value="11%">
                                    </div>
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
            $('.education-repeatable-element:first').clone().appendTo(
                '#education-container-repeatable-elements');
            var lastRepeatableElement = $('.education-repeatable-element:last');
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
        $('#bntEducation').on('click', function() {
            var employee_id = $("input[name='employee_id']").val();
            var school = $("input[name='school[]']").map(function() {
                return $(this).val();
            }).get();
            var field_of_study = $('select[name="field_of_study[]"]').map(function() {
                if ($(this).val()) return $(this).val();
            }).get();
            var degree = $('select[name="degree[]"]').map(function() {
                if ($(this).val()) return $(this).val();
            }).get();
            var start_date = $("input[name='start_date[]']").map(function() {
                return $(this).val();
            }).get();
            var end_date = $("input[name='end_date[]']").map(function() {
                return $(this).val();
            }).get();
            var grade = $("input[name='grade[]']").map(function() {
                return $(this).val();
            }).get();
            $.ajax({
                type: "POST",
                url: "/employee/education",
                data: {
                    "_token": "{{ csrf_token() }}",
                    employee_id: employee_id,
                    school: school,
                    field_of_study: field_of_study,
                    degree: degree,
                    start_date: start_date,
                    end_date: end_date,
                    grade: grade,
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Update education successfully.!',
                            'You clicked the button!',
                            'success'
                        )
                        window.location.reload();
                    }
                }
            });
        });

        $('#bntExperience').on('click',function(){
            var employee_id = $("input[name='employee_id']").val();
            var title = $("input[name='title[]']").map(function() {return $(this).val();}).get();
            var company_name = $("input[name='company_name[]']").map(function() {return $(this).val();}).get();
            var employment_type = $('select[name="employment_type[]"]').map(function() {if ($(this).val()) return $(this).val();}).get();
            var position = $("input[name='position[]']").map(function() {return $(this).val();}).get();
            var start_date_experience = $("input[name='start_date_experience[]']").map(function() {return $(this).val();}).get();
            var end_date_experience = $("input[name='end_date_experience[]']").map(function() {return $(this).val();}).get();
            var location = $("input[name='location[]']").map(function() {return $(this).val();}).get();
            var description = $("input[name='description[]']").map(function() {return $(this).val();}).get();
            $.ajax({
                type: "POST",
                url: "/employee/experience",
                data: {
                    "_token": "{{ csrf_token() }}",
                    employee_id: employee_id,
                    title : title,
                    company_name : company_name,
                    employment_type : employment_type,
                    position : position,
                    start_date_experience : start_date_experience,
                    end_date_experience : end_date_experience,
                    location : location,
                    description : description
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        Swal.fire(
                            'Update education successfully.!',
                            'You clicked the button!',
                            'success'
                        )
                        window.location.reload();
                    }
                }
            });
        });

        $('#bntEmpPromote').on('click',function(){
            var employee_id = $("#employee_id").val();
            var posit_id    = $("#posit_id").val();
            var depart_id    = $("#depart_id").val();
            var promote_date = $("#promote_date").val();

            $.ajax({
                type: "POST",
                url: "/employee/promote",
                data: {
                    "_token": "{{ csrf_token() }}",
                    employee_id     : employee_id,
                    posit_id        : posit_id,
                    depart_id       : depart_id,
                    promote_date    : promote_date
                },
                dataType: "JSON",
                success: function (response) {
                    toastr.success("Message here","Title here");
                }
            });
        });
    });
</script>
