@extends('layouts.master')
<style>
    .card_background_color{
        background-color: #f8f9fa !important;
    }
</style>
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.edit_employee')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.edit_employee')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-pane fade active show" id="bank_statutory" role="tabpanel">
        <div class="card card_background_color">
            <div class="card-body">
                <form action="{{url('users/update')}}" method="POST" enctype="multipart/form-data"  class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-img-wrap edit-img">
                                <img class="inline-block" id="blah" src="#" alt="user">
                                <div class="fileupload btn">
                                    <span class="btn-text">@lang('lang.edit_profile')</span>
                                    <input class="upload" type="file" name="profile" id="profile">
                                    <input type="hidden" name="hidden_image" id="e_profile" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">@lang('lang.last_name') (@lang('lang.kh'))<span
                                        class="text-danger">*</span></label>
                                <input class="form-control @error('last_name_kh') is-invalid @enderror" type="text"
                                    id="e_last_name_kh" required name="last_name_kh"
                                    value="{{ old('last_name_kh') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">@lang('lang.first_name') (@lang('lang.kh'))<span
                                        class="text-danger">*</span></label>
                                <input class="form-control @error('first_name_kh') is-invalid @enderror" type="text"
                                    id="e_first_name_kh" required name="first_name_kh"
                                    value="{{ old('first_name_kh') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">@lang('lang.employee_id')</label>
                                <input type="text" class="form-control" id="e_number_employee" name="number_employee" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">@lang('lang.last_name') (@lang('lang.en'))<span
                                        class="text-danger">*</span></label>
                                <input class="form-control @error('last_name_en') is-invalid @enderror" type="text"
                                    id="e_last_name_en" required name="last_name_en"
                                    value="{{ old('last_name_en') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">@lang('lang.first_name') (@lang('lang.en'))<span
                                        class="text-danger">*</span></label>
                                <input class="form-control @error('first_name_en') is-invalid @enderror" type="text"
                                    id="e_first_name_en" required name="first_name_en"
                                    value="{{ old('first_name_en') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.role_name')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option requered @error('role_id') is-invalid @enderror" name="role_id" id="e_role_id" required>
                                    <option selected disabled value=""> --@lang('lang.select')--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.gender')</label>
                                <select class="form-control select floating" id="e_gender" name="gender">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.date_of_birth') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" type="text" id="e_date_of_birth" required name="date_of_birth" value="{{old('date_of_birth')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.join_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker  @error('date_of_commencement') is-invalid @enderror" id="e_date_of_commencement" required name="date_of_commencement" type="text" value="{{old('date_of_commencement')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.branch')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option" id="e_branch_id" name="branch_id" value="{{old('branch_id')}}">
                                    <option selected disabled value=""> -- @lang('lang.select') --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.department')</label>
                                <select class="form-control hr-select2-option" name="department_id" id="e_department">
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.position') <span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option @error('position_id') is-invalid @enderror" name="position_id" id="e_position" required>
                                    <option selected disabled value=""> -- @lang('lang.select') --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.position_type')</label>
                                <select class="form-control" id="e_position_type" name="position_type" value="{{old('position_type')}}">
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.unit')</label>
                                <input type="text" class="form-control" id="e_unit" name="unit" value="{{old('unit')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.level')</label>
                                <input type="text" class="form-control" id="e_level" name="level" value="{{old('level')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.personal_phone') <span class="text-danger">*</span></label>
                                <input class="form-control @error('personal_phone_number') is-invalid @enderror" type="number" id="e_personal_phone_number" required name="personal_phone_number" value="{{old('personal_phone_number')}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.company_phone')</label>
                                <input class="form-control" type="number" id="e_company_phone_number" name="company_phone_number" value="{{old('company_phone_number')}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.guarantee_letter') (@lang('lang.pdf')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('guarantee_letter') is-invalid @enderror" type="file" id="guarantee_letter" name="guarantee_letter" value="{{old('guarantee_letter')}}">
                                <input type="hidden" name="hidden_file_guarantee" id="e_guarantee_letter" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.agency_phone') </label>
                                <input class="form-control" type="number" id="e_agency_phone_number" name="agency_phone_number" value="{{old('agency_phone_number')}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.email')</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="e_email" name="email"  placeholder="" {{old('email')}}>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.employment_book') (@lang('lang.pdf'))</label>
                                <input class="form-control @error('employment_book') is-invalid @enderror" type="file" id="employment_book" name="employment_book" value="{{old('employment_book')}}">
                                <input type="hidden" name="hidden_file_employment_book" id="e_employment_book" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.password')<span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" required name="password" placeholder="">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.confirm_password')</label>
                                <input type="password" class="form-control" required name="password_confirmation" placeholder="">
                            </div>
                        </div> --}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.loan')</label>
                                <select class="form-control select floating" id="e_is_loan" name="is_loan" value="{{old('is_loan')}}">
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                </select>
                            </div>   
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.fdc_start_date')</label>
                                <input class="form-control datetimepicker  @error('fdc_date') is-invalid @enderror" id="e_fdc_date" required name="fdc_date" type="text" value="{{old('fdc_date')}}">
                            </div>   
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.contract_deadline')</label>
                                <input class="form-control datetimepicker  @error('udc_end_date') is-invalid @enderror" id="e_udc_end_date" required name="udc_end_date" type="text" value="{{old('udc_end_date')}}">
                            </div>   
                        </div>
                    </div>
                    {{-- basic salary infor --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 20px;font-weight: normal !important;">@lang('lang.basic_salary')</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.basic_salary')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="e_basic_salary" name="basic_salary" placeholder="" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.salary_increase')</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="e_salary_increas" name="salary_increas" placeholder="" value="{{old('salary_increas')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.phone_allowance')</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input class="form-control" type="number" name="phone_allowance" id="e_phone_allowance" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bank Infor --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 20px;font-weight: normal !important;">@lang('lang.bank_infor')</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.bank_name')</label>
                                <select class="select form-control" id="e_bank_name" name="bank_name" value="{{old('bank_name')}}"></select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.account_name')</label>
                                <input class="form-control" type="text" id="e_account_name" name="account_name" value="{{old('account_name')}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.account_number')</label>
                                <input class="form-control" type="text" id="e_account_number" name="account_number" value="{{old('account_number')}}">
                            </div>
                        </div>
                    </div>
                    {{-- personal_informations --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 20px;font-weight: normal !important;">@lang('lang.personal_informations')</label>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.nationality')</label>
                                <select class="form-control select floating" id="e_nationality" name="nationality" value="{{old('nationality')}}">
                                  
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.ethnicity')</label>
                                <input class="form-control" type="text" id="e_ethnicity" name="ethnicity" value="{{old('ethnicity')}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.marital_status')</label>
                                <select class="form-control select floating" id="e_marital_status" name="marital_status" value="{{old('marital_status')}}">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.id_card_number')<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="e_id_card_number" name="id_card_number">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.spouse')</label>
                                <select class="form-control select floating" id="e_spouse" name="spouse" value="{{old('spouse')}}">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.identity_type')</label>
                                <select class="form-control select floating" id="e_identity_type" name="identity_type" value="{{old('identity_type')}}">
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.identity_number')</label>
                                <input class="form-control" type="number" id="e_identity_number" name="identity_number" value="{{old('identity_number')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.issue_date')</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="e_issue_date" name="issue_date" value="{{old('issue_date')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.issue_expired_date')</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="e_issue_expired_date" name="issue_expired_date" value="{{old('issue_expired_date')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- NSSF infor --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 20px;font-weight: normal !important;">@lang('lang.nssf_infor')</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.id_number_nssf') </label>
                                <input class="form-control" type="number" id="e_id_number_nssf" name="id_number_nssf" value="{{old('id_number_nssf')}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.type_of_employees')</label>
                                <select class="form-control select floating" id="e_type_of_employees_nssf" name="type_of_employees_nssf">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.spouse_nssf')</label>
                                <select class="form-control select floating" id="e_spouse_nssf" name="spouse_nssf">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.status') (@lang('lang.nssf'))</label>
                                <select class="form-control select floating" id="e_status_nssf" name="status_nssf">
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Created Current Address --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 20px;font-weight: normal !important;">@lang('lang.current_address')</label>
                    </div>
                    {{-- CurrentAddress --}}
                    <div id="CurrentAddress">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.province/city')</label>
                                    <select class="form-control hr-select2-option" id="e_current_province" name="current_province" value="{{old('current_province')}}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.district/khan')</label>
                                    <select class="form-control hr-select2-option" id="e_current_district" name="current_district" value="{{old('current_district')}}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('lang.house_no') </label>
                                    <input class="form-control" type="text" id="e_current_house_no" name="current_house_no">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label class="no-error-label">@lang('lang.commune/sangkat')</label>
                                <select class="form-control hr-select2-option no-error-border" id="e_current_commune" name="current_commune" value="{{old('current_commune')}}">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label class="no-error-label">@lang('lang.village')</label>
                                <select class="form-control hr-select2-option no-error-border" id="e_current_village" name="current_village" value="{{old('current_village')}}">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.street_no')</label>
                                <input class="form-control" type="text" id="e_current_street_no" name="current_street_no">
                            </div>
                        </div>
                    </div>
                    {{-- Created Permanent Address --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 20px;font-weight: normal !important;">@lang('lang.permanent_address')</label>
                    </div>

                    {{-- PermanentAddress --}}
                    <div id="PermanentAddress">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.province/city')</label>
                                    <select class="form-control hr-select2-option" name="permanent_province" id="e_permanent_province" value="{{old('city')}}"></select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.district/khan')</label>
                                    <select class="form-control hr-select2-option" id="e_permanent_district" name="permanent_district" value="{{old('distric')}}"></select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('lang.house_no')</label>
                                    <input class="form-control" type="text" id="e_permanent_house_no" name="permanent_house_no">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2 ">
                                <label class="no-error-label">@lang('lang.commune/sangkat')</label>
                                <select class="form-control hr-select2-option no-error-border" id="e_permanent_commune" name="permanent_commune" value="{{old('commune')}}"></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label class="no-error-label">@lang('lang.village')</label>
                                <select class="form-control hr-select2-option no-error-border" id="e_permanent_village" name="permanent_village" value="{{old('village')}}"></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.street_no')</label>
                                <input class="form-control" type="text" id="e_permanent_street_no" name="permanent_street_no">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="">@lang('lang.remark')</label>
                                <textarea type="text" rows="3" class="form-control" name="remark" id="e_remark" value="{{old('remark')}}"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="e_id">
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                                @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                        <a href="{{ url('users') }}" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{asset('/admin/js/noty.js')}}"></script>
<script>
    $(function(){
        var url = window.location.pathname;
        var id = url.substring(url.lastIndexOf('/') + 1);
        showDataEdit(id);
        // block Current Address
        $("#e_current_province").on("change", function(){
            let id = $("#e_current_province").val() ?? $("#e_current_province").val();
            let optionSelect = "currentProvince";

            $('#e_current_district').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#e_current_commune').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#e_current_village').html('<option selected disabled> --@lang("lang.select") --</option>');

            showProvince(id, optionSelect);
        });

        $("#e_current_district").on("change", function(){
            let id = $("#e_current_district").val() ?? $("#e_current_district").val();
            let optionSelect = "currentDistrict";

            $('#e_current_commune').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#e_current_village').html('<option selected disabled> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });

        $("#e_current_commune").on("change", function(){
            let id = $("#e_current_commune").val() ?? $("#e_current_commune").val();
            let optionSelect = "currentCommune";
            $('#e_current_village').html('<option selected disabled> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });

        // block Permanent Address
        $("#e_permanent_province").on("change", function(){
            let id = $("#e_permanent_province").val() ?? $("#e_permanent_province").val();
            let optionSelect = "permanentProvince";
            $('#e_permanent_district').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#e_permanent_commune').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#e_permanent_village').html('<option selected disabled> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });
        $("#e_permanent_district").on("change", function(){
            let id = $("#e_permanent_district").val() ?? $("#e_permanent_district").val();
            let optionSelect = "permanentDistrict";

            $('#e_permanent_commune').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#e_permanent_village').html('<option selected disabled> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });
        $("#e_permanent_commune").on("change", function(){
            let id = $("#e_permanent_commune").val() ?? $("#e_permanent_commune").val();
            let optionSelect = "permanentCommune";
            $('#e_permanent_village').html('<option selected disabled> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });
        $("#profile").on("change", function () {
            var file_data = $('#profile').prop('files')[0];
            if ($("#profile").val()) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150);
                };
                reader.readAsDataURL(file_data);
            }
        });
    });
    function showDataEdit(id){
        var localeLanguage = '{{ config('app.locale') }}';
        $('#e_bank_name').html('<option selected value=""> </option>');
        
        $('#e_current_province').html('<option selected value="">--@lang("lang.select") --</option>');
        $('#e_current_district').html('<option selected value=""> </option>');
        $('#e_current_commune').html('<option selected value=""> </option>');
        $('#e_current_village').html('<option selected value=""> </option>');

        $('#e_permanent_province').html('<option selected value="">--@lang("lang.select") --</option>');
        $('#e_permanent_district').html('<option selected value=""> </option>');
        $('#e_permanent_commune').html('<option selected value=""> </option>');
        $('#e_permanent_village').html('<option selected value=""> </option>');
        $.ajax({
            type: "GET",
            url: "{{url('users/edit')}}",
            data: {
                id : id
            },
            dataType: "JSON",
            success: function (response) {
                if (response.success) {
                    if (response.success.profile) {
                        $('#blah').attr('src', "{{asset('/uploads/images')}}/"+(response.success.profile)).width(150);
                    }else{
                        $('#blah').attr('src', "{{asset('admin/img/defuals/2023-10-12_10-04-19-removebg-preview.png')}}").width(150);
                    }

                    if (response.role != '') {
                        $('#e_role_id').html('<option selected disabled value=""> --@lang("lang.select") --</option>');
                        $.each(response.role, function(i, item) {
                            $('#e_role_id').append($('<option>', {
                                value: item.id,
                                text: item.role_name,
                                selected: item.id == response.success.role_id
                            }));
                        });
                    }

                    if (response.position != '') {
                        $('#e_position').html('<option selected disabled> --@lang("lang.select") --</option>');
                        $.each(response.position, function(i, item) {
                            $('#e_position').append($('<option>', {
                                value: item.id,
                                text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                selected: item.id == response.success.position_id
                            }));
                        });
                    }
                    
                    if (response.department != '') {
                        $('#e_department').html('<option selected disabled> --@lang("lang.select") --</option>');
                        $.each(response.department, function(i, item) {
                            $('#e_department').append($('<option>', {
                                value: item.id,
                                text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                selected: item.id == response.success.department_id
                            }));
                        });
                    }
                    if (response.optionGender != '') {
                        $('#e_gender').html('<option selected disabled> --@lang("lang.select") --</option>');
                        $.each(response.optionGender, function(i, item) {
                            $('#e_gender').append($('<option>', {
                                value: item.id,
                                text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                selected: item.id == response.success.gender
                            }));
                        });
                    }
                    if (response.branch != '') {
                        $('#e_branch_id').html('<option selected disabled> -- @lang("lang.select") --</option>');
                        $.each(response.branch, function(i, item) {
                            $('#e_branch_id').append($('<option>', {
                                value: item.id,
                                text: localeLanguage == 'en' ? item.branch_name_en : item.branch_name_kh,
                                selected: item.id == response.success.branch_id
                            }));
                        });
                    }
                    if (response.maritalStatus != '') {
                        $('#e_marital_status').html('<option selected disabled> -- @lang("lang.select") --</option>');
                        $.each(response.maritalStatus, function(i, item) {
                            $('#e_marital_status').append($('<option>', {
                                value: item.id,
                                text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                selected: item.id == response.success.marital_status
                            }));
                        });
                    }
                    if (response.nationality != '') {
                        $('#e_nationality').html('<option selected disabled> -- @lang("lang.select") --</option>');
                        $.each(response.nationality, function(i, item) {
                            $('#e_nationality').append($('<option>', {
                                value: item.id,
                                text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                selected: item.id == response.success.nationality
                            }));
                        });
                    }
                    if (response.success.spouse == 1) {
                        $("#e_spouse").append('<option selected value="1">Yes</option> <option value="0">No</option>');
                    } else {
                        $("#e_spouse").append('<option selected value="0">No</option> <option value="1">Yes</option>');   
                    }
                    if (response.success.is_loan == 1) {
                        $("#e_is_loan").append('<option selected value="1">Yes</option> <option value="0">No</option>');
                    } else {
                        $("#e_is_loan").append('<option selected value="0">No</option> <option value="1">Yes</option>');   
                    }
                    if (response.success.type_of_employees_nssf == 1) {
                        $("#e_type_of_employees_nssf").append('<option selected value="1">និវាសនជន</option> <option value="2">អនិវាសនជន</option>');
                    } else {
                        $("#e_type_of_employees_nssf").append('<option selected value="2">អនិវាសនជន</option> <option value="1">និវាសនជន</option>');   
                    }
                    if (response.success.spouse_nssf == 1) {
                        $("#e_spouse_nssf").append('<option selected value="1">Yes</option> <option value="2">No</option>');
                    } else {
                        $("#e_spouse_nssf").append('<option selected value="2">No</option> <option value="1">Yes</option>');   
                    }
                    if (response.success.status_nssf == 1) {
                        $("#e_status_nssf").append('<option selected value="1">@lang("lang.working")</option> <option value="2">Not working</option>');
                    } else {
                        $("#e_status_nssf").append('<option selected value="2">@lang("lang.not_working")</option> <option value="1">@lang("lang.not_working")</option>');   
                    }
                   
                    if (response.optionIdentityType != '') {
                        $.each(response.optionIdentityType, function(i, item) {
                            $('#e_identity_type').append($('<option>', {
                                value: item.id,
                                text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                selected: item.id == response.success.identity_type
                            }));
                        });
                    }

                    if (response.optionPositionType != '') {
                        $.each(response.optionPositionType, function(i, item) {
                            $('#e_position_type').append($('<option>', {
                                value: item.id,
                                text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                selected: item.id == response.success.position_type
                            }));
                        });
                    }
                    if (response.optionLoan != '') {
                        $.each(response.optionLoan, function(i, item) {
                            $('#e_is_loan').append($('<option>', {
                                value: item.id,
                                text: item.name_english,
                                selected: item.id == response.success.is_loan
                            }));
                        });
                    }
                    
                    if (response.bank != '') {
                        $.each(response.bank, function(i, item) {
                            $('#e_bank_name').append($('<option>', {
                                value: item.id,
                                text: item.name,
                                selected: item.id == response.success.bank_name
                            }));
                        });
                    }
                    
                    if (response.province != '') {
                        $.each(response.province, function(i,item) {
                            let option = {
                                value: item.code,
                                text: localeLanguage == 'en' ? item.name_en : item.name_km,
                            }
                            $('#e_current_province').append($('<option>', {...option, selected: item.code == response.success.current_province})); 
                            $('#e_permanent_province').append($('<option>', {...option, selected: item.code == response.success.permanent_province})); 
                        });
                    }

                    if (response.district != '') {
                        $.each(response.district, function(i,item) {
                            if (item.province_id == response.success.current_province) {
                                let cur_option = {}
                                cur_option= {
                                    value:item.code,
                                    text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                    selected: item.code == response.success.current_district
                                };
                                $('#e_current_district').append($('<option>', cur_option));
                            }
                            if (item.province_id == response.success.permanent_province) {
                                let per_option = {}
                                per_option= {
                                    value:item.code,
                                    text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                    selected: item.code == response.success.permanent_district
                                };
                                $('#e_permanent_district').append($('<option>', per_option));
                            } 
                        });
                    }

                    if (response.conmmunes != '') {
                        $.each(response.conmmunes, function(i,item) {
                            if (item.district_id == response.success.current_district) {
                                let cur_option = {}
                                cur_option= {
                                    value:item.code,
                                    text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                    selected: item.code == response.success.current_commune
                                };
                                $('#e_current_commune').append($('<option>', cur_option));
                            }
                            if (item.district_id == response.success.permanent_district) {
                                let per_option = {}
                                per_option= {
                                    value:item.code,
                                    text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                    selected: item.code == response.success.permanent_commune
                                };
                                $('#e_permanent_commune').append($('<option>', per_option));
                            }
                        });
                    }

                    if (response.villages != '') {
                        $.each(response.villages, function(i,item) {
                            if (item.commune_id == response.success.current_commune) {
                                let cur_option = {}
                                cur_option= {
                                    value:item.code,
                                    text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                    selected: item.code == response.success.current_village
                                };
                                $('#e_current_village').append($('<option>', cur_option));
                            }
                            if (item.commune_id == response.success.permanent_commune) {
                                let per_option = {}
                                per_option= {
                                    value:item.code,
                                    text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                    selected: item.code == response.success.permanent_village
                                };
                                $('#e_permanent_village').append($('<option>', per_option));
                            }
                        });
                    }
                    $('#e_id').val(response.success.id);
                    $('#e_number_employee').val(response.success.number_employee);
                    $('#e_last_name_kh').val(response.success.last_name_kh);
                    $('#e_last_name_en').val(response.success.last_name_en);
                    $('#e_first_name_en').val(response.success.first_name_en);
                    $('#e_first_name_kh').val(response.success.first_name_kh);
                    $('#e_date_of_birth').val(response.success.date_of_birth);
                    $('#e_fdc_date').val(response.success.fdc_date);
                    $('#e_udc_end_date').val(response.success.udc_end_date);
                    $('#e_id_card_number').val(response.success.id_card_number);
                    $('#e_id_number_nssf').val(response.success.id_number_nssf);
                    $('#e_ethnicity').val(response.success.ethnicity);
                    $('#e_unit').val(response.success.unit);
                    $('#e_level').val(response.success.level);
                    $('#e_basic_salary').val(response.success.basic_salary);
                    $('#e_salary_increas').val(response.success.salary_increas);
                    $('#e_phone_allowance').val(response.success.phone_allowance);
                    $('#e_date_of_commencement').val(response.success.date_of_commencement);
                    $('#e_number_of_children').val(response.success.number_of_children);
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
                }
            }
        });
    }
    function showProvince(id, optionSelect){
        var localeLanguage = '{{ config('app.locale') }}';
        let url = "";
        let data = {
            "_token": "{{ csrf_token() }}",
        };
        // block Current Address
        if (optionSelect == "currentProvince") {
            url = "{{url('district')}}"
            data.province_id = id
        }else if (optionSelect == "currentDistrict") {
            url = "{{url('commune')}}"
            data.district_id = id
        }else if (optionSelect == "currentCommune") {
            url = "{{url('village')}}"
            data.commune_id = id
        };

        // block Permanent Address
        if (optionSelect == "permanentProvince") {
            url = "{{url('district')}}"
            data.province_id = id
        }else if (optionSelect == "permanentDistrict") {
            url = "{{url('commune')}}"
            data.district_id = id
        }else if (optionSelect == "permanentCommune") {
            url = "{{url('village')}}"
            data.commune_id = id
        }

        $.ajax({
            type: "POST",
            url,
            data,
            dataType: "JSON",
            success: function (response) {
                var data = response.data;
                if (data != '') {
                    let option = {value: "",text: ""}
                    $.each(data, function(i, item) {
                        option = {
                            value: item.code,
                            text: localeLanguage == 'en' ? item.name_en : item.name_km,
                        }
                        if (optionSelect == "currentProvince") {
                            $('#e_current_district').append($('<option>', option));
                        }else if(optionSelect == "currentDistrict"){
                            $('#e_current_commune').append($('<option>', option));
                        }else if (optionSelect == "currentCommune") {
                            $('#e_current_village').append($('<option>', option));
                        }else if (optionSelect == "permanentProvince") {
                            $('#e_permanent_district').append($('<option>', option));
                        }else if (optionSelect == "permanentDistrict") {
                            $('#e_permanent_commune').append($('<option>', option));
                        }else if (optionSelect == "permanentCommune") {
                            $('#e_permanent_village').append($('<option>', option));
                        }
                    
                    });
                }
            }
        });
    }
</script>