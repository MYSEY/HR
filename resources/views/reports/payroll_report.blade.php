@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 8px !important;
    }

    .reset-btn {
        color: #fff !important
    }
    #filter_month {
        position: relative;
    }

    input[type="month"]::-webkit-calendar-picker-indicator {
        background-position: right;
        background-size: auto;
        cursor: pointer;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        top: 0;
        height: auto;
        width: auto;
    }

</style>
@section('content')
<div class="">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.payroll_report')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.payroll_report')</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="">
        @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
            <form>
                {{-- @csrf --}}
                <div class="row filter-btn"> 
                    <div class="col-sm-2 col-md-2"> 
                        <div class="form-group cls-research">
                            <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="@lang('lang.employee_id')" value="{{old('number_employee')}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <div class="form-group cls-research">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group cls-research">
                            {{-- <div class="cal-icon"> --}}
                                <input class="form-control" type="month" id="filter_month">
                            {{-- </div> --}}
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group" id="col-branch">
                            <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                                <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_location')</option>
                                @foreach ($branchs as $item)
                                    <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-sm-6 col-md-4">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-success submit-btn me-2">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-txt">@lang('lang.search')</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_print me-2">
                                <span class="btn-text-print"><i class="fa fa-print fa-lg"></i> @lang('lang.print')</span>
                                <span id="btn-text-loading-print" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2">
                                <span class="btn-text-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <label >@lang('lang.excel')</label></span>
                                <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-warning reset-btn">
                                <span class="btn-text-reset">@lang('lang.reload')</span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                            </button>
                            
                        </div>
                    </div>
                </div>
            </form>
        @endif
        <div class="content">
            <div class="page-menu">
                <div class="row">
                    <div class="col-sm-12 p-0">
                        <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" id="tab_btl_basic_salary" href="#tab_payroll" aria-selected="true" role="tab" data-tab-id="1">@lang('lang.payroll')</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="tab_btn_NSSF" href="#tab_NSSF" aria-selected="false" role="tab" tabindex="-1" data-tab-id="2">@lang('lang.nssf')</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="tab_btn_Benefit" href="#tab_Benefit" aria-selected="false" role="tab" tabindex="-1" data-tab-id="3">@lang('lang.KNY_/_pchum_ben')</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="tab_btn_seniority" href="#tab_Seniority" aria-selected="false" role="tab" tabindex="-1" data-tab-id="4">@lang('lang.seniority_pay')</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="tab_btn_severance_pay" href="#tab_Severance_pay" aria-selected="false" role="tab" tabindex="-1" data-tab-id="5">@lang('lang.severance_pay')</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane active show" id="tab_payroll" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12 p-0">
                            <div class="table-responsive">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped custom-table datatable dataTable no-footer tbl_payment_salary"
                                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting stuck" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                                        <th class="sorting sorting_asc stuck" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee Name: activate to sort column descending" style="width: 178px;">@lang('lang.employee_name')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">@lang('lang.department')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">@lang('lang.position')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">@lang('lang.location')</th>
                                                        <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.join_date')</th>
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
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.KNY_/_pchum_ben')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.total_gross_salary')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.seniority_pay') (@lang('lang.excluded_tax'))
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
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.gross_salary')(@lang('lang.riel'))
                                                        </th>
                                                        
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.salary_charges_reduced')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.tax_base')(@lang('lang.riel'))
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
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.personal_tax')(@lang('lang.riel'))
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.seniority_pay') (@lang('lang.excluded_tax'))
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.severance_pay')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 51.475px;">@lang('lang.net_salary')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Joining Date: activate to sort column ascending" style="width: 89.6px;">@lang('lang.payment_date')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($payroll)>0)
                                                        @foreach ($payroll as $item)
                                                            <tr class="odd">
                                                                <td class="stuck"><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                                <td class="stuck"><a href="#">{{ Helper::getLang() == 'en' ? $item->users->employee_name_en : $item->users->employee_name_kh }}</a></td>
                                                                <td><a href="#">{{$item->users == null ? '' : $item->users->EmployeeDepartment}}</a></td>
                                                                <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeePosition}}</a></td>
                                                                <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeeBranch}}</a></td>
                                                                <td>{{ $item->users == null ? '' : $item->users->joinOfDate}}</td>
                                                                <td>$<a href="#">{{ $item->basic_salary }}</a></td>
                                                                <td>$<a href="#">{{ $item->total_gross_salary }}</a></td>
                                                                <td>$<a href="#">{{ $item->total_child_allowance }}</a></td>
                                                                <td>$<a href="#">{{ $item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                                <td>$<a href="#">{{ $item->total_kny_phcumben}}</a></td>
                                                                <td>$<a href="#">{{ $item->total_gross }}</a></td>
                                                                <td>$<a href="#">{{ $item->seniority_pay_excluded_tax}}</a></td>
                                                                <td>$<a href="#">{{ $item->total_pension_fund}}</a></td>
                                                                <td>$<a href="#">{{ $item->base_salary_received_usd}}</a></td>
                                                                <td><span>៛</span><a href="#">{{ number_format($item->base_salary_received_riel) }}</a></td>
                                                                <td><span>៛</span><a href="#">{{ number_format((int)$item->total_charges_reduced) }}</a></td>
                                                                <td><span>៛</span><a href="#">{{ number_format($item->total_tax_base_riel) }}</a></td>
                                                                <td><a href="#">{{ $item->total_rate}}%</a></td>
                                                                <td>$<a href="#">{{ $item->total_salary_tax_usd}}</a></td>
                                                                <td><span>៛</span><a href="#">{{ number_format($item->total_salary_tax_riel) }}</a></td>
                                                                <td>$<a href="#">{{ $item->seniority_pay_excluded_tax}}</a></td>
                                                                <td>$<a href="#">{{ $item->total_severance_pay}}</a></td>
                                                                <td>$<a href="#">{{ $item->total_salary }}</a></td>
                                                                <td>{{ $item->payment_date}}</td>
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

                <div class="tab-pane show" id="tab_NSSF" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer tbl_nssf">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped custom-table datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting stuck" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1">@lang('lang.employee_id')</th>
                                                        <th class="sorting sorting_asc stuck" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-sort="ascending"
                                                            aria-label="Employee: activate to sort column descending">@lang('lang.name')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.join_date')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Salary: activate to sort column ascending">@lang('lang.total_salary_before_tax_dollars')@lang('lang.usd')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Salary: activate to sort column ascending">@lang('lang.total_salary_before_tax_riel')@lang('lang.riel')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Salary: activate to sort column ascending">@lang('lang.average_wage')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Payslip: activate to sort column ascending"> @lang('lang.occupational_risk')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Payslip: activate to sort column ascending">@lang('lang.health_care')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Payslip: activate to sort column ascending">@lang('lang.pension_contribution_riel')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Payslip: activate to sort column ascending">@lang('lang.pension_contribution_dollar')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Payslip: activate to sort column ascending">@lang('lang.enterprise_pension_contribution')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Salary: activate to sort column ascending">@lang('lang.created_at')
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($dataNSSF) > 0)
                                                        @foreach ($dataNSSF as $item)
                                                            <tr class="odd">
                                                                <td class="stuck"><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                                <td class="stuck"><a href="#">{{ Helper::getLang() == 'en' ? $item->users->employee_name_en : $item->users->employee_name_kh }}</a></td></td></td>
                                                                <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                                                <td>${{ $item->total_pre_tax_salary_usd }}</td>
                                                                <td><span>៛</span>{{ $item->total_pre_tax_salary_riel }}</td>
                                                                <td>{{ $item->total_average_wage }}</td>
                                                                <td>{{ number_format($item->total_occupational_risk) }}</td>
                                                                <td>{{ $item->total_health_care }}</td>
                                                                <td><span>៛</span>{{ number_format($item->pension_contribution_usd) }}</td>
                                                                <td>${{ $item->pension_contribution_riel }}</td>
                                                                <td><span>៛</span>{{ number_format($item->corporate_contribution) }}</td>
                                                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
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
                <div class="tab-pane show" id="tab_Benefit" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped custom-table datatable dataTable no-footer table_banefit" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1">@lang('lang.employee_id')</th>
                                                        <th class="sorting sorting_asc" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-sort="ascending"
                                                            aria-label="Employee: activate to sort column descending">@lang('lang.name')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Join Date: activate to sort column ascending">@lang('lang.join_date')
                                                        </th>

                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Salary: activate to sort column ascending">@lang('lang.number_of_working_days')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Salary: activate to sort column ascending">@lang('lang.basic_salary')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Salary: activate to sort column ascending">@lang('lang.basic_salary_received')
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Payslip: activate to sort column ascending">
                                                            @lang('lang.total_allowance')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Salary: activate to sort column ascending">@lang('lang.created_at')
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($benefit) > 0)
                                                        @foreach ($benefit as $item)
                                                            <tr class="odd">
                                                                <td><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                                <td><a href="#">{{ Helper::getLang() == 'en' ? $item->users->employee_name_en : $item->users->employee_name_kh }}</a></td></td></td>
                                                                <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                                                <td>{{ $item->number_of_working_days }} Days</td>
                                                                <td>${{ $item->base_salary }}</td>
                                                                <td>${{ $item->base_salary_received }}</td>
                                                                <td>${{ $item->total_allowance }}</td>
                                                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
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

                <div class="tab-pane show" id="tab_Seniority" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped custom-table datatable dataTable no-footer tbl_seniority_pay"
                                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.employee_id')</th>
                                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending">@lang('lang.name')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.position')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.join_date')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.month')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">@lang('lang.total_average_salary')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">@lang('lang.total_salary_receive')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">@lang('lang.tax_exemption_salary')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">@lang('lang.taxable_salary')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">@lang('lang.created_at')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($dataSeniority) > 0)
                                                        @foreach ($dataSeniority as $item)
                                                            <tr class="odd">
                                                                <td><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                                <td><a href="#">{{ Helper::getLang() == 'en' ? $item->users->employee_name_en : $item->users->employee_name_kh }}</a></td>
                                                                <td>{{ $item->users == null ? '' : $item->users->EmployeePosition }}</td>
                                                                <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                                                <td>{{ $item->payment_of_month }}</td>
                                                                <td>${{ $item->total_average_salary }}</td>
                                                                <td>${{ $item->total_salary_receive }}</td>
                                                                <td>${{ $item->tax_exemption_salary }}</td>
                                                                <td>${{ $item->taxable_salary }}</td>
                                                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
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
                <div class="tab-pane show" id="tab_Severance_pay" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped custom-table datatable dataTable no-footer tbl_severance_pay"
                                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.employee_id')</th>
                                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending">@lang('lang.name')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.position')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.join_date')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">@lang('lang.total_severanec_pay')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">@lang('lang.total_contract_severance_pay')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">@lang('lang.created_at')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($severancePay) > 0)
                                                        @foreach ($severancePay as $item)
                                                            <tr class="odd">
                                                                <td><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                                <td><a href="#">{{ Helper::getLang() == 'en' ? $item->users->employee_name_en : $item->users->employee_name_kh }}</a></td>
                                                                <td>{{ $item->users == null ? '' : $item->users->EmployeePosition }}</td>
                                                                <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                                                <td>${{ $item->total_severanec_pay }}</td>
                                                                <td>${{ $item->total_contract_severance_pay }}</td>
                                                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
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
        </div>
    </div>
