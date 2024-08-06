@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }
    .content-title {
        border-bottom: 1px solid #ccc;
        padding-top: 6px;
        padding-bottom: 5px;
        color: #983D3A;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.payroll_staff_resign')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.payroll_staff_resign')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (permissionAccess("m4-s1","is_create")->value == "1")
                        <a href="#" class="btn add-btn me-2" data-bs-toggle="modal" data-bs-target="#add_payroll_staff_resign"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        @if (permissionAccess("m4-s1","is_view")->value == "1")
            <form>
                {{-- @csrf --}}
                <div class="row filter-btn"> 
                    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="@lang('lang.employee_id')" value="{{old('number_employee')}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group ">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group">
                            <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                                <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_location')</option>
                                @foreach ($branch as $item)
                                    <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group ">
                            <input class="form-control" type="month" id="filter_month">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 ">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" id="icon-search-download-reload">
                                <span class="btn-txt"><i class="fa fa-search"></i></span>
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                           
                            <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                                <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="content">
                <div class="page-menu">
                    <div class="row">
                        <div class="col-md-12 p-0">
                            <div class="table-responsive">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped custom-table datatable dataTable no-footer display tbl_payment_salary"
                                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"  cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.employee_id')</th>
                                                        <th class=" stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending">@lang('lang.employee_name')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-label="Email: activate to sort column ascending">@lang('lang.position')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Email: activate to sort column ascending">@lang('lang.department')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Email: activate to sort column ascending">@lang('lang.location')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.join_date')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.basic_salary')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.base_salary_received')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.child_allowance')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.phone_allowance')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.incentive')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.KNY_/_pchum_ben')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.annual_bonus')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.other_benefits')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.seniority_pay') (@lang('lang.included_tax'))
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.gross_salary')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.pension_fund')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.gross_salary')(@lang('lang.usd'))
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.gross_salary')(@lang('lang.rile'))
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.salary_charges_reduced')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.tax_base')(@lang('lang.rile'))
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.tax_rate')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.personal_tax')(@lang('lang.usd'))
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.personal_tax')(@lang('lang.rile'))
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.seniority_pay') (@lang('lang.excluded_tax'))
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.severance_pay')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Salary: activate to sort column ascending">@lang('lang.loan_amount')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Salary: activate to sort column ascending">@lang('lang.net_salary')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Salary: activate to sort column ascending">@lang('lang.payment_date')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Salary: activate to sort column ascending">@lang('lang.created_at')
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($data) > 0)
                                                        @foreach ($data as $item)
                                                            <tr class="odd">
                                                                <td class="stuck-scroll-3"><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                                <td class="stuck-scroll-3"><a href="#">{{ $item->users == null ? '' : $item->users->EmployeeName }}</span></a></td>
                                                                <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeePosition }}</a></td>
                                                                <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeeDepartment }}</a></td>
                                                                <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeeBranch }}</a></td>
                                                                <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                                                <td>$<a href="#">{{ $item->basic_salary }}</a></td>
                                                                <td>$<a href="#">{{ $item->total_gross_salary }}</a></td>
                                                                <td>$<a href="#">{{ $item->total_child_allowance }}</a></td>
                                                                <td>$<a href="#">{{ $item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                                <td>$<a href="#">{{ $item->monthly_quarterly_bonuses}}</a></td>
                                                                <td>$<a href="#">{{ $item->total_kny_phcumben}}</a></td>
                                                                <td>$<a href="#">{{ $item->annual_incentive_bonus}}</a></td>
                                                                <td>$<a href="#">{{ $item->other_benefits == null ? "0.00" : $item->other_benefits}}</a></td>
                                                                <td>$<a href="#">{{ $item->seniority_pay_included_tax}}</a></td>
                                                                <td>$<a href="#">{{ $item->total_gross}}</a></td>
                                                                <td>$<a href="#">{{ $item->total_pension_fund}}</a></td>
                                                                <td>$<a href="#">{{ $item->base_salary_received_usd}}</a></td>
                                                                <td><span>៛</span><a href="#">{{ number_format($item->base_salary_received_riel) }}</a></td>
                                                                <td><span>៛</span><a href="#">{{ number_format((int)$item->total_charges_reduced) }}</a></td>
                                                                <td><span>៛</span><a href="#">{{ number_format($item->total_tax_base_riel) }}</a></td>
                                                                <td><a href="#">{{ $item->total_rate}}%</a></td>
                                                                <td>$<a href="#">{{ $item->total_salary_tax_usd}}</a></td>
                                                                <td><span>៛</span><a href="#">{{ number_format($item->total_salary_tax_riel)}}</a></td>
                                                                <td>$<a href="#">{{ $item->seniority_pay_excluded_tax}}</a></td>
                                                                <td>$<a href="#">{{ $item->total_severance_pay}}</a></td>
                                                                <td>$<a href="#">{{ $item->loan_amount == null ? "0.00" : $item->loan_amount}}</a></td>
                                                                <td>$<a href="#">{{ $item->total_salary }}</a></td>
                                                                <td>{{ $item->PayrollPaymentDate }}</td>
                                                                <td>{{ $item->Created }}</td>
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
                    </div>
                </div>
            </div>
        @endif
        <div id="add_payroll_staff_resign" class="modal custom-modal fade" style="display: none;" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.payroll_staff_resign')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
    
                    <div class="modal-body">
                        <form class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.employee') <span class="text-danger">*</span></label>
                                        <select class="select form-control hr-select2-option pay_required" id="number_employee" name="number_employee">
                                            <option value="">@lang('lang.select')</option>
                                            @foreach ($staffResign as $item)
                                                <option value="{{$item->number_employee}}">{{ Helper::getLang() == 'en' ? $item->employee_name_en : $item->employee_name_kh }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="content-title">@lang('lang.exchange_rate') @lang('lang.nssf')</div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.us_dollar')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" disabled id="exchange_rate_nssf_usd" name="" placeholder="" value="1.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.rile')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">៛</span>
                                            <input type="number" class="form-control pay_required" id="exchange_rate_nssf" disabled name="" placeholder="" value="{{$exChangeRateNSSF == null ? "0.00" : $exChangeRateNSSF->amount_riel }}">
                                            <input type="hidden" class="form-control" id="exchange_rate_nssf_preview" name="" placeholder="" value="{{ $exChangeRateNSSF == null ? "" : $exChangeRateNSSF->amount_riel }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="content-title">@lang('lang.exchange_rate') @lang('lang.salary')</div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.us_dollar')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="exchange_rate_salary_en" disabled name="" placeholder="" value="1.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.rile')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">៛</span>
                                            <input type="number" class="form-control pay_required" id="exchange_rate" disabled placeholder="" value="{{$exChangeRateSalary == null ? "0.00" : $exChangeRateSalary->amount_riel }}">
                                            <input type="hidden" class="form-control" id="exchange_rate_preview" name="exchange_rate" placeholder="" value="{{ $exChangeRateSalary == null ? "" : $exChangeRateSalary->amount_riel }}">
                                            <input type="hidden" class="form-control" id="exchange_rate_salary_id" value="{{ $exChangeRateSalary == null ? "" : $exChangeRateSalary->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.payment_date') <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker pay_required" type="text" id="payment_date" name="payment_date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.loan')</label>
                                        <input class="form-control" type="file" id="loan" name="loan">
                                    </div>
                                </div>
                            </div>
    
                            <div class="submit-section">
                                <button type="button" class="btn btn-primary submit-btn" id="btnPayrollStaffResign">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>@lang('lang.submit')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function(){

        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('payroll/review') }}");
        });
        $(".btn-search").on("click", function(){
            $(".btn-search").prop('disabled', true);
            $(".btn-txt").hide();
            $(".loading-icon").css('display', 'block')
            let params = {
                branch_id: $("#branch_id").val(),
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                filter_month: $("#filter_month").val(),
            };
            showdatas(params);
        });
        $(".btn_excel").on("click", function() {
            let query = {
                branch_id: $("#branch_id").val(),
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                filter_month: $("#filter_month").val(),
            };
            var url = "{{URL::to('payroll/review/export')}}?" + $.param(query)
            window.location = url;
        });

       
        $("#btnPayrollStaffResign").on("click",function() {
            let num_miss = 0;
            $(".pay_required").each(function(){
                if($(this).val()=="0.00" || $(this).val()==""){
                    num_miss++;
                    $(this).css("border-color","#dc3545")
                }else{
                    $(this).css("border-color","#198754")
                }
            });
            if (num_miss>0) {
                return false;
            }else{
                let number_employee = $("#number_employee").val();
                let exchange_rate_salary = $("#exchange_rate_preview").val();
                let exchange_rate_nssf = $("#exchange_rate_nssf_preview").val();
                var file_loan = $('#loan').prop('files')[0];

                var form_data = new FormData();
                form_data.append('number_employee', number_employee);
                form_data.append('exchange_rate', exchange_rate_salary);
                form_data.append('payment_date', $("#payment_date").val());
                form_data.append('file_loan', file_loan);
                form_data.append('_token', "{{ csrf_token() }}");
                
                let button_ok = {
                    text: '@lang("lang.pay")',
                    btnClass: 'add-btn-status',
                    action: function () {
                        $(".btn-search").prop('disabled', false);
                        $(".loading-icon").css('display', 'block');
                        $.ajax({
                            type: 'POST',
                            url: "{{ url('payroll/staff/risign/create') }}",
                            data: form_data,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(data) {
                                toastr.success('Data has been save success');
                                window.location.replace("{{ URL('payroll/staff/resign') }}");
                            }
                        });
                    }
                };
               
                $.confirm({
                    // icon: 'fa fa-warning',
                    title: '@lang("lang.are_you_sure_you_want_to_pay")',
                    titleClass: 'text-center',
                    type: 'blue',
                    content: '' +
                    '<form action="" class="formName">' +
                        '<div class="form-group">' +
                            '<div class="content-title">@lang("lang.exchange_rate") @lang("lang.nssf")</div>'+
                            '<span style="margin-left: 15px;"> 1 @lang("lang.us_dollar")  =  '+(exchange_rate_nssf)+' @lang("lang.rile")</span>'+
                            '<div class="content-title">@lang("lang.exchange_rate") @lang("lang.salary")</div>'+
                            '<span style="margin-left: 15px;">1 @lang("lang.us_dollar") = '+(exchange_rate_salary)+' @lang("lang.rile")</span>'+
                            '<input type="hidden" class="form-control id" id="" name="">'+
                        '</div>' +
                    '</form>',
                    onOpenBefore: function () {
                        $(".jconfirm-buttons").addClass("jconfirm-buttons-center");
                    },
                    buttons: {
                        cancel: {
                            text: '@lang("lang.cancel")',
                            btnClass: 'btn-secondary btn-sm',
                        },
                        button_ok,
                    },

                    onContentReady: function () {
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click');
                        });
                    }
                });
            }
        });
    });
    function showdatas(params) {
        var localeLanguage = '{{ config('app.locale') }}';
        $.ajax({
            type: "post",
            url: "{{ url('payroll/staff/risign/search') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                branch_id: params.branch_id ? params.branch_id : null,
                employee_id: params.employee_id ? params.employee_id : null,
                employee_name: params.employee_name ? params.employee_name : null,
                filter_month: params.filter_month ? params.filter_month : null,
            },
            dataType: "JSON",
            success: function(response) {
                let data =  response.success;
                $(".btn-search").prop('disabled', false);
                $(".btn-txt").show();
                $(".loading-icon").css('display', 'none')
                var tr = "";
                if (data.length > 0) {
                    data.map((row) => {
                        let join_date = moment(row.users.date_of_commencement).format('D-MMM-YYYY');
                        let payment_date = moment(row.payment_date).format('D-MMM-YYYY');
                        let created_at = moment(row.created_at).format('D-MMM-YYYY');
                        tr +='<tr class="odd">'+
                            '<td class="stuck-scroll-3"><a href="#">'+(row.users == null ? '' : row.users.number_employee )+'</a></td>'+
                            '<td class="stuck-scroll-3"><a href="#">'+(row.users == null ? '' : localeLanguage == 'en' ? row.users.employee_name_en : row.users.employee_name_kh )+'</span></a></td>'+
                            '<td><a href="#">'+(row.users.position == null ? '' : row.users.position.name_english)+'</a></td>'+
                            '<td><a href="#">'+(row.users == null ? '' : localeLanguage == 'en' ? row.users.department.name_english : row.users.department.name_khmer )+'</a></td>'+
                            '<td><a href="#">'+(row.users == null ? '' : localeLanguage == 'en' ? row.users.branch.branch_name_en : row.users.branch.branch_name_kh)+'</a></td>'+
                            '<td>'+(join_date)+'</td>'+
                            '<td>$<a href="#">'+(row.basic_salary )+'</a></td>'+
                            '<td>$<a href="#">'+(row.total_gross_salary )+'</a></td>'+
                            '<td>$<a href="#">'+(row.total_child_allowance )+'</a></td>'+
                            '<td>$<a href="#">'+(row.phone_allowance == null ? '0.00' : row.phone_allowance)+'</a></td>'+
                            '<td>$<a href="#">'+(row.monthly_quarterly_bonuses)+'</a></td>'+
                            '<td>$<a href="#">'+(row.total_kny_phcumben)+'</a></td>'+
                            '<td>$<a href="#">'+(row.annual_incentive_bonus)+'</a></td>'+
                            '<td>$<a href="#">'+(row.other_benefits == null ? "0.00" : row.other_benefits)+'</a></td>'+
                            '<td>$<a href="#">'+(row.seniority_pay_included_tax)+'</a></td>'+
                            '<td>$<a href="#">'+(row.total_gross)+'</a></td>'+
                            '<td>$<a href="#">'+(row.total_pension_fund)+'</a></td>'+
                            '<td>$<a href="#">'+(row.base_salary_received_usd)+'</a></td>'+
                            '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.base_salary_received_riel))+'</a></td>'+
                            '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.total_charges_reduced))+'</a></td>'+
                            '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.total_tax_base_riel))+'</a></td>'+
                            '<td><a href="#">'+(row.total_rate)+'%</a></td>'+
                            '<td>$<a href="#">'+(row.total_salary_tax_usd)+'</a></td>'+
                            '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.total_salary_tax_riel))+'</a></td>'+
                            '<td>$<a href="#">'+(row.seniority_pay_excluded_tax)+'</a></td>'+
                            '<td>$<a href="#">'+(row.total_severance_pay)+'</a></td>'+
                            '<td>$<a href="#">'+(row.loan_amount == null ? "0.00" : row.loan_amount)+'</a></td>'+
                            '<td>$<a href="#">'+(row.total_salary )+'</a></td>'+
                            '<td>'+(payment_date)+'</td>'+
                            '<td>'+(created_at)+'</td>'+
                        '</tr>';
                    });
                }else{
                    var tr = '<tr><td colspan=35 align="center">@lang("lang.no_record_to_display")</td></tr>';
                }
                $(".tbl_payment_salary tbody").html(tr);
            }
        });
    }
   
    function formatCurrencyKH(currency) {
        return parseInt(currency).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>