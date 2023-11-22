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
                <h3 class="page-title">@lang('lang.add_new_employee')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.add_new_employee')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-pane fade active show" id="bank_statutory" role="tabpanel">
        <div class="card card_background_color">
            <div class="card-body">
                <form action="{{url('users/create')}}" method="POST" enctype="multipart/form-data"  class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-img-wrap edit-img">
                                <img class="inline-block" id="blah" src="#" alt="user">
                                <div class="fileupload btn">
                                    <span class="btn-text">@lang('lang.profile')</span>
                                    <input class="upload" type="file" name="profile" id="profile">
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
                                    id="last_name_kh" required name="last_name_kh"
                                    value="{{ old('last_name_kh') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">@lang('lang.first_name') (@lang('lang.kh'))<span
                                        class="text-danger">*</span></label>
                                <input class="form-control @error('first_name_kh') is-invalid @enderror" type="text"
                                    id="first_name_kh" required name="first_name_kh"
                                    value="{{ old('first_name_kh') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">@lang('lang.employee_id')</label>
                                <input type="text" class="form-control" id="number_employee" name="number_employee"
                                    value="{{ $autoEmpId }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">@lang('lang.last_name') (@lang('lang.en'))<span
                                        class="text-danger">*</span></label>
                                <input class="form-control @error('last_name_en') is-invalid @enderror" type="text"
                                    id="last_name_en" required name="last_name_en"
                                    value="{{ old('last_name_en') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">@lang('lang.first_name') (@lang('lang.en'))<span
                                        class="text-danger">*</span></label>
                                <input class="form-control @error('first_name_en') is-invalid @enderror" type="text"
                                    id="first_name_en" required name="first_name_en"
                                    value="{{ old('first_name_en') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.role_name')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option requered @error('role_id') is-invalid @enderror" name="role_id" id="role_id" required>
                                    <option selected disabled value=""> --@lang('lang.select')--</option>
                                    @foreach ($role as $itme )
                                        <option value="{{ $itme->id }}"> {{ $itme->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.gender')</label>
                                <select class="form-control select floating" id="gender" name="gender" value="{{old('gender')}}">
                                    <option selected disabled value=""> --@lang('lang.select')--</option>
                                    @foreach ($optionGender as $item)
                                        <option value="{{$item->id}}"> {{ Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.date_of_birth')<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" type="text" required id="date_of_birth" name="date_of_birth" value="{{old('date_of_birth')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.join_date')<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('date_of_commencement') is-invalid @enderror" id="date_of_commencement" required name="date_of_commencement" type="text" value="{{old('date_of_commencement')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.branch')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option requered" id="branch_id" name="branch_id" value="{{old('branch_id')}}" required>
                                    <option selected disabled value=""> --@lang('lang.select')--</option>
                                    @foreach ($branch as $item)
                                        <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.department')</label>
                                <select class="form-control hr-select2-option" id="department_id" name="department_id" value="{{old('department_id')}}">
                                    <option selected disabled value=""> --@lang('lang.select')--</option>
                                    @foreach ($department as $item)
                                        <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.position')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option requered @error('position_id') is-invalid @enderror" name="position_id" id="position_id" required>
                                    <option selected disabled value=""> -- @lang('lang.select')--</option>
                                    @foreach ($position as $positions)
                                        <option value="{{ $positions->id }}">{{Helper::getLang() == 'en' ? $positions->name_english : $positions->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.position_type')</label>
                                <select class="form-control select floating" id="position_type" name="position_type" value="{{old('position_type')}}">
                                    @foreach ($optionPositionType as $item)
                                        <option value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.unit')</label>
                                <input type="text" class="form-control" id="unit" name="unit" value="{{old('unit')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.level')</label>
                                <input type="text" class="form-control" id="level" name="level" value="{{old('level')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.personal_phone')<span class="text-danger">*</span></label>
                                <input class="form-control @error('personal_phone_number') is-invalid @enderror" type="number" id="personal_phone_number" required name="personal_phone_number" value="{{old('personal_phone_number')}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.company_phone')</label>
                                <input class="form-control" type="number" id="company_phone_number" name="company_phone_number" value="{{old('company_phone_number')}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.guarantee_letter') (@lang('lang.pdf')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('guarantee_letter') is-invalid @enderror" type="file" id="guarantee_letter" required name="guarantee_letter" value="{{old('guarantee_letter')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.agency_phone') </label>
                                <input class="form-control" type="number" id="agency_phone_number" name="agency_phone_number" value="{{old('agency_phone_number')}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.email')</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="" name="email" placeholder="" {{old('email')}}>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.employment_book') (@lang('lang.pdf'))</label>
                                <input class="form-control @error('employment_book') is-invalid @enderror" type="file" id="employment_book" name="employment_book" value="{{old('employment_book')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
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
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.loan')</label>
                                <select class="form-control select floating" id="is_loan" name="is_loan" value="{{old('is_loan')}}">
                                    <option value="">--@lang('lang.select')--</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
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
                                <label>@lang('lang.basic_salary') <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="basic_salary" name="basic_salary" placeholder="" value="{{old('basic_salary')}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.salary_increase')</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="salary_increas" name="salary_increas" placeholder="" value="{{old('salary_increas')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.phone_allowance')</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input class="form-control" type="number" name="phone_allowance" id="phone_allowance" value="{{old('phone_allowance')}}">
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
                                <select class="form-control select floating" id="bank_name" name="bank_name" value="{{old('bank_name')}}">
                                    <option value="">--@lang('lang.select')--</option>
                                    @foreach ($bank as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.account_name')</label>
                                <input class="form-control" type="text" id="account_name" name="account_name" value="{{old('account_name')}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.account_number')</label>
                                <input class="form-control" type="text" id="account_number" name="account_number" value="{{old('account_number')}}">
                            </div>
                        </div>
                    </div>

                    {{-- Personal Information --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 20px;font-weight: normal !important;">@lang('lang.personal_informations')</label>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.nationality')</label>
                                <select class="form-control select floating" id="nationality" name="nationality" value="{{old('nationality')}}">
                                    <option value="">--@lang('lang.select')--</option>
                                    @foreach ($nationality as $item)
                                        <option value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.ethnicity')</label>
                                <input class="form-control" type="text" id="ethnicity" name="ethnicity" value="{{old('ethnicity')}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.marital_status')</label>
                                <select class="form-control select floating" id="marital_status" name="marital_status" value="{{old('marital_status')}}">
                                    <option value="">--@lang('lang.select')--</option>
                                    @foreach ($maritalStatus as $item)
                                        <option value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.id_card_number') <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="id_card_number" name="id_card_number">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.spouse')</label>
                                <select class="form-control select floating" id="spouse" name="spouse" value="{{old('spouse')}}">
                                    <option value="">--@lang('lang.select')--</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.identity_type')</label>
                                <select class="form-control select floating" id="identity_type" name="identity_type" value="{{old('identity_type')}}">
                                    <option selected disabled> --@lang('lang.select')--</option>
                                    @foreach ($optionIdentityType as $item)
                                        <option value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.identity_number') </label>
                                <input class="form-control" type="number" id="identity_number" name="identity_number" value="{{old('identity_number')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.issue_date')</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="issue_date" name="issue_date" value="{{old('issue_date')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.issue_expired_date')</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="issue_expired_date" name="issue_expired_date" value="{{old('issue_expired_date')}}">
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
                                <input class="form-control" type="number" id="id_number_nssf" name="id_number_nssf" value="{{old('id_number_nssf')}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.type_of_employees')</label>
                                <select class="form-control select floating" name="type_of_employees_nssf">
                                    <option value="">--@lang('lang.select')--</option>
                                    <option value="1">និវាសនជន</option>
                                    <option value="2">អនិវាសនជន</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.spouse_nssf')</label>
                                <select class="form-control select floating" id="spouse_nssf">
                                    <option value="">--@lang('lang.select')--</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.status') (@lang('lang.nssf'))</label>
                                <select class="form-control select floating" id="status_nssf" name="status_nssf">
                                    <option value="">--@lang('lang.select')--</option>
                                    <option value="1">@lang('lang.working')</option>
                                    <option value="2">@lang('lang.not_working')</option>
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
                                    <select class="form-control hr-select2-option" id="current_province" name="current_province" value="{{old('current_province')}}">
                                        <option selected disabled> --@lang('lang.select')--</option>
                                        @if (count($province)>0)
                                            @foreach ($province as $item)
                                                <option value="{{$item->code}}">{{ Helper::getLang() == 'en' ? $item->name_en : $item->name_km}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.district/khan') </label>
                                    <select class="form-control hr-select2-option" id="current_district" name="current_district" value="{{old('current_district')}}">
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('lang.house_no')</label>
                                    <input class="form-control" type="text" id="current_house_no" name="current_house_no">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label class="no-error-label">@lang('lang.commune/sangkat')</label>
                                <select class="form-control hr-select2-option no-error-border" id="current_commune" name="current_commune" value="{{old('current_commune')}}">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label class="no-error-label">@lang('lang.village')</label>
                                <select class="form-control hr-select2-option no-error-border" id="current_village" name="current_village" value="{{old('current_village')}}">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.street_no')</label>
                                <input class="form-control" type="text" id="current_street_no" name="current_street_no">
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
                                    <select class="form-control hr-select2-option" id="permanent_province" name="permanent_province" value="{{old('permanent_province')}}">
                                        <option selected disabled> --@lang('lang.select')--</option>
                                        @if (count($province)>0)
                                            @foreach ($province as $item)
                                                <option value="{{$item->code}}">{{Helper::getLang() == 'en' ? $item->name_en : $item->name_km}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.district/khan')</label>
                                    <select class="form-control hr-select2-option" id="permanent_district" name="permanent_district" value="{{old('permanent_district')}}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('lang.house_no')</label>
                                    <input class="form-control" type="text" id="permanent_house_no" name="permanent_house_no">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2 ">
                                <label class="no-error-label">@lang('lang.commune/sangkat')</label>
                                <select class="form-control hr-select2-option no-error-border" id="permanent_commune" name="permanent_commune" value="{{old('permanent_commune')}}">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label class="no-error-label">@lang('lang.village')</label>
                                <select class="form-control hr-select2-option no-error-border" id="permanent_village" name="permanent_village" value="{{old('permanent_village')}}">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.street_no')</label>
                                <input class="form-control" type="text" id="permanent_street_no" name="permanent_street_no">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="">@lang('lang.remark')</label>
                                <textarea type="text" rows="3" class="form-control" name="remark" id="remark" value="{{old('remark')}}"></textarea>
                            </div>
                        </div>
                    </div>
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
        if (!$("#profile").val()){
            $('#blah')
                    .attr('src', "{{asset('admin/img/defuals/2023-10-12_10-04-19-removebg-preview.png')}}")
                    .width(150);
        }
        // block Current Address
        $("#current_province").on("change", function(){
            let id = $("#current_province").val() ?? $("#current_province").val();
            let optionSelect = "currentProvince";

            $('#current_district').html('<option selected disabled> -- @lang("lang.select") --</option>');
            $('#current_commune').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#current_village').html('<option selected disabled> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });

        $("#current_district").on("change", function(){
            let id = $("#current_district").val() ?? $("#current_district").val();
            let optionSelect = "currentDistrict";
            $('#current_commune').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#current_village').html('<option selected disabled> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });

        $("#current_commune").on("change", function(){
            let id = $("#current_commune").val() ?? $("#current_commune").val();
            let optionSelect = "currentCommune";
            $('#current_village').html('<option selected disabled> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });

        // block Permanent Address
        $("#permanent_province").on("change", function(){
            let id = $("#permanent_province").val() ?? $("#permanent_province").val();
            let optionSelect = "permanentProvince";
            $('#permanent_district').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#permanent_commune').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#permanent_village').html('<option selected disabled> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });
        $("#permanent_district").on("change", function(){
            let id = $("#permanent_district").val() ?? $("#permanent_district").val();
            let optionSelect = "permanentDistrict";
            $('#permanent_commune').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#permanent_village').html('<option selected disabled> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });
        $("#permanent_commune").on("change", function(){
            let id = $("#permanent_commune").val() ?? $("#permanent_commune").val()
            let optionSelect = "permanentCommune";
            $('#permanent_village').html('<option selected disabled> --@lang("lang.select") --</option>');
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
                            $('#current_district').append($('<option>', option));
                        }else if(optionSelect == "currentDistrict"){
                            $('#current_commune').append($('<option>', option));
                        }else if (optionSelect == "currentCommune") {
                            $('#current_village').append($('<option>', option));
                        }else if (optionSelect == "permanentProvince") {
                            $('#permanent_district').append($('<option>', option));
                        }else if (optionSelect == "permanentDistrict") {
                            $('#permanent_commune').append($('<option>', option));
                        }else if (optionSelect == "permanentCommune") {
                            $('#permanent_village').append($('<option>', option));
                        }
                    
                    });
                }
            }
        });
    }
</script>