</div>
  
@endsection
@include('includs.script')
@include('payrolls.print_payroll_report')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script src="{{ asset('/admin/js/date-range-bicker.js') }}"></script>
<script>
    $(function() {
        var tab_status = 1;
        $("#tab_btl_basic_salary, #tab_btn_NSSF, #tab_btn_Benefit, #tab_btn_seniority, #tab_btn_severance_pay").on("click", function() {
            tab_status = $(this).attr('data-tab-id');
            // if check for function print report
            if (tab_status == 1) {
                $("#title_print").text("Basic Salary");
                $("#table_print_basic_salary").show();
                $("#table_print_nssf").hide();
                $("#table_print_benefit").hide();
                $("#table_print_seniority_pay").hide();
                $("#table_print_severance_pay").hide();
                $("#col-branch").css("display", "block");
                $(".cls-research").css("display", "block");
                $(".submit-btn").css('display', 'block');
            }else if (tab_status == 2) {
                $("#title_print").text("NSSF");
                $("#table_print_basic_salary").hide();
                $("#table_print_nssf").show();
                $("#table_print_benefit").hide();
                $("#table_print_seniority_pay").hide();
                $("#table_print_severance_pay").hide();
                $("#col-branch").css("display", "none");
                $(".cls-research").css("display", "block");
                $(".submit-btn").css('display', 'block');
            }else if (tab_status == 3) {
                $("#title_print").text("Khmer New Year / Pchum Ben Benefit");
                $("#table_print_basic_salary").hide();
                $("#table_print_nssf").hide();
                $("#table_print_benefit").show();
                $("#table_print_seniority_pay").hide();
                $("#table_print_severance_pay").hide();
                $("#col-branch").css("display", "none");
                $(".cls-research").css("display", "none");
                $(".submit-btn").css('display', 'none');
            }else if (tab_status == 4) {
                $("#title_print").text("Seniority Pay");
                $("#table_print_basic_salary").hide();
                $("#table_print_nssf").hide();
                $("#table_print_benefit").hide();
                $("#table_print_seniority_pay").show();
                $("#table_print_severance_pay").hide();
                $("#col-branch").css("display", "none");
                $(".cls-research").css("display", "block");
                $(".submit-btn").css('display', 'block');
            }else if (tab_status == 5) {
                $("#title_print").text("Severance Pay");
                $("#table_print_basic_salary").hide();
                $("#table_print_nssf").hide();
                $("#table_print_benefit").hide();
                $("#table_print_seniority_pay").hide();
                $("#table_print_severance_pay").show();
                $("#col-branch").css("display", "none");
                $(".cls-research").css("display", "block");
                $(".submit-btn").css('display', 'block');
            }
        });
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('reports/payroll-report') }}");
        });
        $(".submit-btn").on("click", function(){
            $(".submit-btn").prop('disabled', true);
            $(".btn-txt").hide();
            $(".loading-icon").css('display', 'block')
            let params = {
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                branch_id: $("#branch_id").val(),
                filter_month: $("#filter_month").val(),
            };
            showdatas(tab_status, params);
        });
        $(".btn_excel").on("click", function() {
            let query = {
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                filter_month: $("#filter_month").val(),
                tab_status: tab_status
            };
            var url = "{{URL::to('reports/payroll-export')}}?" + $.param(query)
            window.location = url;
        });
        $(".btn_print").on("click", function() {
            $("#btn-text-loading-print").css('display', 'block');
            $(".btn_print").prop('disabled', true);
            $(".btn-text-print").css("display", "none");
            let params = {
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                filter_month: $("#filter_month").val(),
                btn_print: true
            };
            showdatas(tab_status, params)
            print_pdf();
        });
    });
    function showdatas(tab_status, params) {
        $.ajax({
            type: "post",
            url: "{{ url('reports/payroll-report') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                tab_status,
                employee_id: params.employee_id ? params.employee_id : null,
                employee_name: params.employee_name ? params.employee_name : null,
                branch_id: params.branch_id ? params.branch_id : null,
                filter_month: params.filter_month ? params.filter_month : null,
            },
            dataType: "JSON",
            success: function(response) {
                let data =  response.success;
                $(".submit-btn").prop('disabled', false);
                $(".btn-txt").show();
                $(".loading-icon").css('display', 'none')
                var tr = "";
                if (tab_status == 1 ) {
                    if (data.length > 0) {
                        let dollar = "$";
                        if (params.btn_print) {
                            dollar ="";
                        }
                        data.map((row) => {
                            let join_date = moment(row.users.date_of_commencement).format('D-MMM-YYYY')
                            let payment_date = moment(row.payment_date).format('D-MMM-YYYY')
                            tr +='<tr class="odd">'+
                                '<td class="stuck"><a href="#">'+(row.users == null ? '' : row.users.number_employee )+'</a></td>'+
                                '<td class="stuck"><a href="#">'+(row.users == null ? '' : row.users.employee_name_en )+'</a></td>'+
                                '<td ><a href="#">'+(row.users == null ? '' : row.users.department.name_english)+'</a></td>'+
                                '<td><a href="#">'+(row.users == null ? '' : row.users.position.name_english)+'</a></td>'+
                                '<td><a href="#">'+(row.users == null ? '' : row.users.branch.branch_name_en)+'</a></td>'+
                                '<td>'+(join_date)+'</td>'+
                                '<td>'+(dollar)+'<a href="#">'+(row.basic_salary )+'</a></td>'+
                                '<td>'+(dollar)+'<a href="#">'+(row.total_gross_salary )+'</a></td>'+
                                '<td>'+(dollar)+'<a href="#">'+(row.total_child_allowance )+'</a></td>'+
                                '<td>'+(dollar)+'<a href="#">'+(row.phone_allowance == null ? '0.00' : row.phone_allowance)+'</a></td>'+
                                '<td>'+(dollar)+'<a href="#">'+(row.total_kny_phcumben)+'</a></td>'+
                                '<td>'+(dollar)+'<a href="#">'+(row.total_gross )+'</a></td>'+
                                '<td>'+(dollar)+'<a href="#">'+(row.seniority_pay_excluded_tax)+'</a></td>'+
                                '<td>'+(dollar)+'<a href="#">'+(row.total_pension_fund)+'</a></td>'+
                                '<td>'+(dollar)+'<a href="#">'+(row.base_salary_received_usd)+'</a></td>'+
                                '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.base_salary_received_riel))+'</a></td>'+
                                '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.total_charges_reduced))+'</a></td>'+
                                '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.total_tax_base_riel))+'</a></td>'+
                                '<td><a href="#">'+(row.total_rate)+'%</a></td>'+
                                '<td>'+(dollar)+'<a href="#">'+(row.total_salary_tax_usd)+'</a></td>'+
                                '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.total_salary_tax_riel))+'</a></td>'+
                                '<td>'+(dollar)+'<a href="#">'+(row.seniority_pay_excluded_tax)+'</a></td>'+
                                '<td>'+(dollar)+'<a href="#">'+(row.total_severance_pay)+'</a></td>'+
                                '<td>'+(dollar)+'<a href="#">'+(row.total_salary )+'</a></td>'+
                                '<td>'+(payment_date)+'</td>'+
                            '</tr>';
                        });
                    }else{
                        var tr = '<tr><td colspan=30 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                    }
                    $(".tbl_payment_salary tbody").html(tr);
                    $("#table_print_filter_basic_salary tbody").html(tr);
                }else if (tab_status == 2) {
                    if (data.length > 0) {
                        data.map((row) => {
                            let join_date = moment(row.users.date_of_commencement).format('D-MMM-YYYY')
                            let created_at = moment(row.created_at).format('D-MMM-YYYY')
                            tr +='<tr class="odd">'+
                                    '<td><a href="#">'+(row.users == null ? '' : row.users.number_employee )+'</a></td>'+
                                    '<td><a href="#">'+(row.users == null ? '' : row.users.employee_name_en )+'</a></td></td></td>'+
                                    '<td>'+(join_date)+'</td>'+
                                    '<td>$'+(row.total_pre_tax_salary_usd )+'</td>'+
                                    '<td><span>៛</span>'+(row.total_pre_tax_salary_riel )+'</td>'+
                                    '<td>'+(row.total_average_wage )+'</td>'+
                                    '<td>'+(formatCurrencyKH(row.total_occupational_risk) )+'</td>'+
                                    '<td>'+(row.total_health_care )+'</td>'+
                                    '<td><span>៛</span>'+(formatCurrencyKH(row.pension_contribution_usd) )+'</td>'+
                                    '<td>$'+(row.pension_contribution_riel )+'</td>'+
                                    '<td><span>៛</span>'+(formatCurrencyKH(row.corporate_contribution) )+'</td>'+
                                    '<td>'+(created_at)+'</td>'+
                            '</tr>';
                        });
                    }else {
                        var tr = '<tr><td colspan=13 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                    }
                    $(".tbl_nssf tbody").html(tr);
                    $("#table_print_filter_nssf tbody").html(tr);
                }else if (tab_status == 3) {
                    if (data.length > 0) {
                        data.map((row) => {
                            let join_date = moment(row.users.date_of_commencement).format('D-MMM-YYYY')
                            let created_at = moment(row.created_at).format('D-MMM-YYYY')
                            tr +='<tr class="odd">'+
                                '<td><a href="#">'+(row.users == null ? '' : row.users.number_employee)+'</a></td>'+
                                '<td><a href="#">'+(row.users == null ? '' : row.users.employee_name_en)+'</a></td>'+
                                '<td>'+(row.users == null ? '' : join_date)+'</td>'+
                                '<td>'+(row.number_of_working_days)+' Days</td>'+
                                '<td>$'+(row.base_salary)+'</td>'+
                                '<td>$'+(row.base_salary_received)+'</td>'+
                                '<td>$'+(row.total_allowance)+'</td>'+
                                '<td>'+(created_at)+'</td>'+
                            '</tr>';
                        });
                    }else {
                        var tr = '<tr><td colspan=8 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                    }
                    $(".table_banefit tbody").html(tr);
                    $("#table_print_filter_benefit tbody").html(tr);
                }else if(tab_status == 4){
                    if (data.length > 0) {
                        data.map((row) => {
                            let join_date = moment(row.users.date_of_commencement).format('D-MMM-YYYY')
                            let created_at = moment(row.created_at).format('D-MMM-YYYY')
                            tr +='<tr class="odd">'+
                                '<td><a href="#">'+(row.users == null ? '' : row.users.number_employee )+'</a></td>'+
                                '<td><a href="#">'+(row.users == null ? '' : row.users.employee_name_en )+'</a></td>'+
                                '<td>'+(row.users == null ? '' : row.users.position.name_english )+'</td>'+
                                '<td>'+(join_date)+'</td>'+
                                '<td>'+(row.payment_of_month )+'</td>'+
                                '<td>$'+(row.total_average_salary )+'</td>'+
                                '<td>$'+(row.total_salary_receive )+'</td>'+
                                '<td>$'+(row.tax_exemption_salary )+'</td>'+
                                '<td>$'+(row.taxable_salary )+'</td>'+
                                '<td>'+(created_at)+'</td>'+
                            '</tr>';
                        });
                    }else {
                        var tr = '<tr><td colspan=10 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                    }
                    $(".tbl_seniority_pay tbody").html(tr);
                    $("#table_print_filter_seniority_pay tbody").html(tr);
                }else{
                    if (data.length > 0) {
                        data.map((row) => {
                            let join_date = moment(row.users.date_of_commencement).format('D-MMM-YYYY')
                            let created_at = moment(row.created_at).format('D-MMM-YYYY')
                            tr +='<tr class="odd">'+
                                '<td><a href="#">'+(row.users == null ? '' : row.users.number_employee )+'</a></td>'+
                                '<td><a href="#">'+(row.users == null ? '' : row.users.employee_name_en )+'</a></td>'+
                                '<td>'+(row.users == null ? '' : row.users.position.name_english )+'</td>'+
                                '<td>'+(join_date)+'</td>'+
                                '<td>$'+(row.total_severanec_pay )+'</td>'+
                                '<td>$'+(row.total_contract_severance_pay )+'</td>'+
                                '<td>'+(created_at)+'</td>'+
                            '</tr>';
                        });
                    }else {
                        var tr = '<tr><td colspan=7 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                    }
                    $(".tbl_severance_pay tbody").html(tr);
                    $("#table_print_filter_severance_pay tbody").html(tr);
                }
                    
            }
        });
    }
    function formatCurrencyKH(currency) {
        return parseInt(currency).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    function print_pdf(type) {
        $("#print_purchase").show();
        window.setTimeout(function() {
            $("#print_purchase").hide();
            $(".btn_print").prop('disabled', false);
            $(".btn-text-print").show();
            $("#btn-text-loading-print").css('display', 'none');
        }, 2000);
        $("#print_purchase").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_print_report_payroll.css')}}",
            header: "",
            printDelay: 1000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>