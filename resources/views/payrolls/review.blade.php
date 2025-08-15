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
    .form-check-md .form-check-input {
        width: 1.15rem;
        height: 1.15rem;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.payroll_review')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.payroll_review')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (permissionAccess("m4-s1","is_create")->value == "1")
                        <a href="#" class="btn add-btn me-2" data-bs-toggle="modal" data-bs-target="#add_salary"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
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
                            <input spellcheck="false" id="employee_id" name="employee_id" class="form-control" type="text" placeholder="@lang('lang.employee_id')">
                            {{-- <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="@lang('lang.employee_id')" value="{{old('number_employee')}}"> --}}
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
                            <input class="form-control" type="month" id="filter_month" name="filter_month">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 ">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" id="icon-search-download-reload">
                                <span class="btn-txt"><i class="fa fa-search"></i></span>
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                            @if (permissionAccess("m4-s1","is_export")->value == "1")
                                <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                                    <span class="btn-text-excel"><i class="fa fa-arrow-circle-down"></i></span>
                                    <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                                </button>
                            @endif
                           
                            <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                                <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            {!! Toastr::message() !!}
            @if (permissionAccess("m4-s1","is_delete")->value == "1")
                <button type="button" class="btn btn-sm btn-danger delete_all">@lang('lang.delete_all')</button>
            @endif
            @if (permissionAccess("m4-s1","is_approve")->value == "1")
                <button type="button" class="btn btn-sm btn-success btn_approved" href="#" data-id=""> @lang('lang.approve')</button> 
            @endif

            <div class="content">
                <div class="page-menu">
                    <div class="row">
                        <div class="col-md-12 p-0">
                            <div class="table-responsive">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped custom-table datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"  cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="tuck-scroll-3">
                                                            <div class="form-check form-check-md">
                                                                <input class="form-check-input" type="checkbox" data-has-listeners="true" id="checkAll">
                                                            </div>
                                                        </th>
                                                        <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending">@lang('lang.employee_id')</th>
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
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.adjustment_include_taxe')
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
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.adjustment_excluded_tax')
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
        <div id="add_salary" class="modal custom-modal fade" style="display: none;" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_staff_salary')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
    
                    <div class="modal-body">
                        <form class="needs-validation" novalidate>
                            @csrf
                            <div class="content-title">@lang('lang.exchange_rate') @lang('lang.nssf')</div>
                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>@lang('lang.us_dollar')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" disabled id="exchange_rate_nssf_usd" name="" placeholder="" value="1.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>@lang('lang.rile')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">៛</span>
                                            <input type="number" class="form-control pay_required" id="exchange_rate_nssf" disabled name="" placeholder="" value="{{$exChangeRateNSSF == null ? "0.00" : $exChangeRateNSSF->amount_riel }}">
                                            <input type="hidden" class="form-control" id="exchange_rate_nssf_preview" name="" placeholder="" value="{{ $exChangeRateNSSF == null ? "" : $exChangeRateNSSF->amount_riel }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 align-center">
                                    <button type="button" id="btn-edix-nssf" class="btn btn-white me-2">Edit</button>
                                    <button type="button" class="btn btn-primary" id="btn-save-nssf" data-id="1" data-exchange="{{ $exChangeRateNSSF == null ? "" : $exChangeRateNSSF->id }}" style="display: none">Save</button>
                                </div>
                            </div>

                            <div class="content-title">@lang('lang.exchange_rate') @lang('lang.salary')</div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>@lang('lang.us_dollar')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="exchange_rate_salary_en" disabled name="" placeholder="" value="1.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
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
                                <div class="col-sm-3 align-center">
                                    <button type="button" id="btn-edix-salary" class="btn btn-white me-2">Edit</button>
                                    <button type="button" class="btn btn-primary" id="btn-save-salary" data-id="2" data-exchange="{{ $exChangeRateSalary == null ? "" : $exChangeRateSalary->id }}" style="display: none">Save</button>
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
                                        <label>@lang('lang.incentive')</label>
                                        <input class="form-control" type="file" id="incentive_bonus" name="incentive_bonus">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.other_benefits')</label>
                                        <input class="form-control" type="file" id="other_benefits" name="other_benefits">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.annual_bonus')</label>
                                        <input class="form-control" type="file" id="annual_bonus" name="annual_bonus">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.loan')</label>
                                        <input class="form-control" type="file" id="loan" name="loan">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.staff_book')</label>
                                        <input class="form-control" type="file" id="staff_book" name="staff_book">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.parking_allowance')</label>
                                        <input class="form-control" type="file" id="parking_allowance" name="parking_allowance">
                                    </div>
                                </div>
                            </div>
    
                            <div class="submit-section">
                                <button type="button" class="btn btn-primary submit-btn" id="btn-payroll">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>@lang('lang.submit')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="loading-overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; text-align: center;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>Loading Data...</p>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>

