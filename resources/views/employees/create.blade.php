@extends('layouts.master')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Employee</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a  href="{{url('/dashboad/employee')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/employee')}}">Employee</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div  class="card">
        <div class="row user-tabs">
            <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                    <li class="nav-item" role="presentation"><a href="#emp_profile" data-bs-toggle="tab" class="nav-link active" aria-selected="true" role="tab">Employee Info</a></li>
                    <li class="nav-item" role="presentation"><a href="#education" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">Education</a></li>
                    <li class="nav-item" role="presentation"><a href="#experience" data-bs-toggle="tab" class="nav-link" aria-selected="false" tabindex="-1" role="tab">Experience</a></li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div id="emp_profile" class="pro-overview tab-pane fade show active" role="tabpanel">
                <div class="card-body">
                    <form action="/employee" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Employee ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="number_employee" name="number_employee" value="{{$data['code']}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Name (KH) <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="employee_name_kh" name="employee_name_kh">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Name (EN) <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="employee_name_en" name="employee_name_en">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date Of Birth <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text" id="date_of_birth" name="date_of_birth">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Profile</label>
                                    <input class="form-control" type="file" id="profile" name="profile">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <select class="select" id="gender" name="gender">
                                        <option value="1">Male</option>
                                        <option value="2">FeMale</option>
                                        <option value="3">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Department <span class="text-danger">*</span></label>
                                    <select class="select" id="department_id" name="department_id">
                                        @foreach ($department as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Branch <span class="text-danger">*</span></label>
                                    <select class="select form-control" id="branch_id" name="branch_id">
                                        @foreach ($branch as $item)
                                            <option value="{{$item->id}}">{{$item->branch_name_kh}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Position <span class="text-danger">*</span></label>
                                    <select class="select" id="position_id" name="position_id">
                                        @foreach ($position as $item)
                                            <option value="{{$item->id}}">{{$item->name_khmer}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <input type="text" class="form-control" id="unit" name="unit">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>level</label>
                                    <input type="number" class="form-control" id="level" name="level">
                                </div>
                            </div>
                           
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Date Of Commencement <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" id="date_of_commencement" name="date_of_commencement" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Number Of Children</label>
                                    <input class="form-control" type="number" id="number_of_children" name="number_of_children">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Marital status</label>
                                    <select class="select" id="marital_status" name="marital_status">
                                        <option value="Married">Married</option>
                                        <option value="Single">Single</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nationality <span class="text-danger">*</span></label>
                                    <select class="select" id="nationality" name="nationality">
                                        <option value="Khmer">Khmer</option>
                                        <option value="Chinese">Chinese</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Guarantee Letter</label>
                                    <input class="form-control" type="file" id="guarantee_letter" name="guarantee_letter">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Employment Book</label>
                                    <input class="form-control" type="file" id="employment_book" name="employment_book">
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Remark</label>
                                    <textarea type="text" rows="3" class="form-control" name="remark" id="remark"></textarea>
                                </div>
                            </div>
        
                            {{-- <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Password</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Password</label>
                                    <input class="form-control" type="password" id="password" name="password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Confirm Password</label>
                                    <input class="form-control" type="password" id="password" name="password">
                                </div>
                            </div> --}}
                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Bank Info</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Bank Name</label>
                                    <input class="form-control" type="text" id="bank_name" name="bank_name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Account Name</label>
                                    <input class="form-control" type="text" id="account_name" name="account_name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Account Number</label>
                                    <input class="form-control" type="text" id="account_number" name="account_number">
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Contact Info</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Personal Phone</label>
                                    <input class="form-control" type="number" id="personal_phone_number" name="personal_phone_number">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Company Phone</label>
                                    <input class="form-control" type="number" id="company_phone_number" name="company_phone_number">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Agency Phone </label>
                                    <input class="form-control" type="number" id="agency_phone_number" name="agency_phone_number">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" id="email" name="email">
                                </div>
                            </div>
        
                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Identities</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Identity Type</label>
                                    <div class="form-group">
                                        <select class="select" id="identity_type" name="identity_type">
                                            <option value="1">Family Book</option>
                                            <option value="2">ID Card</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="">Identity Number</label>
                                    <input class="form-control" type="number" id="identity_number" name="identity_number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Issue Date</label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text" id="issue_date" name="issue_date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Issue Expired Date</label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text" id="issue_expired_date" name="issue_expired_date">
                                    </div>
                                </div>
                            </div>
        
                            <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                                <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Current Address</label>
                            </div>
                            @component('components.address')@endcomponent
                            
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
                            @component('components.address')@endcomponent
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
                                <a href="{{url('/employee')}}" class="btn btn-secondary">Cancel</a>
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="tab-pane fade" id="education" role="tabpanel">
                @component('fields.employee.education')
                @endcomponent
            </div>
            <div class="tab-pane fade" id="experience" role="tabpanel">
                @component('fields.employee.experience')
                @endcomponent
            </div>
        </div>        
    </div>
</div>
@endsection