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
                <h3 class="page-title">@lang('lang.edit_staff_upcoming')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.edit_staff_upcoming')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-pane fade active show" role="tabpanel">
        <div class="card">
            <div class="card-body">
                <form action="{{url('/recruitment/candidate-resume/staff/upcoming/update')}}" method="POST" enctype="multipart/form-data"  class="needs-validation" novalidate>
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
                                <label class="">@lang('lang.last_name') (@lang('lang.kh'))<span class="text-danger">*</span></label>
                                <input class="form-control @error('last_name_kh') is-invalid @enderror" type="text" id="last_name_kh" required name="last_name_kh" value="{{ $dataUpcomings->last_name_kh }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">@lang('lang.first_name') (@lang('lang.kh'))<span class="text-danger">*</span></label>
                                <input class="form-control @error('first_name_kh') is-invalid @enderror" type="text" id="first_name_kh" required name="first_name_kh" value="{{ $dataUpcomings->first_name_kh }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">@lang('lang.employee_id')</label>
                                <input type="text" class="form-control" id="number_employee" readonly name="number_employee" value="{{ $dataUpcomings->number_employee }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">@lang('lang.last_name') (@lang('lang.en'))<span class="text-danger">*</span></label>
                                <input class="form-control @error('last_name_en') is-invalid @enderror" type="text" id="last_name_en" required name="last_name_en" value="{{ $dataUpcomings->last_name_en }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">@lang('lang.first_name') (@lang('lang.en'))<span class="text-danger">*</span></label>
                                <input class="form-control @error('first_name_en') is-invalid @enderror" type="text" id="first_name_en" required name="first_name_en" value="{{ $dataUpcomings->first_name_en }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.role_name')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option requered @error('role_id') is-invalid @enderror" name="role_id" id="role_id" required>
                                    <option selected disabled value=""> --@lang('lang.select')--</option>
                                    @foreach ($role as $item)
                                        <option value="{{$item->id}}" {{$dataUpcomings->role_id == $item->id ? "selected" : ""}}>{{$item->role_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.gender')</label>
                                <select class="form-control select floating" id="gender" name="gender">
                                    <option selected disabled value=""> --@lang('lang.select')--</option>
                                    @foreach ($optionGender as $item)
                                        <option value="{{$item->id}}" {{$dataUpcomings->gender == $item->id ? "selected" : ""}}>{{$item->name_english}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.date_of_birth')<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" type="text" id="date_of_birth" required name="date_of_birth" value="{{$dataUpcomings->date_of_birth}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.join_date')<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker  @error('date_of_commencement') is-invalid @enderror" id="date_of_commencement" required name="date_of_commencement" type="text" value="{{$dataUpcomings->date_of_commencement}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.branch')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option" id="branch_id" name="branch_id" value="{{old('branch_id')}}">
                                    <option selected disabled value=""> -- @lang('lang.select') --</option>
                                    @foreach ($branch as $item)
                                        <option value="{{$item->id}}" {{$dataUpcomings->branch_id == $item->id ? "selected" : ""}}>{{$item->branch_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.department')</label>
                                <select class="form-control hr-select2-option" name="department_id" id="department_id">
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                    @foreach ($department as $item)
                                        <option value="{{$item->id}}" {{$dataUpcomings->department_id == $item->id ? "selected" : ""}}>{{$item->name_english}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.position')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option @error('position_id') is-invalid @enderror" name="position_id" id="position_id" required>
                                    <option selected disabled value=""> -- @lang('lang.select') --</option>
                                    @foreach ($positions as $item)
                                        <option value="{{$item->id}}" {{$dataUpcomings->position_id == $item->id ? "selected" : ""}}>{{$item->name_english}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" hidden>
                            <div class="form-group">
                                <label class="">@lang('lang.position_type')</label>
                                <select class="form-control" id="position_type" name="position_type" value="{{old('position_type')}}">
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.unit')</label>
                                <input type="text" class="form-control" id="unit" name="unit" value="{{$dataUpcomings->unit}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.level')</label>
                                <select class="form-control hr-select2-option" id="level" name="level" value="">
                                    <option selected value=""> -- @lang('lang.select')--</option>
                                    @foreach ($level as $item)
                                        <option value="{{$item->name}}" {{$dataUpcomings->level == $item->id ? "selected" : ""}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.line_manager')</label>
                                <select class="form-control hr-select2-option" id="line_manager" name="line_manager" value="">
                                    <option selected value=""> -- @lang('lang.select')--</option>
                                    @foreach ($lineManager as $item)
                                        <option value="{{$item->id}}" {{$dataUpcomings->line_manager == $item->id ? "selected" : ""}}>{{Helper::getLang() == 'en' ? $item->employee_name_en : $item->employee_name_kh}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.personal_phone')<span class="text-danger">*</span></label>
                                <input class="form-control @error('personal_phone_number') is-invalid @enderror" type="number" id="personal_phone_number" required name="personal_phone_number" value="{{$dataUpcomings->personal_phone_number}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.company_phone')</label>
                                <input class="form-control" type="number" id="company_phone_number" name="company_phone_number" value="{{$dataUpcomings->company_phone_number}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.guarantee_letter') (@lang('lang.pdf'))<span class="text-danger">*</span></label>
                                <input class="form-control @error('guarantee_letter') is-invalid @enderror" type="file" id="guarantee_letter" name="guarantee_letter" value="{{$dataUpcomings->guarantee_letter}}">
                                <input type="hidden" name="hidden_file_guarantee" id="e_guarantee_letter" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.agency_phone')</label>
                                <input class="form-control" type="text" id="agency_phone_number" name="agency_phone_number" value="{{$dataUpcomings->agency_phone_number}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.email')</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" {{$dataUpcomings->email}}>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.employment_book') (@lang('lang.pdf'))</label>
                                <input class="form-control @error('employment_book') is-invalid @enderror" type="file" id="employment_book" name="employment_book" value="{{$dataUpcomings->employment_book}}">
                                <input type="hidden" name="hidden_file_employment_book" id="e_employment_book" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.loan')</label>
                                <select class="form-control select floating" id="is_loan" name="is_loan" value="{{old('is_loan')}}">
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                    <option value="1" {{$dataUpcomings->is_loan == 1 ? "selected" : ""}}>Yes</option>
                                    <option value="0" {{$dataUpcomings->is_loan == 0 ? "selected" : ""}}>No</option>
                                </select>
                            </div>   
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.fdc_start_date')</label>
                                <input class="form-control datetimepicker  @error('fdc_date') is-invalid @enderror" id="fdc_date" required name="fdc_date" type="text" value="{{$dataUpcomings->fdc_date}}">
                            </div>   
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.contract_deadline') <span class="text-danger">*</span></label>
                                <input class="form-control datetimepicker  @error('fdc_end') is-invalid @enderror" id="fdc_end" required name="fdc_end" type="text" value="{{$dataUpcomings->fdc_end}}">
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
                                    <input type="text" class="form-control" id="basic_salary" name="basic_salary" value="{{$dataUpcomings->basic_salary}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.salary_increase')</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="any" class="form-control" id="salary_increas" name="salary_increas" value="{{$dataUpcomings->salary_increas}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.phone_allowance')</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input class="form-control" type="number" name="phone_allowance" id="phone_allowance" value="{{$dataUpcomings->phone_allowance}}">
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
                                <select class="select form-control" id="bank_name" name="bank_name" value="{{$dataUpcomings->bank_name}}"></select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.account_name')</label>
                                <input class="form-control" type="text" id="account_name" name="account_name" value="{{$dataUpcomings->account_name}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.account_number')</label>
                                <input class="form-control" type="text" id="account_number" name="account_number" value="{{$dataUpcomings->account_number}}">
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
                                <select class="form-control select floating" id="nationality" name="nationality">
                                    @foreach ($nationality as $item)
                                        <option value="{{$item->id}}" {{$dataUpcomings->nationality == $item->id ? "selected" : ""}}>{{$item->name_english}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.ethnicity')</label>
                                <input class="form-control" type="text" id="ethnicity" name="ethnicity" value="{{$dataUpcomings->ethnicity}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.marital_status')</label>
                                <select class="form-control select floating" id="marital_status" name="marital_status">
                                    @foreach ($maritalStatus as $item)
                                        <option value="{{$item->id}}" {{$dataUpcomings->marital_status == $item->id ? "selected" : ""}}>{{$item->name_english}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>@lang('lang.id_card_number')<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="id_card_number" name="id_card_number" value="{{$dataUpcomings->id_card_number}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.spouse')</label>
                                <select class="form-control select floating" id="spouse" name="spouse" value="{{old('spouse')}}">
                                    <option value="1" {{$dataUpcomings->spouse == 1 ? "selected" : ""}}>Yes</option>
                                    <option value="0" {{$dataUpcomings->spouse == 0 ? "selected" : ""}}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.identity_type')</label>
                                <select class="form-control select floating" id="identity_type" name="identity_type">
                                    <option selected disabled> -- @lang('lang.select') --</option>
                                    @foreach ($optionIdentityType as $item)
                                        <option value="{{$item->id}}" {{$dataUpcomings->identity_type == $item->id ? "selected" : ""}}>{{$item->name_english}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.identity_number')</label>
                                <input class="form-control" type="number" id="identity_number" name="identity_number" value="{{$dataUpcomings->identity_number}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.issue_date')</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="issue_date" name="issue_date" value="{{$dataUpcomings->issue_date}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.issue_expired_date')</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="issue_expired_date" name="issue_expired_date" value="{{$dataUpcomings->issue_expired_date}}">
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
                                <input class="form-control" type="text" id="id_number_nssf" name="id_number_nssf" value="{{$dataUpcomings->id_number_nssf}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.type_of_employees')</label>
                                <select class="form-control select floating" id="type_of_employees_nssf" name="type_of_employees_nssf">
                                    <option value="1" {{$dataUpcomings->type_of_employees_nssf == 1 ? "selected" : ""}}>@lang("lang.residents")</option>
                                    <option value="2" {{$dataUpcomings->type_of_employees_nssf == 2 ? "selected" : ""}}>@lang("lang.non_resident")</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.spouse_nssf')</label>
                                <select class="form-control select floating" id="spouse_nssf" name="spouse_nssf">
                                    <option value="1" {{$dataUpcomings->spouse_nssf == 1 ? "selected" : ""}}>Yes</option> 
                                    <option value="2" {{$dataUpcomings->spouse_nssf == 2 ? "selected" : ""}}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="">@lang('lang.status') (@lang('lang.nssf'))</label>
                                <select class="form-control select floating" id="status_nssf" name="status_nssf">
                                    <option value="1" {{$dataUpcomings->spouse_nssf == 1 ? "selected" : ""}}>@lang("lang.working")</option> 
                                    <option value="2" {{$dataUpcomings->spouse_nssf == 2 ? "selected" : ""}}>@lang("lang.not_working")</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Created Current Address --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 20px;font-weight: normal !important;">@lang('lang.current_address')</label>
                    </div>
                    {{-- CurrentAddress --}}
                    {{-- @dd($dataUpcomings) --}}
                    <div id="CurrentAddress">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.province/city')</label>
                                    <select class="form-control hr-select2-option required @error('current_province') is-invalid @enderror" id="current_province" name="current_province" required>
                                        <option selected disabled> -- @lang('lang.select') --</option>
                                        @if (count($province)>0)
                                            @foreach ($province as $item)
                                                <option value="{{$item->code}}" {{$dataUpcomings->current_province == $item->code ? 'selected' : ''}}>{{ Helper::getLang() == 'en' ? $item->name_en : $item->name_km}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.district/khan')</label>
                                    <select class="form-control hr-select2-option" id="current_district" name="current_district" value="{{old('current_district')}}">
                                        @if (count($district)>0)
                                            @foreach ($district as $item)
                                                <option value="{{$item->code}}" {{$dataUpcomings->current_commune == $item->code ? 'selected' : ''}}>{{ Helper::getLang() == 'en' ? $item->name_en : $item->name_km}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('lang.house_no') </label>
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
                                    @if (count($conmmunes)>0)
                                        @foreach ($conmmunes as $item)
                                            <option value="{{$item->code}}" {{$dataUpcomings->current_district == $item->code ? 'selected' : ''}}>{{ Helper::getLang() == 'en' ? $item->name_en : $item->name_km}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label class="no-error-label">@lang('lang.village')</label>
                                <select class="form-control hr-select2-option no-error-border" id="current_village" name="current_village" value="{{old('current_village')}}">
                                    @if (count($villages)>0)
                                        @foreach ($villages as $item)
                                            <option value="{{$item->code}}" {{$dataUpcomings->current_village == $item->code ? 'selected' : ''}}>{{ Helper::getLang() == 'en' ? $item->name_en : $item->name_km}}</option>
                                        @endforeach
                                    @endif
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
                                    <select class="form-control hr-select2-option" name="permanent_province" id="permanent_province" value="{{old('city')}}">
                                        <option selected disabled> -- @lang('lang.select') --</option>
                                        @if (count($province)>0)
                                            @foreach ($province as $item)
                                                <option value="{{$item->code}}" {{$dataUpcomings->permanent_province == $item->code ? 'selected' : ''}}>{{ Helper::getLang() == 'en' ? $item->name_en : $item->name_km}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.district/khan')</label>
                                    <select class="form-control hr-select2-option" id="permanent_district" name="permanent_district" value="{{old('distric')}}">
                                        @if (count($district)>0)
                                            @foreach ($district as $item)
                                                <option value="{{$item->code}}" {{$dataUpcomings->permanent_district == $item->code ? 'selected' : ''}}>{{ Helper::getLang() == 'en' ? $item->name_en : $item->name_km}}</option>
                                            @endforeach
                                        @endif
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
                                <select class="form-control hr-select2-option no-error-border" id="e_permanent_commune" name="permanent_commune" value="{{old('commune')}}">
                                    @if (count($conmmunes)>0)
                                        @foreach ($conmmunes as $item)
                                            <option value="{{$item->code}}" {{$dataUpcomings->permanent_commune == $item->code ? 'selected' : ''}}>{{ Helper::getLang() == 'en' ? $item->name_en : $item->name_km}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group hr-form-group-select2">
                                <label class="no-error-label">@lang('lang.village')</label>
                                <select class="form-control hr-select2-option no-error-border" id="e_permanent_village" name="permanent_village" value="{{old('village')}}">
                                    @if (count($villages)>0)
                                        @foreach ($villages as $item)
                                            <option value="{{$item->code}}" {{$dataUpcomings->permanent_village == $item->code ? 'selected' : ''}}>{{ Helper::getLang() == 'en' ? $item->name_en : $item->name_km}}</option>
                                        @endforeach
                                    @endif
                                </select>
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
                    <input type="hidden" name="id" id="id" value="{{$dataUpcomings->id}}">
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                                @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                        <a href="{{ url('recruitment/candidate-resume/list') }}" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
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
        $("#e_position").on("change", function() {
            let position_type = $("#e_position option:checked").attr('data-id');
            if (position_type == 1) {
                $('#e_position_type').find('option').each(function(){
                    if ($(this).attr('data-id') == "Supporting Staff") {
                        $("#e_position_type").val($(this).val());
                    }
                }); 
            }else{
                $('#e_position_type').find('option').each(function(){
                    if ($(this).attr('data-id') == "Field Staff") {
                        $("#e_position_type").val($(this).val());
                    }
                });
            }
        });
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
                    $('#blah').attr('src', e.target.result).width(150);
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