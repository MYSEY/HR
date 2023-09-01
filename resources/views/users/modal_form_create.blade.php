<div id="add_user" class="modal custom-modal fade hr-modal-select2" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.add_new_employee')</h5>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('users/store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">@lang('lang.employee_id')</label>
                                <input type="text" class="form-control" id="number_employee" name="number_employee" value="{{$autoEmpId}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">@lang('lang.name') (@lang('lang.kh')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('employee_name_kh') is-invalid @enderror" type="text" id="employee_name_kh" required name="employee_name_kh" value="{{old('employee_name_kh')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">@lang('lang.name') (@lang('lang.en')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('employee_name_en') is-invalid @enderror" type="text" id="employee_name_en" required name="employee_name_en" value="{{old('employee_name_en')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">@lang('lang.profile')</label>
                                <input class="form-control" type="file" id="profile" name="profile" value="{{old('profile')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.role_name') <span class="text-danger">*</span></label>
                                <select class="form-control @error('role_id') is-invalid @enderror" name="role_id" id="role_id" required>
                                    <option selected disabled value=""> --@lang('lang.select')--</option>
                                    @foreach ($role as $itme )
                                        <option value="{{ $itme->id }}"> {{ $itme->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.gender')</label>
                                <select class="form-control" id="gender" name="gender" value="{{old('gender')}}">
                                    <option selected disabled value=""> --@lang('lang.select')--</option>
                                    @foreach ($optionGender as $item)
                                        <option value="{{$item->id}}"> {{ Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.date_of_birth')<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" type="text" required id="date_of_birth" name="date_of_birth" value="{{old('date_of_birth')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.join_date')<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('date_of_commencement') is-invalid @enderror" id="date_of_commencement" required name="date_of_commencement" type="text" value="{{old('date_of_commencement')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.branch') <span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option requered" id="branch_id" name="branch_id" value="{{old('branch_id')}}" required>
                                    <option selected disabled value=""> --@lang('lang.select')--</option>
                                    @foreach ($branch as $item)
                                        <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
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
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.position')<span class="text-danger">*</span></label>
                                <select class="form-control hr-select2-option requered @error('position_id') is-invalid @enderror" name="position_id" id="position_id" required>
                                    <option selected disabled value=""> -- @lang('lang.select')--</option>
                                    @foreach ($position as $positions )
                                        <option value="{{ $positions->id }}">{{Helper::getLang() == 'en' ? $positions->name_english : $positions->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.position_type')</label>
                                <select class="form-control" id="position_type" name="position_type" value="{{old('position_type')}}">
                                    @foreach ($optionPositionType as $item)
                                        <option value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.unit')</label>
                                <input type="text" class="form-control" id="unit" name="unit" value="{{old('unit')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.level')</label>
                                <input type="text" class="form-control" id="level" name="level" value="{{old('level')}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.nationality')</label>
                                <select class="form-control" id="nationality" name="nationality" value="{{old('nationality')}}">
                                    <option value="@lang('lang.khmer')">@lang('lang.khmer')</option>
                                    <option value="@lang('lang.chinese')">@lang('lang.chinese')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.marital_status')</label>
                                <select class="form-control" id="marital_status" name="marital_status" value="{{old('marital_status')}}">
                                    <option value="@lang('lang.married')">@lang('lang.married')</option>
                                    <option value="@lang('lang.single')">@lang('lang.single')</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.guarantee_letter') (@lang('lang.pdf')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('guarantee_letter') is-invalid @enderror" type="file" id="guarantee_letter" required name="guarantee_letter" value="{{old('guarantee_letter')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.employment_book') (@lang('lang.pdf'))</label>
                                <input class="form-control @error('employment_book') is-invalid @enderror" type="file" id="employment_book" name="employment_book" value="{{old('employment_book')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.personal_phone')<span class="text-danger">*</span></label>
                                <input class="form-control @error('personal_phone_number') is-invalid @enderror" type="number" id="personal_phone_number" required name="personal_phone_number" value="{{old('personal_phone_number')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.company_phone')</label>
                                <input class="form-control" type="number" id="company_phone_number" name="company_phone_number" value="{{old('company_phone_number')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.agency_phone') </label>
                                <input class="form-control" type="number" id="agency_phone_number" name="agency_phone_number" value="{{old('agency_phone_number')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.email')</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="" name="email" placeholder="" {{old('email')}}>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.password')<span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" required name="password" placeholder="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.confirm_password')</label>
                                <input type="password" class="form-control" required name="password_confirmation" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.spouse')</label>
                                <select class="form-control" id="spouse" name="spouse" value="{{old('spouse')}}">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.loan')</label>
                                <select class="form-control" id="is_loan" name="is_loan" value="{{old('is_loan')}}">
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="">@lang('lang.remark')</label>
                            <textarea type="text" rows="3" class="form-control" name="remark" id="remark" value="{{old('remark')}}"></textarea>
                        </div>
                    </div>
                    {{-- basic salary infor --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.basic_salary')</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.basic_salary') <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="basic_salary" name="basic_salary" placeholder="" value="{{old('basic_salary')}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
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
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.bank_infor')</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.bank_name')</label>
                                <select class="form-control" id="bank_name" name="bank_name" value="{{old('bank_name')}}">
                                    <option value="">--@lang('lang.select')--</option>
                                    @foreach ($bank as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.account_name')</label>
                                <input class="form-control" type="text" id="account_name" name="account_name" value="{{old('account_name')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.account_number')</label>
                                <input class="form-control" type="text" id="account_number" name="account_number" value="{{old('account_number')}}">
                            </div>
                        </div>
                    </div>
                    {{-- Identities --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.identities')</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.identity_type')</label>
                                <select class="form-control" id="identity_type" name="identity_type" value="{{old('identity_type')}}">
                                    <option selected disabled> --@lang('lang.select')--</option>
                                    @foreach ($optionIdentityType as $item)
                                        <option value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.identity_number') </label>
                                <input class="form-control" type="number" id="identity_number" name="identity_number" value="{{old('identity_number')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.issue_date')</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="issue_date" name="issue_date" value="{{old('issue_date')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.issue_expired_date')</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="issue_expired_date" name="issue_expired_date" value="{{old('issue_expired_date')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Created Current Address --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.current_address')</label>
                    </div>

                    {{-- CurrentAddress --}}
                    <div id="CurrentAddress">
                        <div class="row">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.district/khan') </label>
                                    <select class="form-control hr-select2-option" id="current_district" name="current_district" value="{{old('current_district')}}">
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2">
                                    <label class="no-error-label">@lang('lang.commune/sangkat')</label>
                                    <select class="form-control hr-select2-option no-error-border" id="current_commune" name="current_commune" value="{{old('current_commune')}}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2">
                                    <label class="no-error-label">@lang('lang.village')</label>
                                    <select class="form-control hr-select2-option no-error-border" id="current_village" name="current_village" value="{{old('current_village')}}">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.house_no')</label>
                                <input class="form-control" type="text" id="current_house_no" name="current_house_no">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.street_no')</label>
                                <input class="form-control" type="text" id="current_street_no" name="current_street_no">
                            </div>
                        </div>
                    </div>

                    {{-- Created Permanent Address --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.permanent_address')</label>
                    </div>

                    {{-- PermanentAddress --}}
                    <div id="PermanentAddress">
                        <div class="row">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.district/khan')</label>
                                    <select class="form-control hr-select2-option" id="permanent_district" name="permanent_district" value="{{old('permanent_district')}}">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2 ">
                                    <label class="no-error-label">@lang('lang.commune/sangkat')</label>
                                    <select class="form-control hr-select2-option no-error-border" id="permanent_commune" name="permanent_commune" value="{{old('permanent_commune')}}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2">
                                    <label class="no-error-label">@lang('lang.village')</label>
                                    <select class="form-control hr-select2-option no-error-border" id="permanent_village" name="permanent_village" value="{{old('permanent_village')}}">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.house_no')</label>
                                <input class="form-control" type="text" id="permanent_house_no" name="permanent_house_no">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.street_no')</label>
                                <input class="form-control" type="text" id="permanent_street_no" name="permanent_street_no">
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn" data-dismiss="modal">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                        <button type="button" id="btn-cancel" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>