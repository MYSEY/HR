<div id="add_user" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Employee</h5>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('users/store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Employee ID</label>
                                <input type="text" class="form-control" id="number_employee" name="number_employee" value="{{$autoEmpId}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="">
                                <label class="">Name (KH) <span class="text-danger">*</span></label>
                                <input class="form-control @error('employee_name_kh') is-invalid @enderror" type="text" id="employee_name_kh" required name="employee_name_kh" value="{{old('employee_name_kh')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Name (EN) <span class="text-danger">*</span></label>
                                <input class="form-control @error('employee_name_en') is-invalid @enderror" type="text" id="employee_name_en" required name="employee_name_en" value="{{old('employee_name_en')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="select form-control" id="gender" name="gender" value="{{old('gender')}}">
                                    <option value="">select gender</option>
                                    @foreach ($optionGender as $item)
                                    <option value="{{$item->id}}">{{$item->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Role Name <span class="text-danger">*</span></label>
                                <select class="select form-control @error('role_id') is-invalid @enderror" name="role_id" id="role_id" required>
                                    <option selected disabled value=""> --Select --</option>
                                    @foreach ($role as $itme )
                                    <option value="{{ $itme->id }}">{{ $itme->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Position</label>
                                <select class="select form-control @error('position_id') is-invalid @enderror" name="position_id" id="position_id">
                                    <option selected disabled> --Select --</option>
                                    @foreach ($position as $positions )
                                    <option value="{{ $positions->id }}">{{ $positions->name_khmer }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date Of Birth <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" type="text" required id="date_of_birth" name="date_of_birth" value="{{old('date_of_birth')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Profile</label>
                                <input class="form-control" type="file" id="profile" name="profile" value="{{old('profile')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Department</label>
                                <select class="select form-control" id="department_id" name="department_id" value="{{old('department_id')}}">
                                    <option value="">Please select department</option>
                                    @foreach ($department as $item)
                                    <option value="{{$item->id}}">{{$item->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="select form-control" id="branch_id" name="branch_id" value="{{old('branch_id')}}">
                                    <option value="">Please select branch</option>
                                    @foreach ($branch as $item)
                                    <option value="{{$item->id}}">{{$item->branch_name_kh}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" class="form-control" id="unit" name="unit" value="{{old('unit')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <label>level</label>
                                <input type="number" class="form-control" id="level" name="level" value="{{old('level')}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="">
                                <label class="">Join Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('date_of_commencement') is-invalid @enderror" id="date_of_commencement" required name="date_of_commencement" type="text" value="{{old('date_of_commencement')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Number Of Children</label>
                                <input class="form-control" type="number" id="number_of_children" name="number_of_children" value="{{old('number_of_children')}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Marital status</label>
                                <select class="select form-control" id="marital_status" name="marital_status" value="{{old('marital_status')}}">
                                    <option value="Married">Married</option>
                                    <option value="Single">Single</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nationality</label>
                                <select class="select form-control" id="nationality" name="nationality" value="{{old('nationality')}}">
                                    <option value="Khmer">Khmer</option>
                                    <option value="Chinese">Chinese</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="">
                                <label class="">Guarantee Letter(PDF) <span class="text-danger">*</span></label>
                                <input class="form-control @error('guarantee_letter') is-invalid @enderror" type="file" id="guarantee_letter" required name="guarantee_letter" value="{{old('guarantee_letter')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Employment Book(PDF)</label>
                                <input class="form-control @error('employment_book') is-invalid @enderror" type="file" id="employment_book" required name="employment_book" value="{{old('employment_book')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Personal Phone <span class="text-danger">*</span></label>
                                <input class="form-control @error('personal_phone_number') is-invalid @enderror" type="number" id="personal_phone_number" required name="personal_phone_number" value="{{old('personal_phone_number')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Company Phone</label>
                                <input class="form-control" type="number" id="company_phone_number" name="company_phone_number" value="{{old('company_phone_number')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Agency Phone </label>
                                <input class="form-control" type="number" id="agency_phone_number" name="agency_phone_number" value="{{old('agency_phone_number')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" id="" required name="email" placeholder="Enter Email" {{old('email')}}>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" required name="password" placeholder="Enter Password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" required name="password_confirmation" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="">Remark</label>
                            <textarea type="text" rows="3" class="form-control" name="remark" id="remark" value="{{old('remark')}}"></textarea>
                        </div>
                    </div>

                    {{-- Bank Info --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Bank Info</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Bank Name</label>
                                <input class="form-control" type="text" id="bank_name" name="bank_name" value="{{old('bank_name')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Account Name</label>
                                <input class="form-control" type="text" id="account_name" name="account_name" value="{{old('account_name')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Account Number</label>
                                <input class="form-control" type="text" id="account_number" name="account_number" value="{{old('account_number')}}">
                            </div>
                        </div>
                    </div>
                    {{-- Identities --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Identities</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Identity Type</label>
                                <select class="select form-control" id="identity_type" name="identity_type" value="{{old('identity_type')}}">
                                    <option value="">select identity type</option>
                                    @foreach ($optionIdentityType as $item)
                                    <option value="{{$item->id}}">{{$item->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Identity Number</label>
                                <input class="form-control" type="number" id="identity_number" name="identity_number" value="{{old('identity_number')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Issue Date</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="issue_date" name="issue_date" value="{{old('issue_date')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Issue Expired Date</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="issue_expired_date" name="issue_expired_date" value="{{old('issue_expired_date')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Created Current Address --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Current Address</label>
                    </div>

                    {{-- CurrentAddress --}}
                    <div id="CurrentAddress">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Province/City</label>
                                    <select class="select form-control" id="current_province" name="current_province" value="{{old('current_province')}}">
                                        <option selected disabled> --Select --</option>
                                        @if (count($province)>0)
                                        @foreach ($province as $item)
                                        <option value="{{$item->code}}">{{$item->name_en}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>District/Khan</label>
                                    <select class="select form-control" id="current_district" name="current_district" value="{{old('current_district')}}">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="no-error-label">Commune/Sangkat</label>
                                    <select class="select form-control no-error-border" id="current_commune" name="current_commune" value="{{old('current_commune')}}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="no-error-label">Village</label>
                                    <select class="select form-control no-error-border" id="current_village" name="current_village" value="{{old('current_village')}}">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
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
                    </div>

                    {{-- Created Permanent Address --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Permanent Address</label>
                    </div>

                    {{-- PermanentAddress --}}
                    <div id="PermanentAddress">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Province/City</label>
                                    <select class="select form-control" id="permanent_province" name="permanent_province" value="{{old('permanent_province')}}">
                                        <option selected disabled> --Select --</option>
                                        @if (count($province)>0)
                                        @foreach ($province as $item)
                                        <option value="{{$item->code}}">{{$item->name_en}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>District/Khan</label>
                                    <select class="select form-control" id="permanent_district" name="permanent_district" value="{{old('permanent_district')}}">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="no-error-label">Commune/Sangkat</label>
                                    <select class="select form-control no-error-border" id="permanent_commune" name="permanent_commune" value="{{old('permanent_commune')}}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="no-error-label">Village</label>
                                    <select class="select form-control no-error-border" id="permanent_village" name="permanent_village" value="{{old('permanent_village')}}">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
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
                    </div>

                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn" data-dismiss="modal">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>