@section('script')
<script>
    var lang = @json(Helper::getLang());
    var number_employee = null;
    $(function(){
        $(".btn-search").on("click", function(){
            number_employee = $('#employee_id').val();
            employee_name = $('#employee_name').val();
            branch_id = $('#branch_id').val();
            filter_month = $('#filter_month').val();
            // Reload DataTable with the filter values
            $('#DataTables_Table_0').DataTable().ajax.reload(null, false); 
        });
        dataTables();

        var path = "{{ url('admins/user/autocomplet') }}";
        $('#employee_id').typeahead({
            source: function (query, process) {
                return $.get(path, {
                    query: query
                }, function (response) {
                    return process(response);
                });
            }
        });
        $('#checkAll').on('click', function(e) {
            if($(this).is(':checked',true)){
                $(".sub_chk").prop('checked', true);
            } else {  
                $(".sub_chk").prop('checked',false);
            }  
        });
        $('.delete_all').on('click', function(e) {
            var allValNumberemployee = [];  
            var allValPaymentDate = [];  
            $(".sub_chk:checked").each(function() {  
                allValNumberemployee.push($(this).attr('data-id'));
                allValPaymentDate.push($(this).attr('data-date'));
            });
            var number_employee = allValNumberemployee.join(",");
            var payment_date = allValPaymentDate.join(",");
            if(allValNumberemployee.length <=0)  
            {
                $.alert({
                    title: '@lang("lang.delete")!',
                    content: '@lang("lang.please_select_item_befor_delete").',
                    type: 'red',
                });
            }  else {
                $.confirm({
                    title: '@lang("lang.delete")!',
                    content: "@lang('lang.are_you_sure_want_to_delete')?",
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'ok',
                            btnClass: 'btn-red',
                            action: function(){
                                var id = this.$content.find('.id').val();
                                axios.post('{{ URL("payroll/review/delete") }}', {
                                    number_employee : number_employee,
                                    payment_date : payment_date
                                }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: "@lang('lang.the_process_has_been_successfully').",
                                        type: "success",
                                        timeout: 3000,
                                        icon: true
                                    }).show();
                                    window.location.replace("{{ URL('payroll/review') }}");
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: "@lang('lang.something_went_wrong_please_try_again_later').",
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                            close: function () {
                        }
                    }
                }); 
            } 
        });
        
        $(document).ready(function(){
            $("#btn-edix-nssf").click(function(){
                $("#btn-save-nssf").toggle();
                if ($(this).text() == "Edit") { 
                    $('#exchange_rate_nssf').prop('disabled', false);
                    $(this).text("Cancel"); 
                } else { 
                    $(this).text("Edit");
                    $('#exchange_rate_nssf').prop('disabled', true);
                }; 
            });
        });

        $(document).ready(function(){
            $("#btn-edix-salary").click(function(){
                $("#btn-save-salary").toggle();
                if ($(this).text() == "Edit") { 
                    $('#exchange_rate').prop('disabled', false);
                    $(this).text("Cancel"); 
                } else { 
                    $(this).text("Edit"); 
                    $('#exchange_rate').prop('disabled', true);
                }; 
            });
        });

        $("#btn-save-nssf, #btn-save-salary").on("click", function(){
            let condiction_btn = $(this).data('id');
            let id = $(this).data('exchange');
            let change_date  = moment().format('YYYY-MM-D');
            let data = {
                "_token": "{{ csrf_token() }}",
                'change_date': change_date,
                "id": id,
            };
            if (condiction_btn == 1) {
                if (!$("#exchange_rate_nssf").val()) {
                    $("#exchange_rate_nssf").css("border","solid 1px red");
                    return false;
                }
                data.amount_usd = $("#exchange_rate_nssf_usd").val();
                data.amount_riel = $("#exchange_rate_nssf").val();
                data.type = "NSSF";
            }
            if (condiction_btn == 2) {
                if (!$("#exchange_rate").val()) {
                    $("#exchange_rate").css("border","solid 1px red");
                    return false;
                }
                data.amount_usd = $("#exchange_rate_salary_en").val();
                data.amount_riel = $("#exchange_rate").val();
                data.type = "Salary";
            }
            $.ajax({
                type: "post",
                url: "{{ url('exchange-rate/create') }}",
                data,
                dataType: "JSON",
                success: function(response) {
                    new Noty({
                        title: "",
                        text: "@lang('lang.exchange_rate_created_successfully').",
                        type: "success",
                        timeout: 3000,
                        icon: true
                    }).show();
                    if (condiction_btn == 1) {
                        $('#exchange_rate_nssf').prop('disabled', true);
                        $("#btn-save-nssf").toggle();
                        $("#btn-edix-nssf").text("Edit");
                        $("#exchange_rate_nssf_preview").val(response.success.amount_riel)
                    };
                    if (condiction_btn == 2) {
                        $('#exchange_rate').prop('disabled', true);
                        $("#btn-save-salary").toggle();
                        $("#btn-edix-salary").text("Edit");
                        $("#exchange_rate_preview").val(response.success.amount_riel)
                    }
                }
            });
        });

        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('payroll/review') }}");
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

        $('body').on('click','.btn_approved',function(){
            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });
            var number_employee = allVals.join(",");
            if(allVals.length <=0)  
            {
                $.alert({
                    title: '@lang("lang.approve")!',
                    content: '@lang("lang.please_select_item_befor_approve").',
                    type: 'blue',
                });
            }  else {
                $(".loading-icon").css('display', 'block')
                $.confirm({
                    title: '@lang("lang.approve")',
                    content: "@lang('lang.are_you_sure_want_to_approve')?",
                    type: 'blue',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'ok',
                            btnClass: 'btn-blue',
                            action: function(){
                                axios.post('{{ URL('payroll/approved') }}',{
                                    'number_employee': number_employee,
                                }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.the_process_has_been_successfully")',
                                        type: "success",
                                        icon: true
                                    }).show();
                                        $('.card-footer').remove();
                                        window.location.replace("{{ URL('payroll/review') }}");
                                    }).catch(function(error) {
                                        new Noty({
                                            title: "",
                                            text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                            type: "error",
                                            icon: true
                                        }).show();
                                    });
                                }
                            },
                            close: function () {
                        }
                    }
                });
            }
        });
        $("#btn-payroll").on("click",function() {
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
                let exchange_rate_salary = $("#exchange_rate_preview").val();
                let exchange_rate_nssf = $("#exchange_rate_nssf_preview").val();
                var file_incentive = $('#incentive_bonus').prop('files')[0];
                var other_benefits = $('#other_benefits').prop('files')[0];
                var annual_bonus = $('#annual_bonus').prop('files')[0];
                var file_loan = $('#loan').prop('files')[0];
                var staff_book = $('#staff_book').prop('files')[0];
                var parking_allowance = $('#parking_allowance').prop('files')[0];
                var form_data = new FormData();

                form_data.append('file_incentive', file_incentive);
                form_data.append('other_benefits', other_benefits);
                form_data.append('annual_bonus', annual_bonus);
                form_data.append('file_loan', file_loan);
                form_data.append('staff_book', staff_book);
                form_data.append('parking_allowance', parking_allowance);
                form_data.append('exchange_rate', exchange_rate_salary);
                form_data.append('payment_date', $("#payment_date").val());
                form_data.append('_token', "{{ csrf_token() }}");
                
                
                let button_ok = {
                    text: '@lang("lang.pay")',
                    btnClass: 'add-btn-status',
                    action: function () {
                        $(".btn-search").prop('disabled', false);
                        $(".loading-icon").css('display', 'block');
                        $.ajax({
                            type: 'POST',
                            url: "{{ url('payroll/create') }}",
                            data: form_data,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(data) {
                                toastr.success('Data has been save success');
                                window.location.replace("{{ URL('payroll/review') }}");
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

    function dataTables() {
        $('#loading-overlay').show();
        // Check if DataTable instance exists, then destroy it
        if ($.fn.DataTable.isDataTable('#DataTables_Table_0')) {
            $('#DataTables_Table_0').DataTable().clear().destroy();
        }
        $('#DataTables_Table_0').empty(); // remove old table head/body
        $('#DataTables_Table_0').DataTable({
            pageLength: 10,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            ajax: {
                url: '{{ URL("payroll/review") }}',
                type: 'GET',
                data: function(d) {
                    d.number_employee = $('input[name="employee_id"]').val();
                    d.branch_id = $('select[name="branch_id"]').val();
                    d.employee_name = $('input[name="employee_name"]').val();
                    d.filter_month = $('input[name="filter_month"]').val();
                }
            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    className: 'stuck-scroll-3',
                    render: function(data, type, row) {
                        return `<div class="form-check form-check-md">
                            <input class="form-check-input sub_chk" type="checkbox" data-has-listeners="true" data-id="${row.number_employee}"  data-date="${row.payment_date}">
                        </div>`;
                    },
                    orderable: false,
                    searchable: false
                },
                { 
                    data: 'number_employee', 
                    name: 'number_employee',
                    className: 'stuck-scroll-3'
                },
                { 
                    data: 'employee_name_en', 
                    name: 'employee_name_en' ,
                    className: 'stuck-scroll-3',
                    render: function(data, type, row) {
                        return lang == 'en' ? row.employee_name_en : row.employee_name_kh
                    },
                    orderable: false,
                    searchable: false
                },
                { 
                    data: 'post_name_en', 
                    name: 'post_name_en',
                    render: function(data, type, row) {
                        return lang == 'en' ? row.post_name_en : row.post_name_kh
                    },
                    orderable: false,
                    searchable: false
                },
                { 
                    data: 'depart_name_en', 
                    name: 'depart_name_en',
                    render: function(data, type, row) {
                        return lang == 'en' ? row.depart_name_en : row.depart_name_kh
                    },
                    orderable: false,
                    searchable: false
                },
                { 
                    data: 'branch_name_en', 
                    name: 'branch_name_en',
                    render: function(data, type, row) {
                        return lang == 'en' ? row.branch_name_en : row.branch_name_kh
                    },
                    orderable: false,
                    searchable: false
                },
                { data: 'date_of_commencement', name: 'date_of_commencement' },
                { data: 'basic_salary', name: 'basic_salary' },
                { data: 'total_gross_salary', name: 'total_gross_salary' },
                { data: 'total_child_allowance', name: 'total_child_allowance' },
                { data: 'phone_allowance', name: 'phone_allowance' },
                { data: 'monthly_quarterly_bonuses', name: 'monthly_quarterly_bonuses' },
                { data: 'total_kny_phcumben', name: 'total_kny_phcumben' },
                { data: 'annual_incentive_bonus', name: 'annual_incentive_bonus' },
                { data: 'other_benefits', name: 'other_benefits' },
                { data: 'seniority_pay_included_tax', name: 'seniority_pay_included_tax' },
                { data: 'adjustment_include_taxe', name: 'adjustment_include_taxe' },
                { data: 'total_gross', name: 'total_gross' },
                { data: 'total_pension_fund', name: 'total_pension_fund' },
                { data: 'base_salary_received_usd', name: 'base_salary_received_usd' },
                { 
                    data: 'base_salary_received_riel', 
                    name: 'base_salary_received_riel',
                    render: function(data, type, row) {
                        return formatCurrencyKH(row.base_salary_received_riel)
                    }
                },
                { 
                    data: 'total_charges_reduced', 
                    name: 'total_charges_reduced',
                    render: function(data, type, row) {
                        return formatCurrencyKH(row.total_charges_reduced)
                    }
                },
                { 
                    data: 'total_tax_base_riel', 
                    name: 'total_tax_base_riel',
                    render: function(data, type, row) {
                        return formatCurrencyKH(row.total_tax_base_riel)
                    }
                },
                { 
                    data: 'total_rate', 
                    name: 'total_rate',
                },
                { 
                    data: 'total_salary_tax_usd', 
                    name: 'total_salary_tax_usd',
                },
                { 
                    data: 'total_salary_tax_riel', 
                    name: 'total_salary_tax_riel',
                    render: function(data, type, row) {
                        return formatCurrencyKH(row.total_salary_tax_riel)
                    }
                },
                { 
                    data: 'seniority_pay_excluded_tax', 
                    name: 'seniority_pay_excluded_tax'
                },
                { 
                    data: 'adjustment', 
                    name: 'adjustment'
                },
                { 
                    data: 'total_severance_pay', 
                    name: 'total_severance_pay'
                },
                { 
                    data: 'loan_amount', 
                    name: 'loan_amount',
                    render: function(data, type, row) {
                        return data == null ? "0.00" : data
                    }
                },
                { 
                    data: 'total_salary', 
                    name: 'total_salary',
                },
                { 
                    data: 'payment_date', 
                    name: 'payment_date',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        return moment(data).format('YYYY-MM-DD HH:mm:ss'); // Customize the format as needed
                    }
                }
            ],
            order: [[0, 'desc']],
            initComplete: function() {
                $('#loading-overlay').hide(); // Hide spinner when data is fully loaded
            }
        });
        $('#DataTables_Table_0').on('processing.dt', function (e, settings, processing) {
            if (processing) {
                $('#loading-overlay').show();
            } else {
                $('#loading-overlay').hide();
            }
        });
    }
    function formatCurrencyKH(currency) {
        return parseInt(currency).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>
@endsection