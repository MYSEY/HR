@extends('layouts.master')
@section('content')
<div class="content container-fluid">
    
    <div class="page-header">
        <div class="row">
            <div class="col col-sm-12">
                <h3 class="page-title">Employee</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a  href="{{url('/dashboad/employee')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{url('/employee')}}">Employee</a></li>
                </ul>
            </div>
        </div>
    </div>

    
    <div class="card">
        <form action="{{url('employee')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="pro-overview" role="tabpanel">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Employee ID</label>
                                <input type="text" class="form-control" id="number_employee" name="number_employee" value="{{$data['code']}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Name (KH) <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="employee_name_kh" name="employee_name_kh" value="{{old('employee_name_kh')}}">
                                <p class="text-danger">{!! $errors->first('employee_name_kh') !!}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Name (EN) <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="employee_name_en" name="employee_name_en" value="{{old('employee_name_en')}}">
                                <p class="text-danger">{!! $errors->first('employee_name_en') !!}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date Of Birth <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="date_of_birth" name="date_of_birth" value="{{old('date_of_birth')}}">
                                    <p class="text-danger">{!! $errors->first('date_of_birth') !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Profile</label>
                                <input class="form-control" type="file" id="profile" name="profile" value="{{old('profile')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="select" id="gender" name="gender" value="{{old('gender')}}">
                                    <option value="">select gender</option>
                                    <option value="1">Male</option>
                                    <option value="2">FeMale</option>
                                    <option value="3">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Department</label>
                                <select class="select" id="department_id" name="department_id" value="{{old('department_id')}}">
                                    @foreach ($department as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="select form-control" id="branch_id" name="branch_id" value="{{old('branch_id')}}">
                                    @foreach ($branch as $item)
                                        <option value="{{$item->id}}">{{$item->branch_name_kh}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Position</label>
                                <select class="select" id="position_id" name="position_id" value="{{old('position_id')}}">
                                    @foreach ($position as $item)
                                        <option value="{{$item->id}}">{{$item->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" class="form-control" id="unit" name="unit" value="{{old('unit')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>level</label>
                                <input type="number" class="form-control" id="level" name="level" value="{{old('level')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Join Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" id="date_of_commencement" name="date_of_commencement" type="text" value="{{old('date_of_commencement')}}">
                                    <p class="text-danger">{!! $errors->first('date_of_commencement') !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Number Of Children</label>
                                <input class="form-control" type="number" id="number_of_children" name="number_of_children" value="{{old('number_of_children')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Marital status</label>
                                <select class="select" id="marital_status" name="marital_status" value="{{old('marital_status')}}">
                                    <option value="Married">Married</option>
                                    <option value="Single">Single</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nationality</label>
                                <select class="select" id="nationality" name="nationality" value="{{old('nationality')}}">
                                    <option value="Khmer">Khmer</option>
                                    <option value="Chinese">Chinese</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Guarantee Letter</label>
                                <input class="form-control" type="file" id="guarantee_letter" name="guarantee_letter" value="{{old('guarantee_letter')}}">
                                <p class="text-danger">{!! $errors->first('guarantee_letter') !!}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Employment Book</label>
                                <input class="form-control" type="file" id="employment_book" name="employment_book" value="{{old('employment_book')}}">
                                <p class="text-danger">{!! $errors->first('employment_book') !!}</p>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Remark</label>
                                <textarea type="text" rows="3" class="form-control" name="remark" id="remark" value="{{old('remark')}}"></textarea>
                            </div>
                        </div>
    
                        <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                            <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Bank Info</label>
                        </div>
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Account Number</label>
                                <input class="form-control" type="text" id="account_number" name="account_number" value="{{old('account_number')}}">
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                            <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Contact Info</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Personal Phone <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" id="personal_phone_number" name="personal_phone_number" value="{{old('personal_phone_number')}}">
                                <p class="text-danger">{!! $errors->first('personal_phone_number') !!}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Company Phone</label>
                                <input class="form-control" type="number" id="company_phone_number" name="company_phone_number" value="{{old('company_phone_number')}}">
                                <p class="text-danger">{!! $errors->first('company_phone_number') !!}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Agency Phone </label>
                                <input class="form-control" type="number" id="agency_phone_number" name="agency_phone_number" value="{{old('agency_phone_number')}}">
                                <p class="text-danger">{!! $errors->first('agency_phone_number') !!}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Email <span class="text-danger">*</span></label>
                                <input class="form-control" type="email" id="email" name="email" value="{{old('email')}}">
                                <p class="text-danger">{!! $errors->first('email') !!}</p>
                            </div>
                        </div>
    
                        <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                            <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Identities</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Identity Type</label>
                                <div class="form-group">
                                    <select class="select" id="identity_type" name="identity_type" value="{{old('identity_type')}}">
                                        <option value="">select identity type</option>
                                        <option value="1">Family Book</option>
                                        <option value="2">ID Card</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Identity Number</label>
                                <input class="form-control" type="number" id="identity_number" name="identity_number" value="{{old('identity_number')}}">
                            </div>
                        </div>
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
    
                        <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                            <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Current Address</label>
                        </div>

                        <div id="CurrentAddress">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Province/City</label>
                                        <select class="form-control" @change="cityChange" name="current_addre_city" v-model="frm.city" :disabled="JSON.stringify(cities).length==2" value="{{old('city')}}">
                                            <option v-for="(item,text) in cities" :value="text">@{{item}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>District/Khan</label>
                                        <select class="form-control" @change="districChange" name="current_addre_distric" v-model="frm.distric" :disabled="JSON.stringify(districs).length==2" value="{{old('distric')}}">
                                            <option v-for="(item, text) in districs" :value="text">@{{item}}</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label class="no-error-label">Commune/Sangkat</label>
                                    <select class="form-control no-error-border" @change="communeChange" name="current_addre_commune" v-model="frm.commune" :disabled="JSON.stringify(communes).length==2" value="{{old('commune')}}">
                                        <option v-for="(item, text) in communes" :value="text">@{{item}}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="no-error-label">Village</label>
                                    <select class="form-control no-error-border" @change="villageChange" name="current_addre_village" v-model="frm.village" :disabled="JSON.stringify(villages).length==2" value="{{old('village')}}">
                                        <option v-for="(item, text) in villages" :value="text">@{{item}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
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

                        <div id="PermanentAddress">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Province/City</label>
                                        <select class="form-control" @change="cityChange" name="permanet_addre_city" v-model="frm.city" :disabled="JSON.stringify(cities).length==2" value="{{old('city')}}">
                                            <option v-for="(item,text) in cities" :value="text">@{{item}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>District/Khan</label>
                                        <select class="form-control" @change="districChange" name="permanet_addre_distric" v-model="frm.distric" :disabled="JSON.stringify(districs).length==2" value="{{old('distric')}}">
                                            <option v-for="(item, text) in districs" :value="text">@{{item}}</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label class="no-error-label">Commune/Sangkat</label>
                                    <select class="form-control no-error-border" @change="communeChange" name="permanet_addre_commune" v-model="frm.commune" :disabled="JSON.stringify(communes).length==2" value="{{old('commune')}}">
                                        <option v-for="(item, text) in communes" :value="text">@{{item}}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="no-error-label">Village</label>
                                    <select class="form-control no-error-border" @change="villageChange" name="permanet_addre_village" v-model="frm.village" :disabled="JSON.stringify(villages).length==2" value="{{old('village')}}">
                                        <option v-for="(item, text) in villages" :value="text">@{{item}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
                </div>
            </div>   
        </form>
    </div>
</div>
@endsection
@include('includs.script')
<script>

    window.onload = function () {
        var main = new Vue({
            el: '#CurrentAddress',
            data() {
                return {
                    cities:{},
                    districs:{},
                    communes:{},
                    villages:{},
                    frm:{},
                }
            },
            mounted() {
                this.getData();
            },
            methods:{
                cityChange: async function(){
                    var me = this;
                    this.hidden = this.frm.city;
                    await this.getData(this.frm.city).then(function(response){
                    me.districs = response.data;
                    me.communes={};
                    me.villages={};
                });
            },
            districChange: async function(){
                var me = this;
                this.hidden = this.frm.distric;
                await this.getData(this.frm.distric).then(function(response){
                    me.communes = response.data;
                    me.villages={};
                });
            },
            communeChange: async function(){
                var me = this;
                this.hidden = this.frm.commune;
                await this.getData(this.frm.commune).then(function(response){
                    me.villages = response.data;
                });
            },
            villageChange:function(){
                this.hidden = this.frm.village;
            },
            getData:function(code=''){
                if(code){ 
                    return axios.get('{{route("address")}}?code='+code)
                }
                else
                { 
                    return axios.get('{{route("address")}}')
                }
            }
        },
        
        created: async function(){
            var me = this;
                this.getData().then(function(response){
                    me.cities = response.data;
                });
            }
        });




        var main = new Vue({
            el: '#PermanentAddress',
            data() {
                return {
                    cities:{},
                    districs:{},
                    communes:{},
                    villages:{},
                    frm:{},
                }
            },
            mounted() {
                this.getData();
            },
            methods:{
                cityChange: async function(){
                    var me = this;
                    this.hidden = this.frm.city;
                    await this.getData(this.frm.city).then(function(response){
                    me.districs = response.data;
                    me.communes={};
                    me.villages={};
                });
            },
            districChange: async function(){
                var me = this;
                this.hidden = this.frm.distric;
                await this.getData(this.frm.distric).then(function(response){
                    me.communes = response.data;
                    me.villages={};
                });
            },
            communeChange: async function(){
                var me = this;
                this.hidden = this.frm.commune;
                await this.getData(this.frm.commune).then(function(response){
                    me.villages = response.data;
                });
            },
            villageChange:function(){
                this.hidden = this.frm.village;
            },
            getData:function(code=''){
                if(code){ 
                    return axios.get('{{route("address")}}?code='+code)
                }
                else
                { 
                    return axios.get('{{route("address")}}')
                }
            }
        },
        
        created: async function(){
            var me = this;
                this.getData().then(function(response){
                    me.cities = response.data;
                });
            }
        });
    }
</